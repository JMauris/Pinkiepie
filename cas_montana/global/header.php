
<!DOCTYPE html>


<html>
    <head>

      <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

        <link rel="stylesheet" href="/<?php echo SITE_NAME; ?>/public/css/headerStyle.css" type="text/css">

        <title>Cas Montana</title>
    </head>
    <body>
      <ul class="ulh">
        <li class="lih"><a class="ah" href="#Program">Program</a></li>
        <?php if(isset($_SESSION["personne"]))
        {
            echo  '<li class="lih"><a class="ah" href="#MyProgram">My Program</a></li>';
        }?>
        <li class="lih"><a class="ah" href="#Proposal">Proposal</a></li>
        <?php if(isset($_SESSION["personne"]))
        {
            echo  '<li class="lih"><a class="ah" href="#MyProposal">MyProposal</a></li>';
        }?>
        <li class="lih"><a class="ah" href="#contact">Contact</a></li>
        <li class="lih"><a class="ah" href="#about">About</a></li>
        <li class="lih"><a class="ah" href="#Profil">Profil</a></li>
        <?php if(isset($_SESSION["personne"]))
        {
            echo  '<li class="lih"><a class="ah" href="#MyProposal">MyProposal</a></li>';
        }?>
        <c><a class="ah" href="#log">Login</a></c>
      </ul>

    </body>

</html>