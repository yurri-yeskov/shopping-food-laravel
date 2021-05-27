<!DOCTYPE html>
<html lang="en">
<head>
<title>Local Fine Foods Reply to Request</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

</head>
<body style="background-color:#fff; font-family:arial; font-size:14px;">
<center>
	<table width="800" cellspacing="0" style="border:1px solid #efefef; border-radius:5px; overflow:hidden">
		<tr>
			<td bgcolor="#516672" style="padding:10px 20px;">
				<table style="width:100%;">
					<tr>
						<td width="40%" style="color:#fff;">
							VL - Taxi App
						</td>
						<td style="color:#fff">
							&nbsp;
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="text-align:center; padding:40px 50px 10px; border-bottom:1px solid #e1e1e1;" bgcolor="#f9f9f9">
				<div style="margin:20px auto 10px; font-size:18px;"><h4>Admin has replied to your Support Request</h4></div>
				<div style="margin:20px auto 10px; font-size:28px;">
					Booking ID: {{$mailData['bookingID']}}<br>
					User: {{$mailData['user']}}<br>
					Driver: {{$mailData['driver']}}<br>
					Date: {{$mailData['date']}}<br><br>
					Message: {{$mailData['msg']}}<br>
				</div>
			</td>
		</tr>
		{{-- <tr><td style="border-bottom:1px solid #efefef">&nbsp;</td></tr> --}}
		<tr>
			<td style="text-align:center; padding:20px 10px 20px; font-size:13px; color:#666;">Copyright @ {{ date('Y') }} VL - Taxi App. All rights reserved.</td>
		</tr>

	</table>
</center>
</body>
</html>

