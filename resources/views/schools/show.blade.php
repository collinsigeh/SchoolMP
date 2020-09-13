@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._clients_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>School Dashboard</h3>
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
              <li class="breadcrumb-item active" aria-current="page">{{ $school->school }}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="alert alert-info">
            Welcome to <b><em>{{ $school->school }}</em></b>. You can explore the following areas:
          </div>
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
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('subjects.index') }}">
                <img src="{{ config('app.url') }}/images/icons/subjects_icon.png" alt="subjects_info" class="collins-feature-icon">
                <div class="collins-feature-title">Subjects</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('resulttemplates.index') }}">
                <img src="{{ config('app.url') }}/images/icons/result_template_icon.png" alt="result_template" class="collins-feature-icon">
                <div class="collins-feature-title">Result Templates</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('directors.index') }}">
                <img src="{{ config('app.url') }}/images/icons/director_icon.png" alt="director_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Directors</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('staff.index') }}">
                <img src="{{ config('app.url') }}/images/icons/staff_icon.png" alt="staff_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Staff</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('schools.edit', $school->id) }}">
                <img src="{{ config('app.url') }}/images/icons/school_info_icon.png" alt="schools_info" class="collins-feature-icon">
                <div class="collins-feature-title">School Info</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('subscriptions.index') }}">
                <img src="{{ config('app.url') }}/images/icons/subscription_icon.png" alt="subscription_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Subscriptions</div>
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
      
    </div>
  </div>

@endsection