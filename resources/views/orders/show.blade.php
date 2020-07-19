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
                                    @if (($order->status == 'Pending' && $order->payment == 'Prepaid' && $order->price_type == 'Per-package') OR 
                                            ($order->status == 'Pending' && $order->payment == 'Trial' && $order->amount > 0))
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
                                @if ($order->product->payment == 'Post-paid')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <b>Note: </b>
                                                <ul>
                                                    <li style="padding-bottom: 12px;">This is a <b>post-paid</b> order.</li>
                                                    <li style="padding-bottom: 12px;">The total value of this order will be determined at the end of the term when the total number of students have been known.</li>
                                                    <li style="padding-bottom: 12px;">The rate of this package will remain the same at the end of the term.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($order->product->payment == 'Prepaid' && $order->price_type == 'Per-student')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-info">
                                                <b>Note: </b>
                                                <ul>
                                                    <li style="padding-bottom: 12px;">This is a <b>prepaid</b> plan and can be paid for either by the school or the student.</li>
                                                    <li style="padding-bottom: 12px;">The <b>School asking price is the amount</b> the school wants each student to pay for the subscription.</li>
                                                    <li style="padding-bottom: 12px;">The <b>School asking price can be changed</b> at anytime. <a href="#" data-toggle="modal" data-target="#updateAskingPriceModal">Click to change</a>.</li>
                                                    <li style="padding-bottom: 12px;">If the <b>school makes payment</b>, it will be billed at the price stated above.</li>
                                                    <li style="padding-bottom: 12px;">If the <b>student makes payment</b>, it will be billed at the School asking price specified above.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="table-responsive">    
                                <table class="table table-striped table-bordered table-hover table-sm">
                                    @php
                                        if($order->payment_type == 'Per-package')
                                        {
                                            echo '
                                                <tr>
                                                    <th>Order amount:</th>
                                                    <th>
                                                        {{ $order->currency_symbol }} {{ $order->final_price }}
                                                    </th>
                                                </tr>';
                                        }
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
                                        <td>{!! $order->currency_symbol.' '.$order->price.' <small>(<i>'.$order->price_type.'</i>)</small>' !!}</td>
                                    </tr>
                                    @if ($order->payment == 'Prepaid' && $order->price_type == 'Per-student')
                                    <tr>
                                        <th>School asking price:</th>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-7">
                                                    {!! $order->currency_symbol.' '.$order->school_asking_price.' <small>(<i>'.$order->price_type.'</i>)</small>' !!}
                                                </div>
                                                <div class="col-md-5 text-md-right"><button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#updateAskingPriceModal">Update</button></div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
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
                            @if ($order->subscription_id > 0 && !empty($order->subscription))
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
            </div>
        </div>
        
    </div>
  </div>


  
<div class="modal fade" id="updateAskingPriceModal" tabindex="-1" role="dialog" aria-labelledby="updateAskingPriceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateAskingPriceLabel">Update School Asking Price</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('orders.update', $order->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="update_type" value="School_Asking_Price" required>
    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Item') }}</label>
    
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $order->name }}" disabled autocomplete="name" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Pricing ('.$order->currency_symbol).')' }}</label>
    
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $order->final_price }}" disabled autocomplete="name" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('School asking price ('.$order->currency_symbol).')' }}</label>
    
                        <div class="col-md-8">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $order->school_asking_price }}" required autocomplete="name" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>

@endsection