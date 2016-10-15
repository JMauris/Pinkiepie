<?php include_once ROOT_DIR.'global/header.php';
$user = $_SESSION['personne'];


?>

<head>
	<meta charset="UTF-8">
	<title>SAC Info</title>
	<link rel="stylesheet" type="text/css" href="http://localhost/cas_montana/public/css/main.css">

</head>
<body>

<br><br>
	<div>
<h1> My Profil</h1>


<form method="post" action="<?php echo URL_DIR.'profil/save';?> " onsubmit="alert('Saved')">
	<table align="center">

		<tr>
			<th>* = field obligatory</th>
		</tr>

    <tr>
			<th><label for="name">Name</label>* : </th><th><input type="text" name="firstname" value=" <?php echo $user->getLastname()?>"  disabled="disabled"></th>
    </tr>
      <tr>
			<th><label for="lastname">Lastname</label>* : </th><th><input type="text" name="lastname" value="<?php echo $user->getFirstname()?>" disabled="disabled"></th>
    </tr>
      <tr>
			<th><label for="adress">Adress</label>* :  </th><th><input type="text" name="adress" value="<?php echo $user->getAdresse()?>"></th>
    </tr>
      <tr>
			<th><label for="npa">NPA</label>* :  </th><th><input type="text" name="npa" value="<?php echo $user->getNpa()?>"></th>
    </tr>
      <tr>
      <th><label for="locality">Locality</label>* :  </th><th><input type="text" name="localite" value="<?php echo $user->getLocalite()?>"></th>
    </tr>
      <tr>
      <th><label for="phone">Phone</label> :  </th><th><input type="text" name="phone" value="<?php echo $user->getPhone()?>"></th>
    </tr>

      <tr>
      <th><label for="moblie">Mobile</label> :  </th><th><input type="text" name="mobile" value="<?php echo $user->getPortable()?>"></th>
    </tr>

      <tr>
    	<th><label for="email">Email</label> :  </th><th><input type="text" name="email" value="<?php echo $user->getEmail()?>"></th></br>
    </tr>
		<tr>
		<th><label for="abonnement">Abonnement de transports publics</label> :  </th><th>
<?php
$optionAbo = array('Select please', 'neither','gerneral rail pass', 'half price');
 ?>
    <FORM>
    <SELECT name="abonnement" >


<?php
for ($cpt=0; $cpt<=3; $cpt++) {
	if(($cpt)==$user->getIdxAbonnement())
	{
		echo '<option value="'.$cpt.'" selected="selected">'.$optionAbo[$cpt] .'</option>';
	}else {
	echo '<option value="'.$cpt.'">'.$optionAbo[$cpt].'</option>';
	}
}
?>
</SELECT>
</FORM>
</th></br>
	</tr>
      <tr>
       <th></th><th><input type="submit" name="action" value="Save"></th>
		 </tr>
       <tr>
		   <th></th><th>	<a href="">Change the password</a></th>
		</tr>
	</table>
</form>


</div>
</body>
<?php
unset($_SESSION['msg']);
//include_once ROOT_DIR.'global/footer.php';
?>
