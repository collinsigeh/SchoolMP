@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._directors_sidebar')

      <div class="col-md-10 main">

        <div class="row">
          <div class="col-8">
            <h3>School Dashboard</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
          @if (count($due_invoices) >= 1)
          <div class="alert alert-info">
            <h4>Due invoices</h4>
            <p>The following invoices require payment.</p>
            <div class="table-responsive" style="background-color: #fff; padding: 5px; border-radious: 4px;">    
              <table class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Item description</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">Due date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($due_invoices as $order)
                <tr>
                    <td>{{ $order->name }}</td>
                    <td class="text-right">{{ $order->currency_symbol.' '.$order->final_price }}</td>
                    <td class="text-right">{{ date('D d M, Y', $order->subscription_due_date) }}</td>
                    <td class="text-right"><a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          @endif
          
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info">
                <div>
                  <img src="{{ config('app.url') }}/images/icons/current_term_icon.png" alt="current_term_icon" class="collins-current-term-icon">
                </div>
                
                
                @if (!$currentterm)
                    <span style="font-size: 2em;">Not Available!</span><br />
                    @if (count($previousterms) >= 1)
                      <a href="{{ route('terms.index') }}" class="btn btn-sm btn-primary" style="margin-top:- 15px; margin-right: 50px;">View session terms</a>
                    @else
                      <a href="{{ route('terms.create') }}" class="btn btn-sm btn-primary" style="margin-top:- 15px;">New term</a>
                    @endif
                @else

                <span style="font-size: 2em;">{!! $currentterm->name.' (<small>'.$currentterm->session.'</small>)' !!}</span><br />
                <a href="{{ route('terms.show', $currentterm->id) }}" class="btn btn-sm btn-primary" style="margin-top:- 15px;">Enter</a>
                
                @endif
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('terms.index') }}">
                <img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="session_term" class="collins-feature-icon">
                <div class="collins-feature-title">Session Terms</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('directors.index') }}">
                <img src="{{ config('app.url') }}/images/icons/director_icon.png" alt="director_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Directors</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('staff.index') }}">
                <img src="{{ config('app.url') }}/images/icons/staff_icon.png" alt="staff_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Staff</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('school_settings.index') }}">
                <img src="{{ config('app.url') }}/images/icons/setting_icon.png" alt="setting_icon" class="collins-feature-icon">
                <div class="collins-feature-title">School settings</div>
                </a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('subscriptions.index') }}">
                <img src="{{ config('app.url') }}/images/icons/subscription_icon.png" alt="subscription_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Subscriptions</div>
                </a>
              </div>
            </div>
          </div>

        </div>

      </div>
      
    </div>
  </div>

@endsection