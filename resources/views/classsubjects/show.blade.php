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
          <h3>{{ $classsubject->subject->name.' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.index') }}">Class arms</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.show', $classsubject->arm_id) }}">{{ $classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $classsubject->subject->name }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                @if ($classarm_manager == 'Yes')
                    <li class="breadcrumb-item"><a href="{{ route('arms.index') }}">Class arms</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('arms.show', $classsubject->arm_id) }}">{{ $classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $classsubject->subject->name }}
                    @if ($classarm_manager != 'Yes')
                        {{ ' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}
                    @endif
                </li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            <div class="row">
                <div class="col-md-8">
          
                    <div class="alert alert-info">
                      <div style="margin-bottom: 30px;">
                        <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="class_icon" class="collins-this-term-icon"> <span class="collins-this-term">{{ $classsubject->subject->name }} ({!! $term->name.' - <small>'.$term->session.'</small>' !!})</span>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-hover table-sm">
                                  <tr>
                                    <td><b>Class:</b> {{ $classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }} </td>
                                  </tr>
                              </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-hover table-sm">
                                  <tr>
                                    <th>Subject teacher:</th>                           
                                    @if ($classsubject->user_id < 1)
                                        <td>
                                            {!! '<span class="badge badge-danger">No assigned teacher</span>' !!}
                                            @if ($classarm_manager == 'Yes')
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#assignSubjectTeacherModal{{ $classsubject->id }}">
                                                    Assign class teacher
                                                </button>
                                            @endif
                                        </td>
                                    @else
                                        <td>{!! $classsubject->user->name.' - <small>'.$classsubject->user->staff->phone.'</small>' !!}</td>
                                        @if ($classarm_manager == 'Yes')
                                            <td class="text-right">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#assignSubjectTeacherModal{{ $classsubject->id }}">
                                                    Edit
                                                </button>
                                            </td>
                                        @endif
                                    @endif
                                  </tr>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div style="padding-bottom: 15px;"></div>

                    <div class="resource-details">
                        <div class="title">
                            Students and scores attained
                        </div>
                        <div class="body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm">
                                  @if (count($classsubject->results) < 1)
                                      <tr>
                                          <td>No student is enroled for now!<td>
                                      </tr>
                                  @else
                                      <thead>
                                          <tr>
                                              <th>#</th>
                                              <th>Student</th>
                                              @if ($classsubject->arm->resulttemplate->subject_1st_test_max_score > 0)
                                                <th class="text-right">1st test<br /><span class="badge badge-secondary">{{ $classsubject->arm->resulttemplate->subject_1st_test_max_score }} %</span></th>
                                              @endif
                                              @if ($classsubject->arm->resulttemplate->subject_2nd_test_max_score > 0)
                                                <th class="text-right">2nd test<br /><span class="badge badge-secondary">{{ $classsubject->arm->resulttemplate->subject_2nd_test_max_score }} %</span></th>
                                              @endif
                                              @if ($classsubject->arm->resulttemplate->subject_3rd_test_max_score > 0)
                                              <th class="text-right">3rd test<br /><span class="badge badge-secondary">{{ $classsubject->arm->resulttemplate->subject_3rd_test_max_score }} %</span></th>
                                              @endif
                                              @if ($classsubject->arm->resulttemplate->subject_assignment_score > 0)
                                              <th class="text-right">Assignment<br /><span class="badge badge-secondary">{{ $classsubject->arm->resulttemplate->subject_assignment_score }} %</span></th>
                                              @endif
                                              @if ($classsubject->arm->resulttemplate->subject_exam_score > 0)
                                              <th class="text-right">Exam<br /><span class="badge badge-secondary">{{ $classsubject->arm->resulttemplate->subject_exam_score }} %</span></th>
                                              @endif
                                              <th></th>
                                          </tr>
                                      </thead>
                                      @php
                                          $sn = 1;
                                      @endphp
                                      @foreach ($classsubject->results as $result_slip)
                                          <tr>
                                              <td>{{ $sn }}</td>
                                              <td>{!!  '<b>'.$result_slip->enrolment->user->name.'</b><br /><small>('.$result_slip->enrolment->student->registration_number.') ' !!}</td>
                                              @if ($classsubject->arm->resulttemplate->subject_1st_test_max_score > 0)
                                                <td class="text-right">{{ $result_slip->subject_1st_test_score }}</td>
                                              @endif
                                              @if ($classsubject->arm->resulttemplate->subject_2nd_test_max_score > 0)
                                                <td class="text-right">{{ $result_slip->subject_2nd_test_score }}</td>
                                              @endif
                                              @if ($classsubject->arm->resulttemplate->subject_3rd_test_max_score > 0)
                                                <td class="text-right">{{ $result_slip->subject_3rd_test_score }}</td>
                                              @endif
                                              @if ($classsubject->arm->resulttemplate->subject_assignment_score > 0)
                                                <td class="text-right">{{ $result_slip->subject_assignment_score }}</td>
                                              @endif
                                              @if ($classsubject->arm->resulttemplate->subject_exam_score > 0)
                                                <td class="text-right">{{ $result_slip->subject_exam_score }}</td>
                                              @endif
                                              <td class="text-right">
                                                @if ($result_slip->enrolment->status == 'Inactive')
                                                    <span class="badge badge-danger">Inactive</span>
                                                    @if ($classsubject->arm->user_id == $user->id OR $classarm_manager == 'Yes')
                                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('enrolments.show', $result_slip->enrolment_id) }}">Manage</a>
                                                    @endif
                                                @else
                                                  @if ($classsubject->user_id == $user->id)
                                                      @if ($result_slip->enrolment->result_status == 'Pending' OR $result_slip->enrolment->result_status == 'NOT Approved')
                                                          <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#assignScoreModal{{ $result_slip->id }}">
                                                              Manage scores
                                                          </button>
                                                      @else
                                                          @if ($result_slip->enrolment->result_status == 'Pending Approval')
                                                              <span class="badge badge-secondary">Pending Approval</span>
                                                          @elseif ($result_slip->enrolment->result_status == 'Approved')
                                                              <span class="badge badge-success">Approved</span>
                                                          @endif
                                                      @endif
                                                  @else
                                                      @if ($result_slip->enrolment->result_status == 'Pending' OR $result_slip->enrolment->result_status == 'Pending Approval')
                                                          <span class="badge badge-secondary">{{ $result_slip->enrolment->result_status }}</span>
                                                      @else
                                                          @if ($result_slip->enrolment->result_status == 'NOT Approved')
                                                              <span class="badge badge-danger">NOT Approved</span>
                                                          @elseif ($result_slip->status == 'Approved')
                                                              <span class="badge badge-success">Approved</span>
                                                          @endif
                                                      @endif
                                                  @endif
                                                @endif
                                              </td>
                                          </tr>
                                          @php
                                              $sn++;
                                          @endphp
                                      @endforeach
                                  @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <div style="padding-bottom: 15px;"></div>
                
                </div>


                <div class="col-md-4">
                    <div class="resource-details">
                        <div class="title">
                            More options
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


<!-- assignSubjectTeacherModal for this classsubject -->
@php
    $return_page = 'classsubjects.show';
    $returnpage_id = $classsubject->id;
@endphp
@include('partials._subject_teacher')
<!-- End assignSubjectTeacherModal for this classsubject -->

<!-- assignScoreModal Series -->
@foreach ($classsubject->results as $result_slip)
    @php
        $return_page = 'classsubjects.show';
        $returnpage_id = $classsubject->id;
    @endphp
    @include('partials._assign_score')
@endforeach
<!-- End assignScoreModal Series -->

@endsection