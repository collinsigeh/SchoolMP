<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\School;
use App\Schoolclass;
use App\Director;
use App\Staff;
use App\Term;
use App\Arm;
use App\Item;
use App\Setting;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
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
        $data['items'] = Item::where($db_check)->orderBy('name', 'asc')->simplePaginate(20);

        return view('items.index')->with($data);
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

        if(empty($data['school']->schoolclasses))
        {
            $request->session()->flash('error', "Please create at least a school class before attempting to create fees and other items for students." );
            return redirect()->route('classes.create');
        }
        elseif($data['school']->schoolclasses->count() < 1)
        {
            $request->session()->flash('error', "Please create at least a school class before attempting to create fees and other items for students." );
            return redirect()->route('classes.create');
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
            'school_id' => $school_id
        );
        $data['schoolclasses'] = Schoolclass::where($db_check)->orderBy('name', 'asc')->get();
        
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

        return view('items.create')->with($data);
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
            'name' => ['required'],
            'currency_symbol' => ['required'],
            'amount' => ['required', 'numeric'],
            'item_type' => ['required', 'in:Required,Optional'],
            'arm_count' => ['required', 'numeric']
        ]);

        $name = ucwords(strtolower(trim($request->input('name'))));
        $arm_count = $request->input('arm_count');

        $item = new Item;

        $item->school_id = $school_id;
        $item->term_id = $term_id;
        $item->name = $name;
        $item->currency_symbol = $request->input('currency_symbol');
        $item->amount = $request->input('amount');
        $item->type = $request->input('item_type');
        $item->user_id = $user_id;

        $item->save();

        for ($i=0; $i < $arm_count; $i++) {
            if($request->input($i) > 0)
            {
                DB::insert('insert into arm_item (arm_id, item_id) values (?, ?)', [$request->input($i), $item->id]);
            }
        }

        $request->session()->flash('success', 'Item created.');

        return redirect()->route('items.index');
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
        $data['item'] = Item::find($id);
        if(empty($data['item']))
        {
            $request->session()->flash('error', 'Unavailable resource.');
            return redirect()->route('items.index');
        }
        if($data['item']->count() < 1)
        {
            $request->session()->flash('error', 'Unavailable resource.');
            return redirect()->route('items.index');
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

        $db_check = array(
            'school_id' => $school_id
        );
        $data['schoolclasses'] = Schoolclass::where($db_check)->orderBy('name', 'asc')->get();

        return view('items.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=0)
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
            'name' => ['required'],
            'currency_symbol' => ['required'],
            'amount' => ['required', 'numeric'],
            'arm_count' => ['required', 'numeric']
        ]);

        $name = ucwords(strtolower(trim($request->input('name'))));
        $arm_count = $request->input('arm_count');

        $item = Item::find($id);
        if(empty($item))
        {
            $request->session()->flash('error', 'Unavailable resource.');
            return redirect()->route('items.index');
        }
        if($item->count() < 1)
        {
            $request->session()->flash('error', 'Unavailable resource.');
            return redirect()->route('items.index');
        }

        $item->school_id = $school_id;
        $item->term_id = $term_id;
        $item->name = $name;
        $item->currency_symbol = $request->input('currency_symbol');
        $item->amount = $request->input('amount');
        $item->user_id = $user_id;

        $item->save();

        // clean up previous list of affected class
        DB::delete('delete from arm_item where item_id = ?', [$item->id]);
        // End - clean up previous list of affected class

        // re-specify affected class
        for ($i=0; $i < $arm_count; $i++) {
            if($request->input($i) > 0)
            {
                DB::insert('insert into arm_item (arm_id, item_id) values (?, ?)', [$request->input($i), $item->id]);
            }
        }
        // End - re-specify affected class

        $request->session()->flash('success', 'Update saved!.');

        return redirect()->route('items.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id=0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if(session('school_id') < 1)
        {
            $request->session()->flash('error', 'Error 4' );
            return redirect()->route('dashboard');
        }
        $school_id = session('school_id');

        if($id < 1)
        {
            return redirect()->route('dashboard');
        }

        $this->validate($request, [
            'confirmation_to_delete' => ['required', 'in:DELETE']
        ]);

        $item = Item::find($id);
        if(empty($item))
        {
            $request->session()->flash('error', 'Error 2: Attempt to delete unavailable resource.' );
            return redirect()->route('items.index');
        }

        if(count($item->itempayments) > 0)
        {
            $request->session()->flash('error', 'Error 1: Attempt to delete an item that has linked payment.' );
        }
        else
        {
            DB::delete('delete from arm_item where item_id = ?', [$id]);

            $item->delete();
            $request->session()->flash('success', 'Item deleted');
        }

        return redirect()->route('items.index');
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
                'manage_fees_products'  => 'Yes'
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
