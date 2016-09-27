<?php
session_start();
//Sabine Mathieu : Contrôle si l'utilisateur est connecté, sinon affiche la page de connexion
if(!isset($_SESSION['login']) || $_SESSION['login'] == ''){
    echo " <META HTTP-EQUIV='refresh' CONTENT='0;URL=connexion.php' />";
}
/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Page d'accueil de la console d'administration
***************************************************************************/
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta>
        <title>Console d'administration</title>
        <link rel="stylesheet" href="include/style.css" />
    </head>
    <body>
        <div id="content">    
            <div id="header">
                <div id="header_logo">
                    <img src="../pictures/logoCas_small.png"></img>
                </div>
                <div id="menu">
                    <menu>
                        <li><a href="randonnees/GestionRando.php">Gestion des randonnées</a></li>
                        <li><a href="inscriptions/GestionInscriptions.php">Gestion des inscriptions</a></li>
                        <?php 
												//MAE - Seulement admin
												if($_SESSION['role'] == 'admin'){ ?>
													<li><a href="membres/GestionMembres.php">Gestion des personnes</a></li>
												<?php } ?>
                        <li><a href="sms/GestionEnvoi.php">Plateforme SMS</a></li>
                    </menu>
                </div>
            </div>
            <!--Sabine Mathieu : affiche le bouton de déconnexion-->
						<a id="deconnexion" href="Deconnexion.php">Déconnexion</a>
            <div id="seperator" ></div>
            <div id="main">
                <h3>Meilleurs Randonneurs?</h3>
                <a href="randonnees/MeilleursRandos.php">Voir la liste des meilleurs randonneurs</a>
								
								<?php 
									//MAE - Stats
									if($_SESSION['role'] == 'admin'){ ?>
										<h3>Statistiques</h3>
										<a href="stats.php">Gestion des personnes</a>
										
										<?php
												//Si le lien du fichier est en paramètre, afficher le lien
												if(isset($_GET['file'])){
														echo "<a href='" . $_GET['file'] . "'>Récupérer le fichier</a>";
												}
										?>
								<?php } ?>
            </div>
            <div id="footer">
                <div class="footer-text">
                    <b>Copyright Cas Montana 2013</b>
                </div>
            </div>
        </div>
       

    </body>
</html>