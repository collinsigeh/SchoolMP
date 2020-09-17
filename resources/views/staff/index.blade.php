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
            <h3>Staff</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('staff.create') }}" class="btn btn-primary">New staff</a>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.index') }}">Schools</a></li>
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Staffs</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Staff</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>
        
        @if(count($allstaff) < 1)
            <div class="alert alert-info" sr-only="alert">
              <p>None available.</p>Click on the <b>new staff</b> button at the top-right corner to start creating staff accounts.
            </div>
        @else
          <div class="alert alert-info" sr-only="alert">
              Here's a list of staff members at {{ $school->school }}.
          </div>
          <div class="collins-bg-white">
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <tbody>
                        @foreach ($allstaff as $employee)
                            <tr>
                                <td><a class="collins-link-within-table" href="{{ route('staff.show', $employee->id) }}"><img src="{{ config('app.url') }}/images/profile/{{ $employee->user->pic }}" alt="staff_icon" class="collins-table-item-icon"> {{ $employee->user->name }} ( <i>{{ $employee->designation }}</i> )</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $allstaff->links() }}
          </div>
        @endif
    </div>
  </div>

@endsection