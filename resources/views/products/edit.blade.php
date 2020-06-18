@extends('layouts.dashboard')

@section('title', 'Edit product details | ')

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
          <h3>Edit product details</h3>
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
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('products.update', $product->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->name }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
    
                    <div class="col-md-6">
                        <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" required>
                            <option value="Subscription" @if ($product->type == 'Subscription')
                                {{ 'selected' }}
                            @endif>Subscription</option>
                            <option value="Non-subscription" @if ($product->type == 'Non-subscription')
                                {{ 'selected' }}
                            @endif>Non-subscription</option>
                        </select>
    
                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="payment" class="col-md-4 col-form-label text-md-right">{{ __('Payment') }}</label>
    
                    <div class="col-md-6">
                        <select id="payment" class="form-control @error('payment') is-invalid @enderror" name="payment" required>
                            <option value="Prepaid" @if ($product->payment == 'Prepaid')
                                {{ 'selected' }}
                            @endif>Prepaid</option>
                            <option value="Post-paid" @if ($product->payment == 'Post-paid')
                                {{ 'selected' }}
                            @endif>Post-paid</option>
                            <option value="Trial" @if ($product->payment == 'Trial')
                                {{ 'selected' }}
                            @endif>Trial</option>
                        </select>
    
                        @error('payment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="features" class="col-md-4 col-form-label text-md-right">{{ __('Features') }}</label>

                    <div class="col-md-6">
                        <textarea id="features" class="form-control @error('features') is-invalid @enderror" name="features" required autocomplete="features" autofocus>{{ $product->features }}</textarea>
                        <small class="text-muted">HTML tags allowed for feature clarity.</small>

                        @error('features')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="student_limit" class="col-md-4 col-form-label text-md-right">{{ __('Student limit (optional)') }}</label>

                    <div class="col-md-6">
                        <input id="student_limit" type="text" class="form-control @error('student_limit') is-invalid @enderror" name="student_limit" value="{{ $product->student_limit }}" placeholder="E.g. 400" required autocomplete="student_limit" autofocus>
                        <small class="text-muted">The letter "<b>n</b>" means unspecified number of students.</small>

                        @error('student_limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>

@endsection