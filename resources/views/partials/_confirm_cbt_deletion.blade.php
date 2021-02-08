<!-- confirmCBTDeletionModal -->
<div class="modal fade" id="confirmCBTDeletionModal{{ $cbt->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmCBTDeletionModal{{ $cbt->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmCBTDeletionModal{{ $cbt->id }}Label">Confirm deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('cbts.destroy', $cbt->id) }}">
                    @csrf
                    @method('DELETE')

                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <tr>
                                <th style="vertical-align: middle;">CBT:</th>
                                <td style="font-size: 1.2em;">{!! $cbt->name.' - <i>'.$cbt->subject->name.'<br /><span class="badge badge-secondary">'.$cbt->term->name.' <small>'.$cbt->term->session.'</i></span>' !!}</td>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle;">Type:</th>
                                <td>{{ $cbt->type }}</td>
                            </tr>
                            <tr>
                                <th>Classes affected:</th>
                                <td>
                                    @foreach ($cbt->arms as $arm)
                                        <span class="badge badge-secondary">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <p><b>Hint: </b>To confirm the deletion of this CBT, type <b>DELETE</b> in the box provided and click the <b>Confirm</b> button.</p>
                                <b>Note: </b>Deleting this CBT will also delete its associated resources.
                            </div>
                        </div>
    
                        <div class="col-md-5 offset-md-2">
                            <input id="confirmation" type="text" class="form-control @error('confirmation') is-invalid @enderror" name="confirmation_to_delete" value="{{ old('confirmation') }}" placeholder="DELETE" required autocomplete="confirmation" autofocus>
    
                            @error('confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <input type="hidden" name="classsubject_id" value="{{ $classsubject->id }}">

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-danger">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End confirmCBTDeletionModal -->