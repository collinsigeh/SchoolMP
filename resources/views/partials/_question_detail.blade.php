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
            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-outline-primary">Modify</a>
            <div class="question-detail" style="padding-top: 10px">
                <div class="question" style="padding: 10px 0">
                    <b>Q: </b>{{ $question->question }}
                </div>
                <div class="question-photo" style="padding-bottom: 20px">
                    @if (strlen($question->question_photo) > 0)
                        <a href="{{ config('app.url') }}/images/questions/{{ $question->question_photo }}" target="_blank" title="Click to view">
                            <img src="{{ config('app.url') }}/images/questions/{{ $question->question_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                        </a>
                    @endif
                </div>
                <div class="options">
                    @if (strlen($question->option_a) > 0 OR strlen($question->option_a_photo))
                    <div class="option">
                        <b>Option A:</b>
                    </div>
                    @endif
                </div>
            </div>
            <div class="create-form">
                <form method="POST" action="{{ route('questions.update', $question->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group row"> 
                        <label for="question" class="col-md-3 col-form-label text-md-right">{{ __('Question') }}</label>
    
                        <div class="col-md-9">
                            <textarea id="question" class="form-control @error('question') is-invalid @enderror" name="question" required autocomplete="question" placeholder="Enter the question here..." autofocus>{{ $question->question }}</textarea>
                            
                            @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="question_photo" class="col-md-3 offset-md-3 col-form-label text-md-right">{{ __('Question photo (Optional)') }}</label>

                        <div class="col-md-6">
                            @if (strlen($question->question_photo) > 0)
                                <a href="{{ config('app.url') }}/images/questions/{{ $question->question_photo }}" target="_blank" title="Click to view">
                                    <img src="{{ config('app.url') }}/images/questions/{{ $question->question_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                </a>
                            @endif
                            <input id="question_photo" type="file" class="form-control @error('question_photo') is-invalid @enderror" name="question_photo" value="{{ old('question_photo') }}" autocomplete="question_photo" autofocus>

                            @error('question_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_a" class="col-md-3 col-form-label text-md-right">{{ __('Option A') }}</label>
    
                        <div class="col-md-9">
                            <textarea id="option_a" class="form-control @error('option_a') is-invalid @enderror" name="option_a" autocomplete="option_a" placeholder="Enter option A here..." autofocus>{{ $question->option_a }}</textarea>
                            
                            @error('option_a')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_a_photo" class="col-md-3 offset-md-3 col-form-label text-md-right">{{ __('Option A photo (Optional)') }}</label>

                        <div class="col-md-6">
                            @if (strlen($question->option_a_photo) > 0)
                                <a href="{{ config('app.url') }}/images/questions/{{ $question->option_a_photo }}" target="_blank" title="Click to view">
                                    <img src="{{ config('app.url') }}/images/questions/{{ $question->option_a_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                </a>
                            @endif
                            <input id="option_a_photo" type="file" class="form-control @error('option_a_photo') is-invalid @enderror" name="option_a_photo" value="{{ old('option_a_photo') }}" autocomplete="option_a_photo" autofocus>

                            @error('option_a_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_b" class="col-md-3 col-form-label text-md-right">{{ __('Option B') }}</label>
    
                        <div class="col-md-9">
                            <textarea id="option_b" class="form-control @error('option_b') is-invalid @enderror" name="option_b" autocomplete="option_b" placeholder="Enter option B here..." autofocus>{{ $question->option_b }}</textarea>
                            
                            @error('option_b')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_b_photo" class="col-md-3 offset-md-3 col-form-label text-md-right">{{ __('Option B photo (Optional)') }}</label>

                        <div class="col-md-6">
                            @if (strlen($question->option_b_photo) > 0)
                                <a href="{{ config('app.url') }}/images/questions/{{ $question->option_b_photo }}" target="_blank" title="Click to view">
                                    <img src="{{ config('app.url') }}/images/questions/{{ $question->option_b_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                </a>
                            @endif
                            <input id="option_b_photo" type="file" class="form-control @error('option_b_photo') is-invalid @enderror" name="option_b_photo" value="{{ old('option_b_photo') }}" autocomplete="option_b_photo" autofocus>

                            @error('option_b_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_c" class="col-md-3 col-form-label text-md-right">{{ __('Option C (Optional)') }}</label>
    
                        <div class="col-md-9">
                            <textarea id="option_c" class="form-control @error('option_c') is-invalid @enderror" name="option_c" autocomplete="option_c" placeholder="Enter option C here..." autofocus>{{ $question->option_c }}</textarea>
                            
                            @error('option_c')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_c_photo" class="col-md-3 offset-md-3 col-form-label text-md-right">{{ __('Option C photo (Optional)') }}</label>

                        <div class="col-md-6">
                            @if (strlen($question->option_c_photo) > 0)
                                <a href="{{ config('app.url') }}/images/questions/{{ $question->option_c_photo }}" target="_blank" title="Click to view">
                                    <img src="{{ config('app.url') }}/images/questions/{{ $question->option_c_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                </a>
                            @endif
                            <input id="option_c_photo" type="file" class="form-control @error('option_c_photo') is-invalid @enderror" name="option_c_photo" value="{{ old('option_c_photo') }}" autocomplete="option_c_photo" autofocus>

                            @error('option_c_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_d" class="col-md-3 col-form-label text-md-right">{{ __('Option D (Optional)') }}</label>
    
                        <div class="col-md-9">
                            <textarea id="option_d" class="form-control @error('option_d') is-invalid @enderror" name="option_d" autocomplete="option_d" placeholder="Enter option D here..." autofocus>{{ $question->option_d }}</textarea>
                            
                            @error('option_d')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_d_photo" class="col-md-3 offset-md-3 col-form-label text-md-right">{{ __('Option D photo (Optional)') }}</label>

                        <div class="col-md-6">
                            @if (strlen($question->option_d_photo) > 0)
                                <a href="{{ config('app.url') }}/images/questions/{{ $question->option_d_photo }}" target="_blank" title="Click to view">
                                    <img src="{{ config('app.url') }}/images/questions/{{ $question->option_d_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                </a>
                            @endif
                            <input id="option_d_photo" type="file" class="form-control @error('option_d_photo') is-invalid @enderror" name="option_d_photo" value="{{ old('option_d_photo') }}" autocomplete="option_d_photo" autofocus>

                            @error('option_d_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_e" class="col-md-3 col-form-label text-md-right">{{ __('Option E (Optional)') }}</label>
    
                        <div class="col-md-9">
                            <textarea id="option_e" class="form-control @error('option_e') is-invalid @enderror" name="option_e"  autocomplete="option_e" placeholder="Enter option E here..." autofocus>{{ $question->option_e }}</textarea>
                            
                            @error('option_e')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row"> 
                        <label for="option_e_photo" class="col-md-3 offset-md-3 col-form-label text-md-right">{{ __('Option E photo (Optional)') }}</label>

                        <div class="col-md-6">
                            @if (strlen($question->option_e_photo) > 0)
                                <a href="{{ config('app.url') }}/images/questions/{{ $question->option_e_photo }}" target="_blank" title="Click to view">
                                    <img src="{{ config('app.url') }}/images/questions/{{ $question->option_e_photo }}" style="max-width: 220px; border: 1px solid #dfdede;" alt="Photo can't display" />
                                </a>
                            @endif
                            <input id="option_e_photo" type="file" class="form-control @error('option_e_photo') is-invalid @enderror" name="option_e_photo" value="{{ old('option_e_photo') }}" autocomplete="option_e_photo" autofocus>

                            @error('option_e_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                        
                    <div class="form-group row"> 
                        <label for="correct_option" class="col-md-3 col-form-label text-md-right">{{ __('Correct Option') }}</label>

                        <div class="col-md-9">
                            <select id="correct_option" class="form-control @error('correct_option') is-invalid @enderror" name="correct_option" required autocomplete="correct_option" autofocus>
                                <option value="">Select the correct option</option>
                                <option value="A" <?php if($question->correct_option == 'A'){ echo 'selected'; } ?>>Option A</option>
                                <option value="B" <?php if($question->correct_option == 'B'){ echo 'selected'; } ?>>Option B</option>
                                <option value="C" <?php if($question->correct_option == 'C'){ echo 'selected'; } ?>>Option C</option>
                                <option value="D" <?php if($question->correct_option == 'D'){ echo 'selected'; } ?>>Option D</option>
                                <option value="E" <?php if($question->correct_option == 'E'){ echo 'selected'; } ?>>Option E</option>
                            </select>

                            @error('correct_option')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 text-center" style="padding-top: 15px;">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End questionDetailModal -->