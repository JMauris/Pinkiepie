<?php include_once ROOT_DIR.'global/header.php';

//Collect data from controller
$msg = $this->vars['msg'];

?>
<br><br>
<form action="<?php echo URL_DIR.'login/connection';?>" method="post">
	<table align="center">
		<tr>
			<td>
				<?php echo $msg;?>
				<h1>Mon Cas</h1>
				Email :<br><input type="text" name="email" size="25"/><br>
				Mot de passe :<br><input type="password" name="password" size="25"/><br><br>
				<input type="submit" name="Submit" value="  OK  "/>
				<br/><br/>
				<a href="<?php echo URL_DIR.'login/newuser';?>">Register</a>
			</td>
		</tr>
	</table>
</form>
<br/><br/><br/><br/>
<?php
unset($_SESSION['msg']);
include_once ROOT_DIR.'global/footer.php';
?>
