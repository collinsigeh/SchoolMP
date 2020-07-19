<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Student;
use App\Director;
use App\Staff;
use App\Guardian;
use App\Affiliate;
use App\Partner;
use App\Term;
use App\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }
        
        if(Auth::user()->usertype == 'Client')
        {
            /*
            * Client login
            *
            */
            session(['school_id' => 0]);

            $user_id = Auth::user()->id;

            $db_check = array(
                'user_id' => $user_id
            );
            $data['user'] = User::find($user_id);

            if(strlen(session('school_under_registration')) > 1)
            {
                return redirect(route('schools.create'));
            }

            return view('clients.dashboard')->with($data);
        }
        elseif(Auth::user()->usertype == 'Non-client')
        {
            /*
            * Non-client login
            *
            */

            $user_id = Auth::user()->id;

            $db_check = array(
                'user_id' => $user_id
            );
            $data['user'] = User::find($user_id);

            if($data['user']->role == 'Student')
            {
                /*
                * Student status check
                *
                */
                return view('students.dashboard')->with($data);
            }
            elseif($data['user']->role == 'Director')
            {
                /*
                * Director status check
                *
                */
                if(empty($data['user']->director->school))
                {
                    return redirect()->route('dashboard.relogin');
                }
                session(['school_id' => $data['user']->director->school->id]);
                if(session('school_id') < 1)
                {
                    return redirect()->route('dashboard.relogin');
                }

                $data['school'] = School::find(session('school_id'));
                if(empty($data['school']))
                {
                    return redirect()->route('dashboard.relogin');
                }
                elseif($data['school']->count() < 1)
                {
                    return  redirect()->route('dashboard.relogin');
                }

                $db_check = array(
                    'user_id'   => $data['user']->id,
                    'school_id' => $data['school']->id
                );
                $no_directors = Director::where($db_check)->get();
                if(empty($no_directors))
                {
                    return  redirect()->route('dashboard.relogin');
                }
                elseif($no_directors->count() < 1)
                {
                    return  redirect()->route('dashboard.relogin');
                }

                $current_date = date('Y-m-d', time());

                $db_check = array(
                    'school_id' => $data['school']->id
                );
                $data['currentterm'] = Term::where($db_check)->where('resumption_date','<=',$current_date)->where('closing_date','>=',$current_date)->orderBy('created_at', 'asc')->first();
                $data['previousterms'] = Term::where($db_check)->orderBy('closing_date', 'desc')->get();
                
                $db_check = array(
                    'school_id' => $data['school']->id,
                    'status' => 'Approved-unpaid'
                );
                $data['due_invoices'] = Order::where($db_check)->where('subscription_due_date', '<=', time())->get();
                
                return view('directors.dashboard')->with($data);
            }
            elseif($data['user']->role == 'Staff')
            {
                /*
                * Staff status check
                *
                */
                if(empty($data['user']->staff->school))
                {
                    return redirect()->route('dashboard.relogin');
                }
                session(['school_id' => $data['user']->staff->school->id]);
                if(session('school_id') < 1)
                {
                    return redirect()->route('dashboard.relogin');
                }

                $data['school'] = School::find(session('school_id'));
                if(empty($data['school']))
                {
                    return redirect()->route('dashboard.relogin');
                }
                elseif($data['school']->count() < 1)
                {
                    return  redirect()->route('dashboard.relogin');
                }
                
                $db_check = array(
                    'user_id'   => $data['user']->id,
                    'school_id' => $data['school']->id
                );
                $staff = Staff::where($db_check)->get();
                if(empty($staff))
                {
                    return  redirect()->route('dashboard.relogin');
                }
                elseif($staff->count() < 1)
                {
                    return  redirect()->route('dashboard.relogin');
                }
                $data['staff'] = $staff[0];

                $current_date = date('Y-m-d', time());

                $db_check = array(
                    'school_id' => $data['school']->id
                );
                $data['currentterm'] = Term::where($db_check)->where('resumption_date','<=',$current_date)->where('closing_date','>=',$current_date)->orderBy('created_at', 'asc')->first();
                $data['previousterms'] = Term::where($db_check)->orderBy('closing_date', 'desc')->get();
                
                return view('staff.dashboard')->with($data);
            }
            elseif($data['user']->role == 'Guardian')
            {
                /*
                * Parent & Guardian status check
                *
                */
                return view('guardians.dashboard')->with($data);
            }
            elseif($data['user']->role == 'Affiliate')
            {
                /*
                * Affiliate status check
                *
                */
                return view('affiliates.dashboard')->with($data);
            }
            elseif($data['user']->role == 'Partner')
            {
                /*
                * Partner status check
                *
                */
                return view('partners.dashboard')->with($data);
            }
        }
        elseif(Auth::user()->usertype == 'Admin')
        {
            /*
            * Admin login
            *
            */
            session(['school_id' => 0]);

            $user_id = Auth::user()->id;

            $db_check = array(
                'user_id' => $user_id
            );
            $data['user'] = User::find($user_id);

            if($data['user']->role == 'System')
            {
                /*
                * System status check
                *
                */
                return view('system.dashboard')->with($data);
            }
            elseif($data['user']->role == 'Owner')
            {
                /*
                * Owner status check
                *
                */
                return view('owner.dashboard')->with($data);
            }
        }

        return redirect()->route('login');
    }

    public function relogin()
    {
        $data['title'] = 'School Portal';
        session(['school_id' => 0]);
        return view('welcome.relogin')->with($data);
    }
}
