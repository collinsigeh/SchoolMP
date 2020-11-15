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
            <h3>{{ $term->name }} Students {!! ' - <small>'.$term->session.'</small>' !!}</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_students_account == 'Yes')
                    <a href="{{ route('students.create') }}" class="btn btn-primary">New student</a>
                  @endif
              @else
                  <a href="{{ route('students.create') }}" class="btn btn-primary">New student</a>
              @endif
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Students</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($enrolments) < 1)
            <div class="alert alert-info" sr-only="alert">
                None available.
            </div>
        @else
            <h5>Total students for the term: {{ $total_students}}</h5>
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Fees</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enrolments as $enrolment)
                            <tr>
                                <td><span class="badge badge-secondary">{{ $enrolment->schoolclass->name }}</span></td>
                                <td><b>{{ $enrolment->user->name }}</b><br /><small>({{ $enrolment->student->registration_number }})</small></td>
                                <td><span class="badge badge-secondary">{{ $enrolment->user->gender }}</span></td>
                                <td><span class="badge <?php
                                    if($enrolment->fee_status == 'Unpaid')
                                    {
                                      echo 'badge-danger';
                                    }
                                    elseif($enrolment->fee_status == 'Partly-paid')
                                    {
                                      echo 'badge-warning';
                                    }
                                    elseif($enrolment->fee_status == 'Completely-paid')
                                    {
                                      echo 'badge-success';
                                    }
                                ?>">{{ $enrolment->fee_status }}</span></td>
                                <td><span class="badge <?php
                                    if($enrolment->status == 'Active')
                                    {
                                      echo 'badge-success';
                                    }
                                    else
                                    {
                                      echo 'badge-danger';
                                    }
                                ?>">{{ $enrolment->status }}</span></td>
                                <td class="text-right"><a href="{{ route('enrolments.show', $enrolment->id) }}" class="btn btn-sm btn-outline-primary">Manage</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $enrolments->links() }}
        @endif
    </div>
  </div>

@endsection