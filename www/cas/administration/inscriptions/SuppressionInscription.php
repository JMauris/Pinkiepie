<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page permettant de supprimer une inscription (passage en statut
    *           annulée)
    ***************************************************************************/
    
    //Ajout des fichiers nécessaires au bon fonctionnement du site
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/inscription.php");
    include("../../BusinessObject/randonnees.php");
    include("../../BusinessObject/personne.php");
    include("../../include/fonctions.inc.php");
    
    //Création d'une nouvelle inscription
    $inscription = new inscription();
    $idInscription = $_GET['id'];
    
    //Préparation des données et ajout dans les bonnes variables
    $idInscription = explode('.',$idInscription);
    $inscription->idPersonne = $idInscription[0];
    $inscription->idRandonnee = $idInscription[1];
    
    //Création d'une nouvelle randonnée
    $randonnee = new randonnee();
    $randonnee->id = $idInscription[1];
    $randonnee->getInfoRandonnee();
    
?>

<div id="main">
    <h1>Désinscription</h1>
    
    <?php
        
        //Désinscription de la randonnée
        $inscription->desinscription($randonnee->inscriptionMax, $randonnee->titre);
        
        //redirection vers la page des randonnées
        echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=listeInscriptions.php?id=0$inscription->idRandonnee' />";
    ?>

</div>

<?php
    //Pied de page
    include("../include/footer.inc");
?>