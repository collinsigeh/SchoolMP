
<!-- New Question Modal -->
<div class="modal fade" id="newQuestionModal" tabindex="-1" role="dialog" aria-labelledby="newQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newQuestionModalLabel">New Question</h5>
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

                    Question <?php echo count($cbt->questions) + 1; ?> of {{ $cbt->no_questions }}
                </b>
            </div>
            <div class="create-form">
                <form method="POST" action="{{ route('questions.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="cbt_id" value="{{ $cbt->id }}">

                    <div class="form-group row"> 
                        <label for="question" class="col-md-3 col-form-label text-md-right">{{ __('Question') }}</label>
    
                        <div class="col-md-9">
                            <textarea id="question" class="form-control @error('question') is-invalid @enderror" name="question" required autocomplete="question" placeholder="Enter the question here..." autofocus>{{ old('question') }}</textarea>
                            
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
                            <textarea id="option_a" class="form-control @error('option_a') is-invalid @enderror" name="option_a" autocomplete="option_a" placeholder="Enter option A here..." autofocus>{{ old('option_a') }}</textarea>
                            
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
                            <textarea id="option_b" class="form-control @error('option_b') is-invalid @enderror" name="option_b" autocomplete="option_b" placeholder="Enter option B here..." autofocus>{{ old('option_b') }}</textarea>
                            
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
                            <textarea id="option_c" class="form-control @error('option_c') is-invalid @enderror" name="option_c" autocomplete="option_c" placeholder="Enter option C here..." autofocus>{{ old('option_c') }}</textarea>
                            
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
                            <textarea id="option_d" class="form-control @error('option_d') is-invalid @enderror" name="option_d" autocomplete="option_d" placeholder="Enter option D here..." autofocus>{{ old('option_d') }}</textarea>
                            
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
                            <textarea id="option_e" class="form-control @error('option_e') is-invalid @enderror" name="option_e"  autocomplete="option_e" placeholder="Enter option E here..." autofocus>{{ old('option_e') }}</textarea>
                            
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
                                <option value="A">Option A</option>
                                <option value="B">Option B</option>
                                <option value="C">Option C</option>
                                <option value="D">Option D</option>
                                <option value="E">Option E</option>
                            </select>

                            @error('correct_option')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End New Question Modal -->