@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @if ($user->usertype == 'Client')
        @include('partials._clients_sidebar')
      @else
        @if ($user->role == 'Director')
            @include('partials._directors_sidebar')
        @elseif ($user->role == 'Staff')
            @include('partials._staff_sidebar')
        @endif
      @endif

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>School information</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.index') }}">Schools</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit school information</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit school information</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('schools.update', $school->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group row"> 
                    <div class="col-md-6 offset-md-4 text-left">
                        <img src="{{ config('app.url') }}/images/school/{{ $school->logo }}" alt="School logo" class="school-logo">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="school" class="col-md-4 col-form-label text-md-right">{{ __('School') }}</label>

                    <div class="col-md-6">
                        <input id="school" type="text" class="form-control @error('school') is-invalid @enderror" name="school" value="{{ $school->school }}" required autocomplete="school" autofocus>

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
                        <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" required autocomplete="address" autofocus>{{ $school->address }}</textarea>

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
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $school->phone }}" required autocomplete="phone" autofocus>

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
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $school->email }}" required autocomplete="email" autofocus>

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
                        <input id="website" type="text" class="form-control @error('website') is-invalid @enderror" name="website" value="{{ $school->website }}" autocomplete="website" autofocus>
                        <small class="text-muted"><strong>Format:</strong> http://yourwebsite.com</small>

                        @error('website')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('New Logo / badge (optional)') }}</label>

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
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if ($user->usertype == 'Client')
            <div class="more-options">
                <div class="head">More options</div>
                <div class="body">
                    <div class="option">
                        <h5>Manage school</h5>
                        <div class="row">
                            <div class="col-md-10 offset-md-2">
                                <a href="{{ route('schools.show', $school->id) }}" class="btn btn-primary">Enter</a>
                            </div>
                        </div>
                    </div>
    
                    <div class="option">
                    <form method="POST" action="{{ route('schools.destroy', $school->id) }}">
                        @csrf
                        @method('DELETE')
    
                        <h5>Delete school</h5>
    
                        <div class="form-group row">
                            <div class="col-md-10 offset-md-2">
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
        @endif

      </div>
      
    </div>
  </div>

@endsection