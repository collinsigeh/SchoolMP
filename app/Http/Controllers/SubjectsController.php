<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Subject;
use App\Classsubject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
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
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }
        
        $db_check = array(
            'school_id' => $school_id
        );
        $data['subjects'] = Subject::where($db_check)->orderBy('name', 'asc')->simplePaginate(20);

        return view('subjects.index')->with($data);
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
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        return view('subjects.create')->with($data);
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
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }

        $this->validate($request, [
            'name' => ['required'],
            'description' => ['sometimes', 'max:191']
        ]);
        
        $name = ucwords(strtolower(trim($request->input('name'))));

        $db_check = array(
            'school_id' => $school_id,
            'name' => $name
        );
        $duplicates = Subject::where($db_check)->get();

        if(!empty($duplicates))
        {
            if($duplicates->count() > 0)
            {
                $request->session()->flash('error', 'The subject '.$name.' exists already.');
                return redirect()->route('subjects.create');
            }
        }

        $subject = new Subject;

        $subject->school_id = $school_id;
        $subject->name = $name;
        $subject->description = $request->input('description');
        $subject->user_id = $user_id;

        $subject->save();

        $request->session()->flash('success', 'Subject created.');

        return redirect()->route('subjects.index');
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
            elseif($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }
        
        $data['subject'] = Subject::find($id);

        if(empty($data['subject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['subject']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $data['subject_manager'] = 'No';
        if(Auth::user()->role == 'Consultant' || Auth::user()->role == 'Director')
        {
            $data['subject_manager'] = 'Yes';
        }
        elseif(Auth::user()->role == 'Staff')
        {
            if($data['staff']->manage_subjects == 'Yes')
            {
                $data['subject_manager'] = 'Yes';
            }
        }

        return view('subjects.show')->with($data);
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
        
        $data['subject'] = Subject::find($id);

        if(empty($data['subject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['subject']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('subjects.edit')->with($data);
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
        $duplicates = Subject::where($db_check)->where('id', '!=', $id)->get();

        if(count($duplicates) > 0)
        {
            $request->session()->flash('error', 'The subject '.$name.' exists already.');
            return redirect()->route('subjects.create');
        }
        
        $subject = Subject::find($id);

        if(empty($subject))
        {
            return redirect()->route('dashboard');
        }
        elseif($subject->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $subject->name = $name;
        $subject->description = $request->input('description');

        $subject->save();

        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('subjects.edit', $subject->id);
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

        $subject = Subject::find($id);
        if(empty($subject))
        {
            $request->session()->flash('error', 'ERROR: An attempt to delete unavailable resource.');
        }
        else
        {
            if(!empty($subject->enrolments))
            {
                if(count($subject->enrolments) > 0)
                {
                    $request->session()->flash('error', 'ERROR: Subject has been assigned to student.');
                    return redirect()->route('subjects.show', $id);
                }
            }
            $db_check = array(
                'subject_id' => $id
            );
            $subjectcases = Classsubject::where($db_check)->get();
            if(!empty($subjectcases))
            {
                if($subjectcases->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Subject has been assigned to a class.');
                    return redirect()->route('subjects.show', $id);
                }
            }

            $subject->delete();
            $request->session()->flash('success', 'Record deleted');
        }

        return redirect()->route('subjects.index');
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
            $directorcases = Director::where($db_check)->get();
            if(!empty($directorcases))
            {
                if($directorcases->count() > 0)
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
                'manage_subjects'  => 'Yes'
            );
            $staffcases = Staff::where($db_check)->get();
            if(!empty($staffcases))
            {
                if($staffcases->count() > 0)
                {
                    $resource_manager = true;
                }
            }
        }

        return $resource_manager;
    }
}
