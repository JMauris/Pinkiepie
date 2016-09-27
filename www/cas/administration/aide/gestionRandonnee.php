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
    <h2>Aide pour la gestion des randonnées</h2>
    <p>Sur cette page vous trouvez deux formulaires d’ajout de fichiers, le premier pour le programme et 
       le second pour  la gestion des propositions, un formulaire de recherche ainsi que la liste des randonnées.</p>
    
    <p>Lors d’une recherche par date, il vous suffit de cliquer sur la date désirée dans le calendrier qui apparaît.<br />
        Lors d’une recherche par titre, le tableau est mis à jour à chaque entrée de caractère. <br/>
        Afin d’éviter de devoir aller rechercher le détail des activités dans un cahier ou dans <br />
        la partie de modification des randonnées, un système d’infobulles a été mis en place. <br />
        Pour connaître les informations concernant un tour il vous suffit de passer avec votre souris <br />
        par-dessus le titre de la randonnée.</p>
 
    <h4>Ajout d’un programme de randonnée</h4>
    <p>
    Pour ajouter un nouveau programme dans la base de données, il vous suffit de sélectionner le classeur Excel<br />
    contenant la liste des randonnées en cliquant sur le bouton « Choisissez un fichier » sous le titre « Ajouter un nouveau programme ».<br />
    Une fois le fichier sélectionné, cliquez sur le bouton « Ajouter le programme ».Tout l’ajout des données va être effectué automatiquement. <br />
    Une fois l’importation des données terminée, la page de gestion des randonnées va se recharger.
    </p>
    <h4>Ajout de propositions</h4>
    <p>
    Afin d’ajouter une nouvelle proposition dans la base de données, il faut préparer les fichiers usuels.<br />
    Il vous faut donc ajouter cette proposition dans le fichier « Listes des randonnées.xls ».<br />
    Une fois la randonnée dans le classeur Excel, ajoutez la photo de la randonnée dans le dossier Photos,<br />
    le croquis dans le dossier Croquis, le profil dans le dossier Profil et le fichier KML dans le répertoire KML.<br/>
    Lorsque toutes ces opérations ont été effectuées vous pouvez vous rendre dans la console d’administration,<br/>
    dans la gestion des randonnées et réimporter le fichier des propositions.<br />
    Pour ce faire, vous devez sélectionner le fichier Excel à l’aide du bouton « Choisissez un fichier »<br />
    se trouvant en dessous du titre « Ajouter des propositions ». Tout comme pour l’importation du programme,<br />
    toutes les données vont être récupérées automatiquement. Une fois le chargement des informations terminées,<br />
    la page de gestion des randonnées va se recharger.
    </p>
    <h4>Modification des informations sur une randonnée</h4>
    <p>
    Afin de modifier une activité, vous devez cliquer sur l’icône  <img src="../../pictures/edit.png" height='35px' /> se trouvant tout à gauche dans le tableau<br />
    des randonnées. Cette action va vous amener à la page de modification d’une randonnée.<br />
    Cette page est constituée d’un formulaire contenant tous les champs liés aux randonnées. En cliquant sur Annuler,<br />
    vous serez redirigé vers la page d’accueil de la gestion des randonnées. Une fois toutes les modifications apportées, <br />
    vous pouvez cliquer sur le bouton « Mettre à jour ».<br />
    Si vous désirez supprimer la randonnée, cliquez sur le bouton « Supprimer ». Pour annuler une activité, vous devez<BR />
    décocher la case « à lieu ». Lors de l’annulation d’une randonnée, n’oubliez pas de prévenir les personnes s’étant inscrites à cet événement.
    <h5>Ajout d'une carte pour une randonnée</h5>
    <p>
        Afin d’ajouter une nouvelle carte à une randonnée existante il faut, une fois la carte créée,<br />
        placer la carte sur le serveur. Pour ce faire, veuillez-vous connecter sur le serveur FTP et placer<br />
        la carte dans le répertoire « cartes ». Une fois le fichier en place dans ce répertoire,<br />
        rendez-vous sur la page de modification d’une randonnée et dans le champ « lien carte » ajoutez le lien :<br />
        http://www.valrando.ch/demo/cartes/ suivi du nom du fichier kml de la carte ajoutée.

    </p>
</p>
</div>
<?php
    //Pied de page
    include("../include/footer.inc");
?>