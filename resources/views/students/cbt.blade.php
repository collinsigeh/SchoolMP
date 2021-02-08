@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
          <h3>{{ $cbt->name }} <?php if($cbt->type == 'Practice Quiz'){ echo ' - no.'.$cbt->id ;} ?></h3>
          </div>
          <div class="col-4 text-right">
              
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('students.term', $result_slip->enrolment_id) }}">{!! $result_slip->term->name.' - <small><i>'.$result_slip->term->session.'</i></small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.subject', $result_slip->id) }}">{{ $cbt->subject->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('students.subject', $result_slip->id) }}">CBT</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $cbt->name }} <?php if($cbt->type == 'Practice Quiz'){ echo ' - no.'.$cbt->id ;} ?></li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            <div class="row">
                <div class="col-md-8">
          
                    <div class="alert alert-info">
                      <div style="margin-bottom: 30px;">
                        <img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-this-term-icon"> <span class="collins-this-term">{{ $cbt->name }} <?php if($cbt->type == 'Practice Quiz'){ echo ' - no.'.$cbt->id ;} ?> {!! '(<i>'.$result_slip->term->name.' - <small>'.$result_slip->term->session.'</small></i>)' !!}</span>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
                                  <tr class="bg-light">
                                    <td width="130px"><b>Subject:</b></td><td>{{ $cbt->subject->name.' '.$result_slip->classsubject->arm->name }} </td>
                                  </tr>
                              </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-sm">
                                  <tr class="bg-light">
                                    <td width="130px"><b>Current attempt:</b></td>
                                    <td>
                                        @php
                                            $attempts = 0;
                                            foreach($result_slip->enrolment->attempts as $attempt)
                                            {
                                                if($attempt->cbt_id == $cbt->id)
                                                {
                                                    $attempts++;
                                                }
                                            }
                                            $current_attempt = $attempts + 1;
                                            if ($cbt->type == 'Practice Quiz') {
                                                echo $current_attempt.' practice attempts';
                                            } else {
                                                echo $current_attempt.' of '.$cbt->no_attempts;
                                            }
                                        @endphp
                                    </td>
                                  </tr>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div style="padding-bottom: 15px;"></div>

                    <div class="resource-details">
                        <div class="title">
                            Instructions
                        </div>
                        <div class="body">
                            
                            <div class="alert alert-info">
                                Follow instructions carefully.
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
                                  <a class="btn btn-sm btn-block btn-outline-primary text-left"  href="{{ route('students.cbts', $result_slip->id) }}">
                                    <img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="options-icon">  Back to CBT list
                                  </a>
                                </td>
                              </tr>
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