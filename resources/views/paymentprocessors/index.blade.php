@extends('layouts.dashboard')

@section('title', 'Users | ')

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
            <h3>Users</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('payment_processors.create') }}" class="btn btn-primary">New payment processor</a>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment processors</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(empty($paymentprocessors))
            <div class="alert alert-info" sr-only="alert">
                No payment processor yet.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Payment Processors</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentprocessors as $payment_processor)
                            <tr>
                                <td>{{ $payment_processor->name }}</td>
                                <td class="text-right"><a href="{{ route('payment_processors.edit', $payment_processor->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $paymentprocessors->links() }}
        @endif
    </div>
  </div>

@endsection