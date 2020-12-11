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
            
            <small><div class="alert alert-info"><b>Hint: </b>Select the preferred privileges and click on save</div></small>

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
                        @foreach ($enrolment->results as $result_slip)
                            <tr>
                                <td>{{ $result_slip->classsubject->subject->name }}</td>
                                <td></td>
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
                            <?php $total = 0; ?>
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

            <div class="create-form">
                <form method="POST" action="#">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="item_to_update" value="access_privileges">

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5">
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
<!-- End studentResultModal -->