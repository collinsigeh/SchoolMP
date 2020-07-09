@extends('layouts.dashboard')

@section('title', 'New user | ')

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
            <h3>New payment processor</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
              <li class="breadcrumb-item"><a href="{{ route('payment_processors.index') }}">Payment Processors</a></li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('payment_processors.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="merchant_id" class="col-md-4 col-form-label text-md-right">{{ __('Merchant ID (Optional)') }}</label>

                    <div class="col-md-6">
                        <input id="merchant_id" type="text" class="form-control @error('merchant_id') is-invalid @enderror" name="merchant_id" value="{{ old('merchant_id') }}" autocomplete="merchant_id" autofocus>

                        @error('merchant_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="secret_word" class="col-md-4 col-form-label text-md-right">{{ __('Secret Word (Optional)') }}</label>

                    <div class="col-md-6">
                        <input id="secret_word" type="text" class="form-control @error('secret_word') is-invalid @enderror" name="secret_word" value="{{ old('merchant_id') }}" autocomplete="merchant_id" autofocus>

                        @error('secret_word')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="public_key" class="col-md-4 col-form-label text-md-right">{{ __('Public Key (Optional)') }}</label>

                    <div class="col-md-6">
                        <input id="public_key" type="text" class="form-control @error('public_key') is-invalid @enderror" name="public_key" value="{{ old('public_key') }}" autocomplete="public_key" autofocus>

                        @error('public_key')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="secret_key" class="col-md-4 col-form-label text-md-right">{{ __('Secret Key (Optional)') }}</label>

                    <div class="col-md-6">
                        <input id="secret_key" type="text" class="form-control @error('secret_key') is-invalid @enderror" name="secret_key" value="{{ old('secret_key') }}" autocomplete="secret_key" autofocus>

                        @error('secret_key')
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