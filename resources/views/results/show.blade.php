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
			var a = window.open('', '', 'height=1200, width=900'); 
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
		<div id="GFG" style="width: 900px;"> 
			
			<div style="border: 3px solid #666; padding: 20px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

				<div style="text-align: center;">

					<div style="padding-bottom: 15px; font-size: 0.8em; color: #919191">Termly Result Slip</div>

					<table border="0" cellspacing="0">
						<tr style="vertical-align: top;">
							<td width="98px">

								<img src="{{ config('app.url') }}/images/school/{{ $enrolment->school->logo }}" alt="School Logo" width="85px;">

							</td>
							<td width="700px" style="text-align: center;">

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
							<td width="98px"></td>
						</tr>
					</table>

					<div style="padding: 20px 0 12px 0; font-size: 0.9em; font-weight: 600">
						{{ strtoupper($enrolment->term->session.', '.$enrolment->term->name.' (Termly Examination) Result') }}
					</div>

					<table cellspacing="0" style="border:1px solid #d3d3d3; text-align: left; font-size: 0.9em;">
						<tr style="vertical-align: middle;">
							<td width="73px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Name:
							</td>
							<td width="304px" style="border:1px solid#d3d3d3; padding: 3px;">
								{{ strtoupper($enrolment->user->name) }}
							</td>
							<td rowspan="4" width="6px" style="border:1px solid #d3d3d3;"></td>
							<td width="150px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Class:
							</td>
							<td width="225px" style="border:1px solid #d3d3d3; padding: 3px;">
								{{ $enrolment->schoolclass->name.' '.$enrolment->arm->name }}
							</td>
							<td rowspan="4" width="140px" style="border:1px solid #d3d3d3; padding: 3px; text-align: center">

								<img src="{{ config('app.url') }}/images/profile/{{ $enrolment->user->pic }}" alt="Student photo" width="118px;" style="border: 2px solid #d3d3d3; border-radius: 50%;">
							
							</td>
						</tr>
						<tr style="vertical-align: middle;">
							<td width="73px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Gender:
							</td>
							<td width="304px" style="border:1px solid #d3d3d3; padding: 3px;">
								{{ $enrolment->user->gender }}
							</td>
							<td width="150px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Reg. no.:
							</td>
							<td width="225px" style="border:1px solid #d3d3d3; padding: 3px;">
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
							<td width="140px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								Term's Enrolment ID:
							</td>
							<td width="225px" style="border:1px solid #d3d3d3; padding: 3px;">
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
							<td width="140px" style="border:1px solid #d3d3d3; padding: 3px; background-color: #e2e2e2; font-size: 0.9em; font-weight: 600;">
								
							</td>
							<td width="225px" style="border:1px solid #d3d3d3; padding: 3px;">
								
							</td>
						</tr>
					</table>

				</div>
				
				<table border="1px" cellspacing="0"> 
					<tr> 
						<td style="text-align: right">computer</td> 
						<td>Algorithmmmmmmmmmmmmmmmm</td> 
					</tr> 
					<tr> 
						<td>Microwave</td> 
						<td>Infrared</td> 
					</tr> 
				</table> 
			
			</div>

		</div> 
		
		<p> 
			The table is inside the div and will get 
			printed on the click of button. 
		</p> 
		
		<input type="button" value="click"
					onclick="printDiv()"> 
	</center> 
</body> 

</html>									 
