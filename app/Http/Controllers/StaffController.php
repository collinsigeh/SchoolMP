<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Term;
use App\Subscription;
use App\Subject;
use App\Student;
use App\Schoolclass;
use App\Resulttemplate;
use App\Result;
use App\Payment;
use App\Order;
use App\Item;
use App\Enrolment;
use App\Classteacher;
use App\Classsubject;
use App\Arm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use Storage;

class StaffController extends Controller
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
        $data['allstaff'] = Staff::where($db_check)->orderBy('designation', 'asc')->simplePaginate(25);

        return view('staff.index')->with($data);
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

        return view('staff.create')->with($data);
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
        $data['user'] = User::find($user_id);
        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'designation'               => ['required', 'string', 'max:191'],
            'name'                      => ['required', 'string', 'max:191'],
            'phone'                     => ['required', 'string', 'max:191'],
            'gender'                    => ['required'],
            'pic'                       => ['sometimes', 'image', 'max:1999'],
            'manage_staff_account'      => ['required'],
            'manage_all_results'        => ['required'],
            'manage_students_account'   => ['required'],
            'manage_students_promotion' => ['required'],
            'manage_students_privileges'=> ['required'],
            'manage_guardians'          => ['required'],
            'manage_session_terms'      => ['required'],
            'manage_class_arms'         => ['required'],
            'manage_subjects'           => ['required'],
            'manage_requests'           => ['required'],
            'manage_finance_report'     => ['required'],
            'manage_other_reports'      => ['required'],
            'manage_subscriptions'      => ['required'],
            'manage_fees_products'      => ['required'],
            'manage_received_payments'  => ['required'],
            'manage_calendars'          => ['required']
        ]); 

        if(strlen($request->input('email')) > 0)
        {
            $this->validate($request, [
                'email' => ['email', 'max:191', 'unique:users']
            ]);
            $email = strtolower($request->input('email'));
        }
        else
        {
            $email = 'staff'.time().'_'.$school_id.'.'.rand(1,9).'@school.portal';
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
        $user->role     = 'Staff';
        $user->name     = ucwords(strtolower($request->input('name')));
        $user->gender   = $request->input('gender');
        $user->email    = $email;
        $user->password = Hash::make('password');

        $user->save();

        $number  = strtoupper(trim($request->input('employee_number')));
        if(strlen($number) > 0)
        {
            $db_check = array(
                'employee_number' => $number,
                'school_id' => $school_id
            );
            $staffcases = Staff::where($db_check)->get();
            if(!empty($staffcases))
            {
                if($staffcases->count() > 0)
                {
                    $request->session()->flash('error', 'There is another staff with employee number: '.$number);
                    return redirect()->route('staff.create');
                }
            }
        }
        else
        {
            $number = 'SN-'.date('Y', time()).'/'.$school_id.'/'.$user->id;
        }

        $staff = new Staff;

        $staff->user_id                     = $user->id;
        $staff->school_id                   = $school_id;
        $staff->designation                 = ucwords(strtolower($request->input('designation')));
        $staff->phone                       = $request->input('phone');
        $staff->address                     = $request->input('address');
        $staff->qualification               = $request->input('qualification');
        $staff->employee_number             = $number;
        $staff->employee_since              = $request->input('employee_since');
        $staff->status                      = 'Active';
        $staff->manage_staff_account        = $request->input('manage_staff_account');
        $staff->manage_all_results          = $request->input('manage_all_results');
        $staff->manage_students_account     = $request->input('manage_students_account');
        $staff->manage_students_promotion   = $request->input('manage_students_promotion');
        $staff->manage_students_privileges  = $request->input('manage_students_privileges');
        $staff->manage_guardians            = $request->input('manage_guardians');
        $staff->manage_session_terms        = $request->input('manage_session_terms');
        $staff->manage_class_arms           = $request->input('manage_class_arms');
        $staff->manage_subjects             = $request->input('manage_subjects');
        $staff->manage_requests             = $request->input('manage_requests');
        $staff->manage_finance_report       = $request->input('manage_finance_report');
        $staff->manage_other_reports        = $request->input('manage_other_reports');
        $staff->manage_subscriptions        = $request->input('manage_subscriptions');
        $staff->manage_fees_products        = $request->input('manage_fees_products');
        $staff->manage_received_payments    = $request->input('manage_received_payments');
        $staff->manage_calendars            = $request->input('manage_calendars');
        $staff->created_by                  = $user_id;

        $staff->save();

        
        $request->session()->flash('success', 'Staff added.');

        return redirect()->route('staff.show', $staff->id);
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
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
        
        $data['this_staff'] = Staff::find($id);

        if(empty($data['this_staff']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['this_staff']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('staff.show')->with($data);
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
        
        $data['school'] = School::find($school_id);

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
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
        
        $data['this_staff'] = Staff::find($id);

        if(empty($data['this_staff']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['this_staff']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('staff.edit')->with($data);
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

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');
        
        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);
        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'designation'               => ['required', 'string', 'max:191'],
            'employee_number'           => ['required', 'string', 'max:191'],
            'status'                    => ['required'],
            'phone'                     => ['required', 'string', 'max:191'],
            'manage_staff_account'      => ['required'],
            'manage_all_results'        => ['required'],
            'manage_students_account'   => ['required'],
            'manage_students_promotion' => ['required'],
            'manage_students_privileges'=> ['required'],
            'manage_guardians'          => ['required'],
            'manage_session_terms'      => ['required'],
            'manage_class_arms'         => ['required'],
            'manage_subjects'           => ['required'],
            'manage_requests'           => ['required'],
            'manage_finance_report'     => ['required'],
            'manage_other_reports'      => ['required'],
            'manage_subscriptions'      => ['required'],
            'manage_fees_products'      => ['required'],
            'manage_received_payments'  => ['required'],
            'manage_calendars'          => ['required']
        ]);

        $number  = strtoupper(trim($request->input('employee_number')));
        $db_check = array(
            'employee_number' => $number,
            'school_id' => $school_id
        );
        $duplicates = Staff::where($db_check)->where('id', '!=', $id)->get();
        if(!empty($duplicates))
        {
            if($duplicates->count() > 0)
            {
                $request->session()->flash('error', 'There is another staff with employee number: '.$number);
                return redirect()->route('staff.edit', $id);
            }
        }

        $staff = Staff::find($id);

        $staffuser = User::find($staff->user_id);
        $staffuser->status = $request->input('status');
        $staffuser->save();
        
        $staff->designation                 = ucwords(strtolower($request->input('designation')));
        $staff->phone                       = $request->input('phone');
        $staff->address                     = $request->input('address');
        $staff->qualification               = $request->input('qualification');
        $staff->employee_number             = $number;
        $staff->employee_since              = $request->input('employee_since');
        $staff->status                      = $request->input('status');
        $staff->manage_staff_account        = $request->input('manage_staff_account');
        $staff->manage_all_results          = $request->input('manage_all_results');
        $staff->manage_students_account     = $request->input('manage_students_account');
        $staff->manage_students_promotion   = $request->input('manage_students_promotion');
        $staff->manage_students_privileges  = $request->input('manage_students_privileges');
        $staff->manage_guardians            = $request->input('manage_guardians');
        $staff->manage_session_terms        = $request->input('manage_session_terms');
        $staff->manage_class_arms           = $request->input('manage_class_arms');
        $staff->manage_subjects             = $request->input('manage_subjects');
        $staff->manage_requests             = $request->input('manage_requests');
        $staff->manage_finance_report       = $request->input('manage_finance_report');
        $staff->manage_other_reports        = $request->input('manage_other_reports');
        $staff->manage_subscriptions        = $request->input('manage_subscriptions');
        $staff->manage_fees_products        = $request->input('manage_fees_products');
        $staff->manage_received_payments    = $request->input('manage_received_payments');
        $staff->manage_calendars            = $request->input('manage_calendars');

        $staff->save();

        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('staff.edit', $id);
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

        $staff = Staff::find($id);
        if(empty($staff))
        {
            $request->session()->flash('error', 'ERROR: An attempt to delete unavailable resource.');
        }
        else
        {
            if($staff->count() < 1)
            {
                return  redirect()->route('dashboard');
            }

            if(Auth::user()->id == $staff->user_id)
            {
                $request->session()->flash('error', 'ERROR: An attempt to delete own resource.');
                return redirect()->route('staff.show', $id);
            }

            $staff_user = User::find($staff->user_id);

            //check to see that the staff user hasn't got anything to his name before he can be deleted.
            $has_term = Term::where('created_by', $staff_user->id)->get();
            if(!empty($has_term))
            {
                if($has_term->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 1.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_subject = Subject::where('user_id', $staff_user->id)->get();
            if(!empty($has_subject))
            {
                if($has_subject->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 2.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_student = Student::where('created_by', $staff_user->id)->get();
            if(!empty($has_student))
            {
                if($has_student->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 3.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_staff = Staff::where('created_by', $staff_user->id)->get();
            if(!empty($has_staff))
            {
                if($has_staff->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 4.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_school = School::where('created_by', $staff_user->id)->get();
            if(!empty($has_school))
            {
                if($has_school->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 5.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_schoolclass = Schoolclass::where('user_id', $staff_user->id)->get();
            if(!empty($has_schoolclass))
            {
                if($has_schoolclass->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 6.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_resulttemplate = Resulttemplate::where('user_id', $staff_user->id)->get();
            if(!empty($has_resulttemplate->count() > 0))
            {
                if($has_resulttemplate->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 7.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_subjectteachercomment = Result::where('subjectteachercomment_by', $staff_user->id)->get();
            if(!empty($has_subjectteachercomment))
            {
                if($has_subjectteachercomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 8.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_classteachercomment = Result::where('classteachercomment_by', $staff_user->id)->get();
            if(!empty($has_classteachercomment))
            {
                if($has_classteachercomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 9.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_principalcomment = Result::where('principalcomment_by', $staff_user->id)->get();
            if(!empty($has_principalcomment))
            {
                if($has_principalcomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 10.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_payment = Payment::where('user_id', $staff_user->id)->get();
            if(!empty($has_payment))
            {
                if($has_payment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 11.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_order = Order::where('user_id', $staff_user->id)->get();
            if(!empty($has_order))
            {
                if($has_order->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 12.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_item = Item::where('user_id', $staff_user->id)->get();
            if(!empty($has_item))
            {
                if($has_item->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 13.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_enrolment1 = Enrolment::where('user_id', $staff_user->id)->get();
            if(!empty($has_enrolment1))
            {
                if($has_enrolment1->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 14.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_enrolment2 = Enrolment::where('created_by', $staff_user->id)->get();
            if(!empty($has_enrolment2))
            {
                if($has_enrolment2->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 15.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_classteacher = Classteacher::where('user_id', $staff_user->id)->get();
            if(!empty($has_classteacher))
            {
                if($has_classteacher->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 16.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_classsubject = Classsubject::where('user_id', $staff_user->id)->get();
            if(!empty($has_classsubject))
            {
                if($has_classsubject->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 17.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_arm1 = Arm::where('user_id', $staff_user->id)->get();
            if(!empty($has_arm1))
            {
                if($has_arm1->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 18.');
                    return redirect()->route('staff.show', $id);
                }
            }
            
            $has_arm2 = Arm::where('created_by', $staff_user->id)->get();
            if(!empty($has_arm2))
            {
                if($has_arm2->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 19.');
                    return redirect()->route('staff.show', $id);
                }
            }


            $staff->delete();
            $staff_user->delete();
            $request->session()->flash('success', 'Record deleted');
        }

        return redirect()->route('staff.index');
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

        return view('staff.new')->with($data);
    }

    /**
     * Store a newly created resource in storage.
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
        $data['user'] = User::find($user_id);
        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'designation'   => ['required', 'string', 'max:75'],
            'phone'         => ['required', 'string', 'max:25'],
            'email'         => ['required', 'email', 'max:191']
        ]);

        $email = strtolower(trim($request->input('email')));

        $user = User::where('email', $email)->get();

        if(empty($user))
        {
            $request->session()->flash('error', 'Invalid email : <b>'.$email.'</b>');
            return redirect()->route('staff.new');
        }
        elseif($user->count() < 1)
        {
            $request->session()->flash('error', 'Invalid email : <b>'.$email.'</b>');
            return redirect()->route('staff.new');
        }

        if($user[0]['role'] == 'Student')
        {
            $request->session()->flash('error', 'Email :<b>'.$email.'</b> belongs to a student');
            return redirect()->route('staff.new');
        }
        elseif($user[0]['role'] == 'Director')
        {
            $request->session()->flash('error', 'Email :<b>'.$email.'</b> belongs to a director');
            return redirect()->route('staff.new');
        }
        
        $db_check = array(
            'user_id' => $user[0]['id'],
            'school_id' => $school_id
        );
        $staff = Staff::where($db_check)->get();

        if(!empty($staff))
        {
            if($staff->count() > 0)
            {
                $request->session()->flash('error', '<b>'.$email.'</b> belongs to a staff already.');
                return redirect()->route('staff.new');
            }
        }

        $number  = strtoupper(trim($request->input('employee_number')));
        if(strlen($number) > 0)
        {
            $db_check = array(
                'employee_number' => $number,
                'school_id' => $school_id
            );
            $staffcases = Staff::where($db_check)->get();
            if(!empty($staffcases))
            {
                if($staffcases->count() > 0)
                {
                    $request->session()->flash('error', 'There is another staff with employee number: '.$number);
                    return redirect()->route('staff.create');
                }
            }
        }
        else
        {
            $number = 'SN-'.date('Y', time()).'/'.$school_id.'/'.$user[0]->id;
        }

        $staff = new Staff;

        $staff->user_id                     = $user[0]->id;
        $staff->school_id                   = $school_id;
        $staff->designation                 = ucwords(strtolower($request->input('designation')));
        $staff->phone                       = $request->input('phone');
        $staff->address                     = '';
        $staff->qualification               = '';
        $staff->employee_number             = $number;
        $staff->employee_since              = $request->input('employee_since');
        $staff->status                      = 'Active';
        $staff->created_by                  = $user_id;

        $staff->save();
        
        $request->session()->flash('success', 'Staff added! Update privileges.');

        return redirect()->route('staff.show', $staff->id);
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
                'manage_staff_account'  => 'Yes'
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
