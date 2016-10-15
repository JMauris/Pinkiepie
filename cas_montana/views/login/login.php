<?php include_once ROOT_DIR.'global/header.php';
	//Collect data from controller
	$msg = $this->vars['msg'];
?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="http://localhost/cas_montana/public/css/main.css">
		<style type="text/css">
			form {
				width:25%; 
    			margin:0 auto;
			}
		</style>
	</head>
	<body>
		<div>
			<h1>Mon Cas</h1>
			<form action="<?php echo URL_DIR.'login/connection';?>" method="post">
				<?php echo $msg;?>
				<table>
					<tr>
						<td>Email: </td>
						<td><input type="text" name="email" size="25"/><br></td>
					</tr>
					<tr>
						<td>Mot de passe: </td>
						<td><input type="password" name="password" size="25"/><br><br></td>
					</tr>
					<tr>
						<td><input type="submit" name="Submit" value="  OK  "/></td>
					</tr>
					<tr>
						<td>
							<br/>
							<a href="<?php echo URL_DIR.'login/newuser';?>">Register</a>
							<br/><br/>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>

<?php unset($_SESSION['msg']); include_once ROOT_DIR.'global/footer.php';?>
