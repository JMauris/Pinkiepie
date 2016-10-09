
<!DOCTYPE html>
<?php



?>

<html>
    <head>

      <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

        <link rel="stylesheet" href="/<?php echo SITE_NAME; ?>/public/css/headerStyle.css" type="text/css">

        <title>Cas Montana</title>
    </head>
    <body>
      <ul class="ulh">
        <li class="lih"><a class="ah" href="<?php echo URL_DIR.'mainPage/mainPage'?>">Home</a></li>
        <li class="lih"><a class="ah" href="<?php echo URL_DIR.'programm/programm'?>">Program</a></li>
        <?php if(isset($_SESSION["personne"]))
        {
            echo  '<li class="lih"><a class="ah" href="' .URL_DIR."myProgram/myProgram". ' ">My Program</a></li>';
        }?>
        <li class="lih"><a class="ah" href="<?php echo URL_DIR.'proposal/proposal'?>">Proposal</a></li>
        <?php if(isset($_SESSION["personne"]))
        {
            echo  '<li class="lih"><a class="ah" href="' .URL_DIR."myProposal/myProposal". ' "">MyProposal</a></li>';
        }?>
        <li class="lih"><a class="ah" href="<?php echo URL_DIR.'contact/contact'?>">Contact</a></li>
        <li class="lih"><a class="ah"  href="<?php echo URL_DIR.'about/about'?>">About</a></li>
        <?php if(isset($_SESSION["personne"]))
        {
            echo  '<li class="lih"><a class="ah" href="' .URL_DIR."profil/profil". ' "">Profil</a></li>';
            }?>

        <?php if(isset($_SESSION["personne"]))

        {
          echo  '<c><a class="ah" href="' .URL_DIR."login/logout". ' ">Logout</a></c> ' ;
        }
        else {
         echo  '<c><a class="ah" href="' . URL_DIR."login/login". ' ">Login</a></c>';
        }

        ?>
      </ul>

    </body>

</html>
