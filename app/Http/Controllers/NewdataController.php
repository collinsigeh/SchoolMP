<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Staff;
use App\Newstaffdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use Storage;

class NewdataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('newdata.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('newdata.index');
    }    

    /**
     * Show the form for creating a new staff resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_staff(Request $request, $id=0)
    {
        if($id < 1)
        {
            $request->session()->flash('error', 'ERROR 1: You navigated to this page using a wrong URL.');
            return redirect()->route('newdata.index');
        }

        $school = School::find($id);
        if(empty($school))
        {
            $request->session()->flash('error', 'ERROR 2: You navigated to this page using a wrong URL.');
            return redirect()->route('newdata.index');
        }

        $data['school'] = $school;

        return view('newdata.create_staff')->with($data);
    }

    /**
     * Store a newly created staff resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_staff(Request $request)
    {
        $this->validate($request, [
            'school_id'     => ['required'],
            'designation'   => ['required', 'string', 'max:191'],
            'my_classes'    => ['required'],
            'my_subjects'   => ['required'],
            'name'          => ['required', 'string', 'max:191'],
            'phone'         => ['required', 'string', 'max:191'],
            'gender'        => ['required'],
            'pic'           => ['required', 'image', 'max:1999']
        ]); 

        if($request->input('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = $request->input('school_id');
        $school = School::find($school_id);
        if(empty($school))
        {
            $request->session()->flash('error', 'ERROR 2: You navigated to this page using a wrong URL.');
            return redirect()->route('newdata.index');
        }

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
            $filename = time() . '_' . rand(1,9) . '.' . $image->getClientOriginalExtension();
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
        $staff->employee_since              = '';
        $staff->status                      = 'Active';
        $staff->manage_staff_account        = 'No';
        $staff->manage_all_results          = 'No';
        $staff->manage_students_account     = 'No';
        $staff->manage_students_promotion   = 'No';
        $staff->manage_students_privileges  = 'No';
        $staff->manage_guardians            = 'No';
        $staff->manage_session_terms        = 'No';
        $staff->manage_class_arms           = 'No';
        $staff->manage_subjects             = 'No';
        $staff->manage_requests             = 'No';
        $staff->manage_finance_report       = 'No';
        $staff->manage_other_reports        = 'No';
        $staff->manage_subscriptions        = 'No';
        $staff->manage_fees_products        = 'No';
        $staff->manage_received_payments    = 'No';
        $staff->manage_calendars            = 'No';
        $staff->created_by                  = $user->id;

        $staff->save();

        $newstaffdata = new Newstaffdata;

        $newstaffdata->staff_id     = $staff->id;
        $newstaffdata->my_classes   = $request->input('my_classes');
        $newstaffdata->my_subjects  = $request->input('my_subjects');
        $newstaffdata->status       = 'Pending';

        $newstaffdata->save();

        
        $request->session()->flash('success', 'Your details have been submitted successfully.');

        return redirect()->route('newdata.submission_success', $school_id);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('newdata.index');
    }

    /**
     * Display success message for successful resource storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function submission_success($id = 0)
    {
        if($id < 1)
        {
            $request->session()->flash('error', 'ERROR 1: You navigated to this page using a wrong URL.');
            return redirect()->route('newdata.index');
        }
        $data['school_id'] = $id;
        $school = School::find($id);
        if(empty($school))
        {
            $request->session()->flash('error', 'ERROR 2: You navigated to this page using a wrong URL.');
            return redirect()->route('newdata.index');
        }

        return view('newdata.submission_success')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=0)
    {
        return redirect()->route('newdata.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id=0)
    {
        return redirect()->route('newdata.index');
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
        return redirect()->route('newdata.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        return redirect()->route('newdata.index');
    }
}
