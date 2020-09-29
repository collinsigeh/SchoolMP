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
          <h3>School settings</h3>
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
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">School settings</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">School settings</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            <div class="row">
              @if ($classarm_manager == 'Yes')
              <div class="col-md-3">
                <div class="collins-feature">
                  <a href="{{ route('classes.index') }}">
                  <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="classes_icon" class="collins-feature-icon">
                  <div class="collins-feature-title">Classes</div>
                  </a>
                </div>
              </div>
              @endif
              @if ($subject_manager == 'Yes')
              <div class="col-md-3">
                <div class="collins-feature">
                  <a href="{{ route('subjects.index') }}">
                  <img src="{{ config('app.url') }}/images/icons/subjects_icon.png" alt="subjects_info" class="collins-feature-icon">
                  <div class="collins-feature-title">Subjects</div>
                  </a>
                </div>
              </div>
              @endif
              @if ($manage_all_results == 'Yes')
              <div class="col-md-3">
                <div class="collins-feature">
                  <a href="{{ route('resulttemplates.index') }}">
                  <img src="{{ config('app.url') }}/images/icons/result_template_icon.png" alt="result_template" class="collins-feature-icon">
                  <div class="collins-feature-title">Result Templates</div>
                  </a>
                </div>
              </div>
              @endif
              @if ($calendar_manager == 'Yes')
              <div class="col-md-3">
                <div class="collins-feature">
                  <a href="{{ route('schools.edit', $school->id) }}">
                  <img src="{{ config('app.url') }}/images/icons/school_icon.png" alt="schools_info" class="collins-feature-icon">
                  <div class="collins-feature-title">School Info</div>
                  </a>
                </div>
              </div>
              @endif
            </div>
        </div>
        
    </div>
  </div>

@endsection