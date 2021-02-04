@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>{!! $enrolment->term->name.' - <small><i>'.$enrolment->term->session.'</i></small>' !!}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">{!! $enrolment->term->name.' - <small>'.$enrolment->term->session.'</small>' !!}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="row">
            <div class="col-md-8">
                @if (count($enrolment->results) >= 1)
                    <div class="alert alert-info">
                      <b><u>Hint:</u></b><br />Click on a subject to view your performance and access the lessons and CBTs.
                    </div>
                @endif
                <div class="alert alert-info">
                    <div style="margin-bottom: 30px;">
                      <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="collins-this-term-icon"> <span class="collins-this-term">{!! $enrolment->term->name.' - <small>'.$enrolment->term->session.'</small>' !!}</span>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover table-sm">
                              <tr class="bg-light">
                                <td><b>Class:</b></td><td>{{ $enrolment->arm->schoolclass->name.' '.$enrolment->arm->name }}</td>
                              </tr>
                              <tr class="bg-light">
                                <td><b>Enrolment ID:</b></td><td>{{ $enrolment->id }}</td>
                              </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="table-responsive">
                          <table class="table table-striped table-bordered table-hover table-sm">
                              <tr class="bg-light">
                                <td><b>Resumption date:</b></td><td>{{ date('D, d-M-Y', strtotime($enrolment->term->resumption_date)) }}</td>
                              </tr>
                              <tr class="bg-light">
                                <td><b>Closing date:</b></td><td>{{ date('D, d-M-Y', strtotime($enrolment->term->closing_date)) }}</td>
                              </tr>
                          </table>
                        </div>
                      </div> 
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        My Subjects
                    </div>
                    <div class="body">                          
                        <div class="table-responsive bg-light">
                            <table class="table table-striped table-hover table-sm">
                                @if (count($enrolment->results) < 1)
                                    <tr>
                                        <td>None</td>
                                    </tr>
                                @else
                                    @foreach ($enrolment->results as $result_slip)
                                        <tr>
                                            <td>
                                                <a class="collins-link-within-table" href="{{ route('students.subject', $result_slip->id) }}"><img src="{{ config('app.url') }}/images/icons/subjects_icon.png" alt="subject_icon" class="collins-table-item-icon">  <b>{{ $result_slip->classsubject->subject->name }}</b></a>
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
                            <tr>
                              <td>
                                <button class="btn btn-sm btn-block btn-outline-primary text-left"  data-toggle="modal" data-target="#feesBreakdownModal">
                                  <img src="{{ config('app.url') }}/images/icons/fees_icon.png" alt="fees_icon" class="options-icon">  School fees breakdown
                                </button>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <button class="btn btn-sm btn-block btn-outline-primary text-left"  data-toggle="modal" data-target="#feesBreakdownModal">
                                  <img src="{{ config('app.url') }}/images/icons/voucher_icon.png" alt="payment_icon" class="options-icon">  My payment history
                                </button>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <button class="btn btn-sm btn-block btn-outline-primary text-left"  data-toggle="modal" data-target="#feesBreakdownModal">
                                  <img src="{{ config('app.url') }}/images/icons/result_icon.png" alt="result_icon" class="options-icon">  Termly result
                                </button>
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

@php
    $arm = $enrolment->arm;
@endphp
@include('partials._fees_breakdown')

@endsection