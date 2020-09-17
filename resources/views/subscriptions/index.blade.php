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
            <h3>Subscriptions</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_session_terms == 'Yes')
                    <a href="{{ route('subscriptions.create') }}" class="btn btn-primary">New subscription</a>
                  @endif
              @else
                  <a href="{{ route('subscriptions.create') }}" class="btn btn-primary">New subscription</a>
              @endif
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.index') }}">Schools</a></li>
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>
      
        <div class="alert alert-info">
          <p>Here's a list of subscription and the order summary for {{$school->school}}.</p>Also, click on the <b>new subscription</b> button at the top-right corner to get a new subscription.
        </div>

        <div class="welcome">
          <div class="row">
              <div class="col-md-8">
                  <div class="resource-details">
                      <div class="title">
                          Subscriptions
                      </div>
                      <div class="body">
                          @if (count($subscriptions) < 1)
                              None
                          @else
                            <div class="table-responsive">    
                            <table class="table table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Subscription</th>
                                            <th>Validity</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptions as $subscription)
                                            <tr>
                                                <td>{{ $subscription->name }}</td>
                                                <td>{{ date('d-M-Y', $subscription->start_at).' - to - '.date('d-M-Y', $subscription->end_at) }}</td>
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
                                                  </td>
                                                <td class="text-right"><a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $subscriptions->links() }}
                          @endif
                      </div>
                  </div>
              </div>
              
              <div class="col-md-4">
                  <div class="resource-details">
                      <div class="title">
                          Order summary
                      </div>
                      <div class="body">
                        <div class="table-responsive">    
                          <table class="table table-striped table-bordered table-hover table-sm">
                            <tr>
                              <th>Unpaid orders</th>
                              <td>{{ $no_unpaid_orders }}</td>
                            </tr>
                            <tr>
                              <th>All orders</th>
                              <td>{{ count($school->orders) }}</td>
                            </tr>
                          </table>
                        </div>
                        @if (count($school->orders) >= 1)
                          <div class="text-right"><a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">View orders</a></div>
                        @endif
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
  </div>

@endsection