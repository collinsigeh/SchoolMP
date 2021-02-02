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
          <h3>{!! $cbt->subject->name.' (<i>'.$cbt->name.'</i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
            <?php
            if($cbt->user_id == $user->id)
            {
              ?>
              <button class="btn btn-primary" data-toggle="modal" data-target="#newCBTnModal">New Question</button>
              <?php
            }
            ?>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                @if ($classsubject_id > 0)
                    <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', $classsubject->id) }}">{{ $classsubject->subject->name.' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cbts.listing', $classsubject->id) }}">CBTs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $cbt->name }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('cbts.index') }}">CBTs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $cbt->subject->name.' - '.$cbt->name }}</li>
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
                        <img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-this-term-icon"> <span class="collins-this-term">{!! $cbt->subject->name.' - '.$cbt->name.' (<i>'.$term->name.' - <small>'.$term->session.'</small></i>)' !!}</span>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
                                  <tr class="bg-light">
                                    <td width="130px"><b>Classes:</b></td><td>display classes here! </td>
                                  </tr>
                              </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
                                  <tr class="bg-light">
                                    <td width="130px"><b>Created by:</b></td>                           
                                    @if ($cbt->user_id < 1)
                                        <td>
                                            {!! '<span class="badge badge-danger">NOT Specified</span>' !!}
                                        </td>
                                    @else
                                        <td>{!! $cbt->user->name.' - <small>'.$cbt->user->staff->phone.'</small>' !!}</td>
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
                            {{ $cbt->name }} Questions
                            <?php
                            if($cbt->user_id == $user->id)
                            {
                              ?>
                              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newCBTModal">Add new</button>
                              <?php
                            }
                            ?>
                        </div>
                        <div class="body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm">
                                  @foreach ($cbt->questions as $question)
                                      @php
                                          $question_no = $question->prev_question+1;
                                      @endphp
                                      <tr>
                                        <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/quiz_icon.png" alt="cbt_icon" class="collins-table-item-icon"></td>
                                        <td>{!! '<b>Q '.$question_no.':</b>' !!}</td>
                                        <td>
                                            <a href="#">
                                              {{ substr($question->question, 0, 84) }}
                                              @if (strlen($question->question) > 84)
                                                  ...
                                              @endif
                                            </a>
                                        </td>
                                        <td class="text-right">
                                            <?php
                                              if(($question->user_id == $user->id && $question->user_id == $user->id) OR $user->role == 'Director')
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modifyLessonModal{{ $question->id }}">Modify</button>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmLessonDeletionModal{{ $question->id }}">X</button>
                                                <?php
                                              }
                                            ?>
                                        </td>
                                      </tr>
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
                                @if ($classsubject_id > 0)
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('classsubjects.show', $classsubject_id) }}">
                                      <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="class_icon" class="options-icon">  Back to subject details
                                    </a>
                                  </td>
                                </tr>
                                @endif
                                <tr>
                                  <td>
                                    <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('terms.show', $term->id) }}">
                                      <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="options-icon"> {!! $term->name.' - <small>'.$term->session.'</small>' !!}
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

<!-- New Cbt Modal -->
@include('partials._new_cbt')
<!-- End New Cbt Modal -->

<!-- confirmLessonDeletionModal Series -->
@foreach ($classsubject->arm->cbts as $lesson)
@include('partials._confirm_lesson_deletion')
@endforeach
<!-- End confirmLessonDeletionModal Series -->

<!-- modifyLessonModal Series -->
@foreach ($classsubject->arm->cbts as $lesson)
@include('partials._modify_lesson')
@endforeach
<!-- End modifyLessonModal Series -->

@endsection