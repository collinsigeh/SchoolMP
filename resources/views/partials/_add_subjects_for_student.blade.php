<!-- newSubjectModal -->
<div class="modal fade" id="newSubjectModal" tabindex="-1" role="dialog" aria-labelledby="newSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newSubjectModalLabel">Add subjects for {{ $enrolment->user->name }} - {{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('results.store') }}">
                    @csrf

                    <input type="hidden" name="from_form" value="true">
                    <input type="hidden" name="enrolment_id" value="{{ $enrolment->id }}">

                    <div class="form-group row">
                        <label for="password" class="col-md-12 col-form-label">{{ __('Tick the subjects to add and click on save') }}</label>
        
                        @foreach ($arm->classsubjects as $classsubject)
                            @php
                                $isassigned = 0;
                            @endphp

                            @foreach ($enrolment->results as $studentsubject)
                                @php
                                    if($studentsubject->classsubject_id == $classsubject->id)
                                    {
                                        $isassigned++;
                                    }
                                @endphp
                            @endforeach

                            @if ($isassigned == 0)
                            <div class="col-md-12">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subject['{{ $classsubject->id }}']" id="subject{{ $classsubject->id }}" {{ old('remember') ? 'checked' : '' }} value="{{ $classsubject->id }}">

                                    <label class="form-check-label" for="subject{{ $classsubject->id }}">
                                        {{ $classsubject->subject->name }}
                                    </label>
                                </div>
                            </div>
                            @endif
                        @endforeach
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
      </div>
    </div>
</div>
<!-- End newSubjectModal -->