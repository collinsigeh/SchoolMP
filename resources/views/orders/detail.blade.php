@extends('layouts.dashboard')

@section('title', 'Order: '.$order->number.' | ')

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
          <h3>{{ $order->name }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('orders.all') }}">Orders</a></li>
              <li class="breadcrumb-item active" aria-current="page">Order no.: {{ $order->number }}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        Order Details
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-3">
                                Item:
                            </div>
                            <div class="col-md-9">
                                <h4>{{ $order->name }}</h4>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-3">
                                Order number:
                            </div>
                            <div class="col-md-9">
                                {{ $order->number }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                Order status:
                            </div>
                            <div class="col-md-4">
                                @php
                                    if($order->status == 'Pending' && time() >= $order->expiry)
                                    {
                                        echo '<span class="badge badge-danger">UNPAID - Expired request</span>';
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
                            </div>
                            <div class="col-md-5">
                                @if (($order->status == 'Pending' && $order->payment == 'Post-paid') OR 
                                      ($order->status == 'Pending' && $order->payment == 'Trial' && $order->final_price == 0) OR 
                                      ($order->status == 'Paid'))
                                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#changeDetailModal">Change / edit</button>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                Amount & payment:
                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">    
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th></th>
                                        <th>Order amount</th>
                                        <th>Total payment</th>
                                    </tr>
                                    <tr>
                                        <th>Amount:</th>
                                        <td>{{ $order->currency_symbol.' '.$order->final_price }}</td>
                                        <td>
                                           @php
                                               $total_paid = 0;
                                               if(count($order->payments) > 0)
                                               {
                                                    foreach($order->payments as $payment)
                                                    {
                                                        $total_paid = $total_paid + $payment->amount;
                                                    }
                                               }
                                               echo $order->currency_symbol.' '.$total_paid;
                                           @endphp
                                        </td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                Order utilization:
                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">    
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th></th>
                                        <th>Limit</th>
                                        <th>Utilization</th>
                                    </tr>
                                    <tr>
                                        <th>Term:</th>
                                        <td>{{ $order->term_limit }}</td>
                                        <td>
                                            @if (count($order->subscription) > 0)
                                                {{ count($order->subscription->terms) }}
                                            @else
                                                {{ '0' }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Student:</th>
                                        <td>
                                            @if ($order->student_limit !== 'n')
                                                {{ $order->student_limit }}
                                            @else
                                                {{ 'NOT Applicable' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (count($order->subscription) > 0)
                                            {{ count($order->subscription->enrolments) }}
                                            @else
                                            {{ '0' }}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                Order specification:
                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">    
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th>Type:</th>
                                        <td>
                                            {{ $order->type }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment:</th>
                                        <td>
                                            {{ $order->payment }}
                                        </td>
                                    </tr>
                                    @php
                                        if($order->day_limit == 1)
                                        {
                                          echo '<tr><th>Validity:</th><td>'.$order->day_limit.' day</td></tr>';
                                        }
                                        elseif($order->day_limit > 1)
                                        {
                                          echo '<tr><th>Validity:</th><td>'.$order->day_limit.' days</td></tr>';
                                        }
                                    @endphp
                                    <tr>
                                        <th>Request at:</th>
                                        <td>
                                            <small>{{ $order->created_at }}</small>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                Contact details:
                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">    
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    <tr>
                                        <th>School:</th>
                                        <td>
                                            {{ $order->school->school }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>School email:</th>
                                        <td>
                                            {{ $order->school->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Order by:</th>
                                        <td>
                                            {{ $order->user->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Contact email:</th>
                                        <td>{{ $order->user->email }}</td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
              
            <div class="col-md-4">
                <div class="resource-details">
                    <div class="title">
                        Subscription delivered
                    </div>
                    <div class="body">
                        @if (count($order->subscription) != 1)
                            None
                        @else
                          <div class="table-responsive">    
                            <table class="table table-striped table-hover table-sm">
                                  <tbody>
                                      <tr>
                                          <td>{{ $order->subscription->name }}</td>
                                          <td class="text-right"><a href="{{ route('subscriptions.show', $order->subscription->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                       </tr>
                                  </tbody>
                              </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        Payments for order
                    </div>
                    <div class="body">
                        @if (count($order->payments) < 1)
                            None
                        @else
                          <div class="table-responsive">    
                            <table class="table table-striped table-hover table-sm">
                                  <thead>
                                      <tr>
                                          <th>Amount</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($order->payments as $payment)
                                          <tr>
                                              <td>{{ $payment->currency_symbol.' '.$payment->amount }}</td>
                                              <td class="text-right"><a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                            </div>
                        @endif
                        <div class="text-right">
                            @if ($order->status != 'Completed')
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addPaymentModal">Add payment details</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        Order options
                    </div>
                    <div class="body">
                    @if ($order->status == 'Completed' OR $order->status == 'Approved-unpaid')
                        None
                    @else
                      <div class="table-responsive">    
                        <table class="table">
                          @if (($order->status == 'Pending' && $order->payment == 'Post-paid') OR 
                                ($order->status == 'Pending' && $order->payment == 'Trial' && $order->final_price == 0) OR 
                                ($order->status == 'Paid'))
                            <tr>
                                <td>
                                  <div class="row">
                                      <div class="col-5">
                                          <b>Order status:</b>
                                      </div>
                                      <div class="col-7">
                                          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#changeDetailModal">Change / edit</button>
                                      </div>
                                  </div>
                                </td>
                            </tr>
                          @endif
                          @if ($order->status == 'Pending')
                          <tr>
                            <td>
                                <div class="option">
                                <form method="POST" action="{{ route('orders.destroy', $order->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <div class="form-group row">
                                        <div class="col-5">
                                            <b>Delete order:</b>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} required>
                
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Yes') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                {{ __('Delete') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </td>
                          </tr>
                          @endif
                        </table>
                      </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
  </div>

<!-- changeDetailModal -->
   <div class="modal fade" id="changeDetailModal" tabindex="-1" role="dialog" aria-labelledby="changeDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changeDetailModalLabel">Change order status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('orders.changedetail', $order->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">Current status</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $order->status }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Select new status') }}</label>
        
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="{{ $order->status }}">{{ $order->status }}</option>
                                @if ($order->status == 'Pending' && $order->payment == 'Post-paid')
                                    <option value="Approved-unpaid">Approve post-paid order</option>
                                @endif
                                @if ($order->status == 'Pending' && $order->payment == 'Trial' && $order->final_price == 0)
                                    <option value="Completed">Completed</option>
                                @endif
                                @if ($order->status == 'Paid')
                                    <option value="Completed">Completed</option>
                                @endif
                            </select>
        
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save changes') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End changeDetailModal -->

<!-- addPaymentModal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPaymentModalLabel">Add payment details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('payments.store') }}">
                    @csrf

                    <input type="hidden" name="id" value="{{ $order->id }}">

                    <div class="form-group row">
                        <label for="" class="col-md-4 col-form-label text-md-right">Order number</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $order->number }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount ('.$order->currency_symbol.')') }}</label>
    
                        <div class="col-md-6">
                            <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" required autocomplete="amount" autofocus>
    
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="method" class="col-md-4 col-form-label text-md-right">{{ __('Method of payment') }}</label>
        
                        <div class="col-md-6">
                            <select name="method" id="method" class="form-control @error('method') is-invalid @enderror" required>
                                <option value="Offline">Offline</option>
                                <option value="Online">Online</option>
                            </select>
        
                            @error('method')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status of payment') }}</label>
        
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="Pending">Unconfirmed</option>
                                <option value="Confirmed">Confirmed</option>
                            </select>
        
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="special_note" class="col-md-4 col-form-label text-md-right">{{ __('Special note (Optional):') }}</label>
                        
                        <div class="col-md-6">
                            <textarea id="special_note" class="form-control @error('special_note') is-invalid @enderror" name="special_note" placeholder="More details, if any!">{{ old('special_note') }}</textarea>
    
                            @error('special_note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End addPaymentModal -->

@endsection