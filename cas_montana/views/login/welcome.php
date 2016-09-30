<?php
include_once ROOT_DIR.'global/header.php';

//Collect data from controller and session
$msg = $this->vars['msg'];
$user = $_SESSION['personne']; //<h1>Welcome <?php echo ' '.$user->getFirstname().' '.$user->getLastname();?>
?>
<br><br>
	<table align="center">
		<tr>
			<td>
				<?php echo $msg;?>
				<h1>Welcome <?php echo ' '.$user->getFirstname().' '.$user->getLastname();?> </h1></h1>
				<a href="<?php echo URL_DIR.'login/logout';?>">Logout</a>
			</td>
		</tr>
	</table>
</form>
<br/><br/><br/><br/>
<?php
unset($_SESSION['msg']);
include_once ROOT_DIR.'global/footer.php';
?>
