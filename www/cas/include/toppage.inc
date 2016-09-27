<?php 
session_start();

// Traductions
include("../include/translations.php");
// Choix de la langue
if(!isset($_SESSION['langue']))
    $_SESSION['langue'] = 'fr';
else
    if(isset($_GET['lang']))
        $_SESSION['langue'] = $_GET['lang'];
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Titre de la page -->
        <title>Cas Montana</title>
        
        <!-- Différents Metas pour le site -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" >
        
        <!-- Images et feuilles de style liées à la page à afficher -->
        <link rel="apple-touch-icon" href="../apple-touch-icon.png"/>
        <link rel="icon" type="image/png" href="../apple-touch-icon.png" />
        <link rel="apple-touch-icon-precomposed" href="../apple-touch-icon.png"/>
        <link rel="apple-touch-icon-precomposed" href="../apple-touch-icon-precomposed.png"/>
        <link rel="stylesheet" href="../jquery/jquery-ui-1.8.21.custom.css" />
        <link rel="stylesheet" href="../jquery/jquery.mobile-1.0.1.css" />
        <link rel="stylesheet" href="../jquery/normal.css" media='screen and (max-device-width: 1000px)'/>
        <link rel="stylesheet" href="../jquery/bigger.css" media='screen and (max-device-width: 470px)'/>
        <link rel="stylesheet" type="text/css" href="../include/jrating_v2.2/jquery/jRating.jquery.css" media="screen" />

        <!-- Liens vers les différents scripts -->
        <script src="../jquery/jquery.min.js"></script>
        <script src="../jquery/jquery.mobile-1.1.0.min.js"></script>
        <script src="../jquery/jquery.mask.js"></script>
        <script src="../jquery/jquery.ui.datepicker.js"></script>
        <script type="text/javascript" src="../include/jrating_v2.2/jquery/jRating.jquery.js"></script>
        
        <!-- Langue du calendrier -->
        <?php if($_SESSION['langue'] == 'fr'){ ?>
            <script src="../jquery/jquery.ui.datepicker-fr-CH.js"></script>
        <?php } else { ?>
            <script src="../jquery/jquery.ui.datepicker-de.js"></script>
        <?php } ?>
            
        <script src="../jquery/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript"
            
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA8ill-hzbQdlaiXlUudcGZR2qQtqpD3x4&sensor=true">
        </script>
    </head>
    <body>