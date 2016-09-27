<?php
session_start();

   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page de deconnexion
    ***************************************************************************/
    //vide la variable de session
    $_SESSION['login'] = '';
    
    //Redirige vers la page d'accueil
    echo " <META HTTP-EQUIV='refresh' CONTENT='0;URL=index.php' />";
?>
