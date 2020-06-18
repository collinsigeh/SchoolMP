@extends('layouts.dashboard')

@section('title', 'Product details | ')

@section('content')

<div class="container-fluid">
    <div class="row">
        @if ($user->role == 'Owner')
          @include('partials._owner_sidebar')
        @else
          @include('partials._system_sidebar')
        @endif

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
          <h3>{{ $product->name }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="resource-details">
            <div class="title">
                Product Details
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-2">
                        Name:
                    </div>
                    <div class="col-md-10">
                        <h4>{{ $product->name }}</h4>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        Type:
                    </div>
                    <div class="col-md-10">
                        {{ $product->type }} ( <i>{{ $product->payment }}</i> )
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        Student limit:
                    </div>
                    <div class="col-md-10">
                        {{ $product->student_limit }}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        Features:
                    </div>
                    <div class="col-md-10">
                        {!! $product->features !!}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-2">
                        <small>Created since:</small>
                    </div>
                    <div class="col-md-10">
                        <small>{{ $product->created_at }}</small>
                    </div>
                </div>

                <div class="packages">
                    <h5>List of packages</h5>
                    @if(count($product->packages) < 1)
                        <div class="alert alert-info" sr-only="alert">
                            No package (<i>plan/offer that can be ordered or subscribed to</i>).
                        </div>
                    @else
                        <div class="table-responsive">    
                        <table class="table table-striped table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>Package</th>
                                        <th class="text-right">Price ( {{ $setting->base_currency_symbol }} )</th>
                                        <th class="text-right">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->packages as $package)
                                        <tr>
                                            <td>{{ $product->name }} ( <i>{{ $product->payment.' '.$package->name }}</i> )</td>
                                            <td class="text-right">{{ $setting->base_currency_symbol }} {{$package->price }} ( <i>{{ $package->price_type }}</i> )</td>
                                            <td class="text-right">{{ $package->status }}</td>
                                            <td class="text-right"><a href="{{ route('packages.show', $package->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="more-options">
            <div class="head">More options</div>
            <div class="body">
                <div class="option">
                    <h5>Create product packages</h5>
                    <div class="row">
                        <div class="col-md-10 offset-md-2">
                        <a href="{{ route('packages.create') }}" class="btn btn-primary">New package</a>
                        </div>
                    </div>
                </div>

                <div class="option">
                    <h5>Edit details</h5>
                    <div class="row">
                        <div class="col-md-10 offset-md-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>

                <div class="option">
                <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                    @csrf
                    @method('DELETE')

                    <h5>Delete product</h5>

                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <p><b>NOTE:</b> This action will remove all dependent payment plans.</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Yes') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10 offset-md-2">
                            <button type="submit" class="btn btn-danger">
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
  </div>

@endsection
