<!DOCTYPE html> 
<html> 

<head> 
	<title> 
		Termly result slip 
	</title> 
	
	<!-- Script to print the content of a div -->
	<script> 
		function printDiv() { 
			var divContents = document.getElementById("GFG").innerHTML; 
			var a = window.open('', '', 'height=1200, width=800'); 
			a.document.write('<html>'); 
			a.document.write('<body>'); 
			a.document.write(divContents); 
			a.document.write('</body></html>'); 
			a.document.close(); 
			a.print(); 
		} 
	</script> 
</head> 

<body> 
	<center> 
		<div id="GFG" style="width: 800px;"> 
			
			<div style="border: 3px solid #666; padding: 20px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

				<div style="text-align: center;">

					<div style="padding-bottom: 15px; font-size: 0.8em; color: #919191">Termly Result Slip</div>

					<table width="100%" border="0" cellspacing="0">
						<tr style="vertical-align: top;">
							<td width="78px">

								<img src="{{ config('app.url') }}/images/school/{{ $enrolment->school->logo }}" alt="School Logo" width="75px;">

							</td>
							<td style="text-align: center;">

								<div style="font-size: 1.3em; font-weight: 600">
									{{ strtoupper($enrolment->school->school) }}
								</div>
								<div style="padding-top: 12px; font-size: 0.8em;">
									{{ strtoupper($enrolment->school->address) }}
								</div>
								<div style="padding-top: 5px; font-size: 0.8em;">
									<b><i><span style="color: #7a7a7a">Phone: </span></i></b>{{ $enrolment->school->phone }} |
									<b><i><span style="color: #7a7a7a">Email: </span></i></b>{{ $enrolment->school->email }}
								</div>

							</td>
							<td width="78px"></td>
						</tr>
					</table>

					<div style="padding: 20px 0 12px 0; font-size: 0.9em; font-weight: 600">
						{{ strtoupper($enrolment->term->session.', '.$enrolment->term->name.' (Termly Examination) Result') }}
					</div>

					<table width="100%" cellspacing="0" style="border:1px solid #d3d3d3; text-align: left; font-size: 0.9em;">
						<tr style="vertical-align: middle;">
							<td width="73px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Name:
							</td>
							<td width="304px" style="border:1px solid#d3d3d3; padding: 3px;">
								{{ strtoupper($enrolment->user->name) }}
							</td>
							<td rowspan="4" width="6px" style="border:1px solid #d3d3d3;"></td>
							<td width="158px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Class:
							</td>
							<td width="125px" style="border:1px solid #d3d3d3; padding: 3px;">
								{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}
							</td>
							<td rowspan="4" style="border:1px solid #d3d3d3; padding: 3px; text-align: center">

								<img src="{{ config('app.url') }}/images/profile/{{ $enrolment->user->pic }}" alt="Student photo" width="78px;" style="border: 2px solid #d3d3d3; border-radius: 50%;">
							
							</td>
						</tr>
						<tr style="vertical-align: middle;">
							<td width="73px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Gender:
							</td>
							<td width="304px" style="border:1px solid #d3d3d3; padding: 3px;">
								{{ $enrolment->user->gender }}
							</td>
							<td width="158px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Reg. no.:
							</td>
							<td width="125px" style="border:1px solid #d3d3d3; padding: 3px;">
								{{ $enrolment->student->registration_number }}
							</td>
						</tr>
						<tr style="vertical-align: middle;">
							<td width="73px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								DoB:
							</td>
							<td width="304px" style="border:1px solid #d3d3d3; padding: 3px;">
								{{ date('d-M-Y', strtotime($enrolment->student->date_of_birth)) }}
							</td>
							<td width="158px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Enrolment ID:
							</td>
							<td width="125px" style="border:1px solid #d3d3d3; padding: 3px;">
								{{ $enrolment->id }}
							</td>
						</tr>
						<tr style="vertical-align: middle;">
							<td width="73px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Email:
							</td>
							<td width="304px" style="border:1px solid #d3d3d3; padding: 3px;">
								{{ $enrolment->user->email }}
							</td>
							<td width="158px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								
							</td>
							<td width="125px" style="border:1px solid #d3d3d3; padding: 3px;">
								
							</td>
						</tr>
					</table>

					<?php
						if($enrolment->arm->resulttemplate->ca_display == 'Summary')
						{
							$ca = $enrolment->arm->resulttemplate->subject_1st_test_max_score + 
									$enrolment->arm->resulttemplate->subject_2nd_test_max_score +
									$enrolment->arm->resulttemplate->subject_3rd_test_max_score +
									$enrolment->arm->resulttemplate->subject_assignment_score;
					?>
					<table width="100%" cellspacing="0" style="margin-top: 15px; border:1px solid #d3d3d3; text-align: left; font-size: 0.9em;">
						<tr style="vertical-align: middle;">
							<th width="20px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								#
							</th>
							<th width="215px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Subject
							</th>
							<th width="74px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								C.A. (%)<br />
								{{ $ca }}
							</th>
							<th width="74px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Exam (%)<br />{{ $enrolment->arm->resulttemplate->subject_exam_score }}
							</th>
							<th width="74px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Total (%)<br />100
							</th>
							<th width="55px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Grade
							</th>
							<th style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Remark
							</th>
						</tr>
						<?php
							$sn = 0;
							foreach ($enrolment->results as $result_slip) {

								$sn++;

								$ca = $result_slip->subject_1st_test_score + $result_slip->subject_2nd_test_score +
									$result_slip->subject_3rd_test_score + $result_slip->subject_assignment_score;

								$total = $ca + $result_slip->subject_exam_score;

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
						?>
						<tr style="vertical-align: middle;">
							<td style="border:1px solid #d3d3d3; padding: 3px;">{{ $sn }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; font-size: 0.9em;">{{ strtoupper($result_slip->classsubject->subject->name) }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $ca }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $result_slip->subject_exam_score }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $total }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $grade }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $remark }}</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
						else
						{
							// for ca_display == 'Breakdown'
					?>
					<table width="100%" cellspacing="0" style="margin-top: 15px; border:1px solid #d3d3d3; text-align: left; font-size: 0.9em;">
						<tr style="vertical-align: middle;">
							<th width="20px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								#
							</th>
							<th width="180px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Subject
							</th>
							@if ($enrolment->arm->resulttemplate->subject_1st_test_max_score > 0)
							<th width="54px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								1st Test (%)<br />
								{{ $enrolment->arm->resulttemplate->subject_1st_test_max_score }}
							</th>
							@endif
							@if ($enrolment->arm->resulttemplate->subject_2nd_test_max_score > 0)
							<th width="54px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								2nd Test (%)<br />
								{{ $enrolment->arm->resulttemplate->subject_2nd_test_max_score }}
							</th>
							@endif
							@if ($enrolment->arm->resulttemplate->subject_3rd_test_max_score > 0)
							<th width="54px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								3rd Test (%)<br />
								{{ $enrolment->arm->resulttemplate->subject_3rd_test_max_score }}
							</th>
							@endif
							@if ($enrolment->arm->resulttemplate->subject_assignment_score > 0)
							<th width="54px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Assign. (%)<br />
								{{ $enrolment->arm->resulttemplate->subject_assignment_score }}
							</th>
							@endif
							<th width="54px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Exam (%)<br />{{ $enrolment->arm->resulttemplate->subject_exam_score }}
							</th>
							<th width="54px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Total (%)<br />100
							</th>
							<th width="35px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Grade
							</th>
							<th style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600; text-align: center;">
								Remark
							</th>
						</tr>
						<?php
							$sn = 0;
							foreach ($enrolment->results as $result_slip) {

								$sn++;

								$total = $result_slip->subject_1st_test_score + $result_slip->subject_2nd_test_score +
										$result_slip->subject_3rd_test_score + $result_slip->subject_assignment_score +
										$result_slip->subject_exam_score;

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
						?>
						<tr style="vertical-align: middle">
							<td style="border:1px solid #d3d3d3; padding: 3px;">{{ $sn }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; font-size: 0.9em;">{{ strtoupper($result_slip->classsubject->subject->name) }}</td>
							@if ($enrolment->arm->resulttemplate->subject_1st_test_max_score > 0)
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $result_slip->subject_1st_test_score }}</td>
							@endif
							@if ($enrolment->arm->resulttemplate->subject_2nd_test_max_score > 0)
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $result_slip->subject_2nd_test_score }}</td>
							@endif
							@if ($enrolment->arm->resulttemplate->subject_3rd_test_max_score > 0)
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $result_slip->subject_3rd_test_score }}</td>
							@endif
							@if ($enrolment->arm->resulttemplate->subject_assignment_score > 0)
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $result_slip->subject_assignment_score }}</td>
							@endif
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $result_slip->subject_exam_score }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $total }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $grade }}</td>
							<td style="border:1px solid #d3d3d3; padding: 3px; text-align: center;">{{ $remark }}</td>
						</tr>
						<?php
							}
						?>
					</table>
					<?php
						}
					?>
					
					<table border="0" cellspacing="0" width="100%">
						<tr>
							<td width="250px" style="vertical-align: top">
								<table width="100%" cellspacing="0" style="margin-top: 15px; border:1px solid #d3d3d3; text-align: left; font-size: 0.9em;">
									<tr style="vertical-align: middle;">
										<td width="20px" style="border:1px solid #d3d3d3; padding: 3px;">
											<div style="font-size: 0.9em; font-weight: 600;">Key to Grades</div>
											<table>
												@php
													$grade_symbol = $enrolment->arm->resulttemplate->symbol_95_to_100;
													$grade = $enrolment->arm->resulttemplate->grade_95_to_100;
													$score = $starting_score = 100;
													while ($score >= -1) {
														if($score >= 95 && $score <= 100)
														{
															if($grade_symbol != $enrolment->arm->resulttemplate->symbol_95_to_100 &&
																$grade != $enrolment->arm->resulttemplate->grade_95_to_100)
															{
																echo '<tr><td>'.($score+1).' - '.$starting_score.'</td><td> : '.$grade_symbol.' = '.$grade.'</td></tr>';
																$starting_score = $score;
																$grade_symbol = $enrolment->arm->resulttemplate->symbol_95_to_100;
																$grade = $enrolment->arm->resulttemplate->grade_95_to_100;
															}
														}
														if($score >= 65 && $score < 70)
														{
															if($grade_symbol != $enrolment->arm->resulttemplate->symbol_65_to_69 &&
																$grade != $enrolment->arm->resulttemplate->grade_65_to_69)
															{
																echo '<tr><td>'.($score+1).' - '.$starting_score.'</td><td> : '.$grade_symbol.' = '.$grade.'</td></tr>';
																$starting_score = $score;
																$grade_symbol = $enrolment->arm->resulttemplate->symbol_65_to_69;
																$grade = $enrolment->arm->resulttemplate->grade_65_to_69;
															}
														}
														if($score >= 45 && $score < 50)
														{
															if($grade_symbol != $enrolment->arm->resulttemplate->symbol_45_to_49 &&
																$grade != $enrolment->arm->resulttemplate->grade_45_to_49)
															{
																echo '<tr><td>'.($score+1).' - '.$starting_score.'</td><td> : '.$grade_symbol.' = '.$grade.'</td></tr>';
																$starting_score = $score;
																$grade_symbol = $enrolment->arm->resulttemplate->symbol_45_to_49;
																$grade = $enrolment->arm->resulttemplate->grade_45_to_49;
															}
														}
														if($score >= 10 && $score < 15)
														{
															if($grade_symbol != $enrolment->arm->resulttemplate->symbol_10_to_14 &&
																$grade != $enrolment->arm->resulttemplate->grade_10_to_14)
															{
																echo '<tr><td>'.($score+1).' - '.$starting_score.'</td><td> : '.$grade_symbol.' = '.$grade.'</td></tr>';
																$starting_score = $score;
																$grade_symbol = $enrolment->arm->resulttemplate->symbol_10_to_14;
																$grade = $enrolment->arm->resulttemplate->grade_10_to_14;
															}
														}
														if($score >= 5 && $score < 10)
														{
															if($grade_symbol != $enrolment->arm->resulttemplate->symbol_5_to_9 &&
																$grade != $enrolment->arm->resulttemplate->grade_5_to_9)
															{
																echo '<tr><td>'.($score+1).' - '.$starting_score.'</td><td> : '.$grade_symbol.' = '.$grade.'</td></tr>';
																$starting_score = $score;
																$grade_symbol = $enrolment->arm->resulttemplate->symbol_5_to_9;
																$grade = $enrolment->arm->resulttemplate->grade_5_to_9;
															}
														}
														if($score >= 0 && $score < 5)
														{
															if($grade_symbol != $enrolment->arm->resulttemplate->symbol_0_to_4 &&
																$grade != $enrolment->arm->resulttemplate->grade_0_to_4)
															{
																echo '<tr><td>'.($score+1).' - '.$starting_score.'</td><td> : '.$grade_symbol.' = '.$grade.'</td></tr>';
																$starting_score = $score;
																$grade_symbol = $enrolment->arm->resulttemplate->symbol_0_to_4;
																$grade = $enrolment->arm->resulttemplate->grade_0_to_4;
															}
														}
														if($score >= -1 && $score < 0)
														{
															if($grade_symbol != '' &&
																$grade != '')
															{
																echo '<tr><td>'.($score+1).' - '.$starting_score.'</td><td> : '.$grade_symbol.' = '.$grade.'</td></tr>';
															}
														}
														$score--;
													}
												@endphp	
											</table>		
										</td>
									</tr>
								</table>
							</td>
							<td width="10px">

							</td>
							<td style="vertical-align: top">
								<table width="100%" cellspacing="0" style="margin-top: 15px; border:1px solid #d3d3d3; text-align: left; font-size: 0.9em;">
									<tr style="vertical-align: middle;">
										<td width="20px" style="border:1px solid #d3d3d3; padding: 3px;">
											<div style="font-size: 0.9em; font-weight: 600; text-align: center;">Overall Performance</div>											
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

				</div> 
			
			</div>

		</div> 
		
		<input type="button" style="margin: 20px; border: 1px solid #0084ff; padding: 8px 20px; background-color: #0084ff; color: #ffffff; 
									font-size: 0.9em; letter-spacing: 1.1px;" value="Print Result"
					onclick="printDiv()"> 
	</center> 
</body> 

</html>									 
