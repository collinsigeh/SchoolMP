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
          <h3>{{ $expense->currency_symbol.' '.number_format($expense->amount, 2).' expense for '.substr($expense->description, 0, 12) }} 
            @if (strlen($expense->description) > 12)
              {{ '...' }}
            @endif
          </h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
              <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $expense->currency_symbol.' '.number_format($expense->amount, 2).' expense for '.substr($expense->description, 0, 12) }} 
                @if (strlen($expense->description) > 12)
                  {{ '...' }}
                @endif
              </li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('expenses.update', $expense->id) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group row">
                    <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

                    <div class="col-md-6">
                        <div class="alert alert-info">
                            {{ $expense->currency_symbol.' '.number_format($expense->amount, 2) }}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                    
                    <div class="col-md-6">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Brief description of payment" required>{{ $expense->description }}</textarea>
                        
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="recipient" class="col-md-4 col-form-label text-md-right">{{ __('Recipient') }}</label>

                    <div class="col-md-6">
                        <div class="alert alert-info">
                            {{ $expense->recipient_name }}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="recipient_phone" class="col-md-4 col-form-label text-md-right">{{ __('Recipient phone (Optional)') }}</label>
                    
                    <div class="col-md-6">
                        <input id="recipient_phone" type="text" class="form-control @error('recipient_phone') is-invalid @enderror" name="recipient_phone" value="{{ $expense->recipient_phone }}" autocomplete="recipient_phone" autofocus>
                        
                        @error('recipient_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="created_at" class="col-md-4 col-form-label text-md-right">{{ __('Date recorded') }}</label>

                    <div class="col-md-6">
                        <div class="alert alert-info">
                            {{ date('D, d-M-Y', strtotime($expense->created_at)).' @ '.date('h:i A', strtotime($expense->created_at)) }}
                        </div>
                    </div>
                </div>
                
                @if ($expense->user_id >= 1)
                <div class="form-group row"> 
                    <label for="recorded_by" class="col-md-4 col-form-label text-md-right">{{ __('Recorded by') }}</label>

                    <div class="col-md-6">
                        <div class="alert alert-info">
                            {{ $expense->user->name }}
                            @if ($expense->user->role == 'Staff')<br />
                            <span class="badge badge-secondary">{{ $expense->user->staff->designation }}</span><br />
                            <small>{{ $expense->user->email }} | {{ $expense->user->staff->phone }}</small>
                            @else
                            <span class="badge badge-secondary">{{ $expense->user->role }}</span><br />
                            <small>{{ $expense->user->email }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if ($expense->created_at != $expense->updated_at)
                    <div class="form-group row"> 
                        <label for="updated_at" class="col-md-4 col-form-label text-md-right">{{ __('Last updated on') }}</label>

                        <div class="col-md-6">
                            <div class="alert alert-info">
                                {{ date('D, d-M-Y', strtotime($expense->updated_at)).' @ '.date('h:i A', strtotime($expense->updated_at)) }}
                            </div>
                        </div>
                    </div>
                    
                    @if ($expense->updated_by >= 1)
                        <div class="form-group row"> 
                            <label for="updated_by" class="col-md-4 col-form-label text-md-right">{{ __('Last updated by') }}</label>

                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    {{ $last_updated_by->name }}
                                    @if ($last_updated_by->role == 'Staff')<br />
                                    <span class="badge badge-secondary">{{ $last_updated_by->staff->designation }}</span><br />
                                    <small>{{ $last_updated_by->email }} | {{ $last_updated_by->staff->phone }}</small>
                                    @else
                                    <span class="badge badge-secondary">{{ $last_updated_by->role }}</span><br />
                                    <small>{{ $last_updated_by->email }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

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