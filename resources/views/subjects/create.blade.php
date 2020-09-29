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
            <h3>New subject</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('school_settings.index') }}">School settings</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add new</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('school_settings.index') }}">School settings</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add new</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="alert alert-info">Complete the form below to create a new result template.</div>
        <div class="create-form">
            <form method="POST" action="{{ route('subjects.store') }}">
                @csrf
                
                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Subject name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="E.g. Mathematics" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Brief description (Optional):') }}</label>
                    
                    <div class="col-md-6">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Maybe a little about this subject...">{{ old('description') }}</textarea>

                        @error('description')
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