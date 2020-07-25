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
use App\Result;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
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

        if(session('arm_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $arm_id = session('arm_id');
        
        $data['arm'] = Arm::find($arm_id);

        $this->validate($request, [
            'from_form' => ['required'],
            'enrolment_id' => ['required', 'min:1']
        ]);

        if($data['arm']->user->id != $user_id && $data['user']->role != 'Director')
        {
            if($data['user']->role == 'Staff')
            {
                if($data['user']->staff->manage_students_account != 'Yes')
                {
                    $request->session()->flash('error', 'You do NOT have permission for this aciton.' );
                    return redirect()->route('arms.show', $arm_id);
                }
            }
            else
            {
                $request->session()->flash('error', 'You do NOT have permission for this aciton.' );
                return redirect()->route('arms.show', $arm_id);
            }
        }

        if($request->input('from_form') != 'true' OR empty($request->subject))
        {
            $request->session()->flash('error', 'Improper attempt to add subjects for a student.' );
            return redirect()->route('arms.show', $arm_id);
        }

        foreach($request->subject as $classsubject_id)
        {
            $studentsubject = new Result;

            $studentsubject->school_id = $school_id;
            $studentsubject->term_id = $term_id;
            $studentsubject->enrolment_id = $request->input('enrolment_id');
            $studentsubject->classsubject_id = $classsubject_id;
            $studentsubject->resulttemplate_id = $data['arm']->resulttemplate_id;
            $studentsubject->subject_1st_test_score = 0;
            $studentsubject->first_score_by  = 'No one';
            $studentsubject->subject_2nd_test_score = 0;
            $studentsubject->second_score_by  = 'No one';
            $studentsubject->subject_3rd_test_score = 0;
            $studentsubject->third_score_by  = 'No one';
            $studentsubject->subject_assignment_score = 0;
            $studentsubject->assignment_score_by  = 'No one';
            $studentsubject->subject_exam_score = 0;
            $studentsubject->exam_score_by  = 'No one';
            $studentsubject->classteachercomment_by  = 0;
            $studentsubject->classteacher_comment  = '';
            $studentsubject->principalcomment_by  = 0;
            $studentsubject->principal_comment  = '';
            $studentsubject->status = 'Pending';

            $studentsubject->save();
        }

        $request->session()->flash('success', 'Subjects enrolled successfully.');

        return redirect()->route('enrolments.show', $request->input('enrolment_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
