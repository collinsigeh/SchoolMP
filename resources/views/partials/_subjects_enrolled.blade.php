
    
                        <div class="resource-details">
                            <div class="title">
                                Subjects enrolled
                            </div>
                            <div class="body">
                                @if (count($enrolment->results) < 1)
                                    <div class="alert alert-info">None</div>
                                @else
                                    <div class="table-responsive">    
                                        <table class="table table-striped table-hover table-sm">
                                            <tbody>
                                                @foreach ($enrolment->results as $classsubject)
                                                    <tr>
                                                        <td>{{ $classsubject->classsubject->subject->name }}</td>
                                                        @if ($arm->user_id == $user->id OR $student_manager == 'Yes')
                                                        <td class="text-right">
                                                            <?php
                                                                if($classsubject->subject_1st_test_score == 0 &&
                                                                    $classsubject->subject_2nd_test_score == 0 &&
                                                                    $classsubject->subject_3rd_test_score == 0 &&
                                                                    $classsubject->subject_assignment_score == 0 &&
                                                                    $classsubject->subject_exam_score == 0)
                                                                {
                                                                    ?>
                                                                    <form action="{{ route('results.destroy', $classsubject->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <input type="submit" class="btn btn-sm btn-danger" value="X" />
                                                                    </form>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            
                                @if ($student_manager == 'Yes' OR $arm->user_id == $user->id)
                                    @if (count($arm->classsubjects) > count($enrolment->results))
                                    <div class="text-right">
                                        <div class="buttons">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#newSubjectModal">
                                                Add subjects
                                            </button>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            </div>