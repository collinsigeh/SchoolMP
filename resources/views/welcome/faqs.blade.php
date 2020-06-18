@extends('layouts.welcome')

@section('title', $title)

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="welcome-title">
          @include('partials._messages')
          <h4>FAQs</h4>
        </div>

        <div class="welcome">
            <div class="alert alert-info">Coming soon...</div>
        </div>
      </div>
      
    </div>
</div>

@endsection