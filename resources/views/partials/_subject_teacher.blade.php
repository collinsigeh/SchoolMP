<!-- assignSubjectTeacherModal -->
<div class="modal fade" id="assignSubjectTeacherModal{{ $classsubject->id }}" tabindex="-1" role="dialog" aria-labelledby="assignSubjectTeacherModal{{ $classsubject->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="assignSubjectTeacherModal{{ $classsubject->id }}Label">Assign subject teacher</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('classsubjects.update', $classsubject->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        if(isset($returnpage_id) && isset($return_page))
                        {
                            echo '<input type="hidden" name="return_page" value="'.$return_page.'" />
                            <input type="hidden" name="returnpage_id" value="'.$returnpage_id.'" />';
                        }
                    @endphp
    
                    <div class="form-group row"> 
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Subject Name') }}</label>
    
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $classsubject->arm->schoolclass->name.' '.$classsubject->arm->name.' '.$classsubject->subject->name }}" disabled autocomplete="name" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row"> 
                        <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('Assigned subject teacher') }}</label>
    
                        <div class="col-md-6">
                            <select id="user_id" type="text" class="form-control @error('user_id') is-invalid @enderror" name="user_id" required autocomplete="user_id" autofocus>
                                @php
                                    if($classsubject->user_id == 0)
                                    {
                                        echo '<option value="0">Select a staff</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="'.$classsubject->user_id.'">'.$classsubject->user->name.'</option>';
                                    }
                                    foreach($school->staff as $employee)
                                    {
                                        echo '<option value="'.$employee->user->id.'">'.$employee->user->name.' ( <i>'.$employee->designation.'</i> )</option>';
                                    }
                                @endphp
                            </select>
    
                            @error('user_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End assignSubjectTeacherModal -->