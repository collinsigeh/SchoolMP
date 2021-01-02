@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

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
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="row">
            <div class="col-md-12">
              @if (count($student->enrolments) > 0)
                  <div class="alert alert-info">
                    Select a term.
                  </div>
              @else
                <div class="alert alert-info">
                  You are not yet registered as a student.
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

@endsection