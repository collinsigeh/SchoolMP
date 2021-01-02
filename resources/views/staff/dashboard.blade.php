@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._staff_sidebar')

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
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-info">
                <div>
                  <img src="{{ config('app.url') }}/images/icons/current_term_icon.png" alt="current_term_icon" class="collins-current-term-icon">
                </div>
                
                
                @if (!$currentterm)

                    <span style="font-size: 2em;">Not Available!</span><br />
                    @if (count($previousterms) >= 1)
                            <a href="{{ route('terms.index') }}" class="btn btn-sm btn-primary" style="margin-top:- 15px;">View session terms</a>
                    @else
                            @if ($staff->manage_session_terms == 'Yes')
                                <a href="{{ route('terms.create') }}" class="btn btn-sm btn-primary" style="margin-top:- 15px;">New term</a>
                            @else
                                There's <b>no active session term</b> at present. Please contact the school admin.
                            @endif
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
            @if ($staff->manage_staff_account == 'Yes')
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('staff.index') }}">
                <img src="{{ config('app.url') }}/images/icons/staff_icon.png" alt="staff_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Staff</div>
                </a>
              </div>
            </div>
            @endif
            @if ($staff->manage_calendars == 'Yes' OR $staff->manage_all_results == 'Yes' )
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('school_settings.index') }}">
                <img src="{{ config('app.url') }}/images/icons/setting_icon.png" alt="setting_icon" class="collins-feature-icon">
                <div class="collins-feature-title">School settings</div>
                </a>
              </div>
            </div>
            @endif
            @if ($staff->manage_subscriptions == 'Yes')
            <div class="col-md-3">
              <div class="collins-feature">
                <a href="{{ route('subscriptions.index') }}">
                <img src="{{ config('app.url') }}/images/icons/subscription_icon.png" alt="subscription_icon" class="collins-feature-icon">
                <div class="collins-feature-title">Subscriptions</div>
                </a>
              </div>
            </div>
            @endif
          </div>

        </div>
      </div>
      
    </div>
  </div>

@endsection