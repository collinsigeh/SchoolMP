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
          <h3>{!! $cbt->name.' CBT - <i>'.$cbt->subject->name.'</i>' !!}</h3>
          </div>
          <div class="col-4 text-right">
            <?php
            if($cbt->user_id == $user->id && count($cbt->questions) < $cbt->no_questions)
            {
              ?>
              <button class="btn btn-primary" data-toggle="modal" data-target="#newQuestionModal">New Question</button>
              <?php
            }
            ?>
          </div>
        </div>
        <hr />
        <div class="pagenav">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('terms.show', $term->id) }}">{!! $term->name.' - <small>'.$term->session.'</small>' !!}</a></li>
                @if ($classsubject_id > 0)
                    <li class="breadcrumb-item"><a href="{{ route('classsubjects.show', $classsubject->id) }}">{{ $classsubject->subject->name.' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cbts.listing', $classsubject->id) }}">CBTs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $cbt->name }}</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('cbts.index') }}">CBTs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $cbt->name.' - '.$cbt->subject->name }}</li>
                @endif
            </ol>
          </nav>
          @include('partials._messages')
        </div>

        <div class="welcome">
            
            <div class="create-form">
                <form method="POST" action="{{ route('cbts.update', $cbt->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group row"> 
                        <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('CBT type') }}</label>
    
                        <div class="col-md-6">
                            <div class="alert alert-info"><b>{{ $cbt->type }}</b></div>
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
    
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $cbt->name }}" required autocomplete="name" autofocus>
                           
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="classsubject_id" value="{{ $classsubject_id }}">

                    <div class="form-group row"> 
                        <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Subject') }}</label>
    
                        <div class="col-md-6">
                            <input type="text" class="form-control" value="{{ $cbt->subject->name }}" disabled>
                        </div>
                    </div>

                    <input type="hidden" name="type" value="Exam">

                    <div class="form-group row"> 
                        <label for="number_of_questions" class="col-md-4 col-form-label text-md-right">{{ __('Number of Questions') }}</label>
    
                        <div class="col-md-6">
                            <input id="number_of_questions" type="number" class="form-control @error('number_of_questions') is-invalid @enderror" name="number_of_questions" value="{{ $cbt->no_questions }}" required autocomplete="number_of_questions" autofocus>
                            <small class="text-muted">*** How many questions will this CBT contain? ***</small>
                            @error('number_of_questions')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="duration" class="col-md-4 col-form-label text-md-right">{{ __('Duration (Minutes)') }}</label>
    
                        <div class="col-md-6">
                            <input id="duration" type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ $cbt->duration }}" required autocomplete="duration" autofocus>
                            <small class="text-muted">*** How long (in Minutes) will this CBT be? ***</small>
                            @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @if ($cbt->type == 'Practice Quiz')
                        <input type="hidden" name="use_as_termly_score" value="{{ $cbt->termly_score }}">
                    @else
                        <div class="form-group row"> 
                            <label for="use_as_termly_score" class="col-md-4 col-form-label text-md-right">{{ __('Use as Termly Score') }}</label>
        
                            <div class="col-md-6">
                                <select name="use_as_termly_score" id="use_as_termly_score" class="form-control" required>
                                    <option value="Yes" <?php if($cbt->termly_score == 'Yes'){ echo 'selected'; } ?>>Yes</option>
                                    <option value="No" <?php if($cbt->termly_score == 'Yes'){ echo 'selected'; } ?>>No</option>
                                </select>
                                <small class="text-muted">*** Use this CBT performance as the termly score? ***</small>
                                @error('use_as_termly_score')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    
                    @if ($cbt->type == 'Practice Quiz')
                        <input type="hidden" name="number_of_attempts" value="{{ $cbt->no_attempts }}">
                    @else
                    <div class="form-group row"> 
                        <label for="number_of_attempts" class="col-md-4 col-form-label text-md-right">{{ __('Number of Attempts') }}</label>
    
                        <div class="col-md-6">
                            <input id="number_of_attempts" type="number" class="form-control @error('number_of_attempts') is-invalid @enderror" name="number_of_attempts" value="{{ $cbt->no_attempts }}" required autocomplete="number_of_attempts" autofocus>
                            <small class="text-muted">*** How many times can a student attempt this CBT? ***</small>
                            @error('number_of_attempts')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @endif
                    
                    @if ($cbt->type == 'Practice Quiz')
                        <input type="hidden" name="supervisor_password" value="{{ $cbt->supervisor_pass }}">
                    @else
                    <div class="form-group row"> 
                        <label for="supervisor_password" class="col-md-4 col-form-label text-md-right">{{ __('Supervisor Password (Optional)') }}</label>
    
                        <div class="col-md-6">
                            <input id="supervisor_password" type="text" class="form-control @error('supervisor_password') is-invalid @enderror" name="supervisor_password" value="{{ $cbt->supervisor_pass }}" autocomplete="supervisor_password" autofocus>
                            <small class="text-muted">*** Case-sensitive. Leave blank if CBT will not be supervised? ***</small>
                            @error('supervisor_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @endif
                    
                    @if ($classsubject_id > 0)
                    <div class="form-group row"> 
                        <label for="schoolclass_id" class="col-md-4 col-form-label text-md-right">{{ __('Classes affected') }}</label>
    
                        <div class="col-md-6">
                            <div class="alert alert-info">Tick the classes that will partake in the CBT.</div>
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
                                                            <?php
                                                                $this_arm_checked = 'No';
                                                                foreach ($cbt->arms as $arm_to_check) {
                                                                    if($this_arm_checked == 'No')
                                                                    {
                                                                        if ($this_arm->id == $arm_to_check->id) {
                                                                            $this_arm_checked = 'Yes';
                                                                        }
                                                                    }
                                                                }
                                                            ?>
                                                            <input type="checkbox" <?php if($this_arm_checked == 'Yes'){ echo 'checked'; } ?> name="{{ $arm_count }}" id="{{ $arm_count }}" value="{{ $this_arm->id }}"> &nbsp;&nbsp;<label for="{{ $arm_count }}">{{ $schoolclass->name.' '.$this_arm->name }}</label>
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
                    @else
                    <div class="form-group row"> 
                        <label for="classes_affected" class="col-md-4 col-form-label text-md-right">{{ __('Classes partaking this CBT') }}</label>
    
                        <div class="col-md-6">
                            @foreach ($cbt->arms as $arm)
                                <span class="badge badge-secondary">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" name="arm_count" value="0" required />
                    @endif
    
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

@endsection