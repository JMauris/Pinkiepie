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
    <h3>Liste d'inscriptions</h3>
    
    <p>
        La liste des inscriptions est partagée en deux principales parties. La première comprend les liens afin<br />
        de préparer le rapport de la course qui sera distribué au chef de course, ainsi que le bouton pour<br />
        ajouter une nouvelle inscription.<br />
        Pour préparer le rapport de course, la première étape consiste à clique sur le bouton « Préparer le rapport<br />
        de course ». Une fois l’opération effectuée, un second lien va apparaître en dessous de celui cliqué<br />
        précédemment. Cliquer sur ce lien « Récupérer le fichier » afin de télécharger le classeur Excel du rapport<br />
        de la course. De cette manière, le classeur Excel va être téléchargé sur votre poste.<br />
        Pour ajouter une nouvelle inscription, cliquez sur l’icône <img src='../../pictures/icons/add.png' height='30px' />.<br /><br />
        La seconde partie de cette page est la liste des inscriptions partagée en deux : dans un premier temps, toutes les personnes inscrites et ensuite, la liste d’attente pour cette randonnée.<br />
        Vous avez la possibilité de supprimer une de ces inscriptions en cliquant sur l’icône . La suppression sera effectuée après une confirmation.<br />
        Lors d’une suppression de l’inscription d’une personne dans la liste des inscrits un contrôle automatique est effectué afin d’inscrire<br />
        la première personne sur la liste d’attente. Cette personne va donc remplacer celle s’étant désinscrite et un email lui indiquant que <br />
        le statut de son inscription est passé de « en attente » à « inscrit » lui est envoyé.<br />
        Une autre fonctionnalité qui a été développée est celle permettant de placer une personne en première place dans la liste d’attente<br />
        en cliquant sur l’icône <img src='../../pictures/arrowup.png' height="30px"/>.<br/>
        Dans le cas d’une randonnée avec une seule personne sur la liste d’attente, vous avez également la possibilité de forcer l’inscription de cette<br />
        personne en cliquant sur le lien « Forcer l’inscription ». Il est conseillé de prendre cette décision après avoir contacté le chef de course.<br />
        Dans la zone de texte se trouvant sous remarque vous pouvez indiquer une remarque à propos de cette inscription comme par exemple « bon cadeau » ou<br />
        encore « pas de repas ». Pour enregistrer cette remarque, vous pouvez appuyer sur la touche « Enter ».<br />
        Sur cette page a également été ajouté le système d’infobulles afin d’avoir toutes les informations sur une personne sans avoir à changer de fenêtre.<br />
        Pour afficher l’infobulle, vous devez placer votre curseur en dessus du nom de la personne.<br />

    </p>

</div>
<?php
    //Pied de page
    include("../include/footer.inc");
?>