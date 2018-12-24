<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Account Locked</title>
	</head>
	<body>
		<table align="center" width="65%" style="background-color: #f5f5f5;padding: 20px;">
			<thead>
				<tr>
					<td>Dear <?php echo isset($name) ? $name : '';?>,</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Your User Management account, whose login id is: <strong><?php echo isset($user_name) ? $user_name : '';?></strong>, has been locked because of inserting <strong style="color: #ff0000">Wrong Password</strong> more than or equal to 3 times.</td>
				</tr>
				<tr>
					<td>
						Please send a request email, to <strong>developer@datarpgx.com</strong>, to unlock your account.
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td>
						<div style="font-size: 12px;">
							Note: This is a system generated email. Please do not reply to this email.
						</div>
					</td>
				</tr>
			</tfoot>
		</table>
					
	</body>
</html>