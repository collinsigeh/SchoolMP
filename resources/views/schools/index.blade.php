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
              <p>None available.</p>Click on the <b>new school</b> button at the top-right corner to start adding schools to manage.
            </div>
        @else
            <div class="alert alert-info" sr-only="alert">
                Here's a list of your schools. Click on a school to manage it.
            </div>
            <div class="collins-bg-white">
              <div class="table-responsive">    
                  <table class="table table-striped table-hover table-sm">
                      <tbody>
                          @foreach ($schools as $school)
                              <tr>
                                  <td><a class="collins-link-within-table" href="{{ route('schools.show', $school->id) }}"><img src="{{ config('app.url') }}/images/icons/school_icon.png" alt="schools_icon" class="collins-table-item-icon"> {{ $school->school }}</a></td>
                              <td class="text-right"><a href="{{ route('schools.edit', $school->id) }}" title="Edit"><img src="{{ config('app.url') }}/images/icons/edit_icon.png" alt="Edit" class="collins-edit-table-item-icon"></a></td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              {{ $schools->links() }}
            </div>
        @endif
    </div>
  </div>

@endsection