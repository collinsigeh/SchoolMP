@extends('layouts.dashboard')

@section('title', 'User details | ')

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
          <h3>{{ $thisuser->name }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Schoobic users</a></li>
              <li class="breadcrumb-item active" aria-current="page">{{ $thisuser->name }}</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        User's Details
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <img src="{{ config('app.url') }}/images/profile/{{ $thisuser->pic }}" alt="Photo" class="user-pic" >
                            </div>
                        </div>
                        
                        <div class="table-responsive" style="padding-bottom: 18px;">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <tr>
                                    <th class="bg-light">Name:</th>
                                    <td>
                                        {{ $thisuser->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Gender:</th>
                                    <td>
                                        {{ $thisuser->gender }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email:</th>
                                    <td>
                                        {{ $thisuser->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">User type:</th>
                                    <td>
                                        {{ $thisuser->usertype }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Role:</th>
                                    <td>
                                        {{ $thisuser->role }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status:</th>
                                    <td>
                                        {{ $thisuser->status }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">User since:</th>
                                    <td>
                                        <small>{{ $thisuser->created_at }}</small>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="resource-details">
                    <div class="title">
                        More options
                    </div>
                    <div class="body">
                      <div class="table-responsive">    
                        <table class="table">
                            <tr>
                              <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('users.edit', $thisuser->id) }}">Edit details</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#changeUserPasswordModal">
                                        Change password
                                    </button>
                                </td>
                            </tr>
                            @if ($user->id !== $thisuser->user_id)
                                <tr>
                                    <td>
                                        <form method="POST" action="{{ route('users.destroy', $thisuser->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} required>
                        
                                                        <label class="form-check-label" for="remember">
                                                            {{ __('Check to delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        {{ __('Yes, delete user') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  
    <!-- changeUserPasswordModal -->
    <div class="modal fade" id="changeUserPasswordModal" tabindex="-1" role="dialog" aria-labelledby="changeUserPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="changeUserPasswordModalLabel">Change User Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="create-form">
                    <form method="POST" action="{{ route('users.changeuserpassword', $thisuser->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">User</label>

                            <div class="col-md-6">
                                {{ $thisuser->name }}<br />(<b>{{ $thisuser->email }}</b>)
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
            
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
        
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save changes') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
    </div>
    <!-- End changeUserPasswordModal -->

@endsection
