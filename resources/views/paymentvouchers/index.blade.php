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
                                <th colspan="2"  style="vertical-align: middle;">Serial number</th>
                                <th  style="vertical-align: middle;">Voucher Pin</th>
                                <th  style="vertical-align: middle;">Item</th>
                                <th  style="vertical-align: middle;">Status</th>
                                <th class="text-right"  style="vertical-align: middle;">Voucher detail</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentvouchers as $paymentvoucher)
                                <?php $deletable = 'No'; ?>
                                <tr>
                                    <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/voucher_icon.png" alt="voucher_icon" class="collins-table-item-icon"></td>
                                    <td style="vertical-align: middle"><span class="badge badge-secondary">{{ $paymentvoucher->id }}</span></td>
                                    <td style="vertical-align: middle"><b>{{ $paymentvoucher->pin }}</b></td>
                                    <td style="vertical-align: middle">{{ $paymentvoucher->package->product->name.' '.$paymentvoucher->package->product->payment.' '.$paymentvoucher->package->name }}</td>
                                    <td style="vertical-align: middle">
                                      @if ($paymentvoucher->status == 'Used')
                                          <span class="badge badge-light">Used</span>
                                      @else
                                          @if ($paymentvoucher->expiration_at <= time())
                                              <span class="badge badge-danger">Expired</span>
                                              <?php $deletable = 'Yes'; ?>
                                          @else
                                              <span class="badge badge-success">Available</span>
                                          @endif
                                      @endif
                                    </td>
                                    <td style="vertical-align: middle; text-align: right">
                                        <span class="badge badge-secondary">{{ $paymentvoucher->assigned_to }} payment</span><br />
                                        @if ($paymentvoucher->id_assigned_to > 0)
                                        {{ $paymentvoucher->assigned_to }} ID: {{ $paymentvoucher->id_assigned_to }}                                            
                                        @endif
                                    </td>
                                    <td style="vertical-align: middle; text-align: right">
                                        <?php
                                            if($deletable == 'Yes')
                                            {
                                                echo '<a href="#" class="btn btn-sm btn-danger">X</a>';
                                            }
                                        ?>
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