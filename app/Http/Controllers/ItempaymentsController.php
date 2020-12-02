<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Staff;
use App\Term;
use App\Itempayment;
use Illuminate\Http\Request;

class ItempaymentsController extends Controller
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

        if(session('school_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');

        $this->validate($request, [
            'return_page'       => ['required'],
            'enrolment_id'      => ['required', 'integer'],
            'item_paid_for'     => ['required', 'integer'],
            'currency_symbol'   => ['required'],
            'amount_received'   => ['required', 'numeric'],
            'method_of_payment' => ['required'],
            'status'            => ['required']
        ]);

        $itempayment = new Itempayment;

        $itempayment->enrolment_id = $request->input('enrolment_id');
        $itempayment->item_id = $request->input('item_paid_for');
        $itempayment->term_id = $term_id;
        $itempayment->school_id = $school_id;
        $itempayment->currency_symbol = $request->input('currency_symbol');
        $itempayment->amount = $request->input('amount_received');
        $itempayment->method = $request->input('method_of_payment');
        $itempayment->special_note = $request->input('special_note');
        $itempayment->status = $request->input('status');
        $itempayment->user_id = $user_id;

        $itempayment->save();

        $request->session()->flash('success', 'Payment saved.');

        if($request->input('return_page') == 'enrolments_show')
        {
            return redirect()->route('enrolments.show', $request->input('enrolment_id'));
        }
        return redirect()->route('itempayments.index');
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
