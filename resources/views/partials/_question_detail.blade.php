<!-- questionDetailModal -->
<div class="modal fade" id="questionDetailModal{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="questionDetailModal{{ $question->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="questionDetailModal{{ $question->id }}Label">Question Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>
                    {!! $cbt->name.' - '.$cbt->subject->name.' (<i>'.$cbt->term->name.' - <small>'.$cbt->term->session.'</small></i>)' !!}
                    
                    <div class="classes" style="padding-bottom: 15px;">
                        @foreach ($cbt->arms as $arm)
                            <span class="badge badge-info">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
                        @endforeach
                    </div>

                    Question {{ $sn.' of '.$cbt->no_questions }}
                </b>
            </div>
            <div class="question-detail" style="padding-top: 10px">
                <div class="question" style="padding: 10px 0">
                    <b>Question:</b><br />{{ $question->question }}
                </div>
                <div class="question-photo" style="padding-bottom: 20px">
                    @if (strlen($question->question_photo) > 0)
                        <a href="{{ config('app.url') }}/images/questions/{{ $question->question_photo }}" target="_blank" title="Click to view">
                            <img src="{{ config('app.url') }}/images/questions/{{ $question->question_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                        </a>
                    @endif
                </div>
                <div class="options">
                    @if (strlen($question->option_a) > 0 OR strlen($question->option_a_photo) > 0)
                    <div class="option" style="padding-bottom: 10px;">
                        <b>Option A:</b>
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
                    </div>
                    @endif
                    @if (strlen($question->option_b) > 0 OR strlen($question->option_b_photo) > 0)
                    <div class="option" style="padding-bottom: 10px;">
                        <b>Option B:</b>
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
                    </div>
                    @endif
                    @if (strlen($question->option_c) > 0 OR strlen($question->option_c_photo) > 0)
                    <div class="option" style="padding-bottom: 10px;">
                        <b>Option C:</b>
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
                    </div>
                    @endif
                    @if (strlen($question->option_d) > 0 OR strlen($question->option_d_photo) > 0)
                    <div class="option" style="padding-bottom: 10px;">
                        <b>Option D:</b>
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
                    </div>
                    @endif
                    @if (strlen($question->option_e) > 0 OR strlen($question->option_e_photo) > 0)
                    <div class="option" style="padding-bottom: 10px;">
                        <b>Option E:</b>
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
                    </div>
                    @endif
                    <div class="correct-option" style="padding: 10px 0">
                        <b>Answer:</b> <span class="badge badge-success">{{ 'Option '.$question->correct_option }}</span>
                    </div>
                </div>
            </div>
            @if (($question->user_id == $user->id && $question->user_id == $user->id) OR $user->role == 'Director')
            <div padding: 20px 0;>
                <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-primary">Modify details</a>
            </div>
            @endif
        </div>
      </div>
    </div>
</div>
<!-- End questionDetailModal -->