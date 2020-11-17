<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Order;
use App\Setting;
use App\Subscription;
use App\Paymentprocessors;
use Illuminate\Http\Request;

class OrdersController extends Controller
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
        $data['orders'] = Order::where($db_check)->orderBy('created_at', 'desc')->paginate(25);

        $data['setting'] = Setting::first();

        return view('orders.index')->with($data);
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
                'school_id' => $data['school']->id,
                'manage_subscriptions' => 'Yes'
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
            'id' => $id,
            'school_id' => $school_id
        );
        $orders = Order::where($db_check)->get();
        if(empty($orders))
        {
            return  redirect()->route('dashboard');
        }
        elseif($orders->count() < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['order'] = $orders[0];
        $data['setting'] = Setting::first();
        if($data['setting']->paymentprocessor_id >= 1)
        {
            $data['payment_processor'] = Paymentprocessors::find($data['setting']->paymentprocessor_id);
        }

        return view('orders.show')->with($data);
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

        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        if($id < 1)
        {
            return redirect()->route('dashboard');
        }

        $this->validate( $request, [
            'update_type' => ['required']
        ]);

        $order = Order::find($id);

        if(empty($order))
        {
            return redirect()->route('dashboard');
        }
        elseif($order->count() < 1)
        {
            return redirect()->route('dashboard');
        }

        if($request->input('update_type') == 'School_Asking_Price')
        {
            $this->validate($request, [
                'school_asking_price' => ['required', 'numeric', "min:$order->price"]
            ]);

            $order->school_asking_price = $request->input('school_asking_price');

            $order->save();
        }

        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('orders.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
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
            if(session('school_id') < 1)
            {
                return redirect()->route('dashboard');
            }
            $school_id = session('school_id');
    
            if(!$this->resource_manager($data['user'], $school_id))
            {
                return redirect()->route('dashboard');
            }
        }

        $order = Order::find($id);
        if(empty($order))
        {
            $request->session()->flash('error', 'ERROR: An attempt to delete unavailable resource.');
        }
        else
        {
            if($order->count() < 1)
            {
                $request->session()->flash('error', 'ERROR: An attempt to delete unavailable resource.');
            }

            if($order->subscription_id > 0)
            {
                $request->session()->flash('error', 'ERROR: Delivered orders can NOT be deleted or canceled.');
                if($data['user']->usertype == 'Admin')
                {
                    return redirect()->route('orders.detail', $id);
                }
                return redirect()->route('orders.show', $id);
            }

            if(!empty($order->payments))
            {
                if($order->payments->count() > 0)
                {
                    $request->session()->flash('error', 'ERROR: Orders with payment can NOT be deleted or canceled.');
                    if($data['user']->usertype == 'Admin')
                    {
                        return redirect()->route('orders.detail', $id);
                    }
                    return redirect()->route('orders.show', $id);
                }
            }

            $order->delete();
            $request->session()->flash('success', 'Order deleted');
        }
        
        if($data['user']->usertype == 'Admin')
        {
            return redirect()->route('orders.all');
        }
        
        return redirect()->route('orders.index');
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
                'manage_subscriptions'  => 'Yes'
            );
            if(!empty(Staff::where($db_check)->get()))
            {
                $resource_manager = true;
            }
        }

        return $resource_manager;
    }

    /**
     * Display a listing of the resource to system administrator.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
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
        $data['orders'] = Order::orderBy('created_at', 'desc')->orderBy('school_id', 'asc')->paginate(25);

        $data['setting'] = Setting::first();

        return view('orders.all')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id = 0)
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
        
        $data['order'] = Order::find($id);
        if(empty($data['order']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['order']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('orders.detail')->with($data);
    }

    /**
     * Admin update of the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changedetail(Request $request, $id)
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

        $this->validate($request, [
            'status' => ['required']
        ]);
        
        $order = Order::find($id);
        if(empty($order))
        {
            return redirect()->route('dashboard');
        }
        elseif($order->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        if($order->status == 'Pending' && $order->payment == 'Post-paid' && $request->input('status') == 'Approved-unpaid')
        {
            $time = time();
            $end_at = ($order->day_limit * 24 * 60 * 60) + $time;

            if($order->subscription_id == 0)
            {
                $subscription = new Subscription;

                $subscription->school_id = $order->school_id;
                $subscription->name = $order->name;
                $subscription->start_at = $time;
                $subscription->end_at = $end_at;
                $subscription->term_limit = $order->term_limit;
                $subscription->student_limit = $order->student_limit;

                $subscription->save();

                $subscription_id = $subscription->id;
            }
            else
            {
                $subscription_id = $order->subscription_id;
            }

            $order_to_update = Order::find($order->id);

            $order_to_update->status = $request->input('status');
            $order_to_update->subscription_id = $subscription_id;
            $order_to_update->subscription_due_date = $end_at;
            $order_to_update->save();

            $request->session()->flash('success', 'Post-paid subscription approved.');
        }
        elseif(($order->status == 'Pending' && $order->payment == 'Trial' && $order->final_price == 0 && $request->input('status') == 'Completed') OR 
                ($order->status == 'Paid' && $request->input('status') == 'Completed'))
        {
            if($order->subscription_id == 0)
            {
                $time = time();
                $end_at = ($order->day_limit * 24 * 60 * 60) + $time;

                $subscription = new Subscription;

                $subscription->school_id = $order->school_id;
                $subscription->name = $order->name;
                $subscription->start_at = $time;
                $subscription->end_at = $end_at;
                $subscription->term_limit = $order->term_limit;
                $subscription->student_limit = $order->student_limit;

                $subscription->save();

                $subscription_id = $subscription->id;
            }
            else
            {
                $subscription_id = $order->subscription_id;
            }

            $order_to_update = Order::find($order->id);

            $order_to_update->status = $request->input('status');
            $order_to_update->subscription_id = $subscription_id;
            $order_to_update->save();

            $request->session()->flash('success', 'Status updated.');
        }

        return redirect()->route('orders.detail', $id);
    }
}
