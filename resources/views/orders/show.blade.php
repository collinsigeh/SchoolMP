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
          <h3>{{ $order->name }}</h3>
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
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order no.: {{ $order->number }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order no.: {{ $order->number }}</li>
              @endif
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
                            </div>
                            <div class="col-md-5">
                                @if ($order->expiry >= time())
                                    @if (($order->status == 'Pending' && $order->payment == 'Prepaid') OR 
                                            ($order->status == 'Pending' && $order->payment == 'Trial' && $order->amount))
                                        <a href="#" class="btn btn-primary">Pay for order</a>
                                    @endif
                                @endif
                                @if ($order->status == 'Approved-unpaid' && $order->subscription_due_date <= time())
                                    <a href="#" class="btn btn-primary">Pay for order</a>
                                @endif
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
                                        <th>Order amount:</th>
                                        <th>
                                            {{ $order->currency_symbol }} {{ $order->final_price }}
                                        </th>
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
                                    <tr>
                                        <th>Pricing:</th>
                                        <td>{!! $order->currency_symbol.' '.$order->price.' (<i>'.$order->price_type.'</i>)' !!}</td>
                                    </tr>
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
                                            @if ($order->subscription_id > 0)
                                                @if (!empty($order->subscription->terms))
                                                    {{ count($order->subscription->terms) }}
                                                @else
                                                    {{ '0'}}
                                                @endif
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
                                            @if ($order->subscription_id > 0)
                                                @if (!empty($order->subscription->enrolments))
                                                    {{ count($order->subscription->enrolments) }}
                                                @else
                                                    {{ '0'}}
                                                @endif
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
                                Payments for order:
                            </div>
                            <div class="col-md-9">
                                @if (!empty($order->payments))
                                <div class="table-responsive">    
                                    <table class="table table-striped table-bordered table-hover table-sm">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Payment</th>
                                                  <th>Status</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @php
                                                  $sn = 1;
                                              
                                                foreach ($order->payments as $payment)
                                                {
                                                    $status_display = '';
                                                    if($payment->status == "Confirmed")
                                                    {
                                                        $status_display = '<span class="badge badge-success">Confirmed</span>';
                                                    }
                                                    echo '<tr>
                                                        <td>'.$sn.'</td>
                                                        <td>'.$payment->currency_symbol.' '.$payment->amount.' <small><i>paid</i></small> '.$payment->method.' <small><i>recorded '.$payment->created_at.'</td>
                                                        <td>
                                                            '.$status_display.'
                                                        </td>
                                                    </tr>';
                                                    $sn++;
                                                }
                                              @endphp
                                          </tbody>
                                      </table>
                                    </div>
                                @else
                                    None
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
              
            <div class="col-md-4">
                @if (($order->status == 'Pending' && $order->expiry >= time()) OR ($order->status == 'Approved-unpaid' && $order->subscription_due_date <= time()))
                <div class="resource-details">
                    <div class="title">
                        Order options
                    </div>
                    <div class="body">
                      <div class="table-responsive">    
                        <table class="table table-sm">
                          @if ($order->status != 'Complete' OR $order->status != 'Paid')
                            @if ($order->expiry >= time())
                                @if (($order->status == 'Pending' && $order->payment == 'Prepaid') OR 
                                        ($order->status == 'Pending' && $order->payment == 'Trial' && $order->amount))
                                    <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Pay for order:</b>
                                            </div>
                                            <div class="col-6">
                                                <a href="#" class="btn btn-primary">Pay for order</a>
                                            </div>
                                        </div>
                                    </td>
                                    </tr>
                                @endif
                            @endif
                            @if ($order->status == 'Approved-unpaid' && $order->subscription_due_date <= time())
                                <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <b>Pay for order:</b>
                                        </div>
                                        <div class="col-6">
                                            <a href="#" class="btn btn-primary">Pay for order</a>
                                        </div>
                                    </div>
                                </td>
                                </tr>
                            @endif
                          @endif
                          @if ($order->status != 'Approved-unpaid')
                          <tr>
                            <td>
                                <div class="option">
                                <form method="POST" action="{{ route('orders.destroy', $order->id) }}">
                                    @csrf
                                    @method('DELETE')

                                    <div class="form-group row">
                                        <div class="col-4">
                                            <b>Cancel order:</b>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} required>
                
                                                <label class="form-check-label" for="remember">
                                                    {{ __('Yes') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                {{ __('Cancel order') }}
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
                    </div>
                </div>
                @endif
                
                <div class="resource-details">
                    <div class="title">
                        Subscription for the order
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            @if ($order->subscription > 0 && !empty($order->subscription))
                            <table class="table table-striped table-hover table-sm">
                                <tbody>
                                    <tr>
                                        <td>{{ $order->subscription->name }}</td>
                                        <td class="text-right"><a href="{{ route('subscriptions.show', $order->subscription->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                                    </tr>
                                </tbody>
                            </table>
                            @else
                                <b>No subscription</b> (<i>@if ($order->payment == 'Post-paid')
                                    {{ 'pending approval' }}
                                @else
                                    {{ 'pending payment' }}
                                @endif</i>)
                            @endif
                        </div>
                    </div>
                </div>

                <div class="resource-details">
                    <div class="title">
                        Payments for order
                    </div>
                    <div class="body">
                        <div class="text-right">
                            @if ($order->status != 'Completed')
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addPaymentModal">Add payment details</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
  </div>
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