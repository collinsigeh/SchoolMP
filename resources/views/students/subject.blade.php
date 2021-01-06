@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>{{ $result_slip->classsubject->subject->name }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('students.term', $result_slip->enrolment_id) }}">{!! $result_slip->term->name.' - <small><i>'.$result_slip->term->session.'</i></small>' !!}</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $result_slip->classsubject->subject->name }}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="row">
            <div class="col-md-8">
                <div class="alert alert-info">
                    <div style="margin-bottom: 30px;">
                      <img src="{{ config('app.url') }}/images/icons/subjects_icon.png" alt="subject_icon" class="collins-this-term-icon"> <span class="collins-this-term">{!! $result_slip->classsubject->subject->name.' - ('.$result_slip->term->name.' - <small><i>'.$result_slip->term->session.'</i></small>)' !!}</span>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover table-sm">
                              <tr class="bg-light">
                                <td width="115px;"><b>Class:</b></td><td>{{ $result_slip->enrolment->arm->schoolclass->name.' '.$result_slip->enrolment->arm->name }}</td>
                              </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover table-sm">
                              <tr class="bg-light">
                                <td width="115px;"><b>Subject teacher:</b></td>
                                <td>
                                    @if ($result_slip->classsubject->user_id > 0)
                                        {{ $result_slip->classsubject->user->name }}
                                    @else
                                        <span class="badge badge-danger">NOT specified</span>
                                    @endif
                                </td>
                              </tr>
                          </table>
                        </div>
                      </div> 
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        My performance summary
                    </div>
                    <div class="body">                          
                        <div class="table-responsive bg-light">
                            <table class="table table-striped table-hover table-bordered table-sm">
                                @if ($result_slip->resulttemplate->subject_1st_test_max_score > 0)
                                    <tr>
                                        <th width="115px">1st Test:</th>
                                        <td>
                                            @if ($result_slip->first_score_by != 'No one')
                                                {{ $result_slip->subject_1st_test_score.' / '.$result_slip->resulttemplate->subject_1st_test_max_score }}
                                            @else
                                                <span class="badge badge-secondary">None yet!</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @if ($result_slip->resulttemplate->subject_2nd_test_max_score > 0)
                                    <tr>
                                        <th width="115px">2nd Test:</th>
                                        <td>
                                            @if ($result_slip->second_score_by != 'No one')
                                                {{ $result_slip->subject_2nd_test_score.' / '.$result_slip->resulttemplate->subject_2nd_test_max_score }}
                                            @else
                                                <span class="badge badge-secondary">None yet!</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @if ($result_slip->resulttemplate->subject_3rd_test_max_score > 0)
                                    <tr>
                                        <th width="115px">3rd Test:</th>
                                        <td>
                                            @if ($result_slip->third_score_by != 'No one')
                                                {{ $result_slip->subject_3rd_test_score.' / '.$result_slip->resulttemplate->subject_3rd_test_max_score }}
                                            @else
                                                <span class="badge badge-secondary">None yet!</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @if ($result_slip->resulttemplate->subject_assignment_score > 0)
                                    <tr>
                                        <th width="115px">Assignment:</th>
                                        <td>
                                            @if ($result_slip->assignment_score_by != 'No one')
                                                {{ $result_slip->subject_assignment_score.' / '.$result_slip->resulttemplate->subject_assignment_score }}
                                            @else
                                                <span class="badge badge-secondary">None yet!</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @if ($result_slip->resulttemplate->subject_exam_score > 0)
                                    <tr>
                                        <th width="115px">Exam:</th>
                                        <td>
                                            @if ($result_slip->exam_score_by != 'No one')
                                                {{ $result_slip->subject_exam_score.' / '.$result_slip->resulttemplate->subject_exam_score }}
                                            @else
                                                <span class="badge badge-secondary">None yet!</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
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
                                <button class="btn btn-sm btn-block btn-outline-primary text-left"  data-toggle="modal" data-target="#feesBreakdownModal">
                                  <img src="{{ config('app.url') }}/images/icons/lessons_icon.png" alt="lessons_icon" class="options-icon">  Lessons & notes
                                </button>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <button class="btn btn-sm btn-block btn-outline-primary text-left"  data-toggle="modal" data-target="#feesBreakdownModal">
                                  <img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="options-icon">    Quizes, Tests & Exams
                                </button>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('students.term', $result_slip->enrolment_id) }}">
                                  <img src="{{ config('app.url') }}/images/icons/subjects_icon.png" alt="subjects_icon" class="options-icon">  Back to subject list
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
      </div>
      
    </div>
  </div>

@endsection