<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Term;
use App\Subscription;
use App\Classsubject;
use App\Arm;
use App\Calendar;
use Illuminate\Http\Request;

class TermsController extends Controller
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
        
        $db_check = array(
            'school_id' => $school_id
        );
        $data['terms'] = Term::where($db_check)->orderBy('closing_date','desc')->simplePaginate(20);

        return view('terms.index')->with($data);
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
        
        $thistime = time();
        
        $db_check = array(
            'school_id' => $school_id
        );
        $no_subscriptions = 0;
        $valid_subscriptions = Subscription::where($db_check)->where('end_at', '>=', $thistime)->orderBy('id', 'asc')->get();
        if(!empty($valid_subscriptions))
        {
            $no_subscriptions = count($valid_subscriptions);
        }
        if($no_subscriptions < 1)
        {
            $request->session()->flash('error', "<p>You don't have a valid subscription for creating a new term.</p>
                <a href='".config('app.url')."/subscriptions/create' class='btn btn-sm btn-danger'>Get a new subscription</a> &nbsp;&nbsp;&nbsp;
                <a href='".config('app.url')."/subscriptions' class='btn btn-sm btn-outline-danger'>View previous subscriptons</a>" );
            return redirect()->route('terms.index');
        }

        $subscription_id = 0;
        foreach($valid_subscriptions as $subscription)
        {
            if($subscription_id == 0)
            {
                $no_subscription_terms = 0;
                if(!empty($subscription->terms))
                {
                    $no_subscription_terms = count($subscription->terms);
                }
                if($no_subscription_terms < $subscription->term_limit)
                {
                    $subscription_id = $subscription->id;
                }
            }
        }
        if($subscription_id < 1)
        {
            $request->session()->flash('error', "<p>You don't have a valid subscription for creating a new term.</p>
                <a href='".config('app.url')."/subscriptions/create' class='btn btn-sm btn-danger'>New subscription</a> &nbsp;&nbsp;&nbsp;
                <a href='".config('app.url')."/subscriptions' class='btn btn-sm btn-outline-danger'>View previous subscriptons</a>" );
            return redirect()->route('terms.index');
        }

        $data['subscription_id'] = $subscription_id;

        $thisyear = date('Y', $thistime);
        $data['session'] = array(
            'option1' => ($thisyear-1).'/'.$thisyear,
            'option2' => $thisyear.'/'.($thisyear+1),
            'option3' => ($thisyear+1).'/'.($thisyear+2)
        );

        return view('terms.create')->with($data);
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

        $this->validate($request, [
            'subscription_id' => ['required', 'numeric', 'min:1'],
            'session' => ['required'],
            'name' => ['required'],
            'no_of_weeks' => ['required', 'numeric', 'min:1'],
            'resumption_date' => ['required', 'date'],
            'closing_date' => ['required', 'date', 'after:resumption_date'],
            'next_term_resumption_date' => ['nullable', 'date', 'after:closing_date']
        ]);

        $subscription = Subscription::find($request->input('subscription_id')); 
        if(empty($subscription))
        {
            $request->session()->flash('error', 'Invalid subscription error.');
            return redirect()->route('terms.create');
        }
        elseif($subscription->count() < 1)
        {
            $request->session()->flash('error', 'Invalid subscription error.');
            return redirect()->route('terms.create');
        }
        if($subscription->school_id != $school_id)
        {
            $request->session()->flash('error', 'Improper subscription selection. Please try again');
            return redirect()->route('terms.create');
        }

        $time = time();
        if($subscription->start_at > $time OR $subscription->end_at < $time)
        {
            $request->session()->flash('error', 'Invalid subscription error.');
            return redirect()->route('terms.create');
        }
        $no_subscription_terms = 0;
        if(!empty($subscription->terms))
        {
            $no_subscription_terms = count($subscription->terms);
        }
        if($no_subscription_terms >= $subscription->term_limit)
        {
            $request->session()->flash('error', "<p>Session term limit reached.</p><a href='".config('app.url')."/subscriptions/create' class='btn btn-sm btn-danger'>New Subscription</a>" );
            return redirect()->route('terms.create');
        }

        $db_check = array(
            'school_id' => $school_id,
            'session' => $request->input('session'),
            'name' => $request->input('name')
        );
        $term_cases = Term::where($db_check)->get();
        if(!empty($term_cases))
        {
            if($term_cases->count() > 0)
            {
                $request->session()->flash('error', "Error: An attempt to create duplicate academic term." );
                return redirect()->route('terms.index');
            }
        }

        $no_weeks = $request->input('no_of_weeks');

        $term = new Term;

        $term->school_id = $school_id;
        $term->subscription_id = $subscription->id;
        $term->session = $request->input('session');
        $term->name = $request->input('name');
        $term->no_of_weeks = $no_weeks;
        $term->resumption_date = ucwords(strtolower($request->input('resumption_date')));
        $term->closing_date = ucwords(strtolower($request->input('closing_date')));
        $term->next_term_resumption_date = ucwords(strtolower($request->input('next_term_resumption_date')));
        $term->created_by = $user_id;

        $term->save();

        for ($i=1; $i <= $no_weeks; $i++) { 
            $calendar = new Calendar;

            $calendar->term_id = $term->id;
            $calendar->week = $i;
            $calendar->activity = '';

            $calendar->save();
        }

        $request->session()->flash('success', 'Term created.');

        return redirect()->route('terms.show', $term->id);
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

        $data['term'] = Term::find($id);
        if(empty($data['term']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['term']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        session(['term_id' => $data['term']->id]);

        $db_check = array(
            'term_id' => $id
        );
        $data['calendar'] = Calendar::where($db_check)->orderBy('week', 'asc')->get();

        $data['student_manager'] = 'No';
        $data['classarm_manager'] = 'No';
        $data['fees_manager'] = 'No';
        $data['calendar_manager'] = 'No';
        $data['sessionterm_manager'] = 'No';
        $data['subscription_manager'] = 'No';
        $data['staff_manager'] = 'No';
        $data['subject_manager'] = 'No';
        if(Auth::user()->role == 'Consultant' OR Auth::user()->role == 'Director')
        {
            $data['student_manager'] = 'Yes';
            $data['classarm_manager'] = 'Yes';
            $data['fees_manager'] = 'Yes';
            $data['calendar_manager'] = 'Yes';
            $data['sessionterm_manager'] = 'Yes';
            $data['subscription_manager'] = 'Yes';
            $data['staff_manager'] = 'Yes';
            $data['subject_manager'] = 'Yes';
        }
        elseif(Auth::user()->role == 'Staff')
        {
            if($data['staff']->manage_students_account == 'Yes')
            {
                $data['student_manager'] = 'Yes';
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
            if($data['staff']->manage_subscriptions == 'Yes')
            {
                $data['subscription_manager'] = 'Yes';
            }
            if($data['staff']->manage_staff_account == 'Yes')
            {
                $data['staff_manager'] = 'Yes';
            }
            if($data['staff']->manage_subjects == 'Yes')
            {
                $data['subject_manager'] = 'Yes';
            }
        }
        
        $db_check = array(
            'term_id' => $data['term']->id,
            'user_id' => $user_id
        );
        $data['assigned_subjects'] = Classsubject::where($db_check)->get();
        $data['assigned_classes'] = Arm::where($db_check)->get();

        return view('terms.show')->with($data);
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
        
        $data['term'] = Term::find($id);

        if(empty($data['term']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['term']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $thisyear = date('Y', time());
        $data['session'] = array(
            'option1' => ($thisyear-1).'/'.$thisyear,
            'option2' => $thisyear.'/'.($thisyear+1),
            'option3' => ($thisyear+1).'/'.($thisyear+2)
        );

        $data['term_editable'] = 'Yes';
        if(strtotime($data['term']->resumption_date) <= time())
        {
            $data['term_editable'] = 'No';            
        }
        if(!empty($term->enrolments))
        {
            if(count($term->enrolments) > 0)
            {
                $data['term_editable'] = 'No';
            }
        }

        return view('terms.edit')->with($data);
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }
        
        $data['school'] = School::find($school_id);

        $this->validate($request, [
            'no_of_weeks' => ['required', 'numeric', 'min:1'],
            'resumption_date' => ['required'],
            'closing_date' => ['required', 'date', 'after:resumption_date'],
            'next_term_resumption_date' => ['nullable', 'date', 'after:closing_date']
        ]);

        $term = Term::find($id);

        $term_editable = 'Yes';
        if(strtotime($term->resumption_date) <= time())
        {
            $term_editable = 'No';            
        }
        if(!empty($term->enrolments))
        {
            if(count($term->enrolments) > 0)
            {
                $term_editable = 'No';
            }
        }

        $original_no_weeks = $term->no_of_weeks;
        $new_no_weeks = $request->input('no_of_weeks');
        
        if($term_editable == 'Yes')
        {
            $this->validate($request, [
                'session' => ['required'],
                'name' => ['required']
            ]);

            $term->session = $request->input('session');
            $term->name = $request->input('name');
        }
        $term->no_of_weeks = $new_no_weeks;
        $term->resumption_date = ucwords(strtolower($request->input('resumption_date')));
        $term->closing_date = ucwords(strtolower($request->input('closing_date')));
        $term->next_term_resumption_date = ucwords(strtolower($request->input('next_term_resumption_date')));

        $term->save();

        if($original_no_weeks != $new_no_weeks)
        {
            $db_check = array(
                'term_id' => $term->id
            );
            Calendar::where($db_check)->delete();

            for ($i=1; $i <= $new_no_weeks; $i++) { 
                $calendar = new Calendar;
    
                $calendar->term_id = $term->id;
                $calendar->week = $i;
                $calendar->activity = 'Noting yet!';
    
                $calendar->save();
            }
        }

        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('terms.edit', $id);
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
                'manage_session_terms'  => 'Yes'
            );
            if(!empty(Staff::where($db_check)->get()))
            {
                $resource_manager = true;
            }
        }

        return $resource_manager;
    }
}
