<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use Storage;

class DirectorsController extends Controller
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

        $data['user'] = User::find($user_id);

        if($data['user']->usertype == 'Non-client')
        {
            if($data['user']->role != 'Director')
            {
                return redirect()->route('dashboard');                
            }
        }

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        $db_check = array(
            'school_id' => $school_id
        );
        $data['directors'] = Director::where($db_check)->simplePaginate(20);

        $data['resource_manager'] = false;
        if($this->accessible($user_id, $school_id)){
            $data['resource_manager'] = true;
        }
        return view('directors.index')->with($data);
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

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if(!$this->accessible($user_id, $school_id)){
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

        return view('directors.create')->with($data);
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

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $user_id = Auth::user()->id;
        if(!$this->accessible($user_id, $school_id)){
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'name'      => ['required', 'string', 'max:191'],
            'email'     => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'phone'     => ['required', 'string', 'max:191'],
            'pic'       => ['sometimes', 'image', 'max:1999']
        ]);

        $user = new User;

        $user->usertype = 'Non-client';
        $user->role     = 'Director';
        $user->name     = ucwords(strtolower($request->input('name')));
        $user->email    = strtolower($request->input('email'));
        $user->password = Hash::make('password');

        if($request->hasFile('pic'))
        {
            $image = $request->file('pic');
            $filename = time() . '-' . rand(1,9) . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/profile/' . $filename);
            Image::make($image)->resize(300,300)->save($location);

            $user->pic = $filename;
        }
        else
        {
            $user->pic = 'default_userimage.png';
        }

        $user->save();

        $director = new Director;

        $director->user_id      = $user->id;
        $director->school_id    = $school_id;
        $director->phone        = $request->input('phone');
        $director->created_by   = $user_id;

        $director->save();

        
        $request->session()->flash('success', 'Director added.');

        return redirect()->route('directors.show', $director->id);
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

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        $db_check = array(
            'id' => $id,
            'school_id' => $school_id
        );
        $directors = Director::where($db_check)->get();
        if(empty($directors))
        {
            return  redirect()->route('dashboard');
        }
        elseif($directors->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['director'] = $directors[0];

        $data['resource_manager'] = false;
        if($this->accessible($user_id, $school_id)){
            $data['resource_manager'] = true;
        }
        return view('directors.show')->with($data);
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

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        if(!$this->accessible($user_id, $school_id)){
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);
        $data['director'] = Director::find($id);

        if(empty($data['director']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['director']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('directors.edit')->with($data);
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

        $this->validate($request, [
            'phone' => ['required', 'string', 'min:5', 'max:191']
        ]);

        $director = Director::find($id);

        if(empty($director)){
            return redirect()->route('dashboard');
        }
        elseif($director->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        
        $director->phone = $request->input('phone');

        $director->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('directors.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $director = Director::find($id);
        if(empty($director))
        {
            $request->session()->flash('errors', 'ERROR: An attempt to delete unavailable resource.');
        }
        else
        {
            if($director->count() < 1)
            {
                return  redirect()->route('dashboard');
            }

            if(Auth::user()->id == $director->user_id)
            {
                $request->session()->flash('error', 'ERROR: An attempt to delete own resource.');
                return redirect()->route('directors.show', $id);
            }

            $directoruserid = $director->user_id;

            $director->status = 'Inactive';
            $director->save();

            $directoruser = User::find($directoruserid);
            if(!empty($directoruser))
            {
                if($directoruser->count() > 0)
                {
                    $directoruser->status = 'Inactive';
                    $directoruser->save();
                }
            }
            $request->session()->flash('success', 'Deactivation successful.');
        }

        return redirect()->route('directors.index');
    }

    /**
     * Show the form for adding a new resource by linking it to an existing user.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        return redirect()->route('dashboard');

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if(!$this->accessible($user_id, $school_id)){
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

        return view('directors.new')->with($data);
    }

    /**
     * Store a newly added resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        return redirect()->route('dashboard');

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $user_id = Auth::user()->id;
        if(!$this->accessible($user_id, $school_id)){
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:191'],
        ]);

        $email = strtolower(trim($request->input('email')));

        $user = User::where('email', $email)->get();

        if(empty($user))
        {
            $request->session()->flash('error', 'Invalid email : <b>'.$email.'</b>');
            return redirect()->route('directors.new');
        }
        elseif($user->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if($user[0]['role'] == 'Student')
        {
            $request->session()->flash('error', 'Email :<b>'.$email.'</b> belongs to a student');
            return redirect()->route('directors.new');
        }
        
        $db_check = array(
            'user_id' => $user[0]['id'],
            'school_id' => $school_id
        );
        $director = Director::where($db_check)->get();

        if(!empty($director))
        {
            if($director->count() > 0)
            {
                $request->session()->flash('error', '<b>'.$email.'</b> belongs to a director already.');
                return redirect()->route('directors.new');
            }
        }

        $director = new Director;

        $director->user_id      = $user[0]['id'];
        $director->school_id    = $school_id;
        $director->phone        = '';
        $director->created_by   = $user_id;

        $director->save();

        
        $request->session()->flash('success', 'Director added.');

        return redirect()->route('directors.index');
    }
    
    /**
     * Verifies if the logged-in user has permission to modify the resource (directors).
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
        $user = User::find($user_id);
        if($user->role == 'Director')
        {
            $db_check = array(
                'user_id'   => $user_id,
                'school_id' => $school_id
            );
            $directorcases = Director::where($db_check)->get();
            if(!empty($directorcases))
            {
                if($directorcases->count()> 0)
                {
                    $accessible = true;
                }
            }
        }
        else
        {
            foreach($user->schools as $myschool)
            {
                if($myschool->pivot['school_id'] == $school_id && $myschool->pivot['user_id'] == $user_id)
                {
                    $accessible = true;
                }
            }
        }
        return $accessible;
    }
}
