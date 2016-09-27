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
    <h3>Ajout d'une inscription</h3>
    <p>
        Sur cette page vous avez deux possibilités pour inscrire une personne.<br />
        Dans le premier cas, la personne à ajouter fait partie des membres de l’association ou est un randonneur<br />
        s’inscrivant régulièrement à des événements organisés par Valrando. Il vous faut donc renseigner le nom ainsi<br />
        que le prénom de cette personne. Ce faisant, la liste des personnes va se mettre à jour et en cliquant sur le prénom <br />
        de cette personne vous allez pouvoir l’inscrire.<br />
        Le second cas est celui d’une personne n’existant pas dans la base de données. Il vous faut alors cliquer sur <br/>
        le bouton « nouvelle inscription » se trouvant sous la liste des personnes. En cliquant, un nouveau formulaire va<br />
        apparaître. Il ne vous reste plus qu’à le remplir en renseignant tous les champs et confirmer l’inscription.
    </p>
    
</div>
<?php
    //Pied de page
    include("../include/footer.inc");
?>