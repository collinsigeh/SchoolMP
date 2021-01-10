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
          <h3>Lessons & notes</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('staff.create') }}" class="btn btn-primary">New resource</a>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', $classsubject->id) }}">{{ $classsubject->subject->name.' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</a></li>
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
                        <img src="{{ config('app.url') }}/images/icons/lessons_icon.png" alt="lessons_icon" class="collins-this-term-icon"> <span class="collins-this-term">{{ $classsubject->subject->name }} Lessons</span>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
                                  <tr class="bg-light">
                                      <td width="130px"><b>Term:</b></td><td>{!! $term->name.' - <small>'.$term->session.'</small>' !!}</td>
                                  </tr>
                                  <tr class="bg-light">
                                    <td width="130px"><b>Class:</b></td><td>{{ $classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }} </td>
                                  </tr>
                              </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
                                  <tr class="bg-light">
                                    <td width="130px"><b>Subject teacher:</b></td>                           
                                    @if ($classsubject->user_id < 1)
                                        <td>
                                            {!! '<span class="badge badge-danger">No assigned teacher</span>' !!}
                                        </td>
                                    @else
                                        <td>{!! $classsubject->user->name.' - <small>'.$classsubject->user->staff->phone.'</small>' !!}</td>
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
                                  @if (count($classsubject->lessons) < 1)
                                      <tr>
                                          <td>No lesson yet.<td>
                                      </tr>
                                  @else
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
                                      @foreach ($classsubject->lessons as $lesson)
                                          <tr>
                                              <td>{{ $sn }}</td>
                                              <td>
                                                  {{ substr($lesson->name) }}
                                                  @if (count($lesson->name) > 42)
                                                      ...
                                                  @endif
                                              </td>
                                              <td>{{ $lesson->type }}</td>
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
                              <tr>
                                <td>
                                  <button class="btn btn-sm btn-block btn-outline-primary text-left"  data-toggle="modal" data-target="#feesBreakdownModal">  
                                    <img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="options-icon">    Quizes, Tests & Exams
                                  </button>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('classsubjects.show', $classsubject->id) }}">
                                    <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="class_icon" class="options-icon">  Back to student scores
                                  </a>
                                </td>
                              </tr>
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



@endsection