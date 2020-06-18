@extends('layouts.dashboard')

@section('title', 'Orders | ')

@section('content')

<div class="container-fluid">
    <div class="row">
      @if ($user->role == 'Owner')
          @include('partials._owner_sidebar')
      @else
          @include('partials._system_sidebar')
      @endif

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
            <h3>Orders</h3>
          </div>
          <div class="col-4 text-right">
              
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Orders</li>
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
                            <th>School</th>
                            <th>Item description</th>
                            <th class="text-right">Due amount</th>
                            <th class="text-right">Order status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->school->school }}</td>
                                <td>{{ $order->name }}</td>
                                <td class="text-right">{{ $order->currency_symbol.' '.$order->final_price }}</td>
                                <td class="text-right">
                                    @php
                                        if($order->status == 'Pending' && time() >= $order->expiry)
                                        {
                                            echo '<span class="badge badge-danger">UNPAID - Expired request</span>';
                                        }
                                        elseif($order->status == 'Pending' && $order->payment == 'Post-paid')
                                        {
                                            echo '<span class="badge badge-danger">NEW REQUEST - Waiting for your approval</span>';
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
                                <td class="text-right"><a href="{{ route('orders.detail', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
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