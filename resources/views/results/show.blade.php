<!DOCTYPE html> 
<html> 

<head> 
	<title> 
		Print the content of a div 
	</title> 
	
	<!-- Script to print the content of a div -->
	<script> 
		function printDiv() { 
			var divContents = document.getElementById("GFG").innerHTML; 
			var a = window.open('', '', 'height=500, width=800'); 
			a.document.write('<html>'); 
			a.document.write('<body> <h1>Div contents are <br>'); 
			a.document.write(divContents); 
			a.document.write('</body></html>'); 
			a.document.close(); 
			a.print(); 
		} 
	</script> 
</head> 

<body> 
	<center> 
		<div id="GFG"> 
			
			<h2>Geeksforgeeks result for {{ $enrolment->user->name }}</h2> 
			
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
		
		<p> 
			The table is inside the div and will get 
			printed on the click of button. 
		</p> 
		
		<input type="button" value="click"
					onclick="printDiv()"> 
	</center> 
</body> 

</html>									 
