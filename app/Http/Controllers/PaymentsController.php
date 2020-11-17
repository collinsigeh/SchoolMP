<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Term;
use App\Order;
use App\Payment;
use Illuminate\Http\Request;
use Image;
use Storage;

class PaymentsController extends Controller
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
        //
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
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }
        
        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->usertype == 'Admin')
        {
            $this->validate($request, [
                'id' => ['required', 'numeric'],
                'amount' => ['required', 'numeric', 'min:0'],
                'method' => ['required'],
                'status' => ['required'],
                'special_note' => ['sometimes', 'max:191']
            ]);

            $id = $request->input('id');
            $order = Order::find($id);
            if(empty($order))
            {
                $request->session()->flash('error', 'A valid order is required.');
                return redirect()->route('order.details', $id);
            }
            elseif($order->count() < 1)
            {
                $request->session()->flash('error', 'A valid order is required.');
                return redirect()->route('order.details', $id);
            }

            $payment = new Payment;

            $payment->order_id = $id;
            $payment->currency_symbol = $order->currency_symbol;
            $payment->amount = $request->input('amount');
            $payment->method = $request->input('method');
            if(strlen($request->input('status')) > 1)
            {
                $special_message = $request->input('status');
            }
            $payment->status = $request->input('status');
            $payment->user_id = $user_id;

            $payment->save();

            $request->session()->flash('success', 'Payment added.');

            return redirect()->route('orders.detail', $id);
        }

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

        $this->validate($request, [
            'name' => ['required'],
            'description' => ['sometimes', 'max:191']
        ]);
        
        $name = ucwords(strtolower(trim($request->input('name'))));

        $db_check = array(
            'school_id' => $school_id,
            'name' => $name
        );
        $duplicates = Subject::where($db_check)->get();

        if(!empty($duplicates))
        {
            $request->session()->flash('error', 'The subject '.$name.' exists already.');
            return redirect()->route('subjects.create');
        }

        $subject = new Subject;

        $subject->school_id = $school_id;
        $subject->name = $name;
        $subject->description = $request->input('description');
        $subject->user_id = $user_id;

        $subject->save();

        $request->session()->flash('success', 'Subject created.');

        return redirect()->route('subjects.index');

    }

    /**
     * Initializes paystack payment
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pay_with_paystack(Request $request)
    {
        echo $request->input('payment_pre_reference');
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
