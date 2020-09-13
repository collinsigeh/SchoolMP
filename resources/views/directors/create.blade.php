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
        @endif
        @if ($user->role == 'Staff')
            @include('partials._staff_sidebar')
        @endif
      @endif

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
            <h3>New director</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('directors.index') }}">Directors</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add new</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('directors.index') }}">Directors</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add new</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="alert alert-info">Add new directors here.</div>

        <div class="create-form">
            <form method="POST" action="{{ route('directors.store') }}" enctype="multipart/form-data">
                @csrf
                
                <input type="hidden" name="usertype" value="Non-client">
                <input type="hidden" name="role" value="Director">

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
                    <label for="pic" class="col-md-4 col-form-label text-md-right">{{ __('Picture (optional)') }}</label>

                    <div class="col-md-6">
                        <input id="pic" type="file" class="form-control @error('pic') is-invalid @enderror" name="pic" value="{{ old('pic') }}" autocomplete="pic" autofocus>
                        <small class="text-muted"><strong>Preferred size:</strong> 300 x 300 px</small>

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
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!--
        <div class="more-options">
            <div class="head">More options</div>
            <div class="body">
                <div class="option">
                    <h5>Make an existing user a director</h5>
                    <div class="row">
                        <div class="col-md-10 offset-md-2">
                        <a href="{{ route('directors.new') }}" class="btn btn-primary">New addition</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
    </div>
  </div>

@endsection