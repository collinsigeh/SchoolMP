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
            <h3>Orders</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_subscriptions == 'Yes')
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
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($orders) < 1)
            <div class="alert alert-info" sr-only="alert">
                None available.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Item description</th>
                            <th class="text-right">Due amount</th>
                            <th class="text-right">Order status</th>
                            <th class="text-right">Request at</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->name }}</td>
                                <td class="text-right">{{ $order->currency_symbol.' '.$order->final_price }}</td>
                                <td class="text-right">
                                    @php
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
                                    @endphp
                                </td>
                                <td class="text-right">{{ $order->created_at }}</td>
                                <td class="text-right"><a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                              </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $orders->links() }}
        @endif
    </div>
  </div>

@endsection