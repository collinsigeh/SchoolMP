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
            <h3>New student payment</h3>
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
                <li class="breadcrumb-item"><a href="{{ route('itempayments.index') }}">Payments received</a></li>
                <li class="breadcrumb-item active" aria-current="page">New payment</li>
              @else
              <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('itempayments.index') }}">Payments received</a></li>
                <li class="breadcrumb-item active" aria-current="page">New payment</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('itempayments.store') }}">
                @csrf

                <input type="hidden" name="return_page" value="itempayments_index">

                <div class="form-group row">
                    <label for="enrolment_id" class="col-md-4 col-form-label text-md-right">{{ __('Student\'s Enrolment ID') }}</label>
                    
                    <div class="col-md-6">
                        <input id="enrolment_id" type="number" class="form-control @error('enrolment_id') is-invalid @enderror" name="enrolment_id" value="{{ old('enrolment_id') }}" required autocomplete="enrolment_id" autofocus>
                        <small class="text-muted">*** Enter zero ( <b>0</b> ) for non-student payments ***</small>
                        @error('enrolment_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="item_paid_for" class="col-md-4 col-form-label text-md-right">{{ __('Item paid for') }}</label>

                    <div class="col-md-6">
                        <select id="item_paid_for" type="text" class="form-control @error('item_paid_for') is-invalid @enderror" name="item_paid_for" autocomplete="item_paid_for" autofocus>
                            @php
                                foreach ($items as $item) {
                                    echo '<option value="'.$item->id.'">'.$item->name.'</option>';
                                }
                            @endphp
                            <option value="0">No specific item</option>
                        </select>

                        @error('item_paid_for')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="currency_symbol" value="{{ $setting->base_currency_symbol }}">
                <div class="form-group row">
                    <label for="amount_received" class="col-md-4 col-form-label text-md-right">{{ __('Amount ('.$setting->base_currency_symbol.')') }}</label>

                    <div class="col-md-6">
                        <input id="amount_received" type="text" class="form-control @error('amount_received') is-invalid @enderror" name="amount_received" value="{{ old('amount_received') }}" required autocomplete="amount_received" autofocus>
                        <small class="text-muted">*** Enter amount only. <b>E.g. 450.75</b> ***</small>
                        @error('amount_received')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="method_of_payment" class="col-md-4 col-form-label text-md-right">{{ __('Method of payment') }}</label>

                    <div class="col-md-6">
                        <select id="method_of_payment" type="text" class="form-control @error('method_of_payment') is-invalid @enderror" name="method_of_payment" autocomplete="method_of_payment" autofocus>
                            <option value="Offline (Cash)">Offline (Cash)</option>
                            <option value="Offline (Bank deposit)">Offline (Bank deposit)</option>
                            <option value="Online">Online</option>
                        </select>

                        @error('method_of_payment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="special_note" class="col-md-4 col-form-label text-md-right">{{ __('Special note (Optional):') }}</label>
                    
                    <div class="col-md-6">
                        <textarea id="special_note" class="form-control @error('special_note') is-invalid @enderror" name="special_note">{{ old('special_note') }}</textarea>

                        @error('special_note')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <input type="hidden" name="status" value="Confirmed">

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

@endsection