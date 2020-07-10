@extends('layouts.dashboard')

@section('title', 'Settings | ')

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
          <h3>Schoobic settings</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        Schoobic Settings
                    </div>
                    <div class="body">
        
                        @if (empty($setting))
                            <div class="alert alert-info">
                                The required setting is missing.
                                @if ($no_paymentprocessors < 1)
                                    <br /><br /><b>NOTE: </b>There are no payments processors yet.
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('settings.create') }}" class="btn btn-primary">Configure Settings</a> &nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="{{ route('payment_processors.create') }}" class="btn btn-outline-primary">Add payment processor</a>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-3">
                                    Base currency:
                                </div>
                                <div class="col-md-9">
                                    <h4>{{ $setting->base_currency }} ( {{ $setting->base_currency_symbol }} )</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Payment processor:
                                </div>
                                <div class="col-md-9">
                                    {{ $paymentprocessor }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Try limit:<br /><small>(<i>per user or school</i>)</small>
                                </div>
                                <div class="col-md-9">
                                    {{ $setting->try_limit }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Order expiration:<br /><small>(<i>How long before client order expires</i>)</small>
                                </div>
                                <div class="col-md-9">
                                    {{ $setting->order_expiration }}
                                    @if ($setting->order_expiration > 1)
                                        {{ 'days' }}
                                    @else
                                        {{ 'day' }}
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    Create at:
                                </div>
                                <div class="col-md-9">
                                    {{ $setting->created_at }}
                                </div>
                            </div>
                            <div class="packages">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5>List of alternative currencies</h5>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        @if (!empty($setting))
                                            <a href="{{ route('alternative_currencies.create') }}" class="btn btn-sm btn-primary">New currency</a>
                                        @endif
                                    </div>
                                </div>
                                @if(empty($alternative_currencies))
                                    <div class="alert alert-info" sr-only="alert">
                                        None available.
                                    </div>
                                @else
                                    <div class="table-responsive">    
                                    <table class="table table-striped table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Currency</th>
                                                    <th>Payment processor</th>
                                                    <th class="text-right">Rate ( per {{ $setting->base_currency_symbol }} )</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($alternative_currencies as $currency)
                                                    <tr>
                                                        <td>{{ $currency->name }} ( <i>{{ $currency->symbol }}</i> )</td>
                                                        <td>@foreach ($processors as $processor)
                                                            @if ($processor->id == $currency->paymentprocessor_id)
                                                                {{ $processor->name }}
                                                            @endif
                                                        @endforeach</td>
                                                        <td class="text-right">{{ $currency->symbol }} {{ $currency->rate }}</td>
                                                        <td class="text-right"><a href="{{ route('alternative_currencies.edit', $currency->id) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                                                        <td class="text-right">
                                                            <form method="POST" action="{{ route('alternative_currencies.destroy', $currency->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    {{ __('X') }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="resource-details">
                    <div class="title">
                        More options
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td><a href="{{ route('payment_processors.index') }}" class="btn btn-sm btn-block btn-outline-primary">Payment processors</a></td>
                                </tr>
                                @if (!empty($setting))
                                    <tr>
                                        <td><a href="{{ route('alternative_currencies.create') }}" class="btn btn-sm btn-block btn-outline-primary">Add alternative currency</a></td>
                                    </tr>
                                    <tr>
                                        <td><a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-sm btn-block btn-outline-primary">Change details</a></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
  </div>

@endsection
