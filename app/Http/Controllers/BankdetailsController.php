<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Bankdetail;
use Illuminate\Http\Request;

class BankdetailsController extends Controller
{
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
        
        $data['bankdetails'] = Bankdetail::orderBy('bank_name', 'asc')->simplePaginate(20);

        return view('bankdetails.index')->with($data);
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

        return view('bankdetails.create')->with($data);
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
            'bank_name'         => ['required', 'string', 'max:191'],
            'account_name'      => ['required'],
            'account_number'    => ['required']
        ]);

        $bankdetail = new Bankdetail;

        $bankdetail->bank_name      = strtoupper($request->input('bank_name'));
        $bankdetail->account_name   = strtoupper($request->input('account_name'));
        $bankdetail->account_number = $request->input('account_number');

        $bankdetail->save();
        
        $request->session()->flash('success', 'Saved!');

        return redirect()->route('bankdetails.index');
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

        $data['bankdetail'] = Bankdetail::find($id);

        if(empty($data['bankdetail']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['bankdetail']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        return view('bankdetails.edit')->with($data);
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
            'bank_name'         => ['required', 'string', 'max:191'],
            'account_name'      => ['required'],
            'account_number'    => ['required']
        ]);

        $bankdetail = Bankdetail::find($id);

        $bankdetail->bank_name      = strtoupper($request->input('bank_name'));
        $bankdetail->account_name   = strtoupper($request->input('account_name'));
        $bankdetail->account_number = $request->input('account_number');

        $bankdetail->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('bankdetails.edit', $id);
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
