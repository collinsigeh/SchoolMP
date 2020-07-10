@extends('layouts.dashboard')

@section('title', 'Add new currency | ')

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
            <h3>New currency</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add new currency</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('alternative_currencies.store') }}">
                @csrf

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                    
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="E.g. Nigerian Naira" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="symbol" class="col-md-4 col-form-label text-md-right">{{ __('Symbol') }}</label>

                    <div class="col-md-6">
                        <input id="symbol" type="text" class="form-control @error('symbol') is-invalid @enderror" name="symbol" value="{{ old('symbol') }}" placeholder="E.g. NGN" required autocomplete="symbol" autofocus>

                        @error('symbol')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="rate" class="col-md-4 col-form-label text-md-right">{{ __('Rate') }}</label>

                    <div class="col-md-6">
                        <input id="rate" type="text" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{ old('rate') }}" placeholder="E.g. 17.456432" required autocomplete="symbol" autofocus>
                        <small class="text-muted">How much of this currency makes One {{ $setting->base_currency }} ( {{ $setting->base_currency_symbol }} 1.00 ).</small>

                        @error('symbol')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="payment_processor" class="col-md-4 col-form-label text-md-right">{{ __('Payment Processor') }}</label>
    
                    <div class="col-md-6">
                        <select id="payment_processor" class="form-control @error('payment_processor') is-invalid @enderror" name="payment_processor" required>
                            <option value="0">Select a payment processor for base currency</option>
                            @foreach ($paymentprocessors as $payment_processor)
                                <option value="{{ $payment_processor->id }}">{{ $payment_processor->name }}</option>
                            @endforeach                            
                        </select>
    
                        @error('payment_processor')
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