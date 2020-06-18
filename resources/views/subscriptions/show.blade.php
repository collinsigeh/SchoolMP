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
          <h3>{{ $subscription->name }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Subscription details</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Subscription details</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        Subscription Details
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>{{ $subscription->name }}</h4>
                            </div>
                        </div>
                        
                        <div class="table-responsive" style="padding-bottom: 18px;">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <tr>
                                    <th class="bg-light">Validity:</th>
                                    <td>
                                        {!! date('d-M-Y', $subscription->start_at).' - <small>to</small> - '.date('d-M-Y', $subscription->end_at) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status:</th>
                                    <td>
                                        @php
                                            $now = time();
                                            if($now > $subscription->end_at)
                                            {
                                                echo '<span class="badge badge-danger">EXPIRED</span>';
                                            }
                                            elseif(($subscription->student_limit != 'n') && (count($subscription->enrolments) >= $subscription->student_limit) && (count($subscription->terms) >= $subscription->term_limit))
                                            {
                                                echo '<span class="badge badge-warning">VALID-Limit reached</span>';
                                            }
                                            else
                                            {
                                                echo '<span class="badge badge-success">VALID</span>';
                                            }
                                        @endphp
                                        &nbsp;&nbsp;&nbsp;
                                        <!-- Verify other stuff and give options to buy and update -->
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                              <div class="table-responsive bg-light">
                                <table class="table table-striped table-hover table-sm">
                                  <tr class="bg-secondary">
                                      <th style="font-size: 1.2em; color: #ffffff;" colspan="3">Use of subscription</th>
                                  </tr>
                                  <tr>
                                      <th></th>
                                      <th>Limit</th>
                                      <th>Uses</th>
                                  </tr>
                                  <tr>
                                      <th>No. of terms:</th>
                                      <td>{{ $subscription->term_limit }}</td>
                                      <td>
                                          {{ count($subscription->terms) }}
                                      </td>
                                  </tr>
                                  <tr>
                                      <th>Students per term:</th>
                                      <td>
                                          @if ($subscription->student_limit !== 'n')
                                              {{ $subscription->student_limit }}
                                          @else
                                              {{ 'NOT Applicable' }}
                                          @endif
                                      </td>
                                      <td>
                                          {{ count($subscription->enrolments) }}
                                      </td>
                                  </tr>
                                </table>
                              </div>
                          </div>
                          <div style="padding: 10px"></div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                              <div class="table-responsive bg-light">
                                <table class="table table-striped table-hover table-sm">
                                  <tr class="bg-secondary">
                                      <th style="font-size: 1.2em; color: #ffffff;" colspan="3">Linked orders</th>
                                  </tr>
                                  <tr>
                                      <th>#</th>
                                      <th>Item description</th>
                                      <th>Order status</th>
                                  </tr>
                                  @php
                                      $sn = 1;
                                  
                                    foreach ($subscription->orders as $order)
                                    {
                                        echo '<tr>
                                            <td>'.$sn.'</td>
                                            <td>'.$order->name.'</td>
                                            <td>';

                                        if($order->status == 'Pending' && time() >= $order->expiry)
                                        {
                                            echo '<span class="badge badge-danger">UNPAID - Request closed</span>';
                                        }
                                        elseif($order->status == 'Pending' && $order->payment == 'Post-paid')
                                        {
                                            echo '<span class="badge badge-danger">NEW ORDER - Pending approval</span>';
                                        }
                                        else
                                        {
                                            if($order->status == 'Paid')
                                            {
                                                echo '<span class="badge badge-info">PAID</span>';
                                            }
                                            elseif($order->status == 'Completed')
                                            {
                                                echo '<span class="badge badge-success">COMPLETED</span>';
                                            }
                                            elseif($order->status == 'Approved-unpaid')
                                            {
                                                echo '<span class="badge badge-primary">APPROVED - Unpaid</span>';
                                            }
                                            else
                                            {
                                                echo '<span class="badge badge-danger">UNPAID</span>';
                                            }
                                        }

                                        echo '</td>
                                        </tr>';
                                        $sn++;
                                    }
                                  @endphp
                                </table>
                              </div>
                          </div>
                        </div>                        
                    </div>
                </div>
            </div>
              
            <div class="col-md-4">
                @if (($order->status == 'Pending' && $order->expiry >= time()) OR ($order->status == 'Approved-unpaid' && $order->subscription_due_date <= time()))
                <div class="resource-details">
                    <div class="title">
                        Subscription options
                    </div>
                    <div class="body">
                        <!-- An upgrade button if needed -->
                    </div>
                </div>
                @endif
                
                <div class="resource-details">
                    <div class="title">
                        Linked terms
                    </div>
                    <div class="body">
                        @if (count($subscription->terms) < 1)
                            None
                        @else
                          <div class="table-responsive">    
                            <table class="table table-striped table-hover table-sm">
                                  <tbody>
                                      @foreach ($subscription->terms as $term)
                                      <tr>
                                        <td><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' '.$term->session !!}</a></td>
                                      </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                            </div>
                        @endif
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
  </div>

@endsection