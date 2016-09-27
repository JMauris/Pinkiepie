<!DOCTYPE html>
<html>
  <head>

  </head>
  <body>
<p>
  Bonjour
  <?php echo htmlspecialchars($_POST['prenom']); //htmlspecialchars pour hoter les balise html
  echo '<p/>';
  if(isset ($_POST['isBrony']))
  {
    echo '<p>Welcome everypony !</p>';
  }
  else {
        echo '<p>Welcome !</p>';
  }
  ?>


</p>
  </body>

</html>
