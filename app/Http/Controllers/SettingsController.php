<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Setting;
use App\Alternative_currency;
use App\Paymentprocessors;
use Illuminate\Http\Request;

class SettingsController extends Controller
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

        if($data['user']->role != 'Owner')
        {
            return redirect()->route('dashboard');
        }

        $no_paymentprocessors = 0;
        $processors = Paymentprocessors::all();
        if(!empty($processors))
        {
            $processor_cases = $processors->count();
            if($processor_cases > 0)
            {
                $no_paymentprocessors = $processor_cases;
            }
        }

        $data['no_paymentprocessors'] = $no_paymentprocessors;
        $data['setting'] = Setting::first();
        $data['alternative_currencies'] = Alternative_currency::all();

        return view('settings.index')->with($data);
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

        if($data['user']->role != 'Owner')
        {
            return redirect()->route('dashboard');
        }
        
        $data['paymentprocessors'] = Paymentprocessors::orderBy('name', 'asc')->get();

        return view('settings.create')->with($data);
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
            'base_currency'         => ['required', 'string', 'max:75'],
            'base_currency_symbol'  => ['required', 'string', 'max:25'],
            'try_limit'             => ['required', 'numeric', 'min:0'],
            'order_expiration'      => ['required', 'numeric', 'min:0'],
            'payment_processor'     => ['required']
        ]);

        $setting = new Setting;

        $setting->base_currency         = $request->input('base_currency');
        $setting->base_currency_symbol  = $request->input('base_currency_symbol');
        $setting->try_limit             = $request->input('try_limit');
        $setting->order_expiration      = $request->input('order_expiration');
        $setting->paymentprocessor_id   = $request->input('payment_processor');
        $setting->created_by            = $user_id;

        $setting->save();
        
        $request->session()->flash('success', 'Settings created.');

        return redirect()->route('settings.index');
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
    public function edit($id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->role != 'Owner')
        {
            return redirect()->route('dashboard');
        }

        $data['setting'] = Setting::find($id);

        if(empty($data['setting']))
        {
            return redirect()->route('dashboard');
        }

        return view('settings.edit')->with($data);
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
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'base_currency'         => ['required', 'string', 'max:75'],
            'base_currency_symbol'  => ['required', 'string', 'max:25'],
            'try_limit'             => ['required', 'numeric', 'min:0'],
            'order_expiration'      => ['required', 'numeric', 'min:0']
        ]);

        $setting = Setting::find($id);
        if(empty($setting))
        {
            return redirect()->route('dashboard');
        }

        $setting->base_currency         = $request->input('base_currency');
        $setting->base_currency_symbol  = $request->input('base_currency_symbol');
        $setting->try_limit             = $request->input('try_limit');
        $setting->order_expiration      = $request->input('order_expiration');

        $setting->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('settings.index');
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
