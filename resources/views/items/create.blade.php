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
            <h3>New fee item</h3>
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
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Fees and other items</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
              @else
              <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Fees and other items</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('items.store') }}">
                @csrf

                <input type="hidden" class="form-control @error('term') is-invalid @enderror" name="term" value="{{ $term->name.' '.$term->session }}" required>
                <div class="form-group row"> 
                    <label for="visible-term" class="col-md-4 col-form-label text-md-right">{{ __('Term') }}</label>

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
                    <label for="schoolclass_id" class="col-md-4 col-form-label text-md-right">{{ __('Class(es) concerned') }}</label>

                    <div class="col-md-6">
                        <select id="schoolclass_id" type="text" class="form-control @error('schoolclass_id') is-invalid @enderror" name="schoolclass_id" required autocomplete="schoolclass_id" autofocus>
                            <option value="0">All classes</option>
                            @php
                                foreach($schoolclasses as $schoolclass)
                                {
                                    echo '<option value="'.$schoolclass->id.'">'.$schoolclass->name.'</option>';
                                }
                            @endphp
                        </select>

                        @error('schoolclass_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Item name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="E.g. Schoolfees for primary1" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Item type') }}</label>

                    <div class="col-md-6">
                        <select id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" required autocomplete="type" autofocus>
                            <option value="School fee">School fee</option>
                            <option value="Other items">Other items</option>
                        </select>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="nature" class="col-md-4 col-form-label text-md-right">{{ __('Nature') }}</label>

                    <div class="col-md-6">
                        <select id="nature" type="text" class="form-control @error('nature') is-invalid @enderror" name="nature" required autocomplete="nature" autofocus>
                            <option value="Compulsory">Compulsory</option>
                            <option value="Optional">Optional</option>
                        </select>

                        @error('nature')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount ('.$setting->base_currency_symbol.')') }}</label>

                    <div class="col-md-6">
                        <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" placeholder="E.g. 6750.00" required autocomplete="amount" autofocus>
                        <small class="text-muted">Amount only.</small>

                        @error('amount')
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

@endsection