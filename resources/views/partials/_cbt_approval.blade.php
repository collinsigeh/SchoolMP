<!-- cbtApprovalModal -->
<div class="modal fade" id="cbtApprovalModal" tabindex="-1" role="dialog" aria-labelledby="cbtApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5>CBT Approval</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                Kindly confirm the CBT details and the accuracy of the questions before approval.
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm">
                <tr class="bg-light">
                  <td width="130px"><b>Subject:</b></td><td>{{ $cbt->subject->name }}</td>
                </tr>
                <tr class="bg-light">
                  <td width="130px"><b>Classes affected:</b></td>
                  <td>
                      @foreach ($cbt->arms as $arm)
                          <span class="badge badge-secondary">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
                      @endforeach
                  </td>
                </tr>
                  <tr class="bg-light">
                    <td width="130px"><b>CBT Type:</b></td><td>{{ $cbt->type }}</td>
                  </tr>
                  <tr class="bg-light">
                    <td width="130px"><b>Status:</b></td>
                    <td>
                      @php
                          if($cbt->status == 'Rejected')
                          {
                            echo '<span class="badge badge-danger">NOT Approved</span>';
                          }
                          elseif($cbt->status == 'Approved')
                          {
                            echo '<span class="badge badge-success">Approved</span>';
                          }
                          else
                          {
                            echo '<span class="badge badge-info">Pending Approval</span>';
                          }
                      @endphp
                    </td>
                  </tr>
              </table>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm">
                  <tr class="bg-light">
                    <td width="130px"><b>Used as termly score:</b></td><td>{{ $cbt->termly_score }}</td>
                  </tr>
                  <tr class="bg-light">
                    <td width="130px"><b>Attempts allowed:</b></td>
                    <td>
                        @if ($cbt->no_attempts < 1)
                            NOT Applicable
                        @else
                            {{ $cbt->no_attempts }}
                        @endif
                    </td>
                  </tr>
                  <tr class="bg-light">
                    <td width="130px"><b>Created by:</b></td>                           
                    @if ($cbt->user_id < 1)
                        <td>
                            {!! '<span class="badge badge-danger">NOT Specified</span>' !!}
                        </td>
                    @else
                        <td>
                            {{ $cbt->user->name }}
                            @if ($cbt->user->role == 'Staff')
                                {!!' - <small>'.$cbt->user->staff->phone.'</small>' !!}
                            @elseif ($cbt->user->role == 'Director')
                                {!!' - <small>'.$cbt->user->director->phone.'</small>' !!}
                            @endif
                        </td>
                    @endif
                  </tr>
              </table>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm">
                  <tr class="bg-light">
                    <td width="130px"><b>Req. Questions:</b></td><td>{{ $cbt->no_questions }}</td>
                  </tr>
                  <tr class="bg-light">
                    <td width="130px"><b>All Questions:</b></td><td>{{ count($cbt->questions) }}</td>
                  </tr>
              </table>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm">
                  <tr class="bg-light">
                    <td width="130px"><b>Duration:</b></td><td>{{ $cbt->duration.' minutes' }}</td>
                  </tr>
                  @if (strlen($cbt->supervisor_pass) > 0)
                  <tr class="bg-light">
                    <td width="130px"><b>Supervisor Pass:</b></td><td>{{ $cbt->supervisor_pass }}</td>
                  </tr>
                  @endif
              </table>
            </div>
            <div class="create-form">
                <form method="POST" action="{{ route('cbts.cbt_approval', $cbt->id) }}">
                    @csrf
                    @method('PUT')
                                        
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <b>Hint: </b>Select the appropriate status and click the <b>Save status</b> button.
                            </div>
                        </div>

                        <input type="hidden" name="classsubject_id" value="{{ $classsubject_id }}">
    
                        <div class="col-md-5 offset-md-2">
                            <select name="status" id="status" class="form-control">
                                <option value="">Select a status</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
    
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save status') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End cbtApprovalModal -->