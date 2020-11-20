<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Paymentvoucher;
use App\Package;
use App\School;
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

        $data['paymentvouchers'] = Paymentvoucher::all();

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

        if($request->input('assign_voucher_to') == 'School')
        {
            $school = School::find($request->input('id_assigned_to'));
            if(empty($school))
            {
                $request->session()->flash('error', 'The school ID entered is not recognized.');
                return redirect()->route('paymentvouchers.create');
            }
        }
        die();

        $product = new Product;

        if($request->input('student_limit') < 1 OR !is_numeric($request->input('student_limit')))
        {
            $student_limit = 'n';
        }
        else{
            $student_limit = $request->input('student_limit');
        }

        $product->name = ucwords(strtolower($request->input('name')));
        $product->type = $request->input('type');
        $product->payment = $request->input('payment');
        $product->features = $request->input('features');
        $product->student_limit = $student_limit;
        $product->created_by = $user_id;

        $product->save();
        
        $request->session()->flash('success', 'Product created.');

        return redirect()->route('products.index');
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
