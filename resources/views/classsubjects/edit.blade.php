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
            <h3>{{ $arm->schoolclass->name.' '.$arm->name.' '.$classsubject->subject->name }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.show', $arm->id) }}">{{ $arm->schoolclass->name.' '.$arm->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.show', $arm->id) }}">{{ $arm->schoolclass->name.' '.$arm->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('classsubjects.update', $classsubject->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Subject Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $arm->schoolclass->name.' '.$arm->name.' '.$classsubject->subject->name }}" disabled autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('Assigned subject teacher') }}</label>

                    <div class="col-md-6">
                        <select id="user_id" type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" required autocomplete="user_id" autofocus>
                            @php
                                if($classsubject->user_id == 0)
                                {
                                    echo '<option value="0">Select a staff</option>';
                                }
                                else
                                {
                                    echo '<option value="'.$classsubject->user_id.'">'.$classsubject->user->name.'</option>';
                                }
                                foreach($school->staff as $employee)
                                {
                                    echo '<option value="'.$employee->user->id.'">'.$employee->user->name.' ( <i>'.$employee->designation.'</i> )</option>';
                                }
                            @endphp
                        </select>

                        @error('user_id')
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