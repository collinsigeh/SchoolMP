<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Schoolclass;
use App\Director;
use App\Staff;
use App\Term;
use App\Arm;
use App\Classsubject;
use App\Result;
use Illuminate\Http\Request;

class ClasssubjectsController extends Controller
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
            $data['school'] = School::find($school_id);
    
            if(!$this->resource_manager($data['user'], $school_id))
            {
                return redirect()->route('dashboard');
            }
    
            if(session('term_id') < 1)
            {
                return redirect()->route('dashboard');
            }
            $term_id = session('term_id');
            
            $data['term'] = Term::find($term_id);
    
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
                elseif($staff->count() < 1)
                {
                    return  redirect()->route('dashboard');
                }
                $data['staff'] = $staff[0];
            }
            
            $db_check = array(
                'term_id' => $term_id
            );
            $data['classsubjects'] = Classsubject::where($db_check)->orderBy('arm_id', 'asc')->get();
            $db_check = array(
                'term_id' => $term_id,
                'user_id' => 0
            );
            $data['classsubjectswithoutteacher'] = Classsubject::where($db_check)->orderBy('arm_id', 'asc')->get();
            $db_check = array(
                'school_id' => $school_id,
                'status' => 'Active'
            );
            $data['allstaff'] = Staff::where($db_check)->get();
    
            return view('classsubjects.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $request->session()->flash('error', 'Error 4' );
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if(!$this->resource_manager($data['user'], $school_id))
        {
            $request->session()->flash('error', 'Error 3: You do NOT have permission' );
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            $request->session()->flash('error', 'Error 2' );
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if(session('arm_id') < 1)
        {
            $request->session()->flash('error', 'Error 1' );
            return redirect()->route('dashboard');
        }
        $arm_id = session('arm_id');
        
        $data['arm'] = Arm::find($arm_id);

        $this->validate($request, [
            'from_form' => ['required']
        ]);
        if($request->input('from_form') != 'true' OR empty($request->subject))
        {
            $request->session()->flash('error', 'Improper attempt to add subjects to class.' );
            return redirect()->route('arms.show', $arm_id);
        }

        foreach($request->subject as $this_subject)
        {
            $classsubject = new Classsubject;

            $classsubject->term_id = $term_id;
            $classsubject->arm_id = $arm_id;
            $classsubject->subject_id = $this_subject;
            $classsubject->type = 'Compulsory';
            $classsubject->user_id = 0;

            $classsubject->save();
        }

        $request->session()->flash('success', 'Class subjects added successfully.');

        return redirect()->route('arms.show', $arm_id);
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
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }
        
        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);
        if(empty($data['term']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['term']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $data['classsubject'] = Classsubject::find($id);

        $data['classarm_manager'] = 'Yes';

        if(!$this->resource_manager($data['user'], $school_id))
        {
            $data['classarm_manager'] = '';
            if($data['user']->id != $data['classsubject']->user_id)
            {
                return redirect()->route('dashboard');
            }
            
        }
        session(['enrolment_return_page' => $data['classsubject']]);

        return view('classsubjects.show')->with($data);
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
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if(session('arm_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $arm_id = session('arm_id');
        
        $data['arm'] = Arm::find($arm_id);

        $data['classsubject'] = Classsubject::find($id);

        return view('classsubjects.edit')->with($data);
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

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if(session('arm_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $arm_id = session('arm_id');
        
        $data['arm'] = Arm::find($arm_id);

        $this->validate($request, [
            'user_id' => ['required', 'numeric', 'min:1']
        ]);

        $classsubject = Classsubject::find($id);
        if(empty($classsubject))
        {
            return redirect()->route('dashboard');
        }
        elseif($classsubject->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $classsubject->user_id = $request->input('user_id');
        $classsubject->save();

        $request->session()->flash('success', 'Update saved.');

        if(!empty($request->input('return_page')))
        {
            return redirect()->route($request->input('return_page'), $request->input('returnpage_id'));
        }

        return redirect()->route('classsubjects.edit', $id);
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

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            $request->session()->flash('error', 'Error 4' );
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if(!$this->resource_manager($data['user'], $school_id))
        {
            $request->session()->flash('error', 'Error 3: You do NOT have permission' );
            return redirect()->route('dashboard');
        }

        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $this->validate($request, [
            'arm_id' => ['required', 'min:1']
        ]);

        $classsubject = Classsubject::find($id);
        if(empty($classsubject))
        {
            $request->session()->flash('error', 'Error 2: Attempt to delete unavailable resource.' );
            return redirect()->route('dashboard');
        }
        $arm_id = $classsubject->arm_id;
        $to_continue = 'Yes';

        $db_check = array(
            'classsubject_id' => $id
        );
        $subjectenrolled = Result::where($db_check)->get();
        if(!empty($subjectenrolled))
        {
            if($subjectenrolled->count() > 0)
            {
                $to_continue = 'No';
                $request->session()->flash('error', 'Error 1: Subject has enrolled students and can NOT be deleted.');
            }
        }

        if($to_continue == 'Yes')
        {
            $classsubject->delete();
            $request->session()->flash('success', 'Record deleted');
        }
        return redirect()->route('arms.show', $request->input('arm_id'));
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
            $directors = Director::where($db_check)->get();
            if(!empty($directors))
            {
                if($directors->count() >= 1)
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
            $staff = Staff::where($db_check)->get();
            if(!empty($staff))
            {
                if($staff->count() >= 1)
                {
                    $resource_manager = true;
                }
            }
        }

        return $resource_manager;
    }
}
