@extends('layouts.school')

@section('title', $school->school)

@section('content')

<div class="container">
    <div style="padding: 40px 0 10px 0;">
        <div class="row">
            <div class="col-8">
                <h3>{{ $question->cbt->name }} <?php if($question->cbt->type == 'Practice Quiz'){ echo ' - no.'.$question->cbt->id ;} ?></h3>
            </div>
            <div class="col-4 text-right">
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
                <b>{{ $question->question }}</b>
                @if (strlen($question->question_photo) > 0)
                    <a href="{{ config('app.url') }}/images/questions/{{ $question->question_photo }}" target="_blank" title="Click to view">
                        <img src="{{ config('app.url') }}/images/questions/{{ $question->question_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                    </a>
                @endif
            </div>
            
            <div class="question-options">
                <div class="form">
                    <form method="POST" action="{{ route('students.cbt_submitted', $question->id) }}">
                        @csrf

                        <input type="hidden" name="question_no" value="{{ $question_no }}">
                        <input type="hidden" name="attempt_id" value="{{ session('attempt_id') }}">
                        
                        @if (strlen($question->option_a) > 0 OR strlen($question->option_a_photo) > 0)
                        <div style="padding: 20px 0 6px 0;">
                            <label for="option_a">
                                <input type="radio" name="option" id="option_a" value="A" required>
                                (A):
                                @if (strlen($question->option_a) > 0)
                                    {{ $question->option_a }}
                                @endif
                                @if (strlen($question->option_a_photo) > 0)
                                    <div class="option-photo">
                                        <a href="{{ config('app.url') }}/images/questions/{{ $question->option_a_photo }}" target="_blank" title="Click to view">
                                            <img src="{{ config('app.url') }}/images/questions/{{ $question->option_a_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                        </a>
                                    </div>
                                @endif
                            </label>
                        </div>
                        @endif
                        @if (strlen($question->option_b) > 0 OR strlen($question->option_b_photo) > 0)
                        <div style="padding: 6px 0;">
                            <label for="option_b">
                                <input type="radio" name="option" id="option_b" value="B" required>
                                (B):
                                @if (strlen($question->option_b) > 0)
                                    {{ $question->option_b }}
                                @endif
                                @if (strlen($question->option_b_photo) > 0)
                                    <div class="option-photo" style="padding-bottom: 20px">
                                        <a href="{{ config('app.url') }}/images/questions/{{ $question->option_b_photo }}" target="_blank" title="Click to view">
                                            <img src="{{ config('app.url') }}/images/questions/{{ $question->option_b_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                        </a>
                                    </div>
                                @endif
                            </label>
                        </div>
                        @endif
                        @if (strlen($question->option_c) > 0 OR strlen($question->option_c_photo) > 0)
                        <div style="padding: 6px 0;">
                            <label for="option_c">
                                <input type="radio" name="option" id="option_c" value="C" required>
                                (C):
                                @if (strlen($question->option_c) > 0)
                                    {{ $question->option_c }}
                                @endif
                                @if (strlen($question->option_c_photo) > 0)
                                    <div class="option-photo" style="padding-bottom: 20px">
                                        <a href="{{ config('app.url') }}/images/questions/{{ $question->option_c_photo }}" target="_blank" title="Click to view">
                                            <img src="{{ config('app.url') }}/images/questions/{{ $question->option_cs_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                        </a>
                                    </div>
                                @endif
                            </label>
                        </div>
                        @endif
                        @if (strlen($question->option_d) > 0 OR strlen($question->option_d_photo) > 0)
                        <div style="padding: 6px 0;">
                            <label for="option_d">
                                <input type="radio" name="option" id="option_d" value="D" required>
                                (D):
                                @if (strlen($question->option_d) > 0)
                                    {{ $question->option_d }}
                                @endif
                                @if (strlen($question->option_d_photo) > 0)
                                    <div class="option-photo" style="padding-bottom: 20px">
                                        <a href="{{ config('app.url') }}/images/questions/{{ $question->option_d_photo }}" target="_blank" title="Click to view">
                                            <img src="{{ config('app.url') }}/images/questions/{{ $question->option_d_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                        </a>
                                    </div>
                                @endif
                            </label>
                        </div>
                        @endif
                        @if (strlen($question->option_e) > 0 OR strlen($question->option_e_photo) > 0)
                        <div style="padding: 6px 0;">
                            <label for="option_e">
                                <input type="radio" name="option" id="option_e" value="E" required>
                                (E):
                                @if (strlen($question->option_e) > 0)
                                    {{ $question->option_e }}
                                @endif
                                @if (strlen($question->option_e_photo) > 0)
                                    <div class="option-photo" style="padding-bottom: 20px">
                                        <a href="{{ config('app.url') }}/images/questions/{{ $question->option_e_photo }}" target="_blank" title="Click to view">
                                            <img src="{{ config('app.url') }}/images/questions/{{ $question->option_e_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                        </a>
                                    </div>
                                @endif
                            </label>
                        </div>
                        @endif
                        
                        <div class="row" style="margin-top: 20px; border: 1px solid #d5d5d5; padding: 20px 15px 0 15px">
                            <div class="col-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        @if ($question_no == count($question->cbt->questions))
                                            {{ __('Submit') }}
                                        @else
                                            {{ __('Next') }}
                                        @endif
                                    </button>
                                </div>
                            </div>
                            @php
                                $next_question = $question_no + 1;
                                $prev_question = $question_no - 1;
                            @endphp
                            <div class="col-4 text-center">
                                @if ($question_no < count($question->cbt->questions))
                                    <a href="{{ route('students.cbt_started', $next_question) }}" class="btn btn-outline-primary">Skip question</a>
                                @endif
                            </div>
                            <div class="col-4 text-right">
                                @if ($question_no > 1)
                                    <a href="{{ route('students.cbt_started', $prev_question) }}" class="btn btn-outline-primary">Back</a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>


@endsection