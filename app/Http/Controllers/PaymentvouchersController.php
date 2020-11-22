<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Paymentvoucher;
use App\Package;
use App\Order;
use App\Enrolment;
use Illuminate\Http\Request;

class PaymentvouchersController extends Controller
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

        $data['paymentvouchers'] = Paymentvoucher::paginate(50);

        return view('paymentvouchers.index')->with($data);
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

        $db_check = array(
            'status' => 'Available'
        );
        $data['product_packages'] = Package::where($db_check)->get();

        return view('paymentvouchers.create')->with($data);
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
            'product_package'   => ['required', 'integer', 'min:1'],
            'quantity'          => ['required', 'integer', 'min:1'],
            'expiration_date'   => ['required', 'date'],
            'assign_voucher_to' => ['required']
        ]);

        if($request->input('assign_voucher_to') != 'All')
        {
            $this->validate($request, [
                'id_assigned_to' => ['required', 'integer', 'min:1']
            ]);
        }

        if($request->input('assign_voucher_to') == 'Order')
        {
            $order = Order::find($request->input('id_assigned_to'));
            if(empty($order))
            {
                $request->session()->flash('error', 'The order ID entered is not recognized.');
                return redirect()->route('paymentvouchers.create');
            }
        }
        elseif($request->input('assign_voucher_to') == 'Student')
        {
            $enrolment = Enrolment::find($request->input('id_assigned_to'));
            if(empty($enrolment))
            {
                $request->session()->flash('error', 'The enrolment ID entered is not recognized.');
                return redirect()->route('paymentvouchers.create');
            }
        }

        $quantity = $request->input('quantity');
        while ($quantity > 0) {
            $sn = 0;
            $pin = '';
            while($sn <= 8)
            {
                $pin .= rand(1,9);
                $sn++;
            }

            $paymentvoucher = new Paymentvoucher;
    
            $paymentvoucher->pin = $pin;
            $paymentvoucher->expiration_at = strtotime($request->input('expiration_date'));
            $paymentvoucher->package_id = $request->input('product_package');
            $paymentvoucher->status = 'Available';
            $paymentvoucher->assigned_to = $request->input('assign_voucher_to');
            $paymentvoucher->id_assigned_to = $request->input('id_assigned_to');
    
            $paymentvoucher->save();

            $quantity--;
        }
        
        if($request->input('quantity') > 1)
        {
            $request->session()->flash('success', 'Vouchers created.');
        }
        else
        {
            $request->session()->flash('success', 'Voucher created.');
        }
        

        return redirect()->route('paymentvouchers.index');
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
