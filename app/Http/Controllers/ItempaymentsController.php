<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Director;
use App\Staff;
use App\Term;
use App\Item;
use App\Itempayment;
use App\Setting;
use App\Enrolment;
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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

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
        
        $db_check = array(
            'term_id' => $term_id
        );
        $data['itempayments'] = Itempayment::where($db_check)->orderBy('created_at', 'desc')->paginate(50);

        return view('itempayments.index')->with($data);
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

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        if(empty($data['term']->items))
        {
            $request->session()->flash('error', "Please create at least an item for students to pay for." );
            return redirect()->route('items.create');
        }
        elseif($data['term']->items->count() < 1)
        {
            $request->session()->flash('error', "Please create at least an item for students to pay for." );
            return redirect()->route('items.create');
        }

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

        $db_check = array(
            'term_id' => $term_id
        );
        $data['items'] = Item::where($db_check)->orderBy('name', 'asc')->get();
        
        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            $request->session()->flash('success', 'Error: Settings not found. Configure settings before creating product package.');
            return redirect()->route('settings.index');
        }
        elseif($data['setting']->count() < 1)
        {
            $request->session()->flash('success', 'Error: Settings not found. Configure settings before creating product package.');
            return redirect()->route('settings.index');
        }

        return view('itempayments.create')->with($data);
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

        if($request->input('return_page') == 'itempayments_index')
        {
            // verify the validity of enrolment ID & that the item being paid for is for the student's class
            $enrolment = Enrolment::find($request->input('enrolment_id'));
            if(empty($enrolment))
            {
                $request->session()->flash('error', 'The enrolment ID is NOT recognized.');
                return redirect()->route('itempayments.create');
            }
            if($request->input('item_paid_for') >= 1)
            {
                $item_found = 0;
                foreach($enrolment->arm->items as $item)
                {
                    if($item->id == $request->input('item_paid_for'))
                    {
                        $item_found++;
                    }
                }
                if($item_found < 1)
                {
                    $request->session()->flash('error', 'The item selected is wrong for the student with ID: '.$enrolment->id);
                    return redirect()->route('itempayments.create');
                }
            }
        }

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
    public function edit($id=0)
    {
        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        $data['itempayment'] = Itempayment::find($id);
        if(empty($data['itempayment']))
        {
            $request->session()->flash('error', 'Unavailable resource.');
            return redirect()->route('itempayments.index');
        }
        if($data['itempayment']->count() < 1)
        {
            $request->session()->flash('error', 'Unavailable resource.');
            return redirect()->route('itempayments.index');
        }

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

        if(!$this->resource_manager($data['user'], $school_id))
        {
            return redirect()->route('dashboard');
        }

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

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

        if($data['itempayment']->updated_by >= 1)
        {
            $data['last_updated_by'] = User::find($data['itempayment']->updated_by);
        }

        return view('itempayments.edit')->with($data);
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

        if(session('term_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $term_id = session('term_id');
        
        $data['term'] = Term::find($term_id);

        $this->validate($request, [
            'status' => ['required', 'in:Pending,Declined,Confirmed']
        ]);

        $itempayment = Itempayment::find($id);
        if(empty($itempayment))
        {
            $request->session()->flash('error', 'Unavailable resource.');
            return redirect()->route('itempayments.index');
        }
        if($itempayment->count() < 1)
        {
            $request->session()->flash('error', 'Unavailable resource.');
            return redirect()->route('itempayments.index');
        }

        $itempayment->special_note  = $request->input('special_note');
        $itempayment->status        = $request->input('status');
        $itempayment->updated_by    = $user_id;

        $itempayment->save();

        $request->session()->flash('success', 'Update saved!.');

        return redirect()->route('itempayments.edit', $id);
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

    /**
     * Check if the logged-in user can manipulate this resource by special privilege.
     * All directors are managers already but staff earn it by special privilege
     *
     * @return boolean
     */
    public function resource_manager($user, $school_id)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }
        
        $resource_manager = false;

        if($user->usertype == 'Client')
        {
            foreach($user->schools as $school)
            {
                if($school->id == $school_id)
                {
                    $resource_manager = true;
                }
            }
        }
        elseif($user->role == 'Director')
        {
            $db_check = array(
                'user_id'   => $user->id,
                'school_id' => $school_id
            );
            if(!empty(Director::where($db_check)->get()))
            {
                $resource_manager = true;
            }
        }
        elseif($user->role == 'Staff')
        {
            $db_check = array(
                'user_id'       => $user->id,
                'school_id'     => $school_id,
                'manage_received_payments'  => 'Yes'
            );
            $check_staff = Staff::where($db_check)->get();
            if(!empty($check_staff))
            {
                if($check_staff->count() == 1)
                {
                    $resource_manager = true;
                }
            }
        }

        return $resource_manager;
    }
}
