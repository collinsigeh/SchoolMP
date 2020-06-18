@extends('layouts.dashboard')

@section('title', 'New School | ')

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._clients_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>New school</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Schools</a></li>
              <li class="breadcrumb-item active" aria-current="page">Add new</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('schools.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group row"> 
                    <label for="school" class="col-md-4 col-form-label text-md-right">{{ __('School') }}</label>

                    <div class="col-md-6">
                        <input id="school" type="text" class="form-control @error('school') is-invalid @enderror" name="school" value="@php
                            if(strlen(session('school_under_registration')) > 1){
                                echo (session('school_under_registration'));
                                session(['school_under_registration' => '']);
                            }
                        @endphp {{ old('school') }}" required autocomplete="school" autofocus>

                        @error('school')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                    <div class="col-md-6">
                        <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" required autocomplete="address" autofocus>{{ old('address') }}</textarea>

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                    <div class="col-md-6">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="website" class="col-md-4 col-form-label text-md-right">{{ __('Website (optional)') }}</label>

                    <div class="col-md-6">
                        <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ old('website') }}" autocomplete="website" autofocus>
                        <small class="text-muted"><strong>Format:</strong> https://yourwebsite.com</small>

                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo / badge (optional)') }}</label>

                    <div class="col-md-6">
                        <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}" autocomplete="logo" autofocus>

                        @error('logo')
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
  </div>

@endsection