@extends('layouts.dashboard')

@section('title', 'Edit settings | ')

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
            <h3>Edit settings configuration</h3>
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
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('settings.update', $setting->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group row"> 
                    <label for="contact_email" class="col-md-4 col-form-label text-md-right">{{ __('Contact Email') }}</label>
                    
                    <div class="col-md-6">
                        <input id="contact_email" type="email" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ $setting->contact_email }}" required autocomplete="contact_email" autofocus>

                        @error('contact_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="base_currency" class="col-md-4 col-form-label text-md-right">{{ __('Base Currency') }}</label>
                    
                    <div class="col-md-6">
                        <input id="base_currency" type="text" class="form-control @error('base_currency') is-invalid @enderror" name="base_currency" value="{{ $setting->base_currency }}" placeholder="E.g. Nigerian Naira" required autocomplete="base_currency" autofocus>

                        @error('base_currency')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="base_currency_symbol" class="col-md-4 col-form-label text-md-right">{{ __('Base Currency Symbol') }}</label>

                    <div class="col-md-6">
                        <input id="base_currency_symbol" type="text" class="form-control @error('base_currency_symbol') is-invalid @enderror" name="base_currency_symbol" value="{{ $setting->base_currency_symbol }}" placeholder="E.g. NGN" required autocomplete="base_currency_symbol" autofocus>

                        @error('base_currency_symbol')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="try_limit" class="col-md-4 col-form-label text-md-right">{{ __('Try limit (per user or school)') }}</label>

                    <div class="col-md-6">
                        <input id="try_limit" type="text" class="form-control @error('try_limit') is-invalid @enderror" name="try_limit" value="{{ $setting->try_limit }}" placeholder="E.g. 3" required autocomplete="try_limit" autofocus>

                        @error('try_limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="order_expiration" class="col-md-4 col-form-label text-md-right">{{ __('Order expiration (in days)') }}</label>

                    <div class="col-md-6">
                        <input id="order_expiration" type="text" class="form-control @error('order_expiration') is-invalid @enderror" name="order_expiration" value="{{ $setting->order_expiration }}" placeholder="E.g. 3" required autocomplete="order_expiration" autofocus>
                        <small>How long before client order expires</small>

                        @error('order_expiration')
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
                            @foreach ($paymentprocessors as $payment_processor)
                                <option value="{{ $payment_processor->id }}" @if ($setting->paymentprocessor_id == $payment_processor->id)
                                    {{ 'selected' }}
                                @endif>{{ $payment_processor->name }}</option>
                            @endforeach
                            <option value="0" @if ($setting->paymentprocessor_id == 0)
                                {{ 'selected' }}
                            @endif>None (Off-line payments)</option>
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