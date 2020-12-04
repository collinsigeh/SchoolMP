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
          <h3>Term information {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small></i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('terms.index') }}">Session terms</a></li>
              <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('terms.update', $term->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group row"> 
                    <label for="session" class="col-md-4 col-form-label text-md-right">{{ __('Session') }}</label>

                    <div class="col-md-6">
                        <select id="session" type="text" class="form-control @error('session') is-invalid @enderror" name="session" required autocomplete="session" autofocus @if ($term_editable == 'No')
                            {{ 'disabled' }}
                        @endif>
                            <option value="{{ $term->session }}">{{ $term->session }}</option>
                            <option value="{{ $session['option1'] }}">{{ $session['option1'] }}</option>
                            <option value="{{ $session['option2'] }}">{{ $session['option2'] }}</option>
                            <option value="{{ $session['option3'] }}">{{ $session['option3'] }}</option>
                        </select>

                        @error('session')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Term name') }}</label>

                    <div class="col-md-6">
                        <select id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus @if ($term_editable == 'No')
                        {{ 'disabled' }}
                    @endif>
                            <option value="1st Term" @if ($term->name == '1st Term')
                                {{ 'selected' }}
                            @endif>1st Term</option>
                            <option value="2nd Term" @if ($term->name == '2nd Term')
                                {{ 'selected' }}
                            @endif>2nd Term</option>
                            <option value="3rd Term" @if ($term->name == '3rd Term')
                                {{ 'selected' }}
                            @endif>3rd Term</option>
                            <option value="Summer Classes" @if ($term->name == 'Summer Classes')
                                {{ 'selected' }}
                            @endif>Summer Classes</option>
                            <option value="Special Classes" @if ($term->name == 'Special Classes')
                                {{ 'selected' }}
                            @endif>Special Classes</option>
                        </select>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="no_of_weeks" class="col-md-4 col-form-label text-md-right">{{ __('No. of weeks') }}</label>

                    <div class="col-md-6">
                        <input id="no_of_weeks" type="number" class="form-control @error('no_of_weeks') is-invalid @enderror" name="no_of_weeks" value="{{ $term->no_of_weeks }}" required autocomplete="no_of_weeks" autofocus>
                        <small class="text-muted">Hint: how many weeks will this term be. E.g. 14</small>

                        @error('no_of_weeks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="resumption_date" class="col-md-4 col-form-label text-md-right">{{ __('Resumption date') }}</label>

                    <div class="col-md-6">
                        <input id="resumption_date" type="date" class="form-control @error('resumption_date') is-invalid @enderror" name="resumption_date" value="{{ $term->resumption_date }}" required autocomplete="resumption_date" autofocus>
                        <small class="text-muted">Hint: what date will the term start. E.g. 7th January, 2020</small>

                        @error('resumption_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="closing_date" class="col-md-4 col-form-label text-md-right">{{ __('Closing date') }}</label>

                    <div class="col-md-6">
                        <input id="closing_date" type="date" class="form-control @error('closing_date') is-invalid @enderror" name="closing_date" value="{{ $term->closing_date }}" required autocomplete="closing_date" autofocus>
                        <small class="text-muted">Hint: what date will the term close. E.g. 14th April, 2020</small>

                        @error('closing_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="next_term_resumption_date" class="col-md-4 col-form-label text-md-right">{{ __('Next term resumption date (Optional)') }}</label>

                    <div class="col-md-6">
                        <input id="next_term_resumption_date" type="date" class="form-control @error('next_term_resumption_date') is-invalid @enderror" name="next_term_resumption_date" value="{{ $term->next_term_resumption_date }}" autocomplete="next_term_resumption_date" autofocus>

                        @error('next_term_resumption_date')
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

@endsection