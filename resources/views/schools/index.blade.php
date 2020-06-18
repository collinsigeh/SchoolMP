@extends('layouts.dashboard')

@section('title', 'My Schools | ')

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._clients_sidebar')

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
            <h3>My schools</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('schools.create') }}" class="btn btn-primary">New school</a>
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

        @if(count($user->schools) < 1)
            <div class="alert alert-info" sr-only="alert">
                No school.
            </div>
        @else
            <div class="table-responsive">    
                <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Schools under management</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schools as $school)
                            <tr>
                                <td>{{ $school->school }}</td>
                                <td class="text-right"><a href="{{ route('schools.show', $school->id) }}" class="btn btn-sm btn-primary">Enter</a></td>
                            <td class="text-right"><a href="{{ route('schools.edit', $school->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
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