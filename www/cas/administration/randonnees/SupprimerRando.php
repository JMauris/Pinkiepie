<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Fichier permetant la modification d'une randonnée existante
    ***************************************************************************/
    
    //Ajout des fichiers nécessaires au bon fonctionnement du site
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/randonnees.php");
    include("../../include/fonctions.inc.php");
    
    //Création d'une randonnée
    $randonnee = new randonnee();
    
    //Récupération de l'id de la randonnée
    $randonnee->id = $_GET['id'];
?>
<div id="main">
    <h1>Suppression d'une randonnée</h1>
    <?php
        //Suppression de la randonnée
        $randonnee->supprimerRando();
    ?>
    
    <!-- redirection vers la page d'accueil de la gestion des randos -->
    <META HTTP-EQUIV='refresh' CONTENT='0;URL=GestionRando.php?min=0&max=30' />
     
</div>
<?php
    include("../include/footer.inc");
?>