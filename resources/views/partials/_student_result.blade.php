<!-- studentResultModal -->
<div class="modal fade bd-example-modal-lg" id="studentResultModal{{ $enrolment->id }}" tabindex="-1" role="dialog" aria-labelledby="studentResultModal{{ $enrolment->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="studentResultModal{{ $enrolment->id }}Label">Student Result {!! ' - (<i>'.$term->name.' - <small>'.$term->session.'</small>'.'</i>)' !!}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <b>{{ $enrolment->user->name }}</b><br/>
                <small>({{ $enrolment->student->registration_number }})</small><br />
                <span class="badge badge-secondary">{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}</span>
            </div>
            
            @if ($enrolment->result_status == 'Approved')
                <div class="alert alert-info">
                    <small>Result status:</small> <span class="badge badge-success">Approved!</span>
                    @if ($enrolment->next_class < 1 && $enrolment->term->type == 'Promotion term')
                        <div style="padding-top: 8px;">
                            <small><b>IMPORTANT:</b> The next (promotion/demotion) class is not specified.</small>
                        </div>
                    @endif
                </div>
                <div class="text-right" style="padding-bottom: 8px;">
                    <a href="{{ route('results.show', $enrolment->id) }}" target="_blank" class="btn btn-primary">View print version</a>
                </div>
            @else
                <div class="alert alert-info">
                    <p><small>Result status:</small> <span class="badge badge-danger">NOT approved!</span></p>
                    <small><b>Note: </b>The <b>print version</b> button will be displayed once this result is approved.</small>
                </div>
            @endif
            
            @if ($enrolment->arm->resulttemplate->ca_display == 'Summary')
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th style="vertical-align: middle">Subject</th>
                            <th class="text-right" style="vertical-align: middle">C.A.<br><span class="badge badge-secondary">40 %</span></th>
                            <th class="text-right" style="vertical-align: middle">Exam<br><span class="badge badge-secondary">60 %</span></th>
                            <th class="text-right" style="vertical-align: middle">Total<br><span class="badge badge-secondary">100 %</span></th>
                            <th class="text-right" style="vertical-align: middle">Grade</th>
                            <th class="text-right" style="vertical-align: middle">Remark</th>
                        </tr>
                        <?php 
                            $total = 0; 
                        ?>
                        @foreach ($enrolment->results as $result_slip)
                            <tr>
                                <td>{{ $result_slip->classsubject->subject->name }}</td>
                                <td>
                                    @php
                                        $ca = $result_slip->subject_1st_test_score + $result_slip->subject_2nd_test_score +
                                            $result_slip->subject_3rd_test_score + $result_slip->subject_assignment_score +
                                            $result_slip->subject_exam_score;
                                    @endphp
                                    {{ $ca }}
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @elseif ($enrolment->arm->resulttemplate->ca_display == 'Breakdown')
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th style="vertical-align: middle; background-color: #f1f1f1">Subject</th>
                            @if ($enrolment->arm->resulttemplate->subject_1st_test_max_score > 0)
                                <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">1st Test<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_1st_test_max_score }} %</span></th>
                            @endif
                            @if ($enrolment->arm->resulttemplate->subject_2nd_test_max_score > 0)
                                <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">2nd Test<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_2nd_test_max_score }} %</span></th>
                            @endif
                            @if ($enrolment->arm->resulttemplate->subject_3rd_test_max_score > 0)
                                <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">3rd Test<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_3rd_test_max_score }} %</span></th>
                            @endif
                            @if ($enrolment->arm->resulttemplate->subject_assignment_score > 0)
                                <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Ass. Score<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_assignment_score }} %</span></th>
                            @endif
                            <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Exam<br><span class="badge badge-secondary">{{ $enrolment->arm->resulttemplate->subject_exam_score }} %</span></th>
                            <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Total<br><span class="badge badge-secondary">100 %</span></th>
                            <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Grade</th>
                            <th class="text-right" style="vertical-align: middle; background-color: #f1f1f1">Remark</th>
                        </tr>
                        @foreach ($enrolment->results as $result_slip)
                            <?php 
                                $total = 0;
                            ?>
                            <tr>
                                <td style="background-color: #f1f1f1">{{ $result_slip->classsubject->subject->name }}</td>
                                @if ($enrolment->arm->resulttemplate->subject_1st_test_max_score > 0)
                                    <td class="text-right">{{ $result_slip->subject_1st_test_score }}</td>
                                    <?php $total += $result_slip->subject_1st_test_score; ?>
                                @endif
                                @if ($enrolment->arm->resulttemplate->subject_2nd_test_max_score > 0)
                                    <td class="text-right">{{ $result_slip->subject_2nd_test_score }}</td>
                                    <?php $total += $result_slip->subject_2nd_test_score; ?>
                                @endif
                                @if ($enrolment->arm->resulttemplate->subject_3rd_test_max_score > 0)
                                    <td class="text-right">{{ $result_slip->subject_3rd_test_score }}</td>
                                    <?php $total += $result_slip->subject_3rd_test_score; ?>
                                @endif
                                @if ($enrolment->arm->resulttemplate->subject_assignment_score > 0)
                                    <td class="text-right">{{ $result_slip->subject_assignment_score }}</td>
                                    <?php $total += $result_slip->subject_assignment_score; ?>
                                @endif
                                <td class="text-right">{{ $result_slip->subject_exam_score }}</td>
                                <?php $total += $result_slip->subject_exam_score; ?>
                                <td class="text-right" style="background-color: #f1f1f1">{{ $total }}</td>
                                @php
                                    if($total >= 95 && $total <= 100)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_95_to_100;
                                        $remark = $enrolment->arm->resulttemplate->grade_95_to_100;
                                    }
                                    elseif($total >= 90 && $total <= 94)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_90_to_94;
                                        $remark = $enrolment->arm->resulttemplate->grade_90_to_94;
                                    }
                                    elseif($total >= 85 && $total <= 89)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_85_to_89;
                                        $remark = $enrolment->arm->resulttemplate->grade_85_to_89;
                                    }
                                    elseif($total >= 80 && $total <= 84)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_80_to_84;
                                        $remark = $enrolment->arm->resulttemplate->grade_80_to_84;
                                    }
                                    elseif($total >= 75 && $total <= 79)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_75_to_79;
                                        $remark = $enrolment->arm->resulttemplate->grade_75_to_79;
                                    }
                                    elseif($total >= 70 && $total <= 74)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_70_to_74;
                                        $remark = $enrolment->arm->resulttemplate->grade_70_to_74;
                                    }
                                    elseif($total >= 65 && $total <= 69)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_65_to_69;
                                        $remark = $enrolment->arm->resulttemplate->grade_65_to_69;
                                    }
                                    elseif($total >= 60 && $total <= 64)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_60_to_64;
                                        $remark = $enrolment->arm->resulttemplate->grade_60_to_64;
                                    }
                                    elseif($total >= 55 && $total <= 59)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_55_to_59;
                                        $remark = $enrolment->arm->resulttemplate->grade_55_to_59;
                                    }
                                    elseif($total >= 50 && $total <= 54)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_50_to_54;
                                        $remark = $enrolment->arm->resulttemplate->grade_50_to_54;
                                    }
                                    elseif($total >= 45 && $total <= 49)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_45_to_49;
                                        $remark = $enrolment->arm->resulttemplate->grade_45_to_49;
                                    }
                                    elseif($total >= 40 && $total <= 44)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->grade_40_to_44;
                                        $remark = $enrolment->arm->resulttemplate->symbol_40_to_44;
                                    }
                                    elseif($total >= 35 && $total <= 39)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_35_to_39;
                                        $remark = $enrolment->arm->resulttemplate->grade_35_to_39;
                                    }
                                    elseif($total >= 30 && $total <= 34)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_30_to_34;
                                        $remark = $enrolment->arm->resulttemplate->grade_30_to_34;
                                    }
                                    elseif($total >= 25 && $total <= 29)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_25_to_29;
                                        $remark = $enrolment->arm->resulttemplate->grade_25_to_29;
                                    }
                                    elseif($total >= 20 && $total <= 24)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_20_to_24;
                                        $remark = $enrolment->arm->resulttemplate->grade_20_to_24;
                                    }
                                    elseif($total >= 15 && $total <= 19)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_15_to_19;
                                        $remark = $enrolment->arm->resulttemplate->grade_15_to_19;
                                    }
                                    elseif($total >= 10 && $total <= 14)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_10_to_14;
                                        $remark = $enrolment->arm->resulttemplate->grade_10_to_14;
                                    }
                                    elseif($total >= 5 && $total <= 9)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_5_to_9;
                                        $remark = $enrolment->arm->resulttemplate->grade_5_to_9;
                                    }
                                    elseif($total >= 0 && $total <= 4)
                                    {
                                        $grade  = $enrolment->arm->resulttemplate->symbol_0_to_4;
                                        $remark = $enrolment->arm->resulttemplate->grade_0_to_4;
                                    }
                                @endphp
                                <td class="text-right" style="background-color: #f1f1f1">{{ $grade }}</td>
                                <td class="text-right">{{ $remark }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endif
            
            <div style="padding-top: 20px">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tr class="text-center" style="background-color: #f1f1f1">
                            <th colspan="8">Overall Performance</th>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle; background-color: #f1f1f1"><small><b>No. of subjects:</b></small></td>
                            <td style="vertical-align: middle">17</td>
                            <td style="vertical-align: middle; background-color: #f1f1f1"><small><b>Total score:</b></small></td>
                            <td style="vertical-align: middle">1580</td>
                            <td style="vertical-align: middle; background-color: #f1f1f1"><small><b>Avg. score:</b></small></td>
                            <td style="vertical-align: middle">92.94 <span class="badge badge-secondary">%</span></td>
                            <td style="vertical-align: middle; background-color: #f1f1f1"><small><b>Remark:</b></small></td>
                            <td style="vertical-align: middle">Distinction</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="create-form">
                <form method="POST" action="{{ route('enrolments.update', $enrolment->id) }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="item_to_update" value="student_result">
                    <input type="hidden" name="return_page" value="{{ $return_page }}">

                    <div class="resource-details" style="margin-top: 40px;">
                        <div class="title">
                            Comments <?php if($manage_student_promotion == 'Yes' && $enrolment->term->type == 'Promotion term'){ echo ', promotion detail, '; } ?>& result status
                        </div>
                        <div class="body">

                            <div class="form-group row"> 
                                <label for="class_teacher_comment" class="col-md-4 col-form-label text-md-right">{{ __('Class teacher\'s comment:') }}</label>
                                
                                <div class="col-md-8">
                                    @if (($manage_all_results == 'Yes' OR $enrolment->arm->user_id == $user->id) && $enrolment->result_status != 'Approved')
                                        <textarea id="class_teacher_comment" class="form-control @error('class_teacher_comment') is-invalid @enderror" name="class_teacher_comment" placeholder="Enter class teacher's comment here...">{{ $enrolment->classteacher_comment }}</textarea>
                
                                        @error('class_teacher_comment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    @else
                                        <input type="hidden" name="class_teacher_comment" value="">
                                        <textarea id="class_teacher_comment_display" class="form-control" name="class_teacher_comment_display" disabled>{{ $enrolment->classteacher_comment }}</textarea>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row"> 
                                <label for="principal_comment" class="col-md-4 col-form-label text-md-right">{{ __('Principal\'s comment:') }}</label>
                                
                                <div class="col-md-8">
                                    @if ($manage_all_results == 'Yes' && $enrolment->result_status != 'Approved')
                                        <textarea id="principal_comment" class="form-control @error('principal_comment') is-invalid @enderror" name="principal_comment" placeholder="Enter principal's comment here...">{{ $enrolment->principal_comment }}</textarea>
                
                                        @error('principal_comment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    @else
                                        <input type="hidden"name="principal_comment" value="">
                                        <textarea id="principal_comment_display" class="form-control" name="principal_comment_display" disabled><?php if(strlen($enrolment->principal_comment) > 0){ echo $enrolment->principal_comment; }else{ echo 'None'; } ?></textarea>
                                    @endif
                                </div>
                            </div>

                            @if ($enrolment->term->type == 'Promotion term')
                                <div class="form-group row"> 
                                    <label for="present_class" class="col-md-4 col-form-label text-md-right">{{ __('Present class:') }}</label>
                                    
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}" disabled>
                                    </div>
                                </div>
                                @if ($manage_student_promotion == 'Yes')
                                    <div class="form-group row"> 
                                        <label for="schoolclass_id" class="col-md-4 col-form-label text-md-right">{{ __('Next class (promotion/demotion):') }}</label>
                    
                                        <div class="col-md-8">
                                            <div class="alert alert-info">Specify the class arm that this student will be promoted or demoted to.</div>
                                            <div class="row">
                                                @foreach ($enrolment->school->schoolclasses as $schoolclass)
                                                    <div class="col-md-6">
                                                        <div style="border: solid 1px #e2e2e2; background-color: #fff; margin: 3px 0; padding: 7px 10px;">
                                                            <span class="badge badge-info">{{ $schoolclass->name }} classes</span>
                                                            <?php $class_displayed = 0; ?>
                                                            @foreach ($schoolclass->arms as $arm)
                                                                <div style="vertical-align: middle; padding: 5px 0 5px 10px;">
                                                                    <input type="radio" name="next_class" id="next_class{{ $enrolment->id.'_'.$arm->id }}" value="{{ $arm->id }}" required> &nbsp;&nbsp;<label for="next_class{{ $enrolment->id.'_'.$arm->id }}">{{ $schoolclass->name.' '.$arm->name }}</label>
                                                                </div>
                                                                <?php $class_displayed++; ?>
                                                            @endforeach
                                                            <?php if($class_displayed == 0){ echo '<div style="vertical-align: middle; padding: 5px 0 5px 10px;"><b>None!</b></div>'; } ?>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div style="padding: 15px;"></div>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="next_class" value="{{ $enrolment->next_class }}">
                                @endif
                            @endif

                            @if ($manage_all_results == 'Yes')
                                <div class="form-group row"> 
                                    <label class="col-md-4 col-form-label text-md-right">{{ __('Result status:') }}</label>
        
                                    <div class="col-md-8">
                                        @if ($enrolment->result_status == 'Pending')
                                            <div style="padding-bottom: 5px;"><span class="badge badge-secondary">NOT sent for approval</span></div>
                                        @elseif ($enrolment->result_status == 'Pending Approval')
                                            <span class="badge badge-info">Waiting for approval</span>
                                        @elseif($enrolment->result_status == 'NOT Approved')
                                            <div style="padding-bottom: 5px;"><span class="badge badge-danger">NOT approved</span></div>
                                        @elseif ($enrolment->result_status == 'Approved')
                                            <span class="badge badge-success">Approved</span>
                                        @endif
                                        <div class="small"><div class="alert alert-info">Choose either to approve or reject this result.</div></div>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="radio" name="result_status{{ $enrolment->id }}" id="result_statusa{{ $enrolment->id }}" value="Approved" <?php if($enrolment->result_status == 'Approved'){ echo 'checked'; } ?> required> <label for="result_statusa{{ $enrolment->id }}">Approve</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="radio" name="result_status{{ $enrolment->id }}" id="result_statusb{{ $enrolment->id }}" value="NOT Approved" required> <label for="result_statusb{{ $enrolment->id }}">Reject</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($enrolment->arm->user_id == $user->id)
                            <div class="form-group row"> 
                                <label class="col-md-4 col-form-label text-md-right">{{ __('Result status:') }}</label>
    
                                <div class="col-md-8">
                                    @if ($enrolment->result_status == 'Pending')
                                        <div style="padding-bottom: 5px;"><span class="badge badge-secondary">NOT sent for approval</span></div>
                                        <div class="small"><div class="alert alert-info">Choose whether or NOT to send this result for approval.</div></div>
                                        <div class="row">
                                            <div class="col-5">
                                                <input type="radio" name="result_status{{ $enrolment->id }}" id="result_statusa{{ $enrolment->id }}" value="Pending Approval" required> <label for="result_statusa{{ $enrolment->id }}">Send for approval</label>
                                            </div>
                                            <div class="col-7">
                                                <input type="radio" name="result_status{{ $enrolment->id }}" id="result_statusb{{ $enrolment->id }}" value="Do_nothing" required> <label for="result_statusb{{ $enrolment->id }}">Do NOT send for approval</label>
                                            </div>
                                        </div>
                                    @elseif ($enrolment->result_status == 'Pending Approval')
                                        <span class="badge badge-info">Pending approval</span>
                                        <input type="hidden" name="result_status{{ $enrolment->id }}" value="">
                                    @elseif($enrolment->result_status == 'NOT Approved')
                                        <div style="padding-bottom: 5px;"><span class="badge badge-danger">NOT approved</span></div>
                                        <div class="small"><div class="alert alert-info">Choose whether or NOT to resend this result for approval.</div></div>
                                        <div class="row">
                                            <div class="col-5">
                                                <input type="radio" name="result_status{{ $enrolment->id }}" id="result_statusa{{ $enrolment->id }}" value="Pending Approval" required> <label for="result_statusa{{ $enrolment->id }}">Send for approval</label>
                                            </div>
                                            <div class="col-7">
                                                <input type="radio" name="result_status{{ $enrolment->id }}" id="result_statusb{{ $enrolment->id }}" value="Do_nothing" required> <label for="result_statusb{{ $enrolment->id }}">Do NOT send for approval</label>
                                            </div>
                                        </div>
                                    @elseif ($enrolment->result_status == 'Approved')
                                        <span class="badge badge-success">Approved</span>
                                        <input type="hidden" name="result_status{{ $enrolment->id }}" value="">
                                    @endif
                                </div>
                            </div>
                            @endif
                        

                        </div>
                    </div>

                    @if ($manage_all_results == 'Yes')
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    @else
                        @if ($enrolment->result_status != 'Approved')
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-5">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endif
                </form>
            </div>
        </div>
      </div>
    </div>
</div>
<!-- End studentResultModal -->