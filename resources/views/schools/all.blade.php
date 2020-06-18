@extends('layouts.dashboard')

@section('title', 'Orders | ')

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
            <h3>Schools</h3>
          </div>
          <div class="col-4 text-right">
              
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ config('app.url') }}/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Schools</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($schools) < 1)
            <div class="alert alert-info" sr-only="alert">
                None available.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>School</th>
                            <th>phone</th>
                            <th>email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schools as $school)
                            <tr>
                                <td>
                                    <span style="font-size: 1.1em; font-weight: 700;">{{ $school->school }}</span><br />
                                    {{ $school->address }}
                                </td>
                                <td>{{ $school->phone }}</td>
                                <td>{{ $school->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $schools->links() }}
        @endif
    </div>
  </div>

@endsection