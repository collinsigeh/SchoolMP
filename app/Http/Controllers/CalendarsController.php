<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Term;
use App\Calendar;
use Illuminate\Http\Request;

class CalendarsController extends Controller
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
                'school_id' => $data['school']->id,
                'manage_calendars' => 'Yes'
            );
            $staff = Staff::where($db_check)->get();
            if(!empty($staff))
            {
                if($staff->count() != 1)
                {
                    return  redirect()->route('dashboard');
                }
            }
            else
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }
        
        $db_check = array(
            'term_id' => $term_id
        );
        $data['calendars'] = Calendar::where($db_check)->orderBy('week', 'asc')->get();

        return view('calendars.index')->with($data);
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
            if(!empty($staff))
            {
                if($staff->count() != 1)
                {
                    return  redirect()->route('dashboard');
                }
            }
            else
            {
                return  redirect()->route('dashboard');
            }
        }
        
        $db_check = array(
            'term_id' => $id
        );
        $calendars = Calendar::where($db_check)->orderBy('week', 'asc')->get();
        if(!empty($calendars))
        {
            $no_weeks = $calendars->count();
            if($calendars->count() < 1)
            {
                return  redirect()->route('dashboard');
            }
        }
        else
        {
            return  redirect()->route('dashboard');
        }
        $i = 1;
        foreach ($calendars as $calendar_week) {
            $week_to_change = Calendar::find($calendar_week->id);
            if($i == $week_to_change->week)
            {
                $week_to_change->activity = $request->input('week'.$i);
            }
            $week_to_change->save();

            $i++;
        }

        $request->session()->flash('success', 'Update saved.');
        return redirect()->route('calendars.index');
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
