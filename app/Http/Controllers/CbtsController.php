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
use App\Cbt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CbtsController extends Controller
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
        //
    }

    /**
     * Display a listing of cbts for specific classsubject.
     *
     * @param  int  $id (ID of classsubject that referenced the listing)
     * @return \Illuminate\Http\Response
     */
    public function listing($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        session(['classsubject_id' => $data['classsubject']->id]);

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

        return view('cbts.listing')->with($data);
    }

    /**
     * Show the form for creating exam CBT.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function newexam($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        return view('cbts.newexam')->with($data);
    }

    /**
     * Show the form for creating 3rd test CBT.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function new3rdtest($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        return view('cbts.new3rdtest')->with($data);
    }

    /**
     * Show the form for creating 2nd test CBT.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function new2ndtest($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        return view('cbts.new2ndtest')->with($data);
    }

    /**
     * Show the form for creating 1st test CBT.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function new1sttest($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        return view('cbts.new1sttest')->with($data);
    }

    /**
     * Show the form for creating practice CBT.
     *
     * @param  int  $id (ID of the class subject)
     * @return \Illuminate\Http\Response
     */
    public function newpractice($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['classsubject'] = Classsubject::find($id);
        if(empty($data['classsubject']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['classsubject']->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        return view('cbts.newpractice')->with($data);
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
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        $this->validate($request, [
            'classsubject_id' => ['required'],
            'type'      => ['required', 'in:Exam,3rd Test,2nd Test,1st Test,Practice Quiz'],
            'arm_count' => ['required', 'numeric'],
            'number_of_questions' => ['required', 'integer', 'min:1'],
            'duration' => ['required', 'integer', 'min:1'],
            'use_as_termly_score' => ['required', 'in:No,Yes']
        ]);
        
        $classsubject = Classsubject::find($request->input('classsubject_id'));
        if(empty($classsubject))
        {
            return redirect()->route('dashboard');
        }
        elseif($classsubject->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
                
        $arm_count = $request->input('arm_count');

        $affected_classes = 0;
        for ($i=0; $i < $arm_count; $i++) {
            if($request->input($i) > 0)
            {
                $affected_classes++;
            }
        }
        if($affected_classes < 1)
        {
            $request->session()->flash('error', "<p>The classes taking the CBT was not specified.</p>Please re-submit the CBT details.");
            if($request->input('type') == 'Exam')
            {
                return redirect()->route('cbts.newexam', $classsubject->id);
            }
            elseif($request->input('type') == '3rd Test')
            {
                return redirect()->route('cbts.new3rdtest', $classsubject->id);
            }
            elseif($request->input('type') == '2nd Test')
            {
                return redirect()->route('cbts.new2ndtest', $classsubject->id);
            }
            elseif($request->input('type') == '1st Test')
            {
                return redirect()->route('cbts.new1sttest', $classsubject->id);
            }
            else
            {
                return redirect()->route('cbts.newpractice', $classsubject->id);
            }
        }

        $name           = $request->input('type');
        $status         = 'Pending Approval';
        $approved_by    = 0;
        if($request->input('type') == 'Practice Quiz')
        {
            $name           = $request->input('title_of_quiz');
            $status         = 'Approved';
            $approved_by    = $user_id;

            $this->validate($request, [
                'number_of_attempts' => ['required', 'integer', 'min:0']
            ]);
        }
        else
        {
            $this->validate($request, [
                'number_of_attempts' => ['required', 'integer', 'min:1']
            ]);
        }

        session(['classsubject_id' => $request->input('classsubject_id')]);

        $cbt = new Cbt;

        $cbt->school_id         = $school_id;
        $cbt->subject_id        = $classsubject->subject_id;
        $cbt->term_id           = $term_id;
        $cbt->type              = $request->input('type');
        $cbt->name              = $name;
        $cbt->no_questions      = $request->input('number_of_questions');
        $cbt->duration          = $request->input('duration');
        $cbt->termly_score      = $request->input('use_as_termly_score');
        $cbt->no_attempts       = $request->input('number_of_attempts');
        $cbt->supervisor_pass   = $request->input('supervisor_password');
        $cbt->user_id           = $user_id;
        $cbt->status            = $status;
        $cbt->approved_by       = $approved_by;

        $cbt->save();

        for ($i=0; $i < $arm_count; $i++) {
            if($request->input($i) > 0)
            {
                DB::insert('insert into arm_cbt (arm_id, cbt_id) values (?, ?)', [$request->input($i), $cbt->id]);
            }
        }

        $request->session()->flash('success', 'CBT created. Start adding questions!');

        return redirect()->route('cbts.show', $cbt->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['cbt'] = Cbt::find($id);
        if(empty($data['cbt']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['cbt']->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if(session('classsubject_id') > 0)
        {
            $data['classsubject_id'] = session('classsubject_id');
            $data['classsubject'] = Classsubject::find($data['classsubject_id']);
            if(!empty($data['classsubject']))
            {
                $data['classsubject_id'] = $data['classsubject']->id;
            }
            else
            {
                $data['classsubject_id'] = 0;
            }
        }
        else
        {
            $data['classsubject_id'] = 0;
        }
        session(['classsubject_id' => $data['classsubject_id']]);

        $data['manage_cbt'] = 'No';

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
            
            if($data['staff']->manage_all_result == 'Yes' OR $data['staff']->manage_subjects == 'Yes')
            {
                $data['manage_cbt'] = 'Yes';
            }
        }


        return view('cbts.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['cbt'] = Cbt::find($id);
        if(empty($data['cbt']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['cbt']->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if(session('classsubject_id') > 0)
        {
            $data['classsubject_id'] = session('classsubject_id');
            $data['classsubject'] = Classsubject::find($data['classsubject_id']);
            if(!empty($data['classsubject']))
            {
                $data['classsubject_id'] = $data['classsubject']->id;
            }
            else
            {
                $data['classsubject_id'] = 0;
            }
        }
        else
        {
            $data['classsubject_id'] = 0;
        }
        session(['classsubject_id' => $data['classsubject_id']]);

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

        return view('cbts.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $cbt = Cbt::find($id);
        if(empty($cbt))
        {
            return redirect()->route('dashboard');
        }
        elseif($cbt->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        $this->validate($request, [
            'classsubject_id' => ['required'],
            'name' => ['required', 'max:191'],
            'number_of_questions' => ['required', 'integer', 'min:1'],
            'duration' => ['required', 'integer', 'min:1'],
            'arm_count' => ['required', 'numeric']
        ]);

        if($cbt->type != 'Practice Quiz')
        {
            $this->validate($request, [
                'number_of_attempts' => ['required', 'integer', 'min:1'],
                'use_as_termly_score' => ['required', 'in:No,Yes']
            ]);
        }
        
        if($request->input('classsubject_id') > 0)
        {
            $classsubject = Classsubject::find($request->input('classsubject_id'));
            if(empty($classsubject))
            {
                return redirect()->route('dashboard');
            }
            elseif($classsubject->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
        }
        
        $arm_count = $request->input('arm_count');

        $affected_classes = 0;
        for ($i=0; $i < $arm_count; $i++) {
            if($request->input($i) > 0)
            {
                $affected_classes++;
            }
        }
        if($affected_classes < 1 && $request->input('arm_count') != 0)
        {
            $request->session()->flash('error', 'The classes partaking this CBT was not specified.');
            return redirect()->route('cbts.edit', $cbt->id);
        }
        
        $cbt->name              = $request->input('name');
        $cbt->no_questions      = $request->input('number_of_questions');
        $cbt->duration          = $request->input('duration');
        if($cbt->type != 'Practice Quiz')
        {
            $cbt->termly_score      = $request->input('use_as_termly_score');
            $cbt->no_attempts       = $request->input('number_of_attempts');
            $cbt->supervisor_pass   = $request->input('supervisor_password');
        }

        $cbt->save();

        if($request->input('arm_count') != 0)
        {
            // clean up previous list of affected class
            DB::delete('delete from arm_cbt where cbt_id = ?', [$id]);
            // End - clean up previous list of affected class
    
            // re-specify affected class
            for ($i=0; $i < $arm_count; $i++) {
                if($request->input($i) > 0)
                {
                    DB::insert('insert into arm_cbt (arm_id, cbt_id) values (?, ?)', [$request->input($i), $id]);
                }
            }
            // End - re-specify affected class
        }

        $request->session()->flash('success', 'Update saved!.');

        return redirect()->route('cbts.edit', $cbt->id);
    }

    /**
     * Update the status of resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cbt_approval(Request $request, $id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $cbt = Cbt::find($id);
        if(empty($cbt))
        {
            return redirect()->route('dashboard');
        }
        elseif($cbt->count() < 1)
        {
            return  redirect()->route('dashboard');
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

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        $this->validate($request, [
            'status'            => ['required', 'in:Approved,Rejected']
        ]);
                
        if($request->input('classsubject_id') > 0)
        {
            $classsubject = Classsubject::find($request->input('classsubject_id'));
            if(empty($classsubject))
            {
                return redirect()->route('dashboard');
            }
            elseif($classsubject->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
        }
                
        $cbt->status = $request->input('status');

        $cbt->save();

        $request->session()->flash('success', 'Update saved!.');

        return redirect()->route('cbts.show', $cbt->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id=0)
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

        if($id < 1)
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'confirmation_to_delete' => ['required', 'in:DELETE'],
            'classsubject_id'        => ['required']
        ]);

        $cbt = Cbt::find($id);

        if(empty($cbt))
        {
            $request->session()->flash('error', 'Error 2: Attempt to delete unavailable resource.' );
            return redirect()->route('dashboard');
        }

        if(count($cbt->attempts) > 0)
        {
            $request->session()->flash('error', 'Error 1: Attempt to delete CBT that has been attempted.' );
            return redirect()->route('dashboard');
        }

        DB::delete('delete from arm_cbt where cbt_id = ?', [$id]);
        DB::delete('delete from questions where cbt_id = ?', [$id]);

        $cbt->delete();
        $request->session()->flash('success', 'Item deleted');
        
        return redirect()->route('cbts.listing', $request->input('classsubject_id'));
    }
}
