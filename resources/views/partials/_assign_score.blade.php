<!-- assignScoreModal -->
<div class="modal fade" id="assignScoreModal{{ $result_slip->id }}" tabindex="-1" role="dialog" aria-labelledby="assignScoreModal{{ $result_slip->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="assignScoreModal{{ $result_slip->id }}Label">{{ $classsubject->subject->name.' - '.$classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }} - ({!! '<i>'.$term->name.' - <small>'.$term->session.'</small></i>' !!})</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b> {{ $result_slip->enrolment->user->name }} </b><br />
                <small>({{ $result_slip->enrolment->student->registration_number }})</small><br />
                <span class="badge badge-secondary">{{ $classsubject->arm->schoolclass->name.' '.$classsubject->arm->name }}
            </div>
            <div class="create-form">
                <form method="POST" action="{{ route('results.update', $result_slip->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        if(isset($returnpage_id) && isset($return_page))
                        {
                            echo '<input type="hidden" name="return_page" value="'.$return_page.'" />
                            <input type="hidden" name="returnpage_id" value="'.$returnpage_id.'" />';
                        }
                    @endphp
                    
                    <?php
                        if($classsubject->arm->resulttemplate->subject_1st_test_max_score > 0)
                        {
                            ?>
                            <div class="form-group row"> 
                                <label for="1st_test_score" class="col-md-4 col-form-label text-md-right">{{ __('1st test score (%)') }}</label>
                                
                                <div class="col-md-8">
                                    <input id="1st_test_score" type="number" class="form-control @error('1st_test_score') is-invalid @enderror" name="1st_test_score" value="{{ $result_slip->subject_1st_test_score }}" autocomplete="1st_test_score" autofocus required>
                                    <small class="text-muted">*** Whole numbers only, Max of {{ $classsubject->arm->resulttemplate->subject_1st_test_max_score }} ***</small>
                                    @error('1st_test_score')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    
                    <?php
                        if($classsubject->arm->resulttemplate->subject_2nd_test_max_score > 0)
                        {
                            ?>
                            <div class="form-group row"> 
                                <label for="2nd_test_score" class="col-md-4 col-form-label text-md-right">{{ __('2nd test score (%)') }}</label>
                                
                                <div class="col-md-8">
                                    <input id="2nd_test_score" type="number" class="form-control @error('2nd_test_score') is-invalid @enderror" name="2nd_test_score" value="{{ $result_slip->subject_2nd_test_score }}" autocomplete="2nd_test_score" autofocus required>
                                    <small class="text-muted">*** Whole numbers only, Max of {{ $classsubject->arm->resulttemplate->subject_2nd_test_max_score }} ***</small>
                                    @error('2nd_test_score')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    
                    <?php
                        if($classsubject->arm->resulttemplate->subject_3rd_test_max_score > 0)
                        {
                            ?>
                            <div class="form-group row"> 
                                <label for="3rd_test_score" class="col-md-4 col-form-label text-md-right">{{ __('3rd test score (%)') }}</label>
                                
                                <div class="col-md-8">
                                    <input id="3rd_test_score" type="number" class="form-control @error('3rd_test_score') is-invalid @enderror" name="3rd_test_score" value="{{ $result_slip->subject_3rd_test_score }}" autocomplete="3rd_test_score" autofocus required>
                                    <small class="text-muted">*** Whole numbers only, Max of {{ $classsubject->arm->resulttemplate->subject_3rd_test_max_score }} ***</small>
                                    @error('3rd_test_score')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    
                    <?php
                        if($classsubject->arm->resulttemplate->subject_assignment_score > 0)
                        {
                            ?>
                            <div class="form-group row"> 
                                <label for="assignment_score" class="col-md-4 col-form-label text-md-right">{{ __('Assignment score (%)') }}</label>
            
                                <div class="col-md-8">
                                    <input id="assignment_score" type="number" class="form-control @error('assignment_score') is-invalid @enderror" name="assignment_score" value="{{ $result_slip->subject_assignment_score }}" autocomplete="assignment_score" autofocus required>
                                    <small class="text-muted">*** Whole numbers only, Max of {{ $classsubject->arm->resulttemplate->subject_assignment_score }} ***</small>
                                    @error('assignment_score')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    
                    <?php
                        if($classsubject->arm->resulttemplate->subject_exam_score > 0)
                        {
                            ?>
                            <div class="form-group row"> 
                                <label for="exam_score" class="col-md-4 col-form-label text-md-right">{{ __('Exam score (%)') }}</label>
            
                                <div class="col-md-8">
                                    <input id="exam_score" type="number" class="form-control @error('exam_score') is-invalid @enderror" name="exam_score" value="{{ $result_slip->subject_exam_score }}" autocomplete="exam_score" autofocus required>
                                    <small class="text-muted">*** Whole numbers only, Max of {{ $classsubject->arm->resulttemplate->subject_exam_score }} ***</small>
                                    @error('exam_score')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <?php
                        }
                    ?>
    
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
    </div>
</div>
<!-- End assignScoreModal -->