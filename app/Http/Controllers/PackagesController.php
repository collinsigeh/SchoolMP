<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Product;
use App\Package;
use App\Setting;
use Illuminate\Http\Request;
use Image;
use Storage;

class PackagesController extends Controller
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
    public function create(Request $request)
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

        if(session('product_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $product_id = session('product_id');
        
        $data['product'] = Product::find($product_id);
        if(empty($data['product']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['product']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        
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

        return view('packages.create')->with($data);
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

        if(session('product_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $product_id = session('product_id');
        
        $data['product'] = Product::find($product_id);
        if(empty($data['product']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['product']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        
        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            $request->session()->flash('error', 'Settings not found. Configure settings before creating product package.');
            return redirect()->route('settings.index');
        }
        elseif($data['setting']->count() < 1)
        {
            $request->session()->flash('error', 'Settings not found. Configure settings before creating product package.');
            return redirect()->route('settings.index');
        }

        $this->validate($request, [
            'name'          => ['required', 'string', 'max:191'],
            'image'         => ['sometimes', 'image', 'max:1999'],
            'term_limit'    => ['required', 'integer', 'min: 1'],
            'day_limit'     => ['required', 'integer', 'min: 1'],
            'price_type'    => ['required'],
            'price'         => ['required', 'numeric', 'min: 0'],
            'status'        => ['required']
        ]);

        if($data['product']->payment !== 'Trial')
        {
            $this->validate($request, [
                'price'         => ['required', 'numeric', 'gt: 0']
            ]);
        }

        $name = ucwords(strtolower($request->input('name')));
        
        $db_check = array(
            'product_id'    => $product_id,
            'name'          => $name
        );
        $packages_set = Package::where($db_check)->get();
        if(!empty($packages_set))
        {
            if(count($packages_set) > 0)
            {
                $request->session()->flash('error', 'There is a package with name: '.$name.' for this product.');
                return redirect()->route('packages.create');
            }
        }

        $package = new Package;

        $package->product_id    = $product_id;
        $package->name          = $name;
        $package->term_limit    = $request->input('term_limit');
        $package->day_limit     = $request->input('day_limit');
        $package->price_type    = $request->input('price_type');
        $package->price         = $request->input('price');
        $package->status        = $request->input('status');
        $package->created_by    = $user_id;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $filename = time() . '-' . rand(1,9) . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/product_package/' . $filename);
            $new_location = str_replace('shms/public', 'shms.briigo.com', $location);
            Image::make($image)->resize(300,300)->save($new_location);

            $package->image = $filename;
        }
        else
        {
            $package->image = 'default_image.png';
        }

        $package->save();
        
        $request->session()->flash('success', 'Package created.');

        return redirect()->route('products.show', $product_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 0)
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
        
        $data['package'] = Package::find($id);

        if(empty($data['package']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['package']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        
        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            $request->session()->flash('error', 'Settings not found. Configure settings to view product package details.');
            return redirect()->route('settings.index');
        }
        elseif($data['setting']->count() < 1)
        {
            $request->session()->flash('error', 'Settings not found. Configure settings to view product package details.');
            return redirect()->route('settings.index');
        }

        return view('packages.show')->with($data);
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

        $data['package'] = Package::find($id);

        if(empty($data['package']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['package']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }
        
        $data['setting'] = Setting::first();
        if(empty($data['setting']))
        {
            $request->session()->flash('error', 'Settings not found. Configure settings to view product package details.');
            return redirect()->route('settings.index');
        }
        elseif($data['setting']->count() < 1)
        {
            $request->session()->flash('error', 'Settings not found. Configure settings to view product package details.');
            return redirect()->route('settings.index');
        }

        return view('packages.edit')->with($data);
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

        if(session('product_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $product_id = session('product_id');
        
        $data['product'] = Product::find($product_id);
        if(empty($data['product']))
        {
            return redirect()->route('dashboard');
        }
        elseif($data['product']->count() < 1)
        {
            return  redirect()->route('dashboard');
        }

        $this->validate($request, [
            'name'          => ['required', 'string', 'max:191'],
            'term_limit'    => ['required', 'integer', 'min: 1'],
            'day_limit'     => ['required', 'integer', 'min: 1'],
            'price_type'    => ['required'],
            'price'         => ['required', 'numeric', 'min: 0'],
            'status'        => ['required']
        ]);

        $name = ucwords(strtolower($request->input('name')));

        $db_check = array(
            'product_id'    => $product_id,
            'name'          => $name
        );
        $packages_set = Package::where($db_check)->where('id', '!=', $id)->get();
        if(!empty($packages_set))
        {
            if($packages_set->count() > 0)
            {
                $request->session()->flash('error', 'There is another package with name: '.$name.' for this product.');
                return redirect()->route('packages.create');
            }
        }

        $package = Package::find($id);

        $package->product_id    = $product_id;
        $package->name          = $name;
        $package->term_limit    = $request->input('term_limit');
        $package->day_limit     = $request->input('day_limit');
        $package->price_type    = $request->input('price_type');
        $package->price         = $request->input('price');
        $package->status        = $request->input('status');
        $package->created_by    = $user_id;

        $package->save();
        
        $request->session()->flash('success', 'Update saved.');

        return redirect()->route('packages.edit', $id);
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

        if(session('product_id') < 1)
        {
            return redirect()->route('dashboard');
        }
        $product_id = session('product_id');
        
        $package = Package::find($id);
        if(empty($package))
        {
            $request->session()->flash('error', 'ERROR: An attempt to delete unavailable resource.');
        }
        else
        {
            $package->delete();
            $request->session()->flash('success', 'Package deleted');
        }

        return redirect()->route('products.show', $product_id);
    }
}
