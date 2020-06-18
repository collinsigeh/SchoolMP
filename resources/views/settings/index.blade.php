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

        <div class="resource-details">
            <div class="title">
                Schoobic Settings
            </div>
            <div class="body">

                @if (empty($setting))
                    <p>The required setting is missing.</p>
                    <div>
                        <a href="{{ route('settings.create') }}" class="btn btn-primary">Configure settings</a>
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
                        <h5>List of alternative currencies</h5>
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
                                            <th class="text-right">Rate ( per {{ $setting->base_currency_symbol }} )</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alternative_currencies as $currency)
                                            <tr>
                                                <td>{{ $currency->name }} ( <i>{{ $currency->symbol }}</i> )</td>
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

        @if(!empty($setting))
            <div class="more-options">
                <div class="head">More options</div>
                <div class="body">
                    <div class="option">
                        <h5>Add alternative currency</h5>
                        <div class="row">
                            <div class="col-md-10 offset-md-2">
                            <a href="{{ route('alternative_currencies.create') }}" class="btn btn-primary">New currency</a>
                            </div>
                        </div>
                    </div>

                    <div class="option">
                        <h5>Update settings</h5>
                        <div class="row">
                            <div class="col-md-10 offset-md-2">
                            <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-primary">Change details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
  </div>

@endsection
