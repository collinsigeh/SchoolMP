

<!-- New Lesson Modal -->
<div class="modal fade" id="newLessonModal" tabindex="-1" role="dialog" aria-labelledby="newLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newLessonModalLabel">New Lesson / note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>Hint: </b>Click on the type of lesson material to continue.
            </div>
            <div class="text-center" style="padding: 10px 0 20px 0;">
              <a href="{{ route('lessons.newvideo', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">Video</a>
              <a href="{{ route('lessons.newaudio', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">Audio</a>
              <a href="{{ route('lessons.newphoto', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">Photo</a>
              <a href="{{ route('lessons.newtext', $classsubject->id) }}" class="btn btn-outline-primary" style="margin: 5px;">Text</a>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End New Lesson Modal -->