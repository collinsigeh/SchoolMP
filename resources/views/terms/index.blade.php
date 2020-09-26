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
          <div class="alert alert-info" sr-only="alert">
              Available session terms for {{ $school->school }}.
          </div>
          <div class="collins-bg-white">
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <tbody>
                        @foreach ($terms as $term)
                            <tr>
                                <td><a class="collins-link-within-table" href="{{ route('terms.show', $term->id) }}"><img src="{{ config('app.url') }}/images/icons/terms_icon.png" alt="term_icon" class="collins-table-item-icon"> {!! '<b>'.$term->name.'</b> - <small><i>'.$term->session.'<i></small>' !!}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $terms->links() }}
          </div>
        @endif
    </div>
  </div>

@endsection