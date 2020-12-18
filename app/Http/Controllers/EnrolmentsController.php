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
use App\Student;
use App\Enrolment;
use App\Setting;
use App\Paymentprocessors;
use App\Bankdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use Storage;

class EnrolmentsController extends Controller
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
        
        $no_students = 0;
        $db_check = array(
            'term_id' => $term_id
        );
        $total_students = Enrolment::where($db_check)->get();
        if(!empty($total_students)){
            $no_students = count($total_students);
        }
        $data['total_students'] = $no_students;
        $data['enrolments'] = Enrolment::where($db_check)->orderBy('schoolclass_id', 'asc')->paginate(50);
        session(['enrolment_return_page' => 'enrolments_index']);

        $data['manage_all_results'] = 'No';
        $data['manage_student_promotion'] = 'No';
        if(Auth::user()->role == 'Consultant' || Auth::user()->role == 'Director')
        {
            $data['manage_all_results'] = 'Yes';
            $data['manage_student_promotion'] = 'Yes';
        }
        elseif(Auth::user()->role == 'Staff')
        {
            if($data['staff']->manage_all_results == 'Yes')
            {
                $data['manage_all_results'] = 'Yes';
            }
            if($data['staff']->manage_student_promotion == 'Yes')
            {
                $data['manage_student_promotion'] = 'Yes';
            }
        }

        return view('enrolments.index')->with($data);
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
        //
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

        $data['enrolment'] = Enrolment::find($id);
        if(empty($data['enrolment']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['enrolment']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        
        $data['arm'] = Arm::find($data['enrolment']->arm_id);
        if(empty($data['arm']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['arm']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        session(['arm_id' => $data['arm']->id]);

        $data['student_manager']        = 'No';
        $data['student_privilege_manager'] = 'No';
        $data['classarm_manager']       = 'No';
        $data['fees_manager']           = 'No';
        $data['itempayment_manager']    = 'No';
        $data['finance_manager']        = 'No';
        $data['calendar_manager']       = 'No';
        $data['sessionterm_manager']    = 'No';
        $data['manage_all_results']     = 'No';
        $data['manage_student_promotion'] = 'No';
        if(Auth::user()->role == 'Consultant' || Auth::user()->role == 'Director')
        {
            $data['student_manager']        = 'Yes';
            $data['student_privilege_manager'] = 'Yes';
            $data['classarm_manager']       = 'yes';
            $data['fees_manager']           = 'Yes';
            $data['itempayment_manager']    = 'Yes';
            $data['finance_manager']        = 'Yes';
            $data['calendar_manager']       = 'Yes';
            $data['sessionterm_manager']    = 'Yes';
            $data['manage_all_results']     = 'Yes';
            $data['manage_student_promotion'] = 'Yes';
        }
        elseif(Auth::user()->role == 'Staff')
        {
            if($data['staff']->manage_students_account == 'Yes')
            {
                $data['student_manager'] = 'Yes';
            }
            if($data['staff']->manage_students_privileges == 'Yes')
            {
                $data['student_privilege_manager'] = 'Yes';
            }
            if($data['staff']->manage_class_arms == 'Yes')
            {
                $data['classarm_manager'] = 'Yes';
            }
            if($data['staff']->manage_fees_products == 'Yes')
            {
                $data['fees_manager'] = 'Yes';
            }
            if($data['staff']->manage_received_payments == 'Yes')
            {
                $data['itempayment_manager'] = 'Yes';
            }
            if($data['staff']->manage_finance_report == 'Yes')
            {
                $data['finance_manager'] = 'Yes';
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
            if($data['staff']->manage_student_promotion == 'Yes')
            {
                $data['manage_student_promotion'] = 'Yes';
            }
        }
        $data['setting'] = Setting::first();
        if($data['setting']->paymentprocessor_id >= 1)
        {
            $data['payment_processor'] = Paymentprocessors::find($data['setting']->paymentprocessor_id);
        }
        $data['bankdetails'] = Bankdetail::all();

        return view('enrolments.show')->with($data);
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

        $enrolment = Enrolment::find($id);
        if(empty($enrolment))
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'item_to_update' => ['required']
        ]);

        if($request->input('item_to_update') == 'fee_status')
        {
            $this->validate($request, [
                'fee_payment_status' => ['required', 'in:Unpaid,Partly-paid,Completely-paid']
            ]);

            $enrolment->fee_status = $request->input('fee_payment_status');
            $enrolment->fee_update_by = $user_id;

            $enrolment->save();

            $request->session()->flash('success', 'Update saved');
        }
        elseif($request->input('item_to_update') == 'access_privileges')
        {
            $this->validate($request, [
                'can_write_exams'               => ['required', 'in:No,Yes'],
                'can_partake_in_CA'             => ['required', 'in:No,Yes'],
                'can_partake_in_assignments'    => ['required', 'in:No,Yes'],
                'can_access_termly_report'      => ['required', 'in:No,Yes']
            ]);

            $enrolment->access_exam = $request->input('can_write_exams');
            $enrolment->access_ca = $request->input('can_partake_in_CA');
            $enrolment->access_assignment = $request->input('can_partake_in_assignments');
            $enrolment->access_result = $request->input('can_access_termly_report');
            $enrolment->access_update_by = $user_id;

            $enrolment->save();

            $request->session()->flash('success', 'Update saved');
        }
        elseif($request->input('item_to_update') == 'student_result')
        {
            $this->validate($request, [
                'return_page' => ['required']
            ]);

            if(strlen($request->input('class_teacher_comment')) > 0)
            {
                $enrolment->classteachercomment_by  = $user_id;
                $enrolment->classteacher_comment    = $request->input('class_teacher_comment');
            }
            if(strlen($request->input('principal_comment')) > 0)
            {
                $enrolment->principalcomment_by = $user_id;
                $enrolment->principal_comment   = $request->input('principal_comment');
            }
            if($request->input('result_status'.$id) != 'Do_nothing')
            {
                $enrolment->result_status = $request->input('result_status'.$id);
            }

            $enrolment->save();

            $request->session()->flash('success', 'Update saved');

            if($request->input('return_page') == 'enrolments.show')
            {
                return redirect()->route('enrolments.show', $enrolment->id);
            }
            elseif($request->input('return_page') == 'enrolments.index')
            {
                return redirect()->route('enrolments.index');
            }
            elseif($request->input('return_page') == 'arms.show')
            {
                return redirect()->route('arms.show', $enrolment->arm->id);
            }
        }

        return redirect()->route('enrolments.show', $id);
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
                'manage_students_account'  => 'Yes'
            );
            $check_staff = Staff::where($db_check)->get();
            if(!empty($check_staff))
            {
                if($check_staff->count() == 1)
                {
                    $resource_manager = true;
                }
            }
        }

        return $resource_manager;
    }
}
