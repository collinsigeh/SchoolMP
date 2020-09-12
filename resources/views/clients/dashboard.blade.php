@extends('layouts.dashboard')

@section('title', 'Dashboard | ')

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._clients_sidebar')

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
            <h3>Dashboard</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="alert alert-info">
              Welcome to your dashboard. You can explore the following areas:
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('schools.index') }}">
                <img src="{{ config('app.url') }}/images/icons/school_icon.png" alt="schools_icon" class="collins-feature-icon">
                <div class="collins-feature-title">My Schools</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('users.profile') }}">
                <img src="{{ config('app.url') }}/images/icons/profile_icon.png" alt="profile_icon" class="collins-feature-icon">
                <div class="collins-feature-title">My Profile</div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

@endsection