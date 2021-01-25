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
          <h3>{!! $classsubject->subject->name.' (<i>CBTs - Quizes, Tests & Exam</i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
            <?php
            if($classsubject->user_id == $user->id)
            {
              ?>
              <button class="btn btn-primary" data-toggle="modal" data-target="#newCBTnModal">New CBT</button>
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
                <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', $classsubject->id) }}">{{ $classsubject->subject->name.' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">CBTs - Quizes, Tests & Exam</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            <div class="row">
                <div class="col-md-8">
          
                    <div class="alert alert-info">
                      <div style="margin-bottom: 30px;">
                        <img src="{{ config('app.url') }}/images/icons/lessons_icon.png" alt="lessons_icon" class="collins-this-term-icon"> <span class="collins-this-term">{!! $classsubject->subject->name.' Lessons (<i>'.$term->name.' - <small>'.$term->session.'</small></i>)' !!}</span>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
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
                            CBTs - Quizes, Tests & Exam
                            <?php
                            if($classsubject->user_id == $user->id)
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
                                  <thead>
                                      <tr>
                                          <th colspan="2">CBT</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  @php
                                      $sn = 1;
                                      $has_exam = $has_3rd_test = $has_2nd_test = $has_1st_test = 'No';
                                  @endphp
                                  @foreach ($classsubject->arm->cbts as $cbt)
                                    <?php
                                    if($cbt->subject_id == $classsubject->subject_id && $cbt->type == 'Exam')
                                    {
                                      $has_exam = 'Yes';
                                      ?>
                                      <tr>
                                        <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-table-item-icon"></td>
                                          <td>
                                            <a href="#">
                                              {{ substr($cbt->name, 0, 42) }}
                                              @if (strlen($cbt->name) > 42)
                                                  ...
                                              @endif
                                            </a>
                                          </td>
                                          <td class="text-right">
                                            <?php
                                              if($cbt->user_id == $user->id)
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modifyLessonModal{{ $cbt->id }}">Modify</button>
                                                <?php
                                              }
                                              if(($classsubject->user_id == $user->id && $cbt->user_id == $user->id) OR $user->role == 'Director')
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmLessonDeletionModal{{ $cbt->id }}">X</button>
                                                <?php
                                              }
                                            ?>
                                          </td>
                                      </tr>
                                      <?php
                                      $sn++;
                                    }
                                    ?>
                                  @endforeach
                                  @foreach ($classsubject->arm->cbts as $cbt)
                                    <?php
                                    if($cbt->subject_id == $classsubject->subject_id && $cbt->type == '3rd Test')
                                    {
                                      $has_3rd_test = 'Yes';
                                      ?>
                                      <tr>
                                        <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-table-item-icon"></td>
                                          <td>
                                            <a href="#">
                                              {{ substr($cbt->name, 0, 42) }}
                                              @if (strlen($cbt->name) > 42)
                                                  ...
                                              @endif
                                            </a>
                                          </td>
                                          <td class="text-right">
                                            <?php
                                              if($cbt->user_id == $user->id)
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modifyLessonModal{{ $cbt->id }}">Modify</button>
                                                <?php
                                              }
                                              if(($classsubject->user_id == $user->id && $cbt->user_id == $user->id) OR $user->role == 'Director')
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmLessonDeletionModal{{ $cbt->id }}">X</button>
                                                <?php
                                              }
                                            ?>
                                          </td>
                                      </tr>
                                      <?php
                                      $sn++;
                                    }
                                    ?>
                                  @endforeach
                                  @foreach ($classsubject->arm->cbts as $cbt)
                                    <?php
                                    if($cbt->subject_id == $classsubject->subject_id && $cbt->type == '2nd Test')
                                    {
                                      $has_2nd_test = 'Yes';
                                      ?>
                                      <tr>
                                        <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-table-item-icon"></td>
                                          <td>
                                            <a href="#">
                                              {{ substr($cbt->name, 0, 42) }}
                                              @if (strlen($cbt->name) > 42)
                                                  ...
                                              @endif
                                            </a>
                                          </td>
                                          <td class="text-right">
                                            <?php
                                              if($cbt->user_id == $user->id)
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modifyLessonModal{{ $cbt->id }}">Modify</button>
                                                <?php
                                              }
                                              if(($classsubject->user_id == $user->id && $cbt->user_id == $user->id) OR $user->role == 'Director')
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmLessonDeletionModal{{ $cbt->id }}">X</button>
                                                <?php
                                              }
                                            ?>
                                          </td>
                                      </tr>
                                      <?php
                                      $sn++;
                                    }
                                    ?>
                                  @endforeach
                                  @foreach ($classsubject->arm->cbts as $cbt)
                                    <?php
                                    if($cbt->subject_id == $classsubject->subject_id && $cbt->type == '1st Test')
                                    {
                                      $has_1st_test = 'Yes';
                                      ?>
                                      <tr>
                                        <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-table-item-icon"></td>
                                          <td>
                                            <a href="#">
                                              {{ substr($cbt->name, 0, 42) }}
                                              @if (strlen($cbt->name) > 42)
                                                  ...
                                              @endif
                                            </a>
                                          </td>
                                          <td class="text-right">
                                            <?php
                                              if($cbt->user_id == $user->id)
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modifyLessonModal{{ $cbt->id }}">Modify</button>
                                                <?php
                                              }
                                              if(($classsubject->user_id == $user->id && $cbt->user_id == $user->id) OR $user->role == 'Director')
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmLessonDeletionModal{{ $cbt->id }}">X</button>
                                                <?php
                                              }
                                            ?>
                                          </td>
                                      </tr>
                                      <?php
                                      $sn++;
                                    }
                                    ?>
                                  @endforeach
                                  @foreach ($classsubject->arm->cbts as $cbt)
                                    <?php
                                    if($cbt->subject_id == $classsubject->subject_id && $cbt->type != 'Exam' && $cbt->type == '3rd Test' && $cbt->type == '2nd Test' && $cbt->type == '1st Test')
                                    {
                                      ?>
                                      <tr>
                                        <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-table-item-icon"></td>
                                          <td>
                                            <a href="#">
                                              {{ substr($cbt->name, 0, 42) }}
                                              @if (strlen($cbt->name) > 42)
                                                  ...
                                              @endif
                                            </a>
                                          </td>
                                          <td class="text-right">
                                            <?php
                                              if($cbt->user_id == $user->id)
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#modifyLessonModal{{ $cbt->id }}">Modify</button>
                                                <?php
                                              }
                                              if(($classsubject->user_id == $user->id && $cbt->user_id == $user->id) OR $user->role == 'Director')
                                              {
                                                ?>
                                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmLessonDeletionModal{{ $cbt->id }}">X</button>
                                                <?php
                                              }
                                            ?>
                                          </td>
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
                                  <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('classsubjects.show', $classsubject->id) }}">
                                    <img src="{{ config('app.url') }}/images/icons/classes_icon.png" alt="class_icon" class="options-icon">  Back to subject details
                                  </a>
                                </td>
                              </tr>
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