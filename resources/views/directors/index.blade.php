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
            <h3>School Directors</h3>
          </div>
          <div class="col-4 text-right">
            @if ($resource_manager)
              <a href="{{ route('directors.create') }}" class="btn btn-primary">New director</a>
            @endif
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('schools.index') }}">Schools</a></li>
                <li class="breadcrumb-item"><a href="{{ route('schools.show', $school->id) }}">{{ $school->school }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Directors</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Directors</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($directors) < 1)
            <div class="alert alert-info" sr-only="alert">
                No director.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Diretors of {{ $school->school }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($directors as $director)
                            <tr>
                                <td>{{ $director->user->name }} ( <i>{{ $director->user->email }}</i> )</td>
                                <td class="text-right"><a href="{{ route('directors.show', $director->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $directors->links() }}
        @endif
    </div>
  </div>

@endsection