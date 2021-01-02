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
use App\Resulttemplate;
use App\Classsubject;
use Illuminate\Http\Request;

class ArmsController extends Controller
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
        $data['arms'] = Arm::where($db_check)->orderBy('schoolclass_id', 'asc')->simplePaginate(20);

        return view('arms.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

        if(empty($data['school']->schoolclasses))
        {
            $request->session()->flash('error', "Please create at least a school class before attempting to create class arms for terms." );
            return redirect()->route('classes.create');
        }
        elseif($data['school']->schoolclasses->count() < 1)
        {
            $request->session()->flash('error', "Please create at least a school class before attempting to create class arms for terms." );
            return redirect()->route('classes.create');
        }

        if(empty($data['school']->resulttemplates))
        {
            $request->session()->flash('error', "Please create at least one (1) result template before attempting to create class arms for terms." );
            return redirect()->route('resulttemplates.create');
        }
        elseif($data['school']->resulttemplates->count() < 1)
        {
            $request->session()->flash('error', "Please create at least one (1) result template before attempting to create class arms for terms." );
            return redirect()->route('resulttemplates.create');
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
            'school_id' => $school_id
        );
        $data['schoolclasses'] = Schoolclass::where($db_check)->orderBy('name', 'asc')->get();
        $data['resulttemplates'] = Resulttemplate::where($db_check)->orderBy('name', 'asc')->get();

        return view('arms.create')->with($data);
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

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        $this->validate($request, [
            'schoolclass_id' => ['required', 'numeric'],
            'name' => ['required'],
            'resulttemplate_id' => ['required', 'numeric'],
            'description' => ['sometimes', 'max:191']
        ]);

        $name = ucwords(strtolower(trim($request->input('name'))));

        $db_check = array(
            'name' => $name,
            'term_id' => $term_id,
            'schoolclass_id' => $request->input('schoolclass_id')
        );
        $no_arms = Arm::where($db_check)->get();
        if(!empty($no_arms))
        {
            if($no_arms->count() > 0)
            {
                $request->session()->flash('error', 'The class arm exits already.' );
                return redirect()->route('arms.create');
            }
        }

        $arm = new Arm;

        $arm->name = $name;
        $arm->description = $request->input('description');
        $arm->term_id = $term_id;
        $arm->resulttemplate_id = $request->input('resulttemplate_id');
        $arm->schoolclass_id = $request->input('schoolclass_id');
        $arm->user_id = 0;
        $arm->created_by = $user_id;

        $arm->save();

        foreach($request->subject as $this_subject)
        {
            $subject_added = 0;
            foreach($arm->classsubjects as $this_classsubject)
            {
                if($this_classsubject->subject_id == $this_subject)
                {
                    $subject_added++;
                }
            }
            if($subject_added == 0)
            {
                $classsubject = new Classsubject;
    
                $classsubject->term_id = $term_id;
                $classsubject->arm_id = $arm->id;
                $classsubject->subject_id = $this_subject;
                $classsubject->type = $request->input($this_subject);
                $classsubject->user_id = 0;
    
                $classsubject->save();
            }
        }

        $request->session()->flash('success', 'Class arm created.');

        return redirect()->route('arms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        
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

        $db_check = array(
            'id' => $id,
            'term_id' => $term_id
        );
        $arms = Arm::where($db_check)->get();
        if(empty($arms))
        {
            return  redirect()->route('dashboard');
        }
        elseif($arms->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['arm'] = $arms[0];
        session(['arm_id' => $data['arm']->id]);

        $data['student_manager'] = 'No';
        $data['classarm_manager'] = 'No';
        $data['fees_manager'] = 'No';
        $data['calendar_manager'] = 'No';
        $data['sessionterm_manager'] = 'No';
        $data['manage_all_results'] = 'No';
        $data['manage_student_promotion'] = 'No';
        if(Auth::user()->role == 'Consultant' || Auth::user()->role == 'Director')
        {
            $data['student_manager'] = 'Yes';
            $data['classarm_manager'] = 'Yes';
            $data['fees_manager'] = 'Yes';
            $data['calendar_manager'] = 'Yes';
            $data['sessionterm_manager'] = 'Yes';
            $data['manage_all_results'] = 'Yes';
            $data['manage_student_promotion'] = 'Yes';
        }
        elseif(Auth::user()->role == 'Staff')
        {
            if($data['staff']->manage_students_account == 'Yes')
            {
                $data['student_manager'] = 'Yes';
            }
            if($data['staff']->manage_class_arms == 'Yes')
            {
                $data['classarm_manager'] = 'Yes';
            }
            if($data['staff']->manage_fees_products == 'Yes')
            {
                $data['fees_manager'] = 'Yes';
            }
            if($data['staff']->manage_calendars == 'Yes')
            {
                $data['calendar_manager'] = 'Yes';
            }
            if($data['staff']->manage_session_terms == 'Yes')
            {
                $data['sessionterm_manager'] = 'Yes';
            }
            if($data['staff']->manage_all_results == 'Yes')
            {
                $data['manage_all_results'] = 'Yes';
            }
            if($data['staff']->manage_students_promotion == 'Yes')
            {
                $data['manage_student_promotion'] = 'Yes';
            }
        }
        session(['enrolment_return_page' => 'arms_show']);

        return view('arms.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Add class teacher to the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addclassteacher(Request $request)
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

        $this->validate($request, [
            'id' => ['required', 'numeric', 'min:1'],
            'user_id' => ['required', 'numeric', 'min:1']
        ]);
        
        $arm = Arm::find($request->input('id'));
        if(empty($arm))
        {
            return redirect()->route('dashboard');
        }

        $classteacher = User::find($request->input('user_id'));
        if(empty($classteacher))
        {
            return redirect()->route('dashboard');
        }
        elseif($classteacher->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $arm->user_id = $classteacher->id;

        $arm->save();

        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('arms.show', $arm->id);
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
            if(!empty(Director::where($db_check)->get()))
            {
                $resource_manager = true;
            }
        }
        elseif($user->role == 'Staff')
        {
            $db_check = array(
                'user_id'       => $user->id,
                'school_id'     => $school_id,
                'manage_class_arms'  => 'Yes'
            );
            $arm_cases = Staff::where($db_check)->get();
            if(!empty($arm_cases))
            {
                if($arm_cases->count() > 0)
                {
                    $resource_manager = true;
                }
            }
        }

        return $resource_manager;
    }
}
