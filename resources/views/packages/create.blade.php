@extends('layouts.dashboard')

@section('title', 'New package | ')

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
            <h3>New product package</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create package</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('packages.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group row"> 
                    <label for="product" class="col-md-4 col-form-label text-md-right">{{ __('Product') }}</label>

                    <div class="col-md-6">
                        <input id="product" type="text" class="form-control @error('product') is-invalid @enderror" name="product" value="{{ $product->name }} ( {{ $product->payment }} )" disabled autocomplete="product" autofocus>
                        
                        @error('product')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="student_limit" class="col-md-4 col-form-label text-md-right">{{ __('Student limit') }}</label>

                    <div class="col-md-6">
                        <input id="student_limit" type="text" class="form-control @error('student_limit') is-invalid @enderror" name="student_limit" value="{{ $product->student_limit }}" disabled autocomplete="student_limit" autofocus>
                        
                        @error('student_limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name of package') }}</label>
                    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <small class="text-muted">E.g. One-off, Monthly, Termly, Yearly, etc.</small>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image (optional)') }}</label>

                    <div class="col-md-6">
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" autocomplete="image" autofocus>

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="term_limit" class="col-md-4 col-form-label text-md-right">{{ __('Term limit (optional)') }}</label>

                    <div class="col-md-6">
                        <input id="term_limit" type="text" class="form-control @error('term_limit') is-invalid @enderror" name="term_limit" value="{{ old('term_limit') }}" placeholder="E.g. 3" autocomplete="term_limit" autofocus>
                        <small class="text-muted">How many terms will this package be valid for.</small>

                        @error('term_limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="day_limit" class="col-md-4 col-form-label text-md-right">{{ __('Day limit (optional)') }}</label>

                    <div class="col-md-6">
                        <input id="day_limit" type="text" class="form-control @error('day_limit') is-invalid @enderror" name="day_limit" value="{{ old('day_limit') }}" placeholder="E.g. 400" autocomplete="day_limit" autofocus>
                        <small class="text-muted">How many days will this package be valid for.</small>

                        @error('day_limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="price_type" class="col-md-4 col-form-label text-md-right">{{ __('Price Type') }}</label>
    
                    <div class="col-md-6">
                        <select id="price_type" class="form-control @error('price_type') is-invalid @enderror" name="price_type" required>
                            <option value="Per-student">Per-student</option>
                            <option value="Per-package">Per-package</option>
                        </select>
    
                        @error('price_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Price ('.$setting->base_currency_symbol.')') }}</label>

                    <div class="col-md-6">
                        <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" placeholder="E.g. 650.00" required autocomplete="price" autofocus>
                        <small class="text-muted">Amount only.</small>

                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
    
                    <div class="col-md-6">
                        <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                            <option value="Available">Available</option>
                            <option value="NOT Available">NOT Available</option>
                        </select>
    
                        @error('status')
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