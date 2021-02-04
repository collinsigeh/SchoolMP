@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
          <h3>{!! $result_slip->classsubject->subject->name.' (<i>Lessons & notes</i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
              
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('students.term', $result_slip->enrolment_id) }}">{!! $result_slip->term->name.' - <small><i>'.$result_slip->term->session.'</i></small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.subject', $result_slip->id) }}">{{ $result_slip->classsubject->subject->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lessons</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            <div class="row">
                <div class="col-md-8">
          
                    <div class="alert alert-info">
                      <div style="margin-bottom: 30px;">
                        <img src="{{ config('app.url') }}/images/icons/lessons1_icon.png" alt="lessons_icon" class="collins-this-term-icon"> <span class="collins-this-term">{!! $result_slip->classsubject->subject->name.' Lessons (<i>'.$result_slip->term->name.' - <small>'.$result_slip->term->session.'</small></i>)' !!}</span>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
                                  <tr class="bg-light">
                                    <td width="130px"><b>Class:</b></td><td>{{ $result_slip->classsubject->arm->schoolclass->name.' '.$result_slip->classsubject->arm->name }} </td>
                                  </tr>
                              </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
                                  <tr class="bg-light">
                                    <td width="130px"><b>Subject teacher:</b></td>                           
                                    @if ($result_slip->classsubject->user_id < 1)
                                        <td>
                                            {!! '<span class="badge badge-danger">No assigned teacher</span>' !!}
                                        </td>
                                    @else
                                        <td>{{ $result_slip->classsubject->user->name }}</td>
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
                            Lessons & notes
                        </div>
                        <div class="body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Lesson</th>
                                          <th>Type</th>
                                      </tr>
                                  </thead>
                                  @php
                                      $sn = 1;
                                  @endphp
                                  @foreach ($result_slip->classsubject->arm->lessons as $lesson)
                                    <?php
                                    if($lesson->subject_id == $result_slip->classsubject->subject_id)
                                    {
                                      ?>
                                      <tr>
                                          <td>{{ $sn }}</td>
                                          <td>
                                            <a 
                                            <?php 
                                            if($lesson->type == 'Video')
                                            {
                                              echo 'href="'.$lesson->medialink.'" target="_blank"';
                                            }
                                            elseif($lesson->type == 'Audio')
                                            {
                                              echo 'href="'.$lesson->medialink.'" target="_blank"';
                                            }
                                            elseif($lesson->type == 'Photo')
                                            {
                                              echo 'href="'.config('app.url').'/images/lesson_photo/'.$lesson->medialink.'" target="_blank"';
                                            }
                                            elseif($lesson->type == 'Text')
                                            {
                                              echo 'href="'.config('app.url').'/lesson_docs/'.$lesson->medialink.'" target="_blank"';
                                            }
                                            ?>
                                            >
                                              {{ substr($lesson->name, 0, 42) }}
                                              @if (strlen($lesson->name) > 42)
                                                  ...
                                              @endif
                                            </a>
                                          </td>
                                          <td>{{ $lesson->type }}</td>
                                      </tr>
                                      <?php
                                      $sn++;
                                    }
                                    ?>
                                  @endforeach
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
                              <tr>
                                <td>
                                  <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('students.subject', $result_slip->id) }}">
                                    <img src="{{ config('app.url') }}/images/icons/report1_icon.png" alt="report_icon" class="options-icon">  Back to my performance summary
                                  </a>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('students.term', $result_slip->enrolment_id) }}">
                                    <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="options-icon">  Back to {!! $result_slip->term->name.' - <small>'.$result_slip->term->session.'</small>' !!}
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

@endsection