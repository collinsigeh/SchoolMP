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
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Special note (Optional):') }}</label>
                    
                    <div class="col-md-6">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

                    <div class="col-md-6">
                        <select id="status" type="text" class="form-control @error('status') is-invalid @enderror" name="status" autocomplete="status" autofocus>
                            <option value="Pending" <?php if($itempayment->status == 'Pending'){ echo 'selected'; } ?>>Pending confirmation</option>
                            <option value="Declined" <?php if($itempayment->status == 'Declined'){ echo 'selected'; } ?>>Declined</option>
                            <option value="Confirmed" <?php if($itempayment->status == 'Confirmed'){ echo 'selected'; } ?>>Confirmed</option>
                        </select>

                        @error('status')
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
                            {{ date('D, d-M-Y', strtotime($itempayment->created_at)).' @ '.date('h:i A', strtotime($itempayment->created_at)) }}
                        </div>
                    </div>
                </div>
                
                @if ($itempayment->user_id >= 1)
                <div class="form-group row"> 
                    <label for="recorded_by" class="col-md-4 col-form-label text-md-right">{{ __('Recorded by') }}</label>

                    <div class="col-md-6">
                        <div class="alert alert-info">
                            {{ $itempayment->user->name }}
                            @if ($itempayment->user->role == 'Staff')<br />
                            <span class="badge badge-secondary">{{ $itempayment->user->staff->designation }}</span><br />
                            <small>{{ $itempayment->user->email }} | {{ $itempayment->user->staff->phone }}</small>
                            @else
                            <span class="badge badge-secondary">{{ $itempayment->user->role }}</span><br />
                            <small>{{ $itempayment->user->email }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @if ($itempayment->created_at != $itempayment->updated_at)
                    <div class="form-group row"> 
                        <label for="updated_at" class="col-md-4 col-form-label text-md-right">{{ __('Last updated on') }}</label>

                        <div class="col-md-6">
                            <div class="alert alert-info">
                                {{ date('D, d-M-Y', strtotime($itempayment->updated_at)).' @ '.date('h:i A', strtotime($itempayment->updated_at)) }}
                            </div>
                        </div>
                    </div>
                    
                    @if ($itempayment->updated_by >= 1)
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