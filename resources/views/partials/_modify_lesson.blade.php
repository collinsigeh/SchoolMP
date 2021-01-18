<!-- modifyLessonModal -->
<div class="modal fade" id="modifyLessonModal{{ $lesson->id }}" tabindex="-1" role="dialog" aria-labelledby="modifyLessonModal{{ $lesson->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modifyLessonModal{{ $lesson->id }}Label">Modify affected classes</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="create-form">
                <form method="POST" action="{{ route('lessons.update', $lesson->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <tr>
                                <th style="vertical-align: middle;">Lesson:</th>
                                <td style="font-size: 1.2em;">{{ $lesson->name }}</td>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle;">Resource type:</th>
                                <td>{{ $lesson->type }}</td>
                            </tr>
                            <tr>
                                <th>Classes affected:</th>
                                <td>
                                    @foreach ($lesson->arms as $arm)
                                        <span class="badge badge-secondary">{{ $arm->schoolclass->name.' '.$arm->name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <div class="alert alert-info"><b>Hint: </b>To update the classess affected, <b>tick all the classes</b> that will use this lesson. The click on save.</div>

                            <div class="row">
                                <?php $arm_count = 0; ?>
                                @foreach ($school->schoolclasses as $schoolclass)
                                    <div class="col-md-6">
                                        <div style="border: solid 1px #e2e2e2; background-color: #fff; margin: 3px 0; padding: 7px 10px;">
                                            <span class="badge badge-info">{{ $schoolclass->name }} classes</span>
                                            <?php $class_displayed = 0; ?>
                                            @foreach ($schoolclass->arms as $this_arm)
                                                <?php 
                                                $show_classarm = 'No';
                                                if($this_arm->term_id == $term->id)
                                                { // ensure the class arms are applicable for that term & that the staff is responsible for the classsubject
                                                    foreach($this_arm->classsubjects as $this_classsubject)
                                                    {
                                                        if($this_classsubject->term_id == $term->id && $this_classsubject->user_id == $user->id && $this_classsubject->subject_id == $classsubject->subject_id)
                                                        {
                                                            $show_classarm = 'Yes';
                                                        }
                                                    }
                                                    if($show_classarm == 'Yes')
                                                    {
                                                    ?>
                                                        <div style="vertical-align: middle; padding: 5px 0 5px 10px;">
                                                            <input type="checkbox" name="{{ $arm_count }}" id="{{ $arm_count }}" value="{{ $this_arm->id }}"> &nbsp;&nbsp;<label for="{{ $arm_count }}">{{ $schoolclass->name.' '.$this_arm->name }}</label>
                                                        </div>
                                                    <?php
                                                    $class_displayed++; $arm_count++;
                                                    }
                                                }
                                                ?>
                                            @endforeach
                                            <?php if($class_displayed == 0){ echo '<div style="vertical-align: middle; padding: 5px 0 5px 10px;"><b>None!</b></div>'; } ?>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="arm_count" value="{{ $arm_count }}" required />
                        <input type="hidden" name="classsubject_id" value="{{ $classsubject->id }}" required />

                        <div class="col-md-12 text-center" style="padding-top: 15px;">
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
<!-- End confirmLessonDeletionModal -->