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
            <h3>Result templates</h3>
          </div>
          <div class="col-4 text-right">
              @if ($user->role == 'Staff')
                  @if ($staff->manage_calendars == 'Yes')
                    <a href="{{ route('resulttemplates.create') }}" class="btn btn-primary">New template</a>
                  @endif
              @else
                  <a href="{{ route('resulttemplates.create') }}" class="btn btn-primary">New template</a>
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
                <li class="breadcrumb-item active" aria-current="page">Result templates</li>
              @else
                <li class="breadcrumb-item"><a href="{{ config('app.url') }}/schools">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Result templates</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($templates) < 1)
            <div class="alert alert-info" sr-only="alert">
                <p>None available.</p>Click on the <b>new template</b> button at the top-right corner to start creating result templates.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Result templates</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($templates as $template)
                            <tr>
                                <td>{{ $template->name }}</td>
                                <td class="text-right"><a href="{{ route('resulttemplates.show', $template->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $templates->links() }}
        @endif
    </div>
  </div>

@endsection