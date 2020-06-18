@extends('layouts.welcome')

@section('title', $title)

@section('content')

<div class="container-fluid">
    <div class="row">
      <div class="col-md-10 offset-md-1">
        <div class="welcome-title">
          @include('partials._messages')
          <h4>Schools available</h4>
        </div>

        <div class="welcome">
            @if (count($schools) < 1)
                <div class="alert alert-info">No school found.</div>
            @else
                <div class="alert alert-info"><b>Info:</b> Click on the name of your school to login.</div>
                <div class="table-responsive">    
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>School</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $school)
                                <tr>
                                    <td><a href="{{ route('welcome.login', $school->id) }}">{{ $school->school }}</a></td>
                                    <td class="text-right"><a href="{{ route('welcome.login', $school->id) }}" class="btn btn-sm btn-primary">Login</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
      </div>
      
    </div>
</div>

@endsection