<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Product;
use App\Setting;
use Illuminate\Http\Request;

class ProductsController extends Controller
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

        $data['products'] = Product::orderBy('name', 'asc')->simplePaginate(20);

        return view('products.index')->with($data);
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

        return view('products.create')->with($data);
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
            'name'          => ['required', 'string', 'max:191', 'unique:products'],
            'type'          => ['required'],
            'payment'       => ['required'],
            'features'      => ['required']
        ]);

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
    public function show(Request $request, $id = 0)
    {
        if(Auth::user()->status !== 'Active')
        {
            return view('welcome.inactive');
        }

        if($id < 1)
        {
            return redirect()->route('dashboard');
        }
        
        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }
        
        $data['product'] = Product::find($id);

        if(empty($data['product']))
        {
            return redirect()->route('dashboard');
        }
        
        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            $request->session()->flash('error', 'Settings not found. Configure settings to view product details.');
            return redirect()->route('settings.index');
        }

        session(['product_id' => $data['product']->id]);

        return view('products.show')->with($data);
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

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        $data['product'] = Product::find($id);

        if(empty($data['product']))
        {
            return redirect()->route('dashboard');
        }

        return view('products.edit')->with($data);
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
            'name'      => ['required', 'string', 'max:191', "unique:products,name,$id"],
            'type'      => ['required'],
            'payment'   => ['required'],
            'features'  => ['required']
        ]);

        $product = Product::find($id);

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

        $product->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('products.show', $id);
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
        
        if($id < 1)
        {
            return redirect()->route('products.index');
        }
        
        $user_id = Auth::user()->id;
        $data['user'] = User::find($user_id);

        if($data['user']->usertype != 'Admin')
        {
            return redirect()->route('dashboard');
        }

        $product = Product::find($id);
        if(empty($product))
        {
            $request->session()->flash('error', 'ERROR: An attempt to delete unavailable resource.');
            return redirect()->route('products.index');
        }
        if(!empty($product->packages))
        {
            $request->session()->flash('error', '<p>ERROR: An attempt to delete a product with available packages.</p>You have to delete each of the product packages before attempting to delete the product itself.');
            return redirect()->route('products.show', $id);
        }

        $product->delete();
        $request->session()->flash('success', 'The product and its packages have been deleted');

        return redirect()->route('products.index');
    }
}
