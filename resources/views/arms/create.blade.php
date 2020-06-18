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
            <h3>New arm</h3>
          </div>
          <div class="col-4 text-right">
            
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              @if ($user->usertype == 'Client')
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.index') }}">Class arms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
              @else
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('arms.index') }}">Class arms</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
              @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="create-form">
            <form method="POST" action="{{ route('arms.store') }}">
                @csrf

                <div class="form-group row"> 
                    <label for="schoolclass_id" class="col-md-4 col-form-label text-md-right">{{ __('School class ID') }}</label>

                    <div class="col-md-6">
                        <select id="schoolclass_id" type="text" class="form-control @error('schoolclass_id') is-invalid @enderror" name="schoolclass_id" required autocomplete="schoolclass_id" autofocus>
                            @php
                                foreach($schoolclasses as $schoolclass)
                                {
                                    echo '<option value="'.$schoolclass->id.'">'.$schoolclass->name.'</option>';
                                }
                            @endphp
                        </select>

                        @error('schoolclass_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                <div class="form-group row"> 
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Class arm name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <small class="text-muted">Examples include: A, B, C, Class, Gold Class, Eagle Class, Pearl Class, etc.</small>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="resulttemplate_id" class="col-md-4 col-form-label text-md-right">{{ __('Result template') }}</label>

                    <div class="col-md-6">
                        <select id="resulttemplate_id" type="text" class="form-control @error('resulttemplate_id') is-invalid @enderror" name="resulttemplate_id" required autocomplete="resulttemplate_id" autofocus>
                            @php
                                foreach($resulttemplates as $template)
                                {
                                    echo '<option value="'.$template->id.'">'.$template->name.'</option>';
                                }
                            @endphp
                        </select>

                        @error('resulttemplate_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row"> 
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Brief description (Optional):') }}</label>
                    
                    <div class="col-md-6">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Maybe a little about this arm. E.g. Science class">{{ old('description') }}</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
  </div>

@endsection