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
use App\Order;
use App\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use Storage;

class StudentsController extends Controller
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

        return view('students.index')->with($data);
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
            $request->session()->flash('error', 'Please create at least a school class before attempting to enrol students.</p>
            <a class="btn btn-sm btn-primary" href="'.config('app.url').'/classes/create">New class</a>');
            return redirect()->route('students.index');
        }
        elseif($data['school']->schoolclasses->count() < 1)
        {
            $request->session()->flash('error', 'Please create at least a school class before attempting to enrol students.</p>
            <a class="btn btn-sm btn-primary" href="'.config('app.url').'/classes/create">New class</a>');
            return redirect()->route('students.index');
        }

        $no_classarms = 0;
        foreach($data['school']->schoolclasses as $schoolclass)
        {
            $schoolclass_arms = 0;
            if(!empty($schoolclass->arms))
            {
                $schoolclass_arms = count($schoolclass->arms);
            }
            $no_classarms = $no_classarms + $schoolclass_arms;
        }
        if($no_classarms < 1)
        {
            $request->session()->flash('error', 'Please create at least a specific class arm before attempting to enrol students.</p>
            <a class="btn btn-sm btn-primary" href="'.config('app.url').'/arms/create">New class arm</a>');
            return redirect()->route('students.index');
        }

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if(strtotime($data['term']->closing_date) <= time())
        {
            $request->session()->flash('error', 'ERROR: Attempt to enrol student in a closed/past term');
            return redirect()->route('students.index');
        }
        
        // ensuring post-paid orders are not missed used
        foreach($data['term']->subscription->orders as $this_order)
        {
            if($this_order->payment == 'Post-paid' && $this_order->type == 'Purchase')
            {
                if($this_order->status == 'Paid' OR $this_order->status == 'Completed')
                {
                    $request->session()->flash('error', 'You can NOT enrol more students for this term. The linked post-paid subscription is paid for and closed.');
                    return redirect()->route('students.index');
                }
            }
        }
        // End - ensuring post-paid orders are not missed used

        if(empty($data['term']->subscription))
        {
            $request->session()->flash('error', "<p>Subscription recognition error 1.</p>" );
            return redirect()->route('students.index');
        }
        elseif($data['term']->subscription->count() < 1)
        {
            $request->session()->flash('error', "<p>Subscription recognition error 2.</p>" );
            return redirect()->route('students.index');
        }

        $subscription_enrolments = 0;
        if(!empty($data['term']->subscription->enrolments))
        {
            $subscription_enrolments = count($data['term']->subscription->enrolments);
        }
        if(($subscription_enrolments >= $data['term']->subscription->student_limit) && 
            ($data['term']->subscription->student_limit !== 'n'))
        {
            $request->session()->flash('error', '<p>You can NOT enrol new students because you have reached the limit of your subscription for the term.</p>
            <a class="btn btn-sm btn-primary" href="'.config('app.url').'/subscriptions/'.$data['term']->subscription_id.'">View subscription details</a>');
            return redirect()->route('students.index');
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

        return view('students.create')->with($data);
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

        if(strtotime($data['term']->closing_date) <= time())
        {
            $request->session()->flash('error', 'ERROR: Attempt to enrol student in a closed/past term');
            return redirect()->route('students.index');
        }
        
        // ensuring post-paid orders are not missed used
        foreach($data['term']->subscription->orders as $this_order)
        {
            if($this_order->payment == 'Post-paid' && $this_order->type == 'Purchase')
            {
                if($this_order->status == 'Paid' OR $this_order->status == 'Completed')
                {
                    $request->session()->flash('error', 'You can NOT enrol more students for this term. The linked post-paid subscription is paid for and closed.');
                    return redirect()->route('students.index');
                }
            }
        }
        // End - ensuring post-paid orders are not missed used

        $subscription_enrolments = 0;
        if(!empty($data['term']->subscription->enrolments))
        {
            $subscription_enrolments = count($data['term']->subscription->enrolments);
        }
        if(($subscription_enrolments >= $data['term']->subscription->student_limit) && 
            ($data['term']->subscription->student_limit !== 'n'))
        {
            $request->session()->flash('error', '<p>You can NOT enrol new students because you have reached the limit of your subscription for the term.</p>
            <a class="btn btn-sm btn-primary" href="'.config('app.url').'/subscriptions/'.$data['term']->subscription_id.'">View subscription details</a>');
            return redirect()->route('students.index');
        }

        $subscription_order_id = 0; //useful only for post-paid orders
        $subscription_unit_price = 0; //useful only for post-paid orders
        $subscription_payment = 'None';
        $subscription_price_type = 'None';

        foreach ($data['term']->subscription->orders as $order) {
            if($order->type == 'Purchase')
            {
                $subscription_order_id = $order->id; //useful only for post-paid orders
                $subscription_unit_price = $order->price; //useful only for post-paid orders
                $subscription_payment = $order->payment;
                $subscription_price_type = $order->price_type;
            }
        }

        $enrolment_status = 'Active';
        if($subscription_payment == 'None' OR $subscription_price_type == 'None')
        {
            $request->session()->flash('error', 'ERROR: Lost linked order!');
            return redirect()->route('students.index');
        }
        else
        {
            if($subscription_payment == 'Prepaid' && $subscription_price_type == 'Per-student')
            {
                $enrolment_status = 'Inactive';
            }
            if($subscription_payment == 'Trial' && $subscription_price_type == 'Per-student')
            {
                $enrolment_status = 'Inactive';
            }
        }

        $this->validate($request, [
            'pic'                       => ['sometimes', 'image', 'max:1999'],
            'name'                      => ['required', 'string', 'max:191'],
            'gender'                    => ['required'],
            'date_of_birth'             => ['required', 'date'],
            'religion'                  => ['required'],
            'nationality'               => ['required'],
            'ailment'                   => ['required'],
            'disability'                => ['required'],
            'medication'                => ['required'],
            'schoolclass_id'            => ['required']
        ]);
        
        $arm = Arm::find($request->input('schoolclass_id'));

        $number = $school_id.'.'.time();

        if(strlen($request->input('email')) > 0)
        {
            $this->validate($request, [
                'email' => ['email', 'max:191', 'unique:users']
            ]);

            $email = strtolower($request->input('email'));
        }
        else
        {
            $email = $number.'@school.portal';
        }

        if(strlen($request->input('registration_number')) > 0)
        {
            $registration_number = $request->input('registration_number');
            $db_check = array(
                'school_id' => $school_id,
                'registration_number' => $registration_number
            );
            $candidate = Student::where($db_check)->get();
            if(!empty($candidate))
            {
                $request->session()->flash('error', 'The registration number: "'.$registration_number.'", is in use.');
                return redirect()->route('students.create');
            }
        }
        else
        {
            $registration_number = $number;
        }

        $user = new User;

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

        $user->usertype = 'Non-client';
        $user->role     = 'Student';
        $user->name     = ucwords(strtolower($request->input('name')));
        $user->gender   = $request->input('gender');
        $user->email    = $email;
        $user->password = Hash::make('password');

        $user->save();

        $student = new Student;

        $student->user_id                   = $user->id;
        $student->school_id                 = $school_id;
        $student->registration_number       = $registration_number;
        $student->hobbies                   = ucwords(strtolower($request->input('hobbies')));
        $student->ailment                   = $request->input('ailment');
        $student->disability                = $request->input('disability');
        $student->medication                = $request->input('medication');
        $student->health_detail             = $request->input('health_detail');
        $student->date_of_birth             = $request->input('date_of_birth');
        $student->phone                     = $request->input('phone');
        $student->nationality               = ucwords(strtolower($request->input('nationality')));
        $student->state_of_origin           = ucwords(strtolower($request->input('state_of_origin')));
        $student->lga_of_origin             = ucwords(strtolower($request->input('lga_of_origin')));
        $student->religion                  = $request->input('religion');
        $student->last_school_attended      = ucwords(strtolower($request->input('last_school_attended')));
        $student->last_class_passed         = ucwords(strtolower($request->input('last_class_passed')));
        $student->schoolclass_id            = $arm->schoolclass->id;
        $student->created_by                = $user_id;

        $student->save();

        $enrolment = new Enrolment;

        $enrolment->subscription_id = $data['term']->subscription_id;
        $enrolment->user_id = $user->id;
        $enrolment->student_id = $student->id;
        $enrolment->term_id = $term_id;
        $enrolment->arm_id = $arm->id;
        $enrolment->schoolclass_id = $arm->schoolclass->id;
        $enrolment->school_id = $school_id;
        $enrolment->fee_update_by = 0;  
        $enrolment->status = $enrolment_status;
        $enrolment->access_update_by = 0;
        $enrolment->created_by = $user_id;

        $enrolment->save();

        foreach($enrolment->arm->classsubjects as $classsubject)
        {
            if($classsubject->type == 'Compulsory')
            {
                $enrolled_for_this_subject = 0;
                foreach($enrolment->results as $result_slip)
                {
                    if($enrolled_for_this_subject == 0 && $result_slip->classsubject_id == $classsubject->id)
                    {
                        $enrolled_for_this_subject++;
                    }
                }
                if($enrolled_for_this_subject == 0)
                {
                    $studentsubject = new Result;
        
                    $studentsubject->school_id = $school_id;
                    $studentsubject->term_id = $term_id;
                    $studentsubject->enrolment_id = $enrolment->id;
                    $studentsubject->classsubject_id = $classsubject->id;
                    $studentsubject->resulttemplate_id = $arm->resulttemplate_id;
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
                    $studentsubject->subjectteachercomment_by  = 0;
                    $studentsubject->subjectteacher_comment  = '';
        
                    $studentsubject->save();
                }
            }
        }

        // ensure the accuracy of the final price for post-paid orders
        if($subscription_payment == 'Post-paid' && $subscription_price_type == 'Per-student')
        {
            $db_check = array(
                'subscription_id' => $data['term']->subscription_id
            );
            $order = Order::find($subscription_order_id);
            $order->final_price = $subscription_unit_price * count(Enrolment::where($db_check)->get()); 
            $order->save();
        }
        // End - ensure the accuracy of the final price for post-paid orders

        if($enrolment_status == 'Inactive')
        {
            $request->session()->flash('success', 'Student registered successfully into '.$arm->schoolclass->name.' '.$arm->name);
            return redirect()->route('enrolments.show', $enrolment->id);
        }
        else
        {
            $request->session()->flash('success', 'Student registered successfully into '.$arm->schoolclass->name.' '.$arm->name);
            return redirect()->route('enrolments.index');
        }
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
        
        $db_check = array(
            'student_id' => $id,
            'term_id' => $data['term']->id
        );
        $enrolment = Enrolment::where($db_check)->get();
        if(empty($enrolment))
        {
            return redirect()->route('dashboard');
        }
        elseif($enrolment->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['enrolment'] = $enrolment[0];
        
        $data['arm'] = Arm::find($data['enrolment']->arm->id);
        if(empty($data['arm']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['arm']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        session(['arm_id' => $data['arm']->id]);

        $data['student_manager'] = 'No';
        $data['student_privilege_manager'] = 'No';
        $data['classarm_manager'] = 'No';
        $data['fees_manager'] = 'No';
        $data['calendar_manager'] = 'No';
        $data['sessionterm_manager'] = 'No';
        if(Auth::user()->role == 'Consultant' || Auth::user()->role == 'Director')
        {
            $data['student_manager'] = 'Yes';
            $data['student_privilege_manager'] = 'Yes';
            $data['classarm_manager'] = 'Yes';
            $data['fees_manager'] = 'Yes';
            $data['calendar_manager'] = 'Yes';
            $data['sessionterm_manager'] = 'Yes';
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
            if($data['staff']->manage_calendars == 'Yes')
            {
                $data['calendar_manager'] = 'Yes';
            }
            if($data['staff']->manage_session_terms == 'Yes')
            {
                $data['sessionterm_manager'] = 'Yes';
            }
        }

        return view('students.show')->with($data);
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
