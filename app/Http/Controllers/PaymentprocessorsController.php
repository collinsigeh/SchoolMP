<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Paymentprocessors;

use Illuminate\Http\Request;

class PaymentprocessorsController extends Controller
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
        
        $data['paymentprocessors'] = Paymentprocessors::orderBy('name', 'asc')->simplePaginate(20);

        return view('paymentprocessors.index')->with($data);
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

        return view('paymentprocessors.create')->with($data);
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
            'name'          => ['required', 'string', 'max:191', 'unique:paymentprocessors'],
            'merchant_id'   => ['nullable', 'string', 'max:191'],
            'secret_word'   => ['nullable', 'string', 'max:191'],
            'public_key'    => ['nullable', 'string', 'max:191'],
            'secret_key'    => ['nullable', 'string', 'max:191']
        ]);

        $paymentprocessor = new Paymentprocessors;

        $paymentprocessor->name         = ucwords(strtolower($request->input('name')));
        $paymentprocessor->merchant_id  = $request->input('merchant_id');
        $paymentprocessor->secret_word  = $request->input('secret_word');
        $paymentprocessor->public_key   = $request->input('public_key');
        $paymentprocessor->secret_key   = $request->input('secret_key');

        $paymentprocessor->save();
        
        $request->session()->flash('success', 'Saved!');

        return redirect()->route('payment_processors.index');
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

        $data['paymentprocessor'] = Paymentprocessors::find($id);

        if(empty($data['paymentprocessor']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['paymentprocessor']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('paymentprocessors.edit')->with($data);
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

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'name'          => ['required', 'string', 'max:191', "unique:paymentprocessors,name,$id"],
            'merchant_id'   => ['nullable', 'string', 'max:191'],
            'secret_word'   => ['nullable', 'string', 'max:191'],
            'public_key'    => ['nullable', 'string', 'max:191'],
            'secret_key'    => ['nullable', 'string', 'max:191']
        ]);

        $paymentprocessor = Paymentprocessors::find($id);

        $paymentprocessor->name         = ucwords(strtolower($request->input('name')));
        $paymentprocessor->merchant_id  = $request->input('merchant_id');
        $paymentprocessor->secret_word  = $request->input('secret_word');
        $paymentprocessor->public_key   = $request->input('public_key');
        $paymentprocessor->secret_key   = $request->input('secret_key');

        $paymentprocessor->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('payment_processors.edit', $id);
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
