@extends('layouts.dashboard')

@section('title', 'Edit user details | ')

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
          <h3>Edit user details</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Schoobic users</a></li>
              <li class="breadcrumb-item"><a href="{{ route('users.show', $thisuser->id) }}">{{ $thisuser->name }}</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('users.update', $thisuser->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group row"> 
                    <div class="col-md-6 offset-md-4 text-left">
                        <img src="{{ config('app.url') }}/images/profile/{{ $thisuser->pic }}" alt="Photo" class="user-pic">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $thisuser->name }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                        
                <div class="form-group row"> 
                    <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                    <div class="col-md-6">
                        <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="gender" autofocus>
                            <option value="Male" @if ($user->gender == 'NOT Available')
                                {{ 'selected' }}
                            @endif>NOT Available</option>
                            <option value="Male" @if ($user->gender == 'Male')
                                {{ 'selected' }}
                            @endif>Male</option>
                            <option value="Female" @if ($user->gender == 'Female')
                                {{ 'selected' }}
                            @endif>Female</option>
                        </select>

                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $thisuser->email }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="usertype" class="col-md-4 col-form-label text-md-right">{{ __('Usertype') }}</label>

                    <div class="col-md-6">
                        <input id="usertype" type="text" class="form-control @error('usertype') is-invalid @enderror" name="usertype" value="{{ $thisuser->usertype }}" disabled autocomplete="usertype" autofocus>

                        @error('usertype')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('User Role') }}</label>

                    <div class="col-md-6">
                        <input id="role" type="text" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ $thisuser->role }}" disabled autocomplete="role" autofocus>

                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('User Status') }}</label>
    
                    <div class="col-md-6">
                        <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                            <option value="Active" @if ($thisuser->status == 'Active')
                                {{ 'selected' }}
                            @endif>Active</option>
                            <option value="Inactive" @if ($thisuser->status == 'Inactive')
                                    {{ 'selected' }}
                                @endif>Inactive</option>
                        </select>
    
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="pic" class="col-md-4 col-form-label text-md-right">{{ __('Picture (optional)') }}</label>

                    <div class="col-md-6">
                        <input id="pic" type="file" class="form-control @error('pic') is-invalid @enderror" name="pic" value="{{ old('pic') }}" autocomplete="pic" autofocus>

                        @error('pic')
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