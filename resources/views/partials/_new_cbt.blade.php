
<!-- New CBT Modal -->
<div class="modal fade" id="newCBTModal" tabindex="-1" role="dialog" aria-labelledby="newCBTModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newCBTModalLabel">New CBT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>Hint: </b>Click on the type of CBT to create.
            </div>
            <div class="text-center" style="padding: 10px 0 20px 0;">
              <a href="{{ route('cbts.newexam', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">Exam</a>
              <a href="{{ route('cbts.new3rdtest', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">3rd Test</a>
              <a href="{{ route('cbts.new2ndtest', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">2nd Test</a>
              <a href="{{ route('cbts.new1sttest', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">1st Test</a>
              <a href="{{ route('cbts.newpractice', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">Practice</a>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End New CBT Modal -->