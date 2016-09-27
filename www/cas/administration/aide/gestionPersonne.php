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
    <h3>Gestion des personnes</h3>
    <p>
        La page est partagée en deux parties principales.<br /><br />
        La première est un formulaire permettant de préciser le classeur Excel contenant la liste de tous<br />
        les membres afin de mettre à jour la base de données.
        La seconde partie est la liste de toutes les personnes accompagnée d’un formulaire de recherche afin<br />
        de récupérer plus facilement les informations.

        Pour mettre à jour la liste des membres, il vous faut sélectionner le classeur Excel avec la liste<br />
        de l’ensemble des membres et cliquer sur le bouton « Mettre à jour les membres ». Cette action va<br />
        récupérer toutes les données du fichier et mettre à jour les informations dans la base de données.<br />
        Pour mettre à jour ces informations, une comparaison des numéros de membre est effectuée. Si le numéro<br />
        existe déjà, l’entrée sera modifiée. Dans le cas contraire, la personne sera ajoutée aux données.<br/>
        Le statut de la personne est mis à jour en fonction des données récupérées depuis Alabus.<br /><br/>
        
        Pour ce qui est de l’ajout de participants non-membres, les données sont créées lors de l’inscription de<br />
        ces personnes à un événement.
        Depuis cet écran vous avez la possibilité de mettre à jour les données des participants en cliquant<br />
        sur l’icône de modification. Pour les membres, seules le type d’abonnement de transport public est modifiable.<br />
        Pour voir toutes les inscriptions pour une personne précise, vous n’avez qu’à cliquer sur l’icône .<br />
        Comme pour les inscriptions, en passant votre souris par-dessus le nom de la personne, tous les détails<br />
        de cette dernière vont s’afficher
        <h4>Modification d’une personne</h4>
        La modification d’une personne se fait via le formulaire s’affichant sur la page.<br />
        Ce formulaire est totalement éditable pour les participants. Pour ce qui est des membres, la modification des<br />
        données se fait à l’aide du classeur Excel récupéré depuis Alabus. Le seul changement possible pour un membre est<br />
        l’abonnement de transports publics.<br />
        Les données telles que le téléphone, le téléphone portable ou l’adresse email doivent respecter le format usuel.<br />

        Une fois les modifications effectuées, cliquez sur « Mettre à jour ». Un message de confirmation s’affiche<br />
        une fois les données modifiées dans le système.<br />
        Pour revenir sur la page d’accueil de la gestion des personnes, vous pouvez cliquer sur « Annuler ».<br />
        <h4>Inscriptions pour une personne</h4>
 
        Sur cette page s’affiche la liste des inscriptions pour une personne. De cette manière, vous n’avez pas<br />
        besoin de rechercher manuellement dans les différentes randonnées cette personne.<br />
        Pour voir le détail de la randonnée, il vous suffit de passer la souris par-dessus le titre. <br />

    </p>
</div>
<?php
    //Pied de page
    include("../include/footer.inc");
?>