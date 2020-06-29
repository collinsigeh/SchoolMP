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
            <h3>New subscription</h3>
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
                <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
                <li class="breadcrumb-item active" aria-current="page">New subscription</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Subscriptions</a></li>
                <li class="breadcrumb-item active" aria-current="page">New subscription</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          <div class="row">
              @foreach ($products as $product)
                  @foreach ($product->packages as $package)
                    @if ($package->status == 'Available')
                    <div class="col-lg-3 col-md-4 col-sm-6">
                      <div class="resource-details">
                        <img src="{{ config('app.url') }}/images/product_package/{{ $package->image }}" width="100%" alt="image" />
                        <div class="title2" style="padding-bottom: 0;">
                          {!! '<b>'.$package->product->name.' (<i>'.$package->product->payment.' '.$package->name.'</i>)</b>' !!}
                        </div>
                        <div class="body">
                          <div class="row">
                            <div class="col-8">
                              <b>{{ $setting->base_currency_symbol }} {{ $package->price }}</b><br /><small>(<i>{{ $package->price_type }}</i>)</small>
                            </div>
                            <div class="col-4">
                              <div class="text-right"><a href="{{ route('subscriptions.buy', $package->id) }}" class="btn btn-sm btn-primary">Buy</a></div>
                            </div>
                          </div>
                          <ul>
                            @php
                                if($package->day_limit == 1)
                                {
                                  echo '<li>Validity: '.$package->day_limit.' day</li>';
                                }
                                elseif($package->day_limit > 1)
                                {
                                  echo '<li>Validity: '.$package->day_limit.' days</li>';
                                }
                            @endphp
                            <li>Term limit: {{ $package->term_limit }}</li>
                            <li>
                            <em><b>
                              @if ($package->product->student_limit !== 'n')
                                  Student limit:  {{ $package->product->student_limit }}
                              @else
                                  No student limit
                              @endif
                            </b></em>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    @endif
                  @endforeach
              @endforeach 
          </div>
        </div>

    </div>
  </div>

@endsection