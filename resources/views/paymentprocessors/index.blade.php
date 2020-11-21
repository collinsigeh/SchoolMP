@extends('layouts.dashboard')

@section('title', 'Payment Processors | ')

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
            <h3>Payment processors</h3>
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
            <div class="collins-bg-white">
              <div class="table-responsive">    
                  <table class="table table-striped table-hover table-sm">
                      <tbody>
                          @foreach ($paymentprocessors as $payment_processor)
                              <tr>
                                  <td><a class="collins-link-within-table" href="{{ route('payment_processors.edit', $payment_processor->id) }}"><img src="{{ config('app.url') }}/images/icons/paymentprocessor_icon.png" alt="paymentprocessor_icon" class="collins-table-item-icon"> {{ $payment_processor->name }}</a></td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              {{ $paymentprocessors->links() }}
            </div>
        @endif
    </div>
  </div>

@endsection