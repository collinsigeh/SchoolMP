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
          <p>
            Hello,
          </p>
          <p>
            Welcome to your Schoobic dashboard. You can explore the following areas:
          </p>
          <ul>
            <li><a href="{{ route('users.profile') }}">My profile</a></li>
            <li><a href="{{ route('schools.index') }}">My schools</a></li>
          </ul>
          <p>
            Enjoy!
          </p>
        </div>
      </div>
      
    </div>
  </div>

@endsection