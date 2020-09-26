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
                <li class="breadcrumb-item"><a href="{{ route('terms.index') }}">Session terms</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.index') }}">Session terms</a></li>
                <li class="breadcrumb-item active" aria-current="page">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>
          
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-info">
              <div style="margin-bottom: 30px;">
                <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="collins-this-term-icon"> <span class="collins-this-term">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</span>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <tr>
                          <td><b>Resumption date:</b> {{ $term->resumption_date }}</td>
                        </tr>
                    </table>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <tr>
                          <td><b>Closing date:</b> {{ $term->closing_date }}</td>
                        </tr>
                    </table>
                  </div>
                </div> 
              </div>

            </div>
          </div>
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
              <img src="{{ config('app.url') }}/images/icons/school_icon.png" alt="schools_info" class="collins-feature-icon">
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

        @if ($user->role == 'Director')
        <div class="welcome">
            <div class="row">
                <div class="col-md-8">
                    <div class="resource-details">
                        <div class="title">
                            <b>{!! $term->name.' - <small><i>'.$term->session.'</i></small>' !!}</b>
                        </div>
                        <div class="body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                      <th>Resumption date:</th>
                                      <td>{{ $term->resumption_date }}</td>
                                    </tr>
                                </table>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                      <th>Closing date:</th>
                                      <td>{{ $term->closing_date }}</td>
                                    </tr>
                                </table>
                              </div>
                            </div> 
                          </div>
                          <div style="padding: 25px;"></div>

                          <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive bg-light">
                                  <table class="table table-striped table-hover table-sm">
                                    <tr class="bg-secondary">
                                        <th style="font-size: 1.2em; color: #ffffff;" colspan="3">Available classes:</th>
                                    </tr>
                                      <tr>
                                        <th>No. of class arms:</th>
                                        <th>{{ count($term->arms) }}</th>
                                        <td class="text-right">
                                            <a href="{{ route('arms.create') }}" class="btn btn-sm btn-outline-primary">New class</a> <a href="{{ route('arms.index') }}" class="btn btn-sm btn-primary">View classes</a>
                                        </td>
                                      </tr>
                                  </table>
                                </div>
                            </div>
                          </div>
                          <div style="padding: 25px;"></div>
                          
                          <div class="table-responsive bg-light">
                            <table class="table table-striped table-hover table-sm">
                                <tr class="bg-secondary">
                                    <th style="font-size: 1.2em; color: #ffffff;" colspan="3">Students</th>
                                </tr>
                                <tr>
                                    <td>Male students:</td>
                                    <td class="text-right">
                                        @php
                                            $male = 0;
                                            foreach($term->enrolments as $student)
                                            {
                                                if($student->user->gender == 'Male')
                                                {
                                                    $male++;
                                                }
                                            }
                                            echo $male;
                                        @endphp
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Female students:</td>
                                    <td class="text-right">
                                        @php
                                            $female = 0;
                                            foreach($term->enrolments as $student)
                                            {
                                                if($student->user->gender == 'Female')
                                                {
                                                    $female++;
                                                }
                                            }
                                            echo $female;
                                        @endphp
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Total students:</th>
                                    <th class="text-right">{{ count($term->enrolments) }}</th>
                                    <td class="text-right">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('students.create') }}">New student</a> &nbsp;&nbsp;<a class="btn btn-sm btn-primary" href="{{ route('students.index') }}">View students</a>
                                    </td>
                                </tr>
                            </table>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="resource-details">
                        <div class="title">
                            Term options
                        </div>
                        <div class="body">
                          <div class="table-responsive">    
                            <table class="table">
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('classsubjects.index') }}">Teachers & assigned subjects</a></td>
                                </tr>
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('items.index') }}">School fees and items</a></td>
                                </tr>
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('students.index') }}">Students</a></td>
                                </tr>
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('arms.index') }}">Class arms</a></td>
                                </tr>
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('terms.edit', $term->id) }}">Term information</a></td>
                                </tr>
                                <tr>
                                  <td><button class="btn btn-sm btn-block btn-outline-primary" data-toggle="modal" data-target="#calendarModal">Calendar of activities</button></td>
                                </tr>
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('subscriptions.show', $term->subscription_id) }}">Linked subscription details</a></td>
                                </tr>
                            </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @else

        <div class="welcome">
            <div class="row">
                <div class="col-md-8">
                    <div class="resource-details">
                        <div class="title">
                            <b>{!! $term->name.' - <small><i>'.$term->session.'</i></small>' !!}</b>
                        </div>
                        <div class="body">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                      <th>Resumption date:</th>
                                      <td>{{ $term->resumption_date }}</td>
                                    </tr>
                                </table>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                      <th>Closing date:</th>
                                      <td>{{ $term->closing_date }}</td>
                                    </tr>
                                </table>
                              </div>
                            </div> 
                          </div>
                          <div style="padding: 25px;"></div>

                          <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive bg-light">
                                  <table class="table table-striped table-hover table-sm">
                                    <tr class="bg-secondary">
                                        <th style="font-size: 1.2em; color: #ffffff;" colspan="2">My Classes</th>
                                    </tr>
                                    @if (count($assigned_classes) < 1)
                                        <tr>
                                            <td>None<td>
                                        </tr>
                                    @else
                                        @foreach ($assigned_classes as $classarm)
                                            <tr>
                                                <td>{{ $classarm->schoolclass->name.' '.$classarm->name }}</td>
                                                <td class="text-right">
                                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('arms.show', $classarm->id) }}">Manage</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                  </table>
                                </div>
                            </div>
                          </div>
                          <div style="padding: 25px;"></div>
                          
                          <div class="table-responsive bg-light">
                            <table class="table table-striped table-hover table-sm">
                                <tr class="bg-secondary">
                                    <th style="font-size: 1.2em; color: #ffffff;" colspan="2">My Subjects</th>
                                </tr>
                                @if (count($assigned_subjects) < 1)
                                    <tr>
                                        <td>None</td>
                                    </tr>
                                @else
                                    @foreach ($assigned_subjects as $classsubject)
                                        <tr>
                                            <td>{{ $classsubject->arm->schoolclass->name.' '.$classsubject->arm->name.' '.$classsubject->subject->name }}</td>
                                            <td class="text-right">
                                                <a class="btn btn-sm btn-outline-primary" href="#">Manage</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                          </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="resource-details">
                        <div class="title">
                            Term options
                        </div>
                        <div class="body">
                          <div class="table-responsive">    
                            <table class="table">
                                @if ($fees_manager == 'Yes')
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('items.index') }}">School fees and items</a></td>
                                </tr>
                                @endif
                                @if ($student_manager == 'Yes')
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('students.index') }}">Students</a></td>
                                </tr>
                                @endif
                                @if ($classarm_manager == 'Yes')
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('arms.index') }}">Class arms</a></td>
                                </tr>
                                @endif
                                @if ($sessionterm_manager == 'Yes')
                                <tr>
                                  <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('terms.edit', $term->id) }}">Term information</a></td>
                                </tr>
                                @endif
                                <tr>
                                  <td><button class="btn btn-sm btn-block btn-outline-primary" data-toggle="modal" data-target="#calendarModal">Calendar of activities</button></td>
                                </tr>
                                @if ($subscription_manager == 'Yes')
                                <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('subscriptions.show', $term->subscription_id) }}">Linked subscription details</a></td>
                                @endif
                            </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif
        
    </div>
  </div>


  
<!-- calendarModal -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="calendarModalLabel">Calendar of Activities for {!! $term->name.' - <small>'.$term->session.'</small>' !!}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          @foreach ($calendar as $item)
              <div style="padding-bottom: 15px;">
                <h6>Week {{ $item->week }}</h6>
                <p>{{ $item->activity }}</p>
              </div>
          @endforeach
          <div class="text-center">
            @if ($calendar_manager == 'Yes')
            <a href="{{ route('calendars.index') }}" class="btn bnt-sm btn-outline-primary">Modify</a>
            @endif
          </div>
      </div>
    </div>
  </div>
</div>
<!-- End calendarModal -->
@endsection