<?php
/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      En-tête et menu des pages utilisées dans la console d'admin
***************************************************************************/
?>

<div id="content">
    <!-- Menu de la console d'administration -->      
    <div id="header">
        <div id="header_logo">
            <a href="../index.php"><img src="../../pictures/logoCas_small.png" /></a>
        </div>
        <div id="menu">
            <menu>
                <li><a href="../randonnees/GestionRando.php">Gestion des randonnées</a></li>
                <li><a href="../inscriptions/GestionInscriptions.php">Gestion des inscriptions</a></li>
                <?php
									//MAE - Seulement admin
												if($_SESSION['role'] == 'admin'){ ?>
													<li><a href="../membres/GestionMembres.php">Gestion des personnes</a></li>
												<?php } ?>
                <li><a href="../sms/GestionEnvoi.php">Plateforme SMS</a></li>
            </menu>
        </div>
    </div>
		<!--Sabine Mathieu : affiche le bouton de déconnexion-->
		<a id="deconnexion" href="../Deconnexion.php">Déconnexion</a>
    <div id="seperator" ></div>