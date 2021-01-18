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
          <h3>{!! $classsubject->subject->name.' (<i>New video lesson</i>)' !!}</h3>
          </div>
          <div class="col-4 text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#newLessonModal">New resource</button>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', $classsubject->id) }}">{{ $classsubject->subject->name.' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('lessons.listing', $classsubject->id) }}">Lessons</a></li>
                <li class="breadcrumb-item active" aria-current="page">New video</li>
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">

            <div class="row">
                <div class="col-md-6 offset-md-4">
                    <div class="alert alert-info">Complete the form below to add a new video lesson.</div>
                </div>
            </div>

            <div class="create-form">
                <form method="POST" action="{{ route('lessons.store') }}">
                    @csrf
                    
                    <input type="hidden" name="classsubject_id" value="{{ $classsubject->id }}">
                    <div class="form-group row"> 
                        <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Subject') }}</label>
    
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $classsubject->subject->name }}" disabled>
                        </div>
                    </div>
                    
                    <div class="form-group row"> 
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name of lesson') }}</label>
    
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="E.g. Lesson 001: Introduction" required autocomplete="name" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="type" value="Video">

                    <div class="form-group row"> 
                        <label for="medialink" class="col-md-4 col-form-label text-md-right">{{ __('Media link') }}</label>
    
                        <div class="col-md-6">
                            <input id="medialink" type="text" class="form-control @error('medialink') is-invalid @enderror" name="medialink" value="{{ old('medialink') }}" placeholder="E.g. https://youtube.com/v5hOD7sol88/" required autocomplete="medialink" autofocus>
                            <small class="text-muted">*** External URL link to the video ***</small>
                            @error('medialink')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="schoolclass_id" class="col-md-4 col-form-label text-md-right">{{ __('Classes affected') }}</label>
    
                        <div class="col-md-6">
                            <div class="alert alert-info">Tick the classes that will use the lesson.</div>
                            <div class="row">
                                <?php $arm_count = 0; ?>
                                @foreach ($school->schoolclasses as $schoolclass)
                                    <div class="col-md-6">
                                        <div style="border: solid 1px #e2e2e2; background-color: #fff; margin: 3px 0; padding: 7px 10px;">
                                            <span class="badge badge-info">{{ $schoolclass->name }} classes</span>
                                            <?php $class_displayed = 0; ?>
                                            @foreach ($schoolclass->arms as $this_arm)
                                                <?php 
                                                $show_classarm = 'No';
                                                if($this_arm->term_id == $term->id)
                                                { // ensure the class arms are applicable for that term & that the staff is responsible for the classsubject
                                                    foreach($this_arm->classsubjects as $this_classsubject)
                                                    {
                                                        if($this_classsubject->term_id == $term->id && $this_classsubject->user_id == $user->id && $this_classsubject->subject_id == $classsubject->subject_id)
                                                        {
                                                            $show_classarm = 'Yes';
                                                        }
                                                    }
                                                    if($show_classarm == 'Yes')
                                                    {
                                                    ?>
                                                        <div style="vertical-align: middle; padding: 5px 0 5px 10px;">
                                                            <input type="checkbox" name="{{ $arm_count }}" id="{{ $arm_count }}" value="{{ $this_arm->id }}"> &nbsp;&nbsp;<label for="{{ $arm_count }}">{{ $schoolclass->name.' '.$this_arm->name }}</label>
                                                        </div>
                                                    <?php
                                                    $class_displayed++; $arm_count++;
                                                    }
                                                }
                                                ?>
                                            @endforeach
                                            <?php if($class_displayed == 0){ echo '<div style="vertical-align: middle; padding: 5px 0 5px 10px;"><b>None!</b></div>'; } ?>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="arm_count" value="{{ $arm_count }}" required />
                            <div style="padding: 15px;"></div>
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

<!-- New Lesson Modal -->
@include('partials._new_lesson')
<!-- End New Lesson Modal -->

@endsection