<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Staff;
use Illuminate\Http\Request;
use Image;
use Storage;

class SchoolsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;

        $db_check = array(
            'user_id' => $user_id
        );
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Client')
        {
            return redirect()->route('dashboard');
        }
        
        $data['schools'] = $data['user']->schools()->orderBy('school')->simplePaginate(10);

        return view('schools.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Client')
        {
            return redirect()->route('dashboard');
        }

        return view('schools.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Client')
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'school'    => ['required', 'string', 'max:191', 'unique:schools'],
            'address'   => ['required', 'string', 'max:191'],
            'phone'     => ['required', 'string', 'max:191'],
            'email'     => ['required', 'string', 'email', 'max:191'],
            'logo'      => ['sometimes', 'image', 'max:1999']
        ]);

        $school = new School;

        $school->school = ucwords(strtolower($request->input('school')));
        $school->address = $request->input('address');
        $school->phone = $request->input('phone');
        $school->email = strtolower($request->input('email'));

        if(strlen($request->input('website')) > 0){
            $this->validate($request, [
                'website'   => ['sometimes', 'url', 'max:191']
            ]);
            $school->website = strtolower($request->input('website'));
        }
        else
        {
            $school->website = '';
        }

        if($request->hasFile('logo'))
        {
            $image = $request->file('logo');
            $filename = time() . '-' . rand(1,9) . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/school/' . $filename);
            Image::make($image)->resize(300,300)->save($location);

            $school->logo = $filename;
        }
        else
        {
            $school->logo = 'default_schoolimage.png';
        }

        $school->created_by = $user_id;

        $school->save();

        $school->users()->attach(Auth::user()->id);
        
        $request->session()->flash('success', 'School created.');

        return redirect()->route('schools.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        
        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        $user_id = Auth::user()->id;
        
        if(!$this->accessible($user_id, $id)){
            return redirect()->route('dashboard');
        }

        $data['user'] = User::find($user_id);
        $data['school'] = School::find($id);

        session(['school_id' => $data['school']->id]);

        return view('schools.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;

        $data['user'] = User::find($user_id);
        $data['school'] = School::find($id);

        if(empty($data['school'])){
            return redirect()->route('dashboard');
        }

        if($data['user']->role == 'Staff')
        {
            $db_check = array(
                'user_id'   => $data['user']->id,
                'school_id' => $data['school']->id
            );
            $staff = Staff::where($db_check)->get();
            if(empty($staff))
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        return view('schools.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }
        
        $user_id = Auth::user()->id;

        $this->validate($request, [
            'school'    => ['required', 'string', 'max:191', "unique:schools,school,$id"],
            'address'   => ['required', 'string', 'max:191'],
            'phone'     => ['required', 'string', 'max:191'],
            'email'     => ['required', 'string', 'email', 'max:191'],
            'logo'      => ['sometimes', 'image', 'max:1999']
        ]);

        $school = School::find($id);

        if(empty($school)){
            return redirect()->route('dashboard');
        }

        $school->school     = ucwords(strtolower($request->input('school')));
        $school->address    = $request->input('address');
        $school->phone      = $request->input('phone');
        $school->email      = strtolower($request->input('email'));

        if(strlen($request->input('website')) > 0){
            $this->validate($request, [
                'website'   => ['sometimes', 'url', 'max:191']
            ]);
            $school->website = strtolower($request->input('website'));
        }
        else
        {
            $school->website = '';
        }

        if($request->hasFile('logo'))
        {
            $image = $request->file('logo');
            $filename = time() . '-' . rand(1,9) . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/school/' . $filename);
            Image::make($image)->resize(300,300)->save($location);
            $old_logo = $school->logo;

            $school->logo = $filename;

            if($old_logo != 'default_schoolimage.png')
            {
                Storage::delete('images/school/'.$old_logo);
            }
        }

        $school->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('schools.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //check no of students cos a school with enrolled students can't be deleted
    }
    
    /**
     * Verifies if the logged-in user has permission to modify the resource (schools).
     *
     * @param  int  $user_id
     * @param  int  $school_id
     * @return boolean
     */
    public function accessible($user_id, $school_id)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }
        
        //custom verifier
        $accessible = false;
        $userschools = User::find($user_id)->schools;
        foreach($userschools as $myschool)
        {
            if($myschool->pivot['school_id'] == $school_id && $myschool->pivot['user_id'] == $user_id)
            {
                $accessible = true;
            }
        }
        return $accessible;
    }
}
