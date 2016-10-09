<?php include_once ROOT_DIR.'global/header.php';


?>


<br><br>
<h1> My Profil</h1>


<form method="post" action="<?php echo URL_DIR.'profil/profil';?>">
	<table align="center">



    <tr>
			<th><label for="name">Name</label> : </th><th><input type="text" name="firstname" value=""></th>
    </tr>
      <tr>
			<th><label for="lastname">Lastname</label> : </th><th><input type="text" name="lastname" value=""></th>
    </tr>
      <tr>
			<th><label for="adress">Adress</label> :  </th><th><input type="text" name="username" value=""></th>
    </tr>
      <tr>
			<th><label for="npa">NPA</label> :  </th><th><input type="password" name="password" value=""></th>
    </tr>
      <tr>
      <th><label for="locality">Locality</label> :  </th><th><input type="text" name="firstname" value=""></th>
    </tr>
      <tr>
      <th><label for="phone">Phone</label> :  </th><th><input type="text" name="lastname" value=""></th>
    </tr>
      <tr>
      <th><label for="moblie">Mobile</label> :  </th><th><input type="text" name="username" value=""></th>
    </tr>
      <tr>
    	<th><label for="email">Email</label> :  </th><th><input type="password" name="password" value=""></th></br>
    </tr>
      <tr>
       <th></th><th><input type="submit" name="action" value="Save"></th>
    </tr>

	</table>
</form>
  <a href="">Change the password</a>



<?php
unset($_SESSION['msg']);
include_once ROOT_DIR.'global/footer.php';
?>
