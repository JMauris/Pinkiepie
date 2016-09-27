<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page de connexion pour la console d'administration
    ***************************************************************************/
    
    //Ajout des fichiers nécessaires au bon fonctionnement de la page
    include("../include/fonctions.inc.php");
    
    //variable pour l'email
    $email = '';
    
    //Contrôle si le formulaire a été envoyé
    if(isset($_POST['nomUtilisateur'])){
        $email = $_POST['nomUtilisateur'];
        //Connexion de l'utilisateur
        $infosConnexion = connexionAdmin($email, $_POST['mdp']);
        
        $personneInfo = mysql_fetch_array($infosConnexion);
        
        //Informations données correctes?
        if($personneInfo[0] != ''){
					//MAE - Contrôle rôle
					if($personneInfo[2] == 'admin' || $personneInfo[2] == 'chef'){
            //Récupération du nom
            $_SESSION['login'] = $personneInfo[1] . ' ' . $personneInfo[0];
						$_SESSION['role'] = $personneInfo[2];
             echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=index.php' />";
					}
        }
        else{
            echo "<script>alert('Erreur lors de la connexion');</script>";
        }
    }
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
            </div>
            <div id="seperator" ></div>
            <div id="main">
                <h2>Connexion</h2>
                <form method="post">
                    
                    <span class="label">Email:</span>
                    <span class="champ"><input type="text" name="nomUtilisateur" id="nomUtilisateur" value="<?php echo $email; ?>" /></span><br />
                        
                    <span class="label">Mot de passe:</span>
                    <span class="champ"><input type="password" name="mdp" id="mdp" /></span><br />
                        
                    <input type="submit" value="Se connecter" />
                    
                </form>
            </div>
            <div id="footer">
                <div class="footer-text">
                    <b>Copyright Cas Montana 2013</b>
                </div>
            </div>
        </div>
    </body>
</html>