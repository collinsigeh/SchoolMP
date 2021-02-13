@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._student_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>{!! 'My payments ('.$enrolment->term->name.' - <small><i>'.$enrolment->term->session.'</i></small>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('students.term', $enrolment->id) }}">{!! $enrolment->term->name.' - <small>'.$enrolment->term->session.'</small>' !!}</a></li>
              <li class="breadcrumb-item active" aria-current="page">My payment history</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        List of confirmed payments
                    </div>
                    <div class="body">                          
                        <div class="table-responsive bg-light">
                            <table class="table table-striped table-hover table-sm">
                                @if (count($enrolment->itempayments) < 1)
                                    <tr>
                                        <td>None</td>
                                    </tr>
                                @else
                                    <?php 
                                        $sn = 0;
                                    ?>
                                    @foreach ($enrolment->itempayments as $itempayment)
                                    <?php 
                                        if($itempayment->status == 'Confirmed')
                                        {
                                    ?>
                                        <tr>
                                            <td>
                                                <a class="collins-link-within-table" href="#"><img src="{{ config('app.url') }}/images/icons/voucher_icon.png" alt="payment_icon" class="collins-table-item-icon">  <b>{!! $itempayment->currency_symbol.' '.$itempayment->amount !!}</b></a>
                                            </td>
                                            <td>
                                                @if ($itempayment->item_id > 0)
                                                    {{ 'Payment for '.$itempayment->item->name }}
                                                @else
                                                    {{ 'Payment for non-specified item'}}
                                                @endif
                                            </td>
                                            <td class="text-right">{{ date('d-M-Y', strtotime($itempayment->created_at)) }}</td>
                                        </tr>
                                    <?php
                                            $sn++;
                                        }
                                    ?>
                                    @endforeach
                                    <?php
                                        if($sn < 1)
                                        {
                                            echo '<tr><td>You do NOT have a comfirmed payment yet';
                                        }
                                    ?>
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
                                <a class="btn btn-sm btn-block btn-outline-primary text-left" href="{{ route('students.term', $enrolment->id) }}"><img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="options-icon"> {!! $enrolment->term->name.' - <small>'.$enrolment->term->session.'</small>' !!}</a>
                                
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