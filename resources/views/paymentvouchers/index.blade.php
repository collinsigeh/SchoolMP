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
                                <th colspan="2">Serial number</th>
                                <th>Voucher Pin</th>
                                <th>Item</th>
                                <th>Payment type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentvouchers as $paymentvoucher)
                                <tr>
                                    <td style="width: 50px;"><a class="collins-link-within-table" href="{{ route('paymentvouchers.show', $paymentvoucher->id) }}"><img src="{{ config('app.url') }}/images/icons/voucher_icon.png" alt="voucher_icon" class="collins-table-item-icon"></a></td>
                                    <td style="vertical-align: middle"><a class="collins-link-within-table" href="{{ route('paymentvouchers.show', $paymentvoucher->id) }}"><span class="badge badge-secondary">{{ $paymentvoucher->id }}</span></a></td>
                                    <td style="vertical-align: middle"><a class="collins-link-within-table" href="{{ route('paymentvouchers.show', $paymentvoucher->id) }}"><b>{{ $paymentvoucher->pin }}</b></a></td>
                                    <td style="vertical-align: middle"><a class="collins-link-within-table" href="{{ route('paymentvouchers.show', $paymentvoucher->id) }}">{{ $paymentvoucher->package->product->name.' '.$paymentvoucher->package->product->payment.' '.$paymentvoucher->package->name }}</a></td>
                                    <td style="vertical-align: middle"><span class="badge badge-secondary">{{ $paymentvoucher->package->price_type }}</span></td>
                                    <td style="vertical-align: middle">
                                      @if ($paymentvoucher->status == 'Used')
                                          <span class="badge badge-light">Used</span>
                                      @else
                                          @if ($paymentvoucher->expiration_at <= time())
                                              <span class="badge badge-danger">Expired</span>
                                          @else
                                              @if ($paymentvoucher->status == 'Assigned')
                                                  <span class="badge badge-primary">Assigned</span>
                                              @else
                                                  <span class="badge badge-success">Available</span>
                                              @endif
                                          @endif
                                      @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $paymentvouchers->links() }}
            </div>
        @endif
    </div>
  </div>

@endsection