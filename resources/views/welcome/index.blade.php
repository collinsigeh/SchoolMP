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
                <div class="collins-bg-white">
                    <div class="table-responsive">    
                        <table class="table table-striped table-hover table-sm">
                            <tbody>
                                @foreach ($schools as $school)
                                    <tr>
                                        <td><a class="collins-link-within-table" href="{{ route('welcome.login', $school->id) }}"><img src="{{ config('app.url') }}/images/icons/school_icon.png" alt="schools_icon" class="collins-table-item-icon"> {{ $school->school }}</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
      </div>
      
    </div>
</div>

@endsection