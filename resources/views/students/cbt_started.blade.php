@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container">
    <div style="padding: 40px 0 10px 0;">
        <div class="row">
            <div class="col-9">
                <h3>{{ $question->cbt->name }} <?php if($question->cbt->type == 'Practice Quiz'){ echo ' - no.'.$question->cbt->id ;} ?></h3>
            </div>
            <div class="col-3 text-right">
                <b>Time remaining:</b> countdown_time
            </div>
        </div>
    </div>
    @include('partials._messages')
    <div class="resource-details" style="margin: 20px 0;">
        <div class="title">
            {{ 'Question '.$question_no.' of '.count($question->cbt->questions) }}
        </div>
        <div class="body">
            
            <div>
                {{ $question->question }}
                @if (strlen($question->question_photo) > 0)
                    
                @endif
            </div>
            
            <div class="question-options">
                <div class="form" style="border: 1px solid #d5d5d5; padding: 40px 20px 0 20px;">
                    <form method="POST" action="{{ route('students.cbt_live', $cbt->id) }}">
                        @csrf
    
                        <div class="form-group row"> 
                            <label for="supervisor_email" class="col-md-3 col-form-label text-md-right">{{ __('Supervisor email:') }}</label>
        
                            <div class="col-md-6">
                                <input id="supervisor_email" type="email" class="form-control @error('supervisor_email') is-invalid @enderror" name="supervisor_email" value="{{ old('supervisor_email') }}" required autocomplete="supervisor_email" autofocus>
        
                                @error('supervisor_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row"> 
                            <label for="exam_passcode" class="col-md-3 col-form-label text-md-right">{{ __('Exam Passcode:') }}</label>
        
                            <div class="col-md-6">
                                <input id="exam_passcode" type="password" class="form-control @error('exam_passcode') is-invalid @enderror" name="exam_passcode" value="{{ old('exam_passcode') }}" required autocomplete="exam_passcode" autofocus>
        
                                @error('exam_passcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Start NOW') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            
            <div class="form" style="border: 1px solid #d5d5d5; padding: 20px 20px 0 20px;">
                <form method="POST" action="{{ route('students.cbt_live', $cbt->id) }}">
                    @csrf
    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Start NOW') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>


@endsection