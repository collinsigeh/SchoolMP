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
            <h3>Students {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small></i>)' !!}</h3>
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
                            <th colspan="2">Student</th>
                            <th>Gender</th>
                            <th>Fees</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enrolments as $enrolment)
                            <tr>
                                <td style="width: 50px;"><img src="{{ config('app.url') }}/images/profile/{{ $enrolment->user->pic }}" alt="class_icon" class="collins-table-item-icon"></td>
                                <td style="vertical-align: middle;">
                                  <a class="collins-link-within-table" href="{{ route('enrolments.show', $enrolment->id) }}">
                                    <b>{{ $enrolment->user->name }}</b><br />
                                    <small>({{ $enrolment->student->registration_number }})</small><br />
                                    <span class="badge badge-secondary">{{ $enrolment->schoolclass->name }}</span>
                                  </a>
                                </td>
                                <td style="vertical-align: middle;"><span class="badge badge-secondary">{{ $enrolment->user->gender }}</span></td>
                                <td style="vertical-align: middle;"><span class="badge <?php
                                    if($enrolment->fee_status == 'Unpaid')
                                    {
                                      echo 'badge-danger';
                                    }
                                    elseif($enrolment->fee_status == 'Partly-paid')
                                    {
                                      echo 'badge-primary';
                                    }
                                    elseif($enrolment->fee_status == 'Completely-paid')
                                    {
                                      echo 'badge-success';
                                    }
                                ?>">{{ $enrolment->fee_status }}</span></td>
                                <td style="vertical-align: middle;"><span class="badge <?php
                                    if($enrolment->status == 'Active')
                                    {
                                      echo 'badge-success';
                                    }
                                    else
                                    {
                                      echo 'badge-danger';
                                    }
                                ?>">{{ $enrolment->status }}</span></td>
                                <td class="text-right" style="vertical-align: middle;">
                                  <button class="btn btn-sm btn-outline-primary" style="margin-bottom: 8px;" data-toggle="modal" data-target="#studentResultModal{{ $enrolment->id }}">View result</button>
                                  <a href="{{ route('enrolments.show', $enrolment->id) }}" class="btn btn-sm btn-outline-primary" style="margin-bottom: 8px;">Manage</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $enrolments->links() }}
        @endif
    </div>
  </div>

<!-- assignScoreModal Series -->
@foreach ($enrolments as $enrolment)
    @php
        $return_page = 'enrolments.index';
    @endphp
    @include('partials._student_result')
@endforeach
<!-- End assignScoreModal Series -->

@endsection