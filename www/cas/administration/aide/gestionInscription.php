<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Aide pour la gestion des randonnées
    ***************************************************************************/

    //Ajout des fichiers nécessaires au bon fonctionnement de la page
    include("../include/toppage.inc");
    include("../include/header.inc");
?>

<div id="main">
    
    <h3>Gestion des inscriptions</h3>
    <p>
        
        En cliquant sur le lien « Gestion des inscriptions » dans le menu vous allez arriver sur la page d’accueil de cette partie.<br />
        Par défaut, les dix prochaines randonnées sont affichées.<br />
        Cette page est assez semblable à celle présente dans la gestion des randonnées. On y retrouve le même formulaire<br/>
        de recherche. Les infobulles décrivant plus en détail la randonnée apparaissent<br/>
        également lors du passage avec la souris par-dessus le titre de l’activité.<br />
        Pour voir la liste des inscriptions pour une randonnée, cliquez sur le lien « liste des inscriptions » situé sur la droite des lignes.

    </p>
    
</div>
<?php
    //Pied de page
    include("../include/footer.inc");
?>