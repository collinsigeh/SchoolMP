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

        @if ($user->role == 'Director')
        <div class="welcome">

            <div class="row">

                <div class="col-md-8">
          
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
                    <div style="padding-bottom: 15px;"></div>

                    <div class="resource-details">
                        <div class="title">
                            <b>Available classes</b>
                        </div>
                        <div class="body">

                          <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                  <table class="table table-bordered table-hover table-sm">
                                      <tr>
                                        <td><b>No. of class arms:</b> <span class="badge badge-secondary">{{ count($term->arms) }}</span></td>
                                      </tr>
                                  </table> 
                                  <div class="text-right">
                                    <a href="{{ route('arms.create') }}" class="btn btn-sm btn-outline-primary">New class</a> <a href="{{ route('arms.index') }}" class="btn btn-sm btn-primary">View classes</a>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div style="padding-bottom: 15px;"></div>
                    
                    <div class="resource-details">
                      <div class="title">
                          <b>Students</b>
                      </div>
                      <div class="body">
                        
                        <div class="table-responsive">
                          <table class="table table-bordered table-hover table-sm">
                              <tr>
                                  <td>
                                    No. of male students:
                                    @php
                                        $male = 0;
                                        foreach($term->enrolments as $student)
                                        {
                                            if($student->user->gender == 'Male')
                                            {
                                                $male++;
                                            }
                                        }
                                        echo  '<span class="badge badge-secondary">'.$male.'</span>';
                                    @endphp
                                  </td>
                              </tr>
                              <tr>
                                  <td>
                                    No. of female students:
                                    @php
                                        $female = 0;
                                        foreach($term->enrolments as $student)
                                        {
                                            if($student->user->gender == 'Female')
                                            {
                                                $female++;
                                            }
                                        }
                                        echo  '<span class="badge badge-secondary">'.$female.'</span>';
                                    @endphp
                                  </td>
                              </tr>
                              <tr>
                                  <td><b>Total number of students: </b><span class="badge badge-secondary">{{ count($term->enrolments) }}</span></td>
                              </tr>
                          </table>
                        </div>
                        <div class="text-right">
                          <a class="btn btn-sm btn-outline-primary" href="{{ route('students.create') }}">New student</a> &nbsp;&nbsp;<a class="btn btn-sm btn-primary" href="{{ route('enrolments.index') }}">View students</a>
                        </div>
                      </div>
                  </div>
                  <div style="padding-bottom: 15px;"></div>
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
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('arms.index') }}">
                                      <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="classes_icon" class="options-icon"> Class arms
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('enrolments.index') }}">
                                      <img src="{{ config('app.url') }}/images/icons/students_icon.png" alt="students_icon" class="options-icon"> Students
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('classsubjects.index') }}">
                                      <img src="{{ config('app.url') }}/images/icons/teachers_assigned_subjects_icon.png" alt="teachers_and_assigned_subjects" class="options-icon">  Teachers & assigned subjects
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('items.index') }}">
                                      <img src="{{ config('app.url') }}/images/icons/fees_icon.png" alt="fees_icon" class="options-icon">  School fees and items
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('terms.edit', $term->id) }}">
                                      <img src="{{ config('app.url') }}/images/icons/term_info_icon.png" alt="term_info_icon" class="options-icon"> Term information
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    <button class="btn btn-sm btn-block btn-outline-primary text-left" data-toggle="modal" data-target="#calendarModal">
                                      <img src="{{ config('app.url') }}/images/icons/calendar_icon.png" alt="calendar_icon" class="options-icon"> Calendar of activities</button>
                                    </td>
                                </tr>
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('subscriptions.show', $term->subscription_id) }}">
                                      <img src="{{ config('app.url') }}/images/icons/subscription_icon.png" alt="subscription_icon" class="options-icon"> Linked subscription details
                                    </a>
                                  </td>
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
                    <div style="padding-bottom: 15px;"></div>

                    <div class="resource-details">
                        <div class="title">
                            My Classes
                        </div>
                        <div class="body">
                          <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm">
                              @if (count($assigned_classes) < 1)
                                  <tr>
                                      <td>None</td>
                                  </tr>
                              @else
                                  @foreach ($assigned_classes as $classarm)
                                      <tr>
                                          <td>
                                              <a class="collins-link-within-table" href="{{ route('arms.show', $classarm->id) }}"><img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="class_icon" class="collins-table-item-icon"> {{ $classarm->schoolclass->name.' '.$classarm->name }}</a>
                                          </td>
                                      </tr>
                                  @endforeach
                              @endif
                            </table>
                          </div>
                        </div>
                    </div>
                    <div style="padding-bottom: 15px;"></div>

                    <div class="resource-details">
                        <div class="title">
                            My Subjects
                        </div>
                        <div class="body">                          
                          <div class="table-responsive bg-light">
                            <table class="table table-striped table-hover table-sm">
                                @if (count($assigned_subjects) < 1)
                                    <tr>
                                        <td>None</td>
                                    </tr>
                                @else
                                    @foreach ($assigned_subjects as $classsubject)
                                        <tr>
                                            <td>
                                                <a class="collins-link-within-table" href="{{ route('classsubjects.show', $classsubject->id) }}"><img src="{{ config('app.url') }}/images/icons/subjects_icon.png" alt="subject_icon" class="collins-table-item-icon">  {{ $classsubject->subject->name.' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</a>
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
                                @if ($classarm_manager == 'Yes')
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('arms.index') }}">
                                      <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="classes_icon" class="options-icon"> Class arms
                                    </a>
                                  </td>
                                </tr>
                                @endif
                                @if ($student_manager == 'Yes')
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('enrolments.index') }}">
                                      <img src="{{ config('app.url') }}/images/icons/students_icon.png" alt="students_icon" class="options-icon"> Students
                                    </a>
                                  </td>
                                </tr>
                                @endif
                                @if ($staff_manager == 'Yes' && $student_manager == 'Yes')
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('classsubjects.index') }}">
                                      <img src="{{ config('app.url') }}/images/icons/teachers_assigned_subjects_icon.png" alt="teachers_and_assigned_subjects" class="options-icon">  Teachers & assigned subjects
                                    </a>
                                  </td>
                                </tr>
                                @endif
                                  @if ($fees_manager == 'Yes')
                                  <tr>
                                    <td>
                                      <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('items.index') }}">
                                        <img src="{{ config('app.url') }}/images/icons/fees_icon.png" alt="fees_icon" class="options-icon">  School fees and items
                                      </a>
                                    </td>
                                  </tr>
                                  @endif
                                @if ($sessionterm_manager == 'Yes')
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('terms.edit', $term->id) }}">
                                      <img src="{{ config('app.url') }}/images/icons/term_info_icon.png" alt="term_info_icon" class="options-icon"> Term information
                                    </a>
                                  </td>
                                </tr>
                                @endif
                                <tr>
                                  <td>
                                    <button class="btn btn-sm btn-block btn-outline-primary text-left" data-toggle="modal" data-target="#calendarModal">
                                      <img src="{{ config('app.url') }}/images/icons/calendar_icon.png" alt="calendar_icon" class="options-icon"> Calendar of activities</button>
                                    </td>
                                </tr>
                                @if ($subscription_manager == 'Yes')
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('subscriptions.show', $term->subscription_id) }}">
                                      <img src="{{ config('app.url') }}/images/icons/subscription_icon.png" alt="subscription_icon" class="options-icon"> Linked subscription details
                                    </a>
                                  </td>
                                </tr>
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
          @if ($calendar_manager == 'Yes')
            <div class="alert alert-info"><a href="{{ route('calendars.index') }}">Click here to modify</a> calendar information.</div>
          @endif
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