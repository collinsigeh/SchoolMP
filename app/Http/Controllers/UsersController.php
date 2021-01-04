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

class UsersController extends Controller
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

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }
        
        $data['users'] = User::where('role', '!=', 'Owner')->orderBy('name', 'asc')->simplePaginate(20);

        return view('users.index')->with($data);
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

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        return view('users.create')->with($data);
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

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'role'      => ['required', 'string', 'max:191'],
            'name'      => ['required', 'string', 'max:191'],
            'email'     => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'pic'       => ['sometimes', 'image', 'max:1999']
        ]);

        $user = new User;

        if($request->input('role') == 'System')
        {
            $usertype = 'Admin';
        }
        elseif($request->input('role') == 'Consultant')
        {
            $usertype = 'Client';
        }
        else
        {
            $usertype = 'Non-client';
        }

        $user->usertype = $usertype;
        $user->role     = $request->input('role');
        $user->name     = ucwords($request->input('name'));
        $user->email    = strtolower($request->input('email'));
        $user->password = Hash::make($request->input('password'));

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

        $user->save();
        
        $request->session()->flash('success', 'User created.');

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }
        
        $data['thisuser'] = User::find($id);

        if(empty($data['thisuser']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['thisuser']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('users.show')->with($data);
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

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        $data['thisuser'] = User::find($id);

        if(empty($data['thisuser']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['thisuser']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('users.edit')->with($data);
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
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'name'      => ['required', 'string', 'max:191'],
            'gender'    => ['required'],
            'email'     => ['required', 'string', 'email', 'max:191', "unique:users,email,$id"],
            'status'    => ['required'],
            'pic'       => ['sometimes', 'image', 'max:1999']
        ]);

        $user = User::find($id);

        $user->name     = ucwords($request->input('name'));
        $user->gender   = $request->input('gender');
        $user->email    = strtolower($request->input('email'));
        $user->status   = $request->input('status');

        if($request->hasFile('pic'))
        {
            $image = $request->file('pic');
            $filename = time() . '-' . rand(1,9) . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/profile/' . $filename);
            Image::make($image)->resize(300,300)->save($location);

            $user->pic = $filename;
        }

        $user->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('users.edit', $id);
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

        if($id == $user_id)
        {
            $request->session()->flash('error', "Error: Attempt to delete own resource.");
            return redirect()->route('users.show', $id);
        }
        
        $db_check = array(
            'id' => $id
        );
        $user = User::where($db_check)->get();
        if(empty($user))
        {
            $request->session()->flash('error', "Error: Attempt to delete unavailable resource.");
            return redirect()->route('users.show', $id);
        }
        else
        {
            if(count($user) != 1)
            {
                $request->session()->flash('error', "Error: Issue with resource specification.");
                return redirect()->route('users.show', $id);
            }
        }
        $user = $user[0];

        if($user->role == 'Director')
        {
            $director_user = $user;

            $has_term = Term::where('created_by', $director_user->id)->get();
            if(!empty($has_term))
            {
                if($has_term->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 1.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_subject = Subject::where('user_id', $director_user->id)->get();
            if(!empty($has_subject))
            {
                if($has_subject->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 2.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_student = Student::where('created_by', $director_user->id)->get();
            if(!empty($has_student))
            {
                if($has_student->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 3.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_staff = Staff::where('created_by', $director_user->id)->get();
            if(!empty($has_staff))
            {
                if($has_staff->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 4.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_school = School::where('created_by', $director_user->id)->get();
            if(!empty($has_school))
            {
                if($has_school->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 5.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_schoolclass = Schoolclass::where('user_id', $director_user->id)->get();
            if(!empty($has_schoolclass))
            {
                if($has_schoolclass->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 6.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_resulttemplate = Resulttemplate::where('user_id', $director_user->id)->get();
            if(!empty($has_resulttemplate->count() > 0))
            {
                if($has_resulttemplate->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 7.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_subjectteachercomment = Result::where('subjectteachercomment_by', $director_user->id)->get();
            if(!empty($has_subjectteachercomment))
            {
                if($has_subjectteachercomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 8.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_classteachercomment = Result::where('classteachercomment_by', $director_user->id)->get();
            if(!empty($has_classteachercomment))
            {
                if($has_classteachercomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 9.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_principalcomment = Result::where('principalcomment_by', $director_user->id)->get();
            if(!empty($has_principalcomment))
            {
                if($has_principalcomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 10.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_payment = Payment::where('user_id', $director_user->id)->get();
            if(!empty($has_payment))
            {
                if($has_payment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 11.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_order = Order::where('user_id', $director_user->id)->get();
            if(!empty($has_order))
            {
                if($has_order->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 12.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_item = Item::where('user_id', $director_user->id)->get();
            if(!empty($has_item))
            {
                if($has_item->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 13.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_enrolment1 = Enrolment::where('user_id', $director_user->id)->get();
            if(!empty($has_enrolment1))
            {
                if($has_enrolment1->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 14.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_enrolment2 = Enrolment::where('created_by', $director_user->id)->get();
            if(!empty($has_enrolment2))
            {
                if($has_enrolment2->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 15.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_classteacher = Classteacher::where('user_id', $director_user->id)->get();
            if(!empty($has_classteacher))
            {
                if($has_classteacher->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 16.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_classsubject = Classsubject::where('user_id', $director_user->id)->get();
            if(!empty($has_classsubject))
            {
                if($has_classsubject->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 17.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_arm1 = Arm::where('user_id', $director_user->id)->get();
            if(!empty($has_arm1))
            {
                if($has_arm1->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 18.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_arm2 = Arm::where('created_by', $director_user->id)->get();
            if(!empty($has_arm2))
            {
                if($has_arm2->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a director account having related useful resources 19.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $director_to_delete = Director::where('user_id',$director_user->id)->get();
            
            if(!empty($director_to_delete))
            {
                if($director_to_delete->count() > 0)
                {
                    $director_to_delete = $director_to_delete[0];
                    $director_to_delete->delete();
                }
            }
            $director_user->delete();
            $request->session()->flash('success', 'Record deleted');
        }
        elseif($user->role == 'Staff')
        {
            $staff_user = $user;

            $has_term = Term::where('created_by', $staff_user->id)->get();
            if(!empty($has_term))
            {
                if($has_term->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 1.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_subject = Subject::where('user_id', $staff_user->id)->get();
            if(!empty($has_subject))
            {
                if($has_subject->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 2.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_student = Student::where('created_by', $staff_user->id)->get();
            if(!empty($has_student))
            {
                if($has_student->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 3.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_staff = Staff::where('created_by', $staff_user->id)->get();
            if(!empty($has_staff))
            {
                if($has_staff->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 4.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_school = School::where('created_by', $staff_user->id)->get();
            if(!empty($has_school))
            {
                if($has_school->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 5.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_schoolclass = Schoolclass::where('user_id', $staff_user->id)->get();
            if(!empty($has_schoolclass))
            {
                if($has_schoolclass->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 6.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_resulttemplate = Resulttemplate::where('user_id', $staff_user->id)->get();
            if(!empty($has_resulttemplate->count() > 0))
            {
                if($has_resulttemplate->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 7.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_subjectteachercomment = Result::where('subjectteachercomment_by', $staff_user->id)->get();
            if(!empty($has_subjectteachercomment))
            {
                if($has_subjectteachercomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 8.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_classteachercomment = Result::where('classteachercomment_by', $staff_user->id)->get();
            if(!empty($has_classteachercomment))
            {
                if($has_classteachercomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 9.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_principalcomment = Result::where('principalcomment_by', $staff_user->id)->get();
            if(!empty($has_principalcomment))
            {
                if($has_principalcomment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 10.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_payment = Payment::where('user_id', $staff_user->id)->get();
            if(!empty($has_payment))
            {
                if($has_payment->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 11.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_order = Order::where('user_id', $staff_user->id)->get();
            if(!empty($has_order))
            {
                if($has_order->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 12.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_item = Item::where('user_id', $staff_user->id)->get();
            if(!empty($has_item))
            {
                if($has_item->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 13.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_enrolment1 = Enrolment::where('user_id', $staff_user->id)->get();
            if(!empty($has_enrolment1))
            {
                if($has_enrolment1->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 14.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_enrolment2 = Enrolment::where('created_by', $staff_user->id)->get();
            if(!empty($has_enrolment2))
            {
                if($has_enrolment2->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 15.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_classteacher = Classteacher::where('user_id', $staff_user->id)->get();
            if(!empty($has_classteacher))
            {
                if($has_classteacher->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 16.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_classsubject = Classsubject::where('user_id', $staff_user->id)->get();
            if(!empty($has_classsubject))
            {
                if($has_classsubject->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 17.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_arm1 = Arm::where('user_id', $staff_user->id)->get();
            if(!empty($has_arm1))
            {
                if($has_arm1->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 18.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $has_arm2 = Arm::where('created_by', $staff_user->id)->get();
            if(!empty($has_arm2))
            {
                if($has_arm2->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Attempt to delete a staff account having related useful resources 19.');
                    return redirect()->route('users.show', $id);
                }
            }
            
            $staff_to_delete = Staff::where('user_id',$staff_user->id)->get();
            
            if(!empty($staff_to_delete))
            {
                if($staff_to_delete->count() > 0)
                {
                    $staff_to_delete = $staff_to_delete[0];
                    $staff_to_delete->delete();
                }
            }
            $staff_user->delete();
            $request->session()->flash('success', 'Record deleted');
        }
        elseif($user->role == 'Student')
        {
            $db_check = array(
                'user_id' => $user->id
            );
            $student = Student::where($db_check)->get();
            $student[0]->status = 'Inactive';
            $student[0]->save();
        }
        
        return redirect()->route('users.index');
    }

    /**
     * Display the logged-in user resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
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

        if($data['user']->usertype == 'Client')
        {
            return view('clients.profile')->with($data);
        }
        elseif($data['user']->usertype == 'Non-client')
        {
            if($data['user']->role == 'Student')
            {
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

                return view('students.profile')->with($data);
            }
            elseif($data['user']->role == 'Director')
            {
                if(session('school_id') < 1)
                {
                    return redirect()->route('dashboard');
                }
                $school_id = session('school_id');
                
                $data['school'] = School::find($school_id);

                return view('directors.profile')->with($data);
            }
            elseif($data['user']->role == 'Staff')
            {
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

                return view('staff.profile')->with($data);
            }
            elseif($data['user']->role == 'Guardian')
            {
                if(session('school_id') < 1)
                {
                    return redirect()->route('dashboard');
                }
                $school_id = session('school_id');
                
                $data['school'] = School::find($school_id);
                
                return view('guardians.profile');
            }
            elseif($data['user']->role == 'Affiliate')
            {
                return view('affiliates.profile')->with($data);
            }
            elseif($data['user']->role == 'Partner')
            {
                return view('partners.profile')->with($data);
            }
        }
        elseif($data['user']->usertype == 'Admin')
        {
            if($data['user']->role == 'System')
            {
                return view('system.profile')->with($data);
            }
            elseif($data['user']->role == 'Owner')
            {
                return view('owner.profile')->with($data);
            }
        }

        return redirect()->route('dashboard');
    }

    /**
     * Change password for the logged-in user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changepassword(Request $request, $id)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($user_id != $id)
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::find($id);

        $user->password = Hash::make($request->input('password'));

        $user->save();
        
        $request->session()->flash('success', 'Password updated.');

        return redirect()->route('users.profile');
    }

    /**
     * Change password for the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeuserpassword(Request $request, $id)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = User::find($id);

        $user->password = Hash::make($request->input('password'));

        $user->save();
        
        $request->session()->flash('success', 'Password updated.');

        return redirect()->route('users.show', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileedit()
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

        if($data['user']->usertype == 'Client')
        {
            return view('clients.profileedit')->with($data);
        }
        elseif($data['user']->usertype == 'Non-client')
        {
            if($data['user']->role == 'Student')
            {
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

                return view('students.profileedit')->with($data);
            }
            elseif($data['user']->role == 'Director')
            {
                if(session('school_id') < 1)
                {
                    return redirect()->route('dashboard');
                }
                $school_id = session('school_id');
                
                $data['school'] = School::find($school_id);

                return view('directors.profileedit')->with($data);
            }
            elseif($data['user']->role == 'Staff')
            {
                if(session('school_id') < 1)
                {
                    return redirect()->route('dashboard');
                }
                $school_id = session('school_id');
                
                $data['school'] = School::find($school_id);

                return view('staff.profileedit')->with($data);
            }
            elseif($data['user']->role == 'Guardian')
            {
                if(session('school_id') < 1)
                {
                    return redirect()->route('dashboard');
                }
                $school_id = session('school_id');
                
                $data['school'] = School::find($school_id);
                
                return view('guardians.profileedit')->with($data);
            }
            elseif($data['user']->role == 'Affiliate')
            {
                return view('affiliates.profileedit')->with($data);
            }
            elseif($data['user']->role == 'Partner')
            {
                return view('partners.profileedit');
            }
        }
        elseif($data['user']->usertype == 'Admin')
        {
            if($data['user']->role == 'System')
            {
                return view('system.profileedit')->with($data);
            }
            elseif($data['user']->role == 'Owner')
            {
                return view('owner.profileedit')->with($data);
            }
        }

        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileupdate(Request $request)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }
        
        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        $this->validate($request, [
            'name'      => ['required', 'string', 'max:191'],
            'gender'    => ['required'],
            'email'     => ['required', 'string', 'email', 'max:191', "unique:users,email,$user_id"],
            'pic'       => ['sometimes', 'image', 'max:1999']
        ]);

        $user = User::find($user_id);
        
        $user->name     = ucwords(strtolower($request->input('name')));
        $user->gender   = $request->input('gender');
        $user->email    = strtolower($request->input('email'));

        if($request->hasFile('pic'))
        {
            $image = $request->file('pic');
            $filename = time() . '-' . rand(1,9) . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/profile/' . $filename);
            Image::make($image)->resize(300,300)->save($location);

            $user->pic = $filename;
        }

        $user->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('profile.edit');
    }
}
