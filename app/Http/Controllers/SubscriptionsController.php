<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Term;
use App\Subscription;
use App\Package;
use App\Product;
use App\Setting;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use Storage;

class SubscriptionsController extends Controller
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
                'school_id' => $data['school']->id,
                'manage_subscriptions' => 'Yes'
            );
            $staff = Staff::where($db_check)->get();
            if(empty($staff))
            {
                return  redirect()->route('dashboard');
            }
            $data['staff'] = $staff[0];
        }
        
        $db_check = array(
            'school_id' => $school_id
        );
        $data['subscriptions'] = Subscription::where($db_check)->orderBy('created_at', 'desc')->paginate(25);
        $db_check = array(
            'school_id' => $school_id
        );
        
        $data['no_unpaid_orders'] = 0;
        $unpaid_orders = Order::where($db_check)->where('status', '!=', 'Completed')->where('status', '!=', 'Paid')->get();
        if(!empty($unpaid_orders))
        {
            $data['no_unpaid_orders'] = count($unpaid_orders);
        }

        return view('subscriptions.index')->with($data);
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
            'status' => 'Available'
        );
        $packages = Package::where($db_check)->get();
        if(empty($packages))
        {
            $request->session()->flash('error', 'New subscription orders are suspended at the moment.' );
            return redirect()->route('subscriptions.index');
        }
        elseif($packages->count() < 1)
        {
            $request->session()->flash('error', 'New subscription orders are suspended at the moment.' );
            return redirect()->route('subscriptions.index');
        }

        $data['products'] = Product::orderBy('name', 'asc')->get();
        if(empty($data['products']))
        {
            $request->session()->flash('error', 'New subscription orders are suspended at the moment.' );
            return redirect()->route('subscriptions.index');
        }
        elseif($data['products']->count() < 1)
        {
            $request->session()->flash('error', 'New subscription orders are suspended at the moment.' );
            return redirect()->route('subscriptions.index');
        }

        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            $request->session()->flash('error', 'New subscription orders are suspended at the moment.' );
            return redirect()->route('subscriptions.index');
        }
        elseif($data['setting']->count() < 1)
        {
            $request->session()->flash('error', 'New subscription orders are suspended at the moment.' );
            return redirect()->route('subscriptions.index');
        }

        return view('subscriptions.create')->with($data);
    }

    /**
     * Provide confirmation for the purchase of resource before storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buy(Request $request, $id = 0)
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

        $data['package'] = Package::find($id);
        if(empty($data['package']))
        {
            $request->session()->flash('error', 'Invalid package selection');
            return redirect()->route('subscriptions.create');
        }
        elseif($data['package']->count() < 1)
        {
            $request->session()->flash('error', 'Invalid package selection');
            return redirect()->route('subscriptions.create');
        }

        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            $request->session()->flash('error', 'New subscription orders are suspended at the moment.' );
            return redirect()->route('subscriptions.index');
        }
        elseif($data['setting']->count() < 1)
        {
            $request->session()->flash('error', 'New subscription orders are suspended at the moment.' );
            return redirect()->route('subscriptions.index');
        }

        //check school exhaustion of trials
        if($data['package']->product->payment == 'Trial')
        {
            $db_check = array(
                'school_id' => $school_id,
                'package_id' => $id,
                'type' => 'Trial'
            );
            $no_tries = 0;
            $tries = Order::where($db_check)->get();
            if(!empty($tries))
            {
                $no_tries = $tries->count();
            }
            if($no_tries >= $data['setting']->try_limit)
            {
                $request->session()->flash('error', '<p>This institution has exhausted it\'s trial limit for this package.</p>Buy other paid packages.' );
                return redirect()->route('subscriptions.create');
            }
        }
        
        //check for unpaid post-paid orders
        if($data['package']->product->payment == 'Post-paid')
        {
            $db_check = array(
                'school_id' => $data['school']->id,
                'status' => 'Approved-unpaid'
            );
            $unpaid_cases = Order::where($db_check)->get();
            if(!empty($unpaid_cases))
            {
                if(count($unpaid_cases) > 0)
                {
                    $request->session()->flash('error', '<p>This institution has unpaid invoice/order.</p>Buy other prepaid packages. OR pay off the unpiad invoice/order.' );
                    return redirect()->route('subscriptions.create');
                }
            }
        }

        return view('subscriptions.buy')->with($data);
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
        
        $data['school'] = School::find($school_id);

        $this->validate($request, [
            'package_id' => ['required', 'numeric']
        ]);

        $package = Package::find($request->input('package_id'));
        if(empty($package))
        {
            $request->session()->flash('error', '<p>Invalid package selection.</p>Please pick from one of the following packages.');
            return redirect()->route('subscriptions.create');
        }
        elseif($package->count() < 1)
        {
            $request->session()->flash('error', '<p>Invalid package selection.</p>Please pick from one of the following packages.');
            return redirect()->route('subscriptions.create');
        }
        if($package->status != 'Available')
        {
            $request->session()->flash('error', '<p>Selected package is no longer available.</p>Please pick from one of the following packages.');
            return redirect()->route('subscriptions.create');
        }

        $setting = Setting::first();

        $total_price = 0;
        $discount = 0;
        $school_asking_price = 0;
        
        if($package->product->payment == 'Trial')
        {
            $db_check = array(
                'school_id' => $school_id,
                'package_id' => $package->id,
                'type' => 'Trial'
            );
            $no_tries = 0;
            $tries = Order::where($db_check)->get();
            if(!empty($tries))
            {
                $no_tries = $tries->count();
            }
            if($no_tries >= $setting->try_limit)
            {
                $request->session()->flash('error', '<p>This institution has exhausted it\'s trial limit for this package.</p>Buy other paid packages.' );
                return redirect()->route('subscriptions.create');
            }
            
            if ($package->price_type == 'Per-student') 
            {
                $this->validate($request, [
                    'no_students' => ['required', 'numeric', 'min:40']
                ]);

                $total_price = round(($request->input('no_students') * $package->price), 2);
            }
            else
            {
                $total_price = $package->price;
            }
        }
        elseif($package->product->payment == 'Prepaid')
        {
            if ($package->price_type == 'Per-student') 
            {
                $this->validate($request, [
                    'school_asking_price' => ['required', 'numeric', "min:$package->price"]
                ]);

                $total_price = 0;
            }
            else
            {
                $total_price = $package->price;
            }

            if(null !== $request->input('school_asking_price'))
            {
                $school_asking_price = $request->input('school_asking_price');
            }
        }
        elseif($package->product->payment == 'Post-paid')
        {
            if ($package->price_type == 'Per-student') 
            {
                $total_price = 0;
            }
            else
            {
                $total_price = $package->price;
            }
        }
        else
        {
            $request->session()->flash('error', 'Improper order.' );
            return redirect()->route('subscriptions.create');
        }

        $setting = Setting::first();
        $time = time();
        $expiry = ($setting->order_expiration * 24 * 60 * 60) + $time;
        $final_price = $total_price - $discount;

        $order = new Order;

        $order->user_id = $user_id;
        $order->school_id = $school_id;
        $order->number = 'NS-'.$time.'-'.rand(1,9);
        $order->name = $package->product->name.' ('.$package->product->payment.' '.$package->name.')';
        $order->product_id = $package->product_id;
        $order->package_id = $package->id;
        $order->type = 'Purchase';
        $order->payment = $package->product->payment;
        $order->price_type = $package->price_type;
        $order->price = $package->price;    
        $order->currency_symbol = $setting->base_currency_symbol;
        $order->total_price = $total_price;
        $order->discount = $discount;
        $order->final_price = $final_price;
        $order->school_asking_price = $school_asking_price;
        $order->term_limit = $package->term_limit;
        $order->day_limit = $package->day_limit;
        $order->student_limit = $package->product->student_limit;
        $order->expiry = $expiry;
        $order->status = 'Pending';
        $order->subscription_id = 0;

        $order->save();

        if($order->payment == 'Trial' && $order->final_price == 0)
        {
            $end_at = ($order->day_limit * 24 * 60 * 60) + $time;

            $subscription = new Subscription;

            $subscription->school_id = $order->school_id;
            $subscription->name = $order->name;
            $subscription->start_at = $time;
            $subscription->end_at = $end_at;
            $subscription->term_limit = $order->term_limit;
            $subscription->student_limit = $order->student_limit;

            $subscription->save();

            $order_to_update = Order::find($order->id);
            $order_to_update->subscription_id = $subscription->id;
            $order_to_update->status = 'Completed';
            $order_to_update->save();
            
            $request->session()->flash('success', 'Congratulations! Subscription was successful.');
            return redirect()->route('subscriptions.index');
        }   
        elseif($order->payment == 'Post-paid')
        {
            $request->session()->flash('success', 'Order submitted. Pending approval.');
            return redirect()->route('orders.show', $order->id);
        }
        else
        {
            if($order->student_limit == 'n')
            {
                $end_at = ($order->day_limit * 24 * 60 * 60) + $time;
    
                $subscription = new Subscription;
    
                $subscription->school_id = $order->school_id;
                $subscription->name = $order->name;
                $subscription->start_at = $time;
                $subscription->end_at = $end_at;
                $subscription->term_limit = $order->term_limit;
                $subscription->student_limit = $order->student_limit;
    
                $subscription->save();
    
                $order_to_update = Order::find($order->id);
                $order_to_update->subscription_id = $subscription->id;
                $order_to_update->status = 'Completed';
                $order_to_update->save();
                
                $request->session()->flash('success', 'Congratulations! Subscription was successful.');
                return redirect()->route('subscriptions.index');
            }
            else
            {
                $request->session()->flash('success', 'Order saved. Make payment.');
                return redirect()->route('orders.show', $order->id);
            }
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
        $subscriptions = Subscription::where($db_check)->get();
        if(empty($subscriptions))
        {
            return  redirect()->route('dashboard');
        }
        elseif($subscriptions->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        $data['subscription'] = $subscriptions[0];

        return view('subscriptions.show')->with($data);
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
