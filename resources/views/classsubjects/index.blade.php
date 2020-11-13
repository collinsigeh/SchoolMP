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
            <h3>{{ $term->name }} Teachers and Assigned Subjects {!! ' - <small>'.$term->session.'</small>' !!}</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('staff.create') }}" class="btn btn-primary">New staff</a>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Teachers and assigned subjects</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Teachers and assigned subjects</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>
        
        <div class="row">
            <div class="col-md-8">
                @if(count($classsubjects) < 1 OR count($allstaff) < 1)
                    <div class="alert alert-info" sr-only="alert">
                        Required details are missing. Click on the appropriate buttons to add details.
                    </div>
                    @if (count($allstaff) < 1)
                        <a href="{{ route('staff.create') }}" class="btn btn-lg btn-outline-primary">Add teacher</a>
                    @endif
                    @if (count($classsubjects) < 1)
                        <a href="{{ route('arms.index') }}" class="btn btn-lg btn-outline-primary">View classes</a>
                    @endif
                @else
                    @if ($classsubjectswithoutteacher->count() > 0)
                        <div class="resource-details">
                            <div class="title">
                                Subjects without teachers
                            </div>
                            <div class="body">
                                <div class="table-responsive">    
                                    <table class="table table-striped table-hover table-sm">
                                        @foreach ($classsubjectswithoutteacher as $item)
                                        <tr>
                                            <td>{{ $item->arm->schoolclass->name.' '.$item->arm->name.' '.$item->subject->name }}</td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#assignSubjectTeacherModal{{ $item->id }}">
                                                    Assign teacher
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
        
                    <div class="resource-details">
                        <div class="title">
                            Teachers and assigned subjects
                        </div>
                        <div class="body">
                            <div class="table-responsive">    
                                <table class="table table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Staff</th>
                                            <th>Assigned Subjects</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sn = 1;
                                        @endphp
                                        @foreach ($allstaff as $this_staff)
                                            <tr>
                                                <td>{{ $sn }}</td>
                                                <td>
                                                    <b>{{ $this_staff->user->name }}</b>
                                                    @php
                                                        $total_assigned = 0;
                                                        foreach($classsubjects as $assigned_subject)
                                                        {
                                                            if($assigned_subject->user_id == $this_staff->user_id)
                                                            {
                                                                $total_assigned++;
                                                            }
                                                        }
                                                    @endphp
                                                    <br><small> {{ $this_staff->designation }}</small><br />
                                                    <span class="badge badge-secondary">{{ $total_assigned }} subjects</span>
                                                </td>
                                                <td>
                                                    @if ($total_assigned > 0)  
                                                        @foreach ($classsubjects as $assigned_subject)
                                                            @if ($assigned_subject->user_id == $this_staff->user_id)
                                                                <div class="row">   
                                                                <div class="col-lg-8">{{ '- '.$assigned_subject->arm->schoolclass->name.' '.$assigned_subject->arm->name.' '.$assigned_subject->subject->name }}</div>
                                                                <div class="col-lg-4 text-lg-right"><button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#assignSubjectTeacherModal{{ $assigned_subject->id }}">
                                                                    Re-assign
                                                                </button>
                                                                </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <span class="badge badge-secondary">None</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $sn++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="resource-details">
                    <div class="title">
                        More options
                    </div>
                    <div class="body">
                      <div class="table-responsive">    
                        <table class="table">
                            <tr>
                              <td>
                                <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('terms.show', $term->id) }}">
                                  <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="options-icon"> {!! $term->name.' - <small>'.$term->session.'</small>' !!}</button>
                                </td>
                            </tr>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

<!-- assignSubjectTeacherModal Series -->
@foreach ($classsubjects as $classsubject)
    @php
        $return_page = 'classsubjects.index';
        $returnpage_id = '';
    @endphp
    @include('partials._subject_teacher')
@endforeach
<!-- End assignSubjectTeacherModal Series -->
@endsection