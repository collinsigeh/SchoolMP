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
          <h3>{{ $item->name.' of '.$item->currency_symbol.' '.$item->amount }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
              <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Fees and other items</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $item->name.' of '.$item->currency_symbol.' '.$item->amount }}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('items.update', $item->id) }}">
                @csrf
                @method('PUT')

                <input type="hidden" class="form-control @error('term') is-invalid @enderror" name="term" value="{{ $term->name.' '.$term->session }}" required>
                <div class="form-group row"> 
                    <label for="visible-term" class="col-md-4 col-form-label text-md-right">{{ __('Session term') }}</label>

                    <div class="col-md-6">
                        <input id="visible-term" type="text" class="form-control @error('visible-term') is-invalid @enderror" name="visible-term" value="{{ $term->name.' '.$term->session }}" required autocomplete="visible-term" autofocus disabled>

                        @error('visible-term')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Item name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $item->name }}" placeholder="E.g. School fees" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <input type="hidden" name="currency_symbol" value="{{ $item->currency_symbol }}" required />
                <div class="form-group row"> 
                    <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount ('.$item->currency_symbol.')') }}</label>

                    <div class="col-md-6">
                        <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $item->amount }}" placeholder="E.g. 6750.00" required autocomplete="amount" autofocus>
                        <small class="text-muted">Amount only.</small>

                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="schoolclass_id" class="col-md-4 col-form-label text-md-right">{{ __('Classes affected') }}</label>

                    <div class="col-md-6">
                        <div class="alert alert-info">Tick the class arms that this item applies to.</div>
                        <div class="row">
                            <?php $arm_count = 0; ?>
                            @foreach ($schoolclasses as $schoolclass)
                                <div class="col-md-6">
                                    <div style="border: solid 1px #e2e2e2; background-color: #fff; margin: 3px 0; padding: 7px 10px;">
                                        <span class="badge badge-info">{{ $schoolclass->name }} classes</span>
                                        <?php $class_displayed = 0; ?>
                                        @foreach ($schoolclass->arms as $arm)
                                            <div style="vertical-align: middle; padding: 5px 0 5px 10px;">
                                                <input type="checkbox" name="{{ $arm_count }}" id="{{ $arm_count }}" value="{{ $arm->id }}"
                                                @foreach ($item->arms as $affected_arm)
                                                    @if ($affected_arm->id == $arm->id)
                                                        {{ 'checked' }}
                                                    @endif
                                                @endforeach
                                                > &nbsp;&nbsp;<label for="{{ $arm_count }}">{{ $schoolclass->name.' '.$arm->name }}</label>
                                            </div>
                                            <?php $class_displayed++; $arm_count++; ?>
                                        @endforeach
                                        <?php if($class_displayed == 0){ echo '<div style="vertical-align: middle; padding: 5px 0 5px 10px;"><b>None!</b></div>'; } ?>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="arm_count" value="{{ $arm_count }}" required />
                        <div style="padding: 15px;"></div>
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

@endsection