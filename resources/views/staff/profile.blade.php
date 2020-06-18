@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container-fluid">
    <div class="row">
      @include('partials._staff_sidebar')

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
                            <div class="col-md-12 text-center">
                                <img src="{{ config('app.url') }}/images/profile/{{ $user->pic }}" alt="My Photo" class="user-pic" >
                            </div>
                        </div>
        
                        <div class="table-responsive" style="padding-bottom: 18px;">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <tr>
                                    <th class="bg-light">Name:</th>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Gender:</th>
                                    <td>
                                        {{ $user->gender }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email:</th>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Role:</th>
                                    <td>
                                        {{ $user->role }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status:</th>
                                    <td>
                                        {{ $user->status }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created at:</th>
                                    <td>
                                        <small>{{ $user->created_at }}</small>
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
  
<!-- HIDDEN MODAL AREA -->
@include('partials._changeownpassword')
<!-- END HIDDEN MODAL AREA -->

@endsection