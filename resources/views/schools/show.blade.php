@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._school_sidebar')

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
          <p>
            Hello,
          </p>
          <p>
            Welcome to <b><em>{{ $school->school }}</em></b> dashboard. You can explore the following areas:
          </p>
          <ul>
            <li><a href="{{ route('directors.index') }}">Directors</a></li>
            <li><a href="#">Staff</a></li>
            <li><a href="#">Students / Pupils</a></li>
            <li><a href="#">Parents / Guardians</a></li>
            <li><a href="#">Terms</a></li>
            <li><a href="#">Classes</a></li>
            <li><a href="#">Subjects</a></li>
            <li><a href="#">Report</a></li>
            <li><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
          </ul>
          <p>
            Enjoy!
          </p>
        </div>

        <div class="more-options">
            <div class="head">More options</div>
            <div class="body">
                <div class="option">
                    <h5>School information</h5>
                    <div class="row">
                        <div class="col-md-10 offset-md-2">
                        <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-primary">View / Modify</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      </div>
      
    </div>
  </div>

@endsection