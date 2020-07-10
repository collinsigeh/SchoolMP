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
            <h3>Confirm subscription</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subscriptions.create') }}">New subscription</a></li>
                <li class="breadcrumb-item active" aria-current="page">Confirm</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>
        
        <div class="resource-details">
          <div class="title">
              Order details
          </div>
          <div class="body">
              <div class="row">
                  <div class="col-md-3 col-sm-4 text-sm-right text-center">
                    <img src="{{ config('app.url') }}/images/product_package/{{ $package->image }}" width="100%" alt="image" style="border: 1px solid #e3e3e3;" />
                  </div>
                  <div class="col-md-9 col-sm-8">
                    <div class="row">
                        <div class="col-md-3 col-form-label text-md-right">
                            Item:
                        </div>
                        <div class="col-md-7" style="padding-top: 7px;">
                            <h4>{!! $package->product->name.' (<i>'.$package->product->payment.' '.$package->name.'</i>)' !!} </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-form-label text-md-right">
                            Specification:
                        </div>
                        <div class="col-md-7">
                            <div class="table-responsive">    
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <tr>
                                    <th>Term limit:</th>
                                    <td>{{ $package->term_limit }}</td>
                                </tr>
                                <tr>
                                    <th>Student limit:</th>
                                    <td>
                                        @if ($package->product->student_limit !== 'n')
                                            {{ $package->product->student_limit }}
                                        @else
                                            {{ 'NOT Applicable' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Price:</th>
                                    <td>
                                        {{ $setting->base_currency_symbol }} {{ $package->price }} (<i>{{ $package->price_type }}</i>)
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="create-form">
                        <form method="POST" action="{{ route('subscriptions.store') }}">
                            @csrf
                            
                            <input type="hidden" name="package_id" value="{{ $package->id }}">

                            @if ($package->product->student_limit != 'n')
                                <div class="form-group row"> 
                                    <label class="col-md-3 col-form-label text-md-right">{{ __('Order amount:') }}</label>
                                    
                                    <div class="col-md-7">
                                        <div style="font-size: 1.3em; padding-top: 5px;">{{ $setting->base_currency_symbol }} <span id="total_price">@if ($package->price_type == 'Per-package')
                                            {{ $package->price }}
                                        @else
                                            0.00
                                        @endif</span></div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-7 offset-md-3">
                                        <div class="alert alert-info">
                                            <b>Note: </b>
                                            <ul>
                                                <li>This is a post-paid order.</li>
                                                <li>The total value of this order will be determined at the end of the term when the total number of students have been known.</li>
                                                <li>The rate of this package will remain the same at the end of the term.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
            
                            <div class="form-group row mb-0">
                                <div class="col-md-7 offset-md-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit order') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
              </div>
          </div>
        </div>

    </div>
  </div>

@endsection

@section('scripts')
    
<script type="text/javascript">
    function totalPrice()
    {
        var no_students = document.getElementById('no_students').value;
        var price_type = document.getElementById('price_type').value;
        var package_price = document.getElementById('package_price').value;
        var total_price = 0;

        if(no_students > 0 && price_type == 'Per-student')
        {
            total_price = package_price * no_students;
        }
        document.getElementById("total_price").innerHTML = total_price.toFixed(2);
    }
</script>

@endsection