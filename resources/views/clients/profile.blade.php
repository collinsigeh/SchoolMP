@extends('layouts.dashboard')

@section('title', 'My Profile | ')

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._clients_sidebar')

      <div class="col-md-10 main">
        <div class="row">
          <div class="col-8">
            <h3>My profile</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">My profile</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        Profile Details
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-10 offset-md-2">
                                <img src="{{ config('app.url') }}/images/profile/{{ $user->pic }}" alt="My Photo" class="user-pic" >
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-2">
                                Name:
                            </div>
                            <div class="col-md-10">
                                <h4>{{ $user->name }}</h4>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-2">
                                Gender:
                            </div>
                            <div class="col-md-10">
                                {{ $user->gender }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Email:
                            </div>
                            <div class="col-md-10">
                                {{ $user->email }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Role:
                            </div>
                            <div class="col-md-10">
                                {{ $user->role }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                Status:
                            </div>
                            <div class="col-md-10">
                                {{ $user->status }}
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <small>Profile since:</small>
                            </div>
                            <div class="col-md-10">
                                <small>{{ $user->created_at }}</small>
                            </div>
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
                              <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('profile.edit') }}">Edit profile</a></td>
                            </tr>
                            <tr>
                                <td>
                                    @include('partials._changeownpassword_option')
                                </td>
                            </tr>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>

      </div>
      
    </div>
  </div>

  @include('partials._changeownpassword')

@endsection