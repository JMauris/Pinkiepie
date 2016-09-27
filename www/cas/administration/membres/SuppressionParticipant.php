<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Fichier supprimant un participant de la base de données
    ***************************************************************************/
    //Fichiers nécessaires au bon fonctionnement de la page
    include("../../include/fonctions.inc.php");
    include("../../BusinessObject/personne.php");
    
    //Création d'une personne et récupération de l'ID
    $personne = new personne();
    $personne->id = $_GET[id];
    
    //Suppression du participant
    $personne->suppressionParticipant();
    
    //redirection vers la apge d'accueil de la gestion des membres
     echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=GestionMembres.php' />";
    
?>
