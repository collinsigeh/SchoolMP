@extends('layouts.dashboard')

@section('title', 'Bank details | ')

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
            <h3>Bank details</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('bankdetails.create') }}" class="btn btn-primary">New bank account</a>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Bank details</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($bankdetails) == 0)
            <div class="alert alert-info" sr-only="alert">
                No bank account details yet.
            </div>
        @else
            <div class="collins-bg-white">
              <div class="table-responsive">    
                  <table class="table table-striped table-hover table-sm">
                      <tbody>
                          @foreach ($bankdetails as $bankdetail)
                              <tr>
                                  <td><a class="collins-link-within-table" href="{{ route('bankdetails.edit', $bankdetail->id) }}"><img src="{{ config('app.url') }}/images/icons/wallet_icon.png" alt="wallet_icon" class="collins-table-item-icon"> {{ $bankdetail->bankname }}</a></td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              {{ $bankdetails->links() }}
            </div>
        @endif
    </div>
  </div>

@endsection