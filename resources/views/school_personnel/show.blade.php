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
          <h3>{!! $term->name.' - <small>'.$term->session.'</small>' !!}</h3>
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
                <li class="breadcrumb-item active" aria-current="page">School personnel</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">School personnel</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            <div class="row">
              <div class="col-md-3">
                <div class="collins-feature">
                  <a href="{{ route('terms.index') }}">
                  <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="session_term" class="collins-feature-icon">
                  <div class="collins-feature-title">Session Terms</div>
                  </a>
                </div>
              </div>
              <div class="col-md-3">
                <div class="collins-feature">
                  <a href="{{ route('classes.index') }}">
                  <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="classes_icon" class="collins-feature-icon">
                  <div class="collins-feature-title">Classes</div>
                  </a>
                </div>
              </div>
            </div>
        </div>
        
    </div>
  </div>

@endsection