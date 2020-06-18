@extends('layouts.dashboard')

@section('title', 'Users | ')

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
            <h3>Users</h3>
          </div>
          <div class="col-4 text-right">
            <a href="{{ route('users.create') }}" class="btn btn-primary">New user</a>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Schoobic users</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        @if(count($users) < 1)
            <div class="alert alert-info" sr-only="alert">
                No user.
            </div>
        @else
            <div class="table-responsive">    
            <table class="table table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Users ( Total: {{ count($users) }} )</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $thisuser)
                            <tr>
                                <td>{{ $thisuser->name }} ( <i>{{ $thisuser->email }}</i> )</td>
                                <td class="text-right"><a href="{{ route('users.show', $thisuser->id) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        @endif
    </div>
  </div>

@endsection