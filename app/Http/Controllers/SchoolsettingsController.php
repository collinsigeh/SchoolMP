<?php

namespace App\Http\Controllers;


use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use Illuminate\Http\Request;

class SchoolsettingsController extends Controller
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

        $data['classarm_manager'] = 'No';
        $data['calendar_manager'] = 'No';
        $data['subscription_manager'] = 'No';
        $data['subject_manager'] = 'No';
        if(Auth::user()->role == 'Consultant' OR Auth::user()->role == 'Director')
        {
            $data['classarm_manager'] = 'Yes';
            $data['calendar_manager'] = 'Yes';
            $data['subscription_manager'] = 'Yes';
            $data['subject_manager'] = 'Yes';
        }
        elseif(Auth::user()->role == 'Staff')
        {
            if($data['staff']->manage_class_arms == 'Yes')
            {
                $data['classarm_manager'] = 'Yes';
            }
            if($data['staff']->manage_calendars == 'Yes')
            {
                $data['calendar_manager'] = 'Yes';
            }
            if($data['staff']->manage_subscriptions == 'Yes')
            {
                $data['subscription_manager'] = 'Yes';
            }
            if($data['staff']->manage_subjects == 'Yes')
            {
                $data['subject_manager'] = 'Yes';
            }
        }

        return view('school_settings.index')->with($data);
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
