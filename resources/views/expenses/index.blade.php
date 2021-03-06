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
            <h3>Expenses {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small></i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_class_arms == 'Yes')
                    <a href="{{ route('expenses.create') }}" class="btn btn-primary">New expense</a>
                  @endif
              @else
                  <a href="{{ route('expenses.create') }}" class="btn btn-primary">New expense</a>
              @endif
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Expenses</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Expenses</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($expenses) < 1)
            <div class="alert alert-info" sr-only="alert">
                None available.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th colspan="2"  style="vertical-align: middle;">Amount</th>
                            <th style="vertical-align: middle;">Item paid for</th>
                            <th style="vertical-align: middle;">Recipient</th>
                            <th class="text-right" style="vertical-align: middle;">Date recorded</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td style="width: 50px; vertical-align: middle;"><img src="{{ config('app.url') }}/images/icons/voucher_icon.png" alt="expense_icon" class="collins-table-item-icon"></td>
                                <td style="vertical-align: middle;"><a class="collins-link-within-table" href="{{ route('expenses.edit', $expense->id) }}"><b>{{ $expense->currency_symbol.' '.number_format($expense->amount, 2) }}</b></a></td>
                                <td style="vertical-align: middle;">
                                  {{ substr($expense->description, 0, 35) }}
                                  @if (strlen($expense->description) > 35)
                                      {{ '...' }}
                                  @endif
                                </td>
                                <td style="vertical-align: middle;">{{ $expense->recipient_name }}</td>
                                <td class="text-right" style="vertical-align: middle;"><small>{{ date('D, d-M-Y', strtotime($expense->created_at)) }}</small></td>
                                <td class="text-right" style="vertical-align: middle;">
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-outline-primary">Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $expenses->links() }}
        @endif
    </div>
  </div>

@endsection