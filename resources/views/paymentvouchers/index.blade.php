@extends('layouts.dashboard')

@section('title', 'Payment vouchers | ')

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
            <h3>Payment vouchers</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('paymentvouchers.create') }}" class="btn btn-primary">New voucher</a>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment vouchers</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($paymentvouchers) < 1)
            <div class="alert alert-info" sr-only="alert">
                None found.
            </div>
        @else
            <div class="collins-bg-white">
                <div class="table-responsive">    
                <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Payment voucher</th>
                                <th>Pin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentvouchers as $paymentvoucher)
                                <tr>
                                    <td><a class="collins-link-within-table" href="{{ route('paymentvoucher.show', $paymentvoucher->id) }}"><img src="{{ config('app.url') }}/images/icons/voucher_icon.png" alt="voucher_icon" class="collins-table-item-icon"> <span class="badge badge-secondary">{{ $voucher->id }}</span></a></td>
                                    <td><a class="collins-link-within-table" href="{{ route('paymentvoucher.show', $paymentvoucher->id) }}"><b>{{ $voucher->pin }}</b></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        @endif
    </div>
  </div>

@endsection