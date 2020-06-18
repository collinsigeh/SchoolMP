@extends('layouts.welcome')

@section('title', $title)

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="welcome-title">
          @include('partials._messages')
          <h4>Oops!</h4>
        </div>

        <div class="welcome">
            <div class="alert alert-info">
              <p>Improper login attempt!</p>Please logout and re-login.
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                     {{ __('Logout') }}
                 </a>

                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf

                     <input type="hidden" name="usertype" value="{{ Auth::user()->usertype }}">
                     <input type="hidden" name="school_id" value="{{ session('school_id') }}">
                 </form>
            </div>
        </div>
      </div>
      
    </div>
</div>

@endsection