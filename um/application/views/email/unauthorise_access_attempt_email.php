<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Unauthorise Access</title>
	</head>
	<body>
		<table align="center" width="50%" style="background-color: #f5f5f5;padding: 20px;">
			<tr>
				<td>Dear Admin,</td>
			</tr>
			<tr>
				<td>An unauthorised access has been attempted for login at datargene.com</td>
			</tr>
			<tr>
				<td>
					<div style="margin-top: 30px;">
						<label>Follwing are the details:</label>
						<table align="center" width="80%" border="0" cellpadding="5" cellspacing="0" style="border: 1px solid #ccc;margin-top: 10px;">
							<tr>
								<td>User Name</td>
								<td>:</td>
								<td><strong><?php echo isset($user_name) ? $user_name : '';?></strong></td>
							</tr>
							<tr>
								<td>Ip Addess</td>
								<td>:</td>
								<td><strong><?php echo isset($ip_addesss) ? $ip_addesss : '';?></strong></td>
							</tr>
							<tr>
								<td>Status</td>
								<td>:</td>
								<td><strong><?php echo isset($status) ? $status : '';?></strong></td>
							</tr>
							<tr>
								<td>Date</td>
								<td>:</td>
								<td><strong><?php echo date("d-m-Y h:i A");?></strong></td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</body>
</html>