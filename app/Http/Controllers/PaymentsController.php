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
use App\Paymentprocessors;
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
            /*
            * STILL NEEDS TO WORK ON THIS!!!
            */
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
        $this->validate($request, [
            'payment_order_id'      => ['required'],
            'payment_pre_reference' => ['required'],
            'payment_amount'        => ['required'],
            'payment_currency'      => ['required'],
            'payment_email'         => ['required', 'email'],
            'payment_firstname'     => ['required'],
            'payment_user_id'       => ['required'],
            'return_page'           => ['required']
        ]);
        
        $return_page = $request->input('return_page');

        //get secret key
        $db_check = array(
            'name' => 'Paystack'
        );
        $payment_processor = Paymentprocessors::where($db_check)-> get();
        if(empty($payment_processor))
        {
            $request->session()->flash('error', 'Fatal Error: secret key missing.');
            return redirect($return_page);
        }
        $secret_key = $payment_processor[0]->secret_key;

        $curl = curl_init();

		$email = $request->input('payment_email');
        $amount = $request->input('payment_amount') * 100;  //the amount in kobo. This value is actually NGN 300
        $currency = $request->input('payment_currency');
		$reference = $request->input('payment_pre_reference').time();
		$metadata = array(
			'custom_fields' => array(
                'order_id'  => $request->input('payment_order_id'),
                'user_id'   => $request->input('payment_user_id'),
                'first_name'   => $request->input('payment_firstname'),
			)
        );
		

		// url to go to after payment
		$callback_url = route('payments.verifypaystack_transaction');

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode([
            'amount'=>$amount,
            'currency' => $currency,
			'email'=>$email,
			'reference'=> $reference,
			'callback_url' => $callback_url,
			'metadata' => $metadata
		]),
		CURLOPT_HTTPHEADER => [
			"authorization: Bearer ".$secret_key, //replace this with your own test key
			"content-type: application/json",
			"cache-control: no-cache"
		],
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		if($err){
		// there was an error contacting the Paystack API
			die('Curl returned error: ' . $err.'<div style="margin: 80px auto;"><a href="'.$return_page.'"><< Go back</a></div>');
		}

		$tranx = json_decode($response, true);

		if(!$tranx['status']){
		// there was an error from the API
			print_r('API returned error: ' . $tranx['message']);
			die('<div style="margin: 80px auto;"><a href="'.$return_page.'"><< Go back</a></div>');
		}

		// comment out this line if you want to redirect the user to the payment page
		// print_r($tranx);
		// redirect to page so User can pay
		// uncomment this line to allow the user redirect to the payment page
		header('Location: ' . $tranx['data']['authorization_url']);
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
