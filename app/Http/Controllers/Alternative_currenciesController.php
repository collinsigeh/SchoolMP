<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Setting;
use App\Alternative_currency;
use App\Paymentprocessors;
use Illuminate\Http\Request;

class Alternative_currenciesController extends Controller
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

        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['setting']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $data['paymentprocessors'] = Paymentprocessors::all();

        return view('alternative_currencies.create')->with($data);
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
        
        $setting = Setting::first();
        if(empty($setting))
        {
            return redirect()->route('dashboard');
        }
        elseif($setting->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $this->validate($request, [
            'name'      => ['required', 'string', 'max:75', 'unique:alternative_currencies'],
            'symbol'    => ['required', 'string', 'max:25', 'unique:alternative_currencies'],
            'rate'      => ['required', 'numeric']
        ]);

        if($setting->count() >= 1)
        {
            if(($setting->base_currency == $request->input('name')) OR ($setting->base_currency_symbol == $request->input('symbol')))
            {
                $request->session()->flash('error', 'The specified currency is the base currency.');
                return redirect()->route('alternative_currencies.create');
            }
        }

        $currency = new Alternative_currency;

        $currency->name         = $request->input('name');
        $currency->symbol       = $request->input('symbol');
        $currency->rate         = $request->input('rate');
        $currency->created_by   = $user_id;

        $currency->save();
        
        $request->session()->flash('success', 'Currency added.');

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

        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['setting']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $data['currency'] = Alternative_currency::find($id);
        if(empty($data['currency']))
        {
            return redirect()->route('dashboard');
        }
        elseif($sdata['currency']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $data['paymentprocessors'] = Paymentprocessors::all();

        return view('alternative_currencies.edit')->with($data);
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
            'name'      => ['required', 'string', 'max:75', "unique:alternative_currencies,name,$id"],
            'symbol'    => ['required', 'string', 'max:25', "unique:alternative_currencies,symbol,$id"],
            'rate'      => ['required', 'numeric'],
            'payment_processor' => ['required']
        ]);

        $currency = Alternative_currency::find($id);

        $currency->name     = $request->input('name');
        $currency->symbol   = $request->input('symbol');
        $currency->rate     = $request->input('rate');
        $currency->paymentprocessor_id  = $request->input('payment_processor');

        $currency->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('alternative_currencies.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = 0)
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

        $currency = Alternative_currency::find($id);
        if(empty($currency))
        {
            return redirect()->route('dashboard');
        }
        elseif($currency->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $currency->delete();
        
        $request->session()->flash('success', 'Currency deleted.');

        return redirect()->route('settings.index');
    }
}
