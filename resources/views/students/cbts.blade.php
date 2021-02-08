@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
          <h3>{!! 'CBTs (<i>'.$result_slip->classsubject->subject->name.'</i>)' !!}</h3>
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
                <li class="breadcrumb-item active" aria-current="page">CBTs</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            <div class="row">
                <div class="col-md-8">
          
                    <div class="alert alert-info">
                      <div style="margin-bottom: 30px;">
                        <img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-this-term-icon"> <span class="collins-this-term">{!! $result_slip->classsubject->subject->name.' CBTs (<i>'.$result_slip->term->name.' - <small>'.$result_slip->term->session.'</small></i>)' !!}</span>
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
                            CBTs
                        </div>
                        <div class="body">
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm">
                                  @php
                                      $sn = 1;
                                  @endphp
                                  @foreach ($result_slip->classsubject->arm->cbts as $cbt)
                                    <?php
                                    if($cbt->subject_id == $result_slip->classsubject->subject_id && $cbt->status == 'Approved')
                                    {
                                      ?>
                                      <tr>
                                        <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/quiz1_icon.png" alt="cbt_icon" class="collins-table-item-icon"></td>
                                          <td style="vertical-align: middle;">
                                            <a class="collins-link-within-table" href="{{ route('students.cbt', $cbt->id) }}">
                                              <b>
                                              {{ substr($cbt->name, 0, 42) }}
                                              @if (strlen($cbt->name) > 42)
                                                  ...
                                              @endif
                                              </b>
                                              @if ($cbt->type == 'Practice Quiz')
                                                {{ ' - no.'.$cbt->id }}
                                              @endif
                                            </a>
                                          </td>
                                          <td class="text-right" style="vertical-align: middle">
                                            @php
                                                $attempts = 0;
                                                foreach($result_slip->enrolment->attempts as $attempt)
                                                {
                                                    if($attempt->cbt_id == $cbt->id)
                                                    {
                                                        $attempts++;
                                                    }
                                                }
                                            @endphp
                                            @if ($cbt->type == 'Practice Quiz')
                                            <span class="badge badge-secondary">{{ $attempts.' practice attempts' }}</span>
                                            @else
                                            <span class="badge badge-secondary">{{ $attempts.' of '.$cbt->no_attempts.' Attempts' }}</span>
                                            @endif
                                            <a href="{{ route('students.cbt', $cbt->id) }}" class="btn btn-sm btn-outline-primary">Take CBT</a>
                                          </td>
                                      </tr>
                                      <?php
                                      $sn++;
                                    }
                                    ?>
                                  @endforeach
                                </table>
                            </div>
                            @if ($sn < 2)
                                <div class="alert alert-info">None yet!</div>
                            @endif
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