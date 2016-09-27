<?php session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Sommet des pages affichées dans la console d'administration,
    *           Ajout des fichiers liés aux différentes pages et styles
    ***************************************************************************/
		//Sabine Mathieu : Contrôle si l'utilisateur est connecté, sinon affiche la page de connexion
		if(!isset($_SESSION['login']) || $_SESSION['login'] == ''){
    echo " <META HTTP-EQUIV='refresh' CONTENT='0;URL=../connexion.php' />";
}
?>
<!DOCTYPE HTML>
<!-- En-tête du document -->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" charset="utf-8"/>
        <title>Console d'administration</title>
        
        <!-- Liens vers les fichiers jQuery -->
        <script src="../../jquery/jquery.min.js"></script>
        <script src="../../jquery/jquery-ui-1.8.21.custom.min.js"></script>
        <script src="../../jquery/jquery.ui.datepicker.js"></script>
        <script src="../../jquery/jquery.ui.datepicker-fr-CH.js"></script>
        <script type="text/javascript" src="../../jquery/jquery.qtip.min.js"></script>
        
        <!-- Style CSS -->
        <link rel="stylesheet" href="../include/style.css" />
        <link rel="stylesheet" href="../../jquery/jquery-ui.css" type="text/css" />
        <link type="text/css" rel="stylesheet" href="../../jquery/jquery.qtip.css" />
    </head>
    <body>
