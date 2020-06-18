<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Schoolclass;
use Illuminate\Http\Request;

class ClassesController extends Controller
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

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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
        
        $db_check = array(
            'school_id' => $school_id
        );
        $data['classes'] = Schoolclass::where($db_check)->orderBy('name', 'asc')->simplePaginate(20);

        return view('classes.index')->with($data);
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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

        return view('classes.create')->with($data);
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

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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

        $this->validate($request, [
            'schoolsegment' => ['required'],
            'name' => ['required'],
            'description' => ['sometimes', 'max:191']
        ]);
        
        $name = $request->input('schoolsegment').' '.ucwords(strtolower(trim($request->input('name'))));

        $db_check = array(
            'school_id' => $school_id,
            'name' => $name
        );
        $duplicates = Schoolclass::where($db_check)->get();

        if(!empty($duplicates))
        {
            if($duplicates->count() > 0)
            {
                $request->session()->flash('error', $name.' exists already.');
                return redirect()->route('classes.create');
            }
        }

        $schoolclass = new Schoolclass;

        $schoolclass->school_id = $school_id;
        $schoolclass->name = $name;
        $schoolclass->description = $request->input('description');
        $schoolclass->user_id = $user_id;

        $schoolclass->save();

        $request->session()->flash('success', 'Class created.');

        return redirect()->route('classes.index');
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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
        
        $db_check = array(
            'id' => $id,
            'school_id' => $school_id
        );
        $schoolclasses = Schoolclass::where($db_check)->get();
        if(empty($schoolclasses))
        {
            return  redirect()->route('dashboard');
        }
        $data['schoolclass'] = $schoolclasses[0];

        return view('classes.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

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
        
        $data['schoolclass'] = Schoolclass::find($id);

        if(empty($data['schoolclass']))
        {
            return redirect()->route('dashboard');
        }

        return view('classes.edit')->with($data);
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

        $this->validate($request, [
            'name' => ['required'],
            'description' => ['sometimes', 'max:191']
        ]);
        
        $name = ucwords(strtolower(trim($request->input('name'))));

        $db_check = array(
            'school_id' => $school_id,
            'name' => $name
        );
        $duplicates = Schoolclass::where($db_check)->where('id', '!=', $id)->get();

        if(!empty($duplicates))
        {
            if($duplicates->count() > 0)
            {
                $request->session()->flash('error', $name.' exists already.');
                return redirect()->route('classes.create');
            }
        }
        
        $schoolclass = Schoolclass::find($id);

        if(empty($schoolclass))
        {
            return redirect()->route('dashboard');
        }

        $schoolclass->name = $name;
        $schoolclass->description = $request->input('description');

        $schoolclass->save();

        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('classes.edit', $schoolclass->id);
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $schoolclass = Schoolclass::find($id);
        if(empty($schoolclass))
        {
            $request->session()->flash('error', 'ERROR: An attempt to delete unavailable resource.');
        }
        else
        {
            if(!empty($schoolclass->arms))
            {
                if(count($schoolclass->arms) > 0)
                {
                    $request->session()->flash('error', 'ERROR 001: The class is in use.');
                    return redirect()->route('classes.show', $id);
                }
            }
            if(!empty($schoolclass->enrolments))
            {
                if(count($schoolclass->enrolments) > 0)
                {
                    $request->session()->flash('error', 'ERROR 002: The class is in use.');
                    return redirect()->route('subject.show', $id);
                }
            }

            $schoolclass->delete();
            $request->session()->flash('success', 'Record deleted');
        }

        return redirect()->route('classes.index');
    }

    /**
     * Check if the logged-in user can manipulate this resource by special privilege.
     * All directors are managers already but staff earn it by special privilege
     *
     * @return boolean
     */
    public function resource_manager($user, $school_id)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }
        
        $resource_manager = false;

        if($user->usertype == 'Client')
        {
            foreach($user->schools as $school)
            {
                if($school->id == $school_id)
                {
                    $resource_manager = true;
                }
            }
        }
        elseif($user->role == 'Director')
        {
            $db_check = array(
                'user_id'   => $user->id,
                'school_id' => $school_id
            );
            $directorship = Director::where($db_check)->get();
            if(!empty($directorship))
            {
                if($directorship->count() > 0)
                {
                    $resource_manager = true;
                }
            }
        }
        elseif($user->role == 'Staff')
        {
            $db_check = array(
                'user_id'       => $user->id,
                'school_id'     => $school_id,
                'manage_class_arms'  => 'Yes'
            );
            $staffship = Staff::where($db_check)->get();
            if(!empty($staffship))
            {
                if($staffship->count() > 0)
                {
                    $resource_manager = true;
                }
            }
        }

        return $resource_manager;
    }
}
