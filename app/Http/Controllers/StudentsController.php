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
use App\Cbt;
use App\Attempt;
use App\Question;
use App\Questionattempt;
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
            $new_location = str_replace('shms/public', 'shms.briigo.com', $location);
            Image::make($image)->resize(300,300)->save($new_location);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function term($id = 0)
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

        $db_check = array(
            'user_id' => $user_id
        );
        $data['user'] = User::find($user_id);
        
        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        $db_check = array(
            'user_id'   => $data['user']->id,
            'school_id' => $data['school']->id
        );
        $student = Student::where($db_check)->get();
        if(empty($student))
        {
            return  redirect()->route('dashboard');
        }
        elseif($student->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['student'] = $student[0];
        $data['enrolment'] = Enrolment::find($id);
        if(empty($data['enrolment']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['enrolment']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        session(['enrolment_id' => $data['enrolment']->id]);

        return view('students.term')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subject($id = 0)
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

        $db_check = array(
            'user_id' => $user_id
        );
        $data['user'] = User::find($user_id);
        
        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        $db_check = array(
            'user_id'   => $data['user']->id,
            'school_id' => $data['school']->id
        );
        $student = Student::where($db_check)->get();
        if(empty($student))
        {
            return  redirect()->route('dashboard');
        }
        elseif($student->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['student'] = $student[0];

        $data['result_slip'] = Result::find($id);
        if(empty($data['result_slip']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['result_slip']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('students.subject')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lessons($id = 0)
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

        $db_check = array(
            'user_id' => $user_id
        );
        $data['user'] = User::find($user_id);
        
        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        $db_check = array(
            'user_id'   => $data['user']->id,
            'school_id' => $data['school']->id
        );
        $student = Student::where($db_check)->get();
        if(empty($student))
        {
            return  redirect()->route('dashboard');
        }
        elseif($student->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['student'] = $student[0];

        $data['result_slip'] = Result::find($id);
        if(empty($data['result_slip']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['result_slip']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('students.lessons')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cbts($id = 0)
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

        $db_check = array(
            'user_id' => $user_id
        );
        $data['user'] = User::find($user_id);
        
        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        $db_check = array(
            'user_id'   => $data['user']->id,
            'school_id' => $data['school']->id
        );
        $student = Student::where($db_check)->get();
        if(empty($student))
        {
            return  redirect()->route('dashboard');
        }
        elseif($student->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['student'] = $student[0];

        $data['result_slip'] = Result::find($id);
        if(empty($data['result_slip']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['result_slip']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        session(['result_slip_id' => $data['result_slip']->id]);

        return view('students.cbts')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cbt(Request $request, $id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        if($id < 1)
        {
            $request->session()->flash('error', 'Error 1');
            return redirect()->route('dashboard');
        }

        $user_id = Auth::user()->id;

        $db_check = array(
            'user_id' => $user_id
        );
        $data['user'] = User::find($user_id);
        
        if(session('school_id') < 1)
        {
            $request->session()->flash('error', 'Error 2');
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        if(session('result_slip_id') < 1)
        {
            $request->session()->flash('error', 'Error 3');
            return redirect()->route('dashboard');
        }
        $data['result_slip'] = Result::find(session('result_slip_id'));
        
        $db_check = array(
            'user_id'   => $data['user']->id,
            'school_id' => $data['school']->id
        );
        $student = Student::where($db_check)->get();
        if(empty($student))
        {
            $request->session()->flash('error', 'Error 4');
            return  redirect()->route('dashboard');
        }
        elseif($student->count() < 1)
        {
            $request->session()->flash('error', 'Error 5');
            return  redirect()->route('dashboard');
        }
        $data['student'] = $student[0];

        $data['cbt'] = Cbt::find($id);
        if(empty($data['cbt']))
        {
            $request->session()->flash('error', 'Error 6');
            return redirect()->route('dashboard');
        }
        elseif($data['cbt']->count() < 1)
        {
            $request->session()->flash('error', 'Error 7');
            return  redirect()->route('dashboard');
        }

        //check for the cbt status and attempt before granting access to exam instructions'
        if($data['cbt']->type == 'Practice Quiz')
        {
            if($data['result_slip']->enrolment->access_assignment != 'Yes')
            {
                $request->session()->flash('error', 'You do NOT 4have the permission to partake in the selected CBT.');
                return redirect()->route('students.cbts', $data['result_slip']->id);
            }
        }
        else
        {
            if($data['cbt']->type == 'Exam')
            {
                if($data['result_slip']->enrolment->access_exam != 'Yes')
                {
                    $request->session()->flash('error', 'You do NOT have the permission to partake in the selected CBT.');
                    return redirect()->route('students.cbts', $data['result_slip']->id);
                }
            }
            else
            {
                if($data['result_slip']->enrolment->access_ca != 'Yes')
                {
                    $request->session()->flash('error', 'You do NOT have the permission to partake in the selected CBT.');
                    return redirect()->route('students.cbts', $data['result_slip']->id);
                }
            }
        }
        if (count($data['cbt']->questions) != $data['cbt']->no_questions) {
            $request->session()->flash('error', 'The CBT questions are not complete.');
            return redirect()->route('students.cbts', $data['result_slip']->id);
        }
        if ($data['cbt']->status != 'Approved') {
            $request->session()->flash('error', 'Attempt to view a yet to be approved CBT');
            return redirect()->route('students.cbts', $data['result_slip']->id);
        }
        $attempts = 0;
        foreach($data['result_slip']->enrolment->attempts as $attempt)
        {
            if($attempt->cbt_id == $data['cbt']->id)
            {
                $attempts++;
            }
        }
        if ($attempts >= $data['cbt']->no_attempts && $data['cbt']->type != 'Practice Quiz') {
            $request->session()->flash('error', 'You have completed your allowed attempts for the selected CBT.');
            return redirect()->route('students.cbts', $data['result_slip']->id);
        }

        return view('students.cbt')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cbt_live(Request $request, $id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        if($id < 1)
        {
            $request->session()->flash('error', 'Error 1');
            return redirect()->route('dashboard');
        }

        $user_id = Auth::user()->id;

        $db_check = array(
            'user_id' => $user_id
        );
        $data['user'] = User::find($user_id);
        
        if(session('school_id') < 1)
        {
            $request->session()->flash('error', 'Error 2');
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        if(session('result_slip_id') < 1)
        {
            $request->session()->flash('error', 'Error 3');
            return redirect()->route('dashboard');
        }
        $data['result_slip'] = Result::find(session('result_slip_id'));
        
        $db_check = array(
            'user_id'   => $data['user']->id,
            'school_id' => $data['school']->id
        );
        $student = Student::where($db_check)->get();
        if(empty($student))
        {
            $request->session()->flash('error', 'Error 4');
            return  redirect()->route('dashboard');
        }
        elseif($student->count() < 1)
        {
            $request->session()->flash('error', 'Error 5');
            return  redirect()->route('dashboard');
        }
        $data['student'] = $student[0];

        $data['cbt'] = Cbt::find($id);
        if(empty($data['cbt']))
        {
            $request->session()->flash('error', 'Error 6');
            return redirect()->route('dashboard');
        }
        elseif($data['cbt']->count() < 1)
        {
            $request->session()->flash('error', 'Error 7');
            return  redirect()->route('dashboard');
        }

        //check for the cbt status and attempt before granting access to exam instructions'
        if($data['cbt']->type == 'Practice Quiz')
        {
            if($data['result_slip']->enrolment->access_assignment != 'Yes')
            {
                $request->session()->flash('error', 'You do NOT have the permission to partake in the selected CBT.');
                return redirect()->route('students.cbts', $data['result_slip']->id);
            }
        }
        else
        {
            if($data['cbt']->type == 'Exam')
            {
                if($data['result_slip']->enrolment->access_exam != 'Yes')
                {
                    $request->session()->flash('error', 'You do NOT have the permission to partake in the selected CBT.');
                    return redirect()->route('students.cbts', $data['result_slip']->id);
                }
            }
            else
            {
                if($data['result_slip']->enrolment->access_ca != 'Yes')
                {
                    $request->session()->flash('error', 'You do NOT have the permission to partake in the selected CBT.');
                    return redirect()->route('students.cbts', $data['result_slip']->id);
                }
            }
        }
        if (count($data['cbt']->questions) != $data['cbt']->no_questions) {
            $request->session()->flash('error', 'The CBT questions are not complete.');
            return redirect()->route('students.cbts', $data['result_slip']->id);
        }
        if ($data['cbt']->status != 'Approved') {
            $request->session()->flash('error', 'Attempt to view a yet to be approved CBT');
            return redirect()->route('students.cbts', $data['result_slip']->id);
        }
        $attempts = 0;
        foreach($data['result_slip']->enrolment->attempts as $attempt)
        {
            if($attempt->cbt_id == $data['cbt']->id)
            {
                $attempts++;
            }
        }
        if ($attempts >= $data['cbt']->no_attempts && $data['cbt']->type != 'Practice Quiz') {
            $request->session()->flash('error', 'You have completed your allowed attempts for the selected CBT.');
            return redirect()->route('students.cbts', $data['result_slip']->id);
        }

        //creating the attempt
        $supervisor_id = 0;
        if(strlen($data['cbt']->supervisor_pass) > 0)
        {
            $this->validate($request, [
                'supervisor_email' => ['required', 'email'],
                'exam_passcode' => ['required']
            ]);

            if($request->input('exam_passcode') != $data['cbt']->supervisor_pass)
            {
                $request->session()->flash('error', 'Incorrect passcode.');
                return redirect()->route('students.cbt', $data['cbt']->id);
            }
            $db_check = array(
                'email' => $request->input('supervisor_email')
            );
            $supervisor = User::where($db_check)->get();
            if(count($supervisor) < 1)
            {
                $request->session()->flash('error', 'Unrecognised supervisor email.');
                return redirect()->route('students.cbt', $data['cbt']->id);
            }elseif($supervisor[0]->role == 'Student')
            {
                $request->session()->flash('error', 'The supervisor email entered is for a student.');
                return redirect()->route('students.cbt', $data['cbt']->id);
            }elseif($supervisor[0]->role == 'Guardian')
            {
                $request->session()->flash('error', 'The supervisor email entered is for a guardian.');
                return redirect()->route('students.cbt', $data['cbt']->id);
            }

            $supervisor_id = $supervisor[0]->id;
        }

        $attempt = new Attempt;

        $attempt->school_id = $school_id;
        $attempt->subject_id = $data['cbt']->subject_id;
        $attempt->term_id = $data['cbt']->term_id;
        $attempt->cbt_id = $data['cbt']->id;
        $attempt->enrolment_id = $data['result_slip']->enrolment_id;
        $attempt->total_correct = 0;
        $attempt->status = 'NOT Completed';
        $attempt->user_id = $supervisor_id;

        $attempt->save();
        session(['attempt_id' => $attempt->id]);

        return redirect()->route('students.cbt_started', 1);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cbt_started(Request $request, $id = 1)
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
        
        if(session('school_id') < 1)
        {
            $request->session()->flash('error', 'Error 1.1');
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        if(session('attempt_id') < 1)
        {
            $request->session()->flash('error', 'Error 1.2');
            return redirect()->route('dashboard');
        }
        $attempt = Attempt::find(session('attempt_id'));
        if(empty($attempt))
        {
            $request->session()->flash('error', 'Error 1.3');
            return redirect()->route('dashboard');
        }
        if($attempt->status == 'Completed')
        {
            return redirect()->route('dashboard');
        }

        $db_check = array(
            'cbt_id' => $attempt->cbt_id
        );
        $questions = Question::where($db_check)->get();
        if($id < 1 OR $id > count($questions))
        {
            $request->session()->flash('error', 'The requested question is out of range.');
            return redirect()->route('students.cbt_started', 1);
        }

        $data['question_no'] = $id;
        $real_question_no = $id - 1;
        $data['question'] = $questions[$real_question_no];

        $data['time_remaining'] = 0;
        $time_spent = time() - strtotime($attempt->created_at);
        $time_remaining = ($data['question']->cbt->duration * 60) - $time_spent;
        if($time_remaining > 0)
        {
            $data['time_remaining'] = $time_remaining;
        }
        else
        {
            return redirect()->route('students.cbt_completed', $attempt->id);
        }

        return view('students.cbt_started_2')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cbt_submitted(Request $request, $id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $question = Question::find($id);
        if(empty($question))
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'question_no'   => ['required', 'numeric', 'min:1'],
            'attempt_id'    => ['required', 'numeric', 'min:1']
        ]);

        $attempt = Attempt::find($request->input('attempt_id'));
        if(empty($attempt))
        {
            return redirect()->route('dashboard');
        }
        elseif($attempt->status == 'Completed')
        {
            return redirect()->route('dashboard');
        }

        // check if his time has expired to do nothing for expired time
        $time_spent = time() - strtotime($attempt->created_at);
        $time_remaining = ($question->cbt->duration * 60) - $time_spent;
        if($time_remaining > 0)
        {
            $total_correct_subtraction = $total_correct_addition = 0;
            $option_status = 'Wrong';
            if($request->input('option') == $question->correct_option)
            {
                $option_status = 'Right';
                $total_correct_addition = 1;
            }
            
            // check if he has answered this question before in this very attempt this will determine 
            // whether a new storage or an update of previous storage
            $question_answered_prev = 'No';
            $questionattempt_id = 0;
            foreach ($attempt->questionattempts as $questionattempt) {
                if ($question_answered_prev == 'No') {
                    if($questionattempt->question_id == $id)
                    {
                        $question_answered_prev = 'Yes';
                        $questionattempt_id = $questionattempt->id;
                    }
                }
            }
            if($question_answered_prev == 'Yes')
            {
                $questionattempt = Questionattempt::find($questionattempt_id);

                if($questionattempt->option_status == 'Right')
                {
                    $total_correct_subtraction = 1;
                }

                $questionattempt->option_selected   = $request->input('option');
                $questionattempt->option_status     = $option_status;
            }
            else
            {
                $questionattempt = new Questionattempt;

                $questionattempt->school_id         = $attempt->school_id;
                $questionattempt->term_id           = $attempt->term_id;
                $questionattempt->cbt_id            = $attempt->cbt_id;
                $questionattempt->enrolment_id      = $attempt->enrolment_id;
                $questionattempt->attempt_id        = $attempt->id;
                $questionattempt->question_id       = $question->id;
                $questionattempt->option_selected   = $request->input('option');
                $questionattempt->option_status     = $option_status;
            }
            $questionattempt->save();

            $attempt->total_correct = $attempt->total_correct - $total_correct_subtraction + $total_correct_addition;
            $attempt->save();
        }
        else
        {
            return redirect()->route('students.cbt_completed', $attempt->id);
        }

        // redirect using the next question (if available) details
        if($request->input('question_no') < count($question->cbt->questions) && $time_remaining > 0)
        {
            $next_question = $request->input('question_no') + 1;
            return redirect()->route('students.cbt_started', $next_question);
        }
        else
        {
            return redirect()->route('students.cbt_completed', $attempt->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cbt_completed($id = 0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['attempt'] = $attempt = Attempt::find($id);
        if(empty($data['attempt']))
        {
            return redirect()->route('dashboard');
        }
        
        if($attempt->status != 'Completed')
        {
            $attempt->status = 'Completed';
            $attempt->save();
        }

        return view('students.cbt_completed')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment_history($id = 0)
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

        $db_check = array(
            'user_id' => $user_id
        );
        $data['user'] = User::find($user_id);
        
        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $data['school'] = School::find($school_id);
        
        $db_check = array(
            'user_id'   => $data['user']->id,
            'school_id' => $data['school']->id
        );
        $student = Student::where($db_check)->get();
        if(empty($student))
        {
            return  redirect()->route('dashboard');
        }
        elseif($student->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['student'] = $student[0];
        $data['enrolment'] = Enrolment::find($id);
        if(empty($data['enrolment']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['enrolment']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        session(['enrolment_id' => $data['enrolment']->id]);

        return view('students.payment_history')->with($data);
    }
}
