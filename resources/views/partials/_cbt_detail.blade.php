<!-- cbtDetailModal -->
<div class="modal fade" id="cbtDetailModal{{ $cbt->id }}" tabindex="-1" role="dialog" aria-labelledby="cbtDetailModal{{ $cbt->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          @if ($cbt->type == 'Practice Quiz')
            <h5 class="modal-title" id="cbtDetailModal{{ $cbt->id }}Label">{!! $cbt->name.' - no.'.$cbt->id.' - (<i>'.$cbt->term->name.' <small>'.$cbt->term->session.'</i></small>)' !!}</h5>
          @else
            <h5 class="modal-title" id="cbtDetailModal{{ $cbt->id }}Label">{!! $cbt->name.' - (<i>'.$cbt->term->name.' <small>'.$cbt->term->session.'</i></small>)' !!}</h5>
          @endif
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm">
                <tr class="bg-light">
                  <td width="130px"><b>Subject:</b></td><td>{{ $cbt->subject->name }}</td>
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
                  <tr class="bg-light">
                    <td width="130px"><b>Classes affected:</b></td>
                    <td>
                        @foreach ($cbt->arms as $arm)
                            <span class="badge badge-secondary">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
                        @endforeach
                    </td>
                  </tr>
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
            <div class="text-center">
                <a href="{{ route('cbts.edit', $cbt->id) }}" class="btn btn-sm btn-outline-primary">Modify details</a>
                <a href="{{ route('cbts.show', $cbt->id) }}" class="btn btn-sm btn-primary">View questions</a>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End cbtDetailModal -->