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
    <h3>Zone d'envoi de SMS</h3>
    <p>
        Cette page est partagée en deux parties principales. La première partie permet de contacter les participants<br />
        à une randonnée et la seconde zone permet de garder un historique des derniers messages envoyés. Cette zone vous<br />
        permettra de savoir facilement si un message pour une randonnée a déjà été envoyé ou s’il faut prévenir directement<br />
        les participants.<br /><br />
 
        En dessous du titre « Crédits restants » est affiché le nombre de message qu’il est possible d’envoyer avec les crédits<br />
        qu’il vous reste sur mySMS. Il est possible de recharger ces crédits en se rendant sur le site de la plateforme en ligne.<br />
        Afin d’envoyer un message, il faut dans un premier temps sélectionner la randonnée<br />
        pour laquelle il faut prévenir les participants.
        Une fois la randonnée sélectionnée, veuillez indiquer les textes des messages en français ainsi qu’en allemand.<br />
        La limite du nombre de caractères est identique à celle d’un SMS normal, soit 160 caractères.<br />
        En cliquant sur le bouton « Envoyer les messages », les informations seront transmises aux participants.<br />
        <br />
        Les messages sont envoyés de la manière suivante :<br />
        <ul>
            <li>Pour tous les participants ayant renseignés un numéro de téléphone portable, un sms est envoyé</li>
            <li>Pour toutes les personne n’ayant pas renseigné de téléphone portable mais possédant une adresse email, un email est envoyé.</li>
            <li>Pour les participants n’ayant renseigné ni téléphone portable, ni adresse email le numéro de téléphone va s’afficher dans une<br />
                liste des personnes à contacter par téléphone.</li>
        </ul>
        <h4>Recharge des crédits sur mySMS</h4>
        Pour recharger les crédits sur mySMS de Chrus, il vous faut vous rendre à l’adresse suivante :<br />
        <a href="http://www.chrus.ch/mysms/">http://www.chrus.ch/mysms/</a><br />
        En arrivant sur cette page, il faut cliquer sur le lien « Login » se trouvant dans le menu de droite<br />
        dans la partie « Membres ».<br />
        Sur la page qui va s’afficher, il faut entrer les informations de connexion comme demandé.<br />
        Le nom d’utilisateur est le numéro de téléphone mobile avec lequel l’abonnement a été créé. Le format du<br />
        numéro de téléphone doit suivre le suivant : 41790000000.<br />
        Le mot de passe est celui reçu lors de la création du compte.<br />

        Une fois connecté, vous allez arriver sur la page d’accueil du compte. Sur cette page, toujours<br />
        dans le menu de droite, il faut cliquer sur le lien « Commande » dans la partie « Mon compte ».<br />
        Sur la page qui s’affiche il ne vous reste plus qu’à commander le nombre de crédits désirés.<br />
        Pour commander, la première étape est de sélectionner le nombre de crédits désirés. Il faut ensuite,<br/>
        dans la deuxième étape, choisir l’option de paiement. <br/>
        Pour payer, vous avez la possibilité d’utiliser une carte de crédit ou d’effectuer un virement bancaire. <br />

        
    </p>
</div>
<?php
    //Pied de page
    include("../include/footer.inc");
?>