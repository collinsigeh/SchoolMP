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
              <p>None available.</p>Click on the <b>new director</b> button at the top-right corner to start creating director accounts.
            </div>
        @else
          <div class="alert alert-info" sr-only="alert">
              Here's a list of directors at {{ $school->school }}.
          </div>
          <div class="collins-bg-white">
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <tbody>
                        @foreach ($directors as $director)
                            <tr>
                                <td><a class="collins-link-within-table" href="{{ route('directors.show', $director->id) }}"><img src="{{ config('app.url') }}/images/profile/{{ $director->user->pic }}" alt="director_icon" class="collins-table-item-icon"> {{ $director->user->name }} ( <i>{{ $director->user->email }}</i> )</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $directors->links() }}
          </div>
        @endif
    </div>
  </div>

@endsection