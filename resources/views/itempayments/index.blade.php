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
            <h3>{{ $term->name }} Payments received {!! ' - <small>'.$term->session.'</small>' !!}</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_class_arms == 'Yes')
                    <a href="{{ route('itempayments.create') }}" class="btn btn-primary">New payment</a>
                  @endif
              @else
                  <a href="{{ route('itempayments.create') }}" class="btn btn-primary">New payment</a>
              @endif
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payments received</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payments received</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($itempayments) < 1)
            <div class="alert alert-info" sr-only="alert">
                None available.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="2"  style="vertical-align: middle;">Amount received</th>
                            <th style="vertical-align: middle;">Item paid for</th>
                            <th style="vertical-align: middle;">Student</th>
                            <th style="vertical-align: middle;">Date</th>
                            <th style="vertical-align: middle;">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($itempayments as $itempayment)
                            <tr>
                                <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/wallet_icon.png" alt="payment_icon" class="collins-table-item-icon"></td>
                                <td style="vertical-align: middle;"><a class="collins-link-within-table" href="{{ route('itempayments.edit', $itempayment->id) }}"><b>{{ $itempayment->currency_symbol.' '.number_format($itempayment->amount, 2) }}</b></a></td>
                                <td style="vertical-align: middle;">
                                    @if ($itempayment->item_id == 0)
                                        {{ 'No specific item' }}
                                    @else
                                        {{ $itempayment->item->name }}
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">
                                    @if ($itempayment->enrolment_id == 0)
                                        
                                    @else
                                        {{ $itempayment->enrolment->user->name }}<br />
                                        <span class="badge badge-secondary">{{ $itempayment->enrolment->arm->schoolclass->name.' '.$itempayment->enrolment->arm->name }}</span>
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">{{ date('D, d-M-Y', strtotime($itempayment->created_at)) }}</td>
                                <td style="vertical-align: middle;">
                                    @php
                                        if($itempayment->status == 'Confirmed')
                                        {
                                            echo '<span class="badge badge-success">Confirmed</span>';
                                        }
                                        elseif($itempayment->status == 'Declined')
                                        {
                                            echo '<span class="badge badge-danger">Declined</span>';
                                        }
                                        else
                                        {
                                            echo '<span class="badge badge-info">Pending</span>';
                                        }
                                    @endphp
                                </td>
                                <td class="text-right" style="vertical-align: middle;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $itempayments->links() }}
        @endif
    </div>
  </div>

@endsection