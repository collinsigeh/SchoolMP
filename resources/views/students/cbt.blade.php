@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container">
    <div style="padding: 40px 0 10px 0;">
        <div class="row">
            <div class="col-9">
                <h3>{{ $cbt->name }} <?php if($cbt->type == 'Practice Quiz'){ echo ' - no.'.$cbt->id ;} ?></h3>
            </div>
            <div class="col-3 text-right">
                <a href="{{ route('students.cbts', $result_slip->id) }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    @include('partials._messages')
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-sm">
            <tr class="bg-light">
                <td width="130px"><b>Session term:</b></td>
                <td>{!! $result_slip->term->name.' - <small><i>'.$result_slip->term->session.'</i></small>' !!}</td>
            </tr>
            <tr class="bg-light">
                <td width="130px"><b>Subject:</b></td>
                <td>{{ $cbt->subject->name }}</td>
            </tr>
            <tr class="bg-light">
                <td width="130px"><b>Duration:</b></td>
                <td>{{ $cbt->duration.' minutes' }}</td>
            </tr>
            <tr class="bg-light">
                <td width="130px"><b>Current attempt:</b></td>
                <td>
                    @php
                        $attempts = 0;
                        foreach($result_slip->enrolment->attempts as $attempt)
                        {
                            if($attempt->cbt_id == $cbt->id)
                            {
                                $attempts++;
                            }
                        }
                        $current_attempt = $attempts + 1;
                        if ($cbt->type == 'Practice Quiz') {
                            if($current_attempt == 1)
                            {
                                echo $current_attempt.'st practice attempt';
                            }
                            else
                            {
                                echo 'Attempt number: '.$current_attempt;
                            }
                        } else {
                            echo $current_attempt.' of '.$cbt->no_attempts;
                        }
                    @endphp
                </td>
            </tr>
        </table>
    </div>
    <div class="resource-details" style="margin: 20px 0;">
        <div class="title">
            Instructions
        </div>
        <div class="body">
            
            <p>Read the instructions below carefully.</p>
            <ul>
                <li>Ensure you have a good internet connection before attempting this CBT.</li>
                <li>There are {{ count($cbt->questions) }} questions in all.</li>
                <li>For each question, select the correct option as you answer.</li>
                <li>Ensure your work is submitted once you've completed the CBT.</li>
                @if (strlen($cbt->supervisor_pass) > 0)
                    <li>To start this CBT, request the exam supervisor to enter his/her <b>email</b> and the <b>exam passcode</b>.</li>
                @else
                    <li>To start this CBT, click on the "Start NOW" button.</li>
                @endif
            </ul>
            
            @if (strlen($cbt->supervisor_pass) > 0)
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
            @else
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
            @endif
            
        </div>
    </div>
</div>


@endsection