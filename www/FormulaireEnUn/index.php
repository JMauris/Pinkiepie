<!DOCTYPE html>
<html>
  <head>

  </head>
  <body>
    <p>
      <?php
      if(!isset($_POST['mot_de_passe'])OR $_POST['mot_de_passe'] != "PinkiePie")
      {
        echo'
          <form action="index.php" method="post">
        <p><label> Mot de passe ? :<input type="text" name="mot_de_passe" /></label></p>
        <p><input type="submit"></p>
        </form>';
        echo $_SERVER['REMOTE_ADDR'];
      }
      else {
          echo '<p>Welcome in the PARTY EVERYPONY !!!!! </p>';
      }
       ?>
    </p>

  </body>
</html>
