@extends('layouts.dashboard')

@section('title', 'New product | ')

@section('stylesheets')
    
@endsection

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
            <h3>New payment voucher</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('paymentvouchers.index') }}">Payment vouchers</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('paymentvouchers.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group row"> 
                    <label for="product_package" class="col-md-4 col-form-label text-md-right">{{ __('Product package') }}</label>
    
                    <div class="col-md-6">
                        <select id="product_package" class="form-control @error('product_package') is-invalid @enderror" name="product_package" required>
                            @foreach ($product_packages as $package)
                                <option value="{{ $package->id }}">{{ $package->product->name.' ('.$package->product->payment.' '.$package->name.') - '.$package->price_type }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">*** The product package for which you are creating this payment voucher ***.</small>
    
                        @error('product_package')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="quantity" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                    <div class="col-md-6">
                        <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" required autocomplete="quantity" autofocus>
                        <small class="text-muted">*** How many vouchers to create ***.</small>
                        
                        @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="expiration_date" class="col-md-4 col-form-label text-md-right">{{ __('Expiration date') }}</label>

                    <div class="col-md-6">
                        <input id="expiration_date" type="date" class="form-control @error('expiration_date') is-invalid @enderror" name="expiration_date" value="{{ old('expiration_date') }}" required autocomplete="expiration_date" autofocus>
                        <small class="text-muted">*** E.g. 27/10/2020 ***.</small>
                        
                        @error('expiration_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="assign_voucher_to" class="col-md-4 col-form-label text-md-right">{{ __('Assign voucher to') }}</label>
    
                    <div class="col-md-6">
                        <select id="assign_voucher_to" class="form-control @error('assign_voucher_to') is-invalid @enderror" name="assign_voucher_to" required>
                            <option value="All">All users</option>
                            <option value="Order">Specific order</option>
                            <option value="Student">Specific student</option>
                        </select>
    
                        @error('assign_voucher_to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="id_assigned_to" class="col-md-4 col-form-label text-md-right">{{ __('ID assigned to (optional)') }}</label>
                    
                    <div class="col-md-6">
                        <input id="id_assigned_to" type="number" class="form-control @error('id_assigned_to') is-invalid @enderror" name="id_assigned_to" value="{{ old('id_assigned_to') }}" placeholder="E.g. 12" autocomplete="id_assigned_to" autofocus>
                        <small class="text-muted">*** The <b>order ID</b> or <b>enrolment ID</b> to assign this voucher to. ***</small>
                        
                        @error('id_assigned_to')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>

@endsection