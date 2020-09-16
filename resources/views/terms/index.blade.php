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
            <h3>Session terms</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_session_terms == 'Yes')
                    <a href="{{ route('terms.create') }}" class="btn btn-primary">New term</a>
                  @endif
              @else
                  <a href="{{ route('terms.create') }}" class="btn btn-primary">New term</a>
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
                <li class="breadcrumb-item active" aria-current="page">Session terms</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Session terms</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($terms) < 1)
            <div class="alert alert-info" sr-only="alert">
              <p>None available.</p>Click on the <b>new term</b> button at the top-right corner to start creating session terms to manage.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Session terms</th>
                            <th>No. of classarms</th>
                            <th>No. of students</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($terms as $term)
                            <tr>
                                <td>{!! '<b>'.$term->name.'</b> - <small><i>'.$term->session.'<i></small>' !!}</td>
                                <td>{{ count($term->arms) }}</td>
                                <td>{{ count($term->enrolments) }}</td>
                                <td class="text-right"><a href="{{ route('terms.show', $term->id) }}" class="btn btn-sm btn-outline-primary">Enter</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $terms->links() }}
        @endif
    </div>
  </div>

@endsection