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
          <h3>{{ $subject->name }}</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('school_settings.index') }}">School settings</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $subject->name }}</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('school_settings.index') }}">School settings</a></li>
                <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $subject->name }}</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="alert alert-info">
            Here's the descriptive information for <strong>{{ $subject->name }}</strong>. To assign or manage this subject, <a href="{{ route('terms.index') }}" class="btn btn-sm btn-primary">select a session term</a>.
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="resource-details">
                    <div class="title">
                        Subject Details
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>{{ $subject->name }}</h4>
                            </div>
                        </div>
                        
                        <div class="table-responsive" style="padding-bottom: 18px;">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <tr>
                                    <th class="bg-light">Brief description:</th>
                                    <td>
                                        {{ $subject->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created by:</th>
                                    <td>
                                        {!! $subject->user->name.' ( <i>'.$subject->user->email.'</i> )' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created at:</th>
                                    <td>
                                        <small>{{ $subject->created_at }}</small>
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
                              <td><a class="btn btn-sm btn-block btn-outline-primary" href="{{ route('subjects.edit', $subject->id) }}">Edit details</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <form method="POST" action="{{ route('subjects.destroy', $subject->id) }}">
                                        @csrf
                                        @method('DELETE')
                    
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} required>
                    
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Click to delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    {{ __('Yes, delete subject') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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

@endsection