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
            <h3>New school class</h3>
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
                <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">School classes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">School classes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add new</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('classes.store') }}">
                @csrf
                
                <div class="form-group row"> 
                  <label for="schoolsegment" class="col-md-4 col-form-label text-md-right">{{ __('School segment') }}</label>

                  <div class="col-md-6">
                      <select id="schoolsegment" type="text" class="form-control @error('schoolsegment') is-invalid @enderror" name="schoolsegment" required autocomplete="schoolclass_id" autofocus>
                          <option value="Primary">Primary</option>
                          <option value="Junior Secondary">Junior Secondary</option>
                          <option value="Senior Secondary">Senior Secondary</option>
                          <option value="Nursery">Nursery</option>
                          <option value="Pre-nursery">Pre-nursery</option>
                          <option value="Kindergarten">Kindergarten</option>
                          <option value="Creche">Creche</option>
                          <option value="Basic">Basic</option>
                          <option value="Preparatory">Preparatory</option>
                          <option value="Standard">Standard</option>
                          <option value="Grade">Grade</option>
                      </select>

                      @error('schoolsegment')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                </div>

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Class') }}</label>

                    <div class="col-md-6">
                        <select id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>
                            @php
                                for($i = 1; $i <= 12; $i++)
                                {
                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                }
                            @endphp
                        </select>

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
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Maybe a little about this class...">{{ old('description') }}</textarea>

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