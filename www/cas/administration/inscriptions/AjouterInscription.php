<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page permettant d'ajouter une nouvelle inscription dans la base
    *           de données. Affichage du tableau de toutes les personnes ainsi
    *           que d'un formulaire pour une nouvelle personne
    ***************************************************************************/

    //Ajout des fichiers nécessaires au bon fonctionnement du site
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/inscription.php");
    include("../../BusinessObject/personne.php");
    include("../../BusinessObject/localite.php");
    include("../../BusinessObject/randonnees.php");
    include("../../include/fonctions.inc.php");
    
    //Création des différentes classes utilisées dans la page
    $inscription = new inscription();
    $personne = new personne();
    $randonnee = new randonnee();
    
    //Si l'identifiant de la randonnée est déclaré
    if(isset($_GET['idRando'])){
        //Récupération de l'identifiant et recherche des 
        //informations sur la rando
        $randonnee->id = $_GET['idRando'];
        $inscription->idRandonnee = $_GET['idRando'];
        $randonnee->getInfoRandonnee();
    }
    elseif(isset($_POST['idRando'])){
        //Récupération de l'identifiant et recherche des 
        //informations sur la rando
        $randonnee->id = $_POST['idRando'];
        $inscription->idRandonnee = $_POST['idRando'];
        $randonnee->getInfoRandonnee();
    }
    
    //Si l'identifiant de la randonnée n'est pas vide
    if($randonnee->id != ''){
        //Récupération de l'identifiant de la personne à inscrire
        if(isset($_GET['idpersonne'])){
            //Récupération de l'identifiant et recherche
            //des informations sur la personne
            $personne->id = $_GET['idpersonne'];
            $personne->getDetailPersonne();
        }
        //Ou récupération du numéro de membre
        elseif(isset($_POST['numMembre']) && $_POST['numMembre'] != ''){
            
            //Récupération du numéro de membre et recherche
            //des informations du membre
            $personne->numMembre = $_POST['numMembre'];
            $personne->getPersonneParNumero();
            $personne->abonnement = $_POST['abo'];
            
            $inscription->remarque = "<script>prompt('Assurance:','Name');</script>";
            
            //Modification de l'abonnement
            $personne->modifAbonnement();
        }
        //Sinon
        else{
            //Récupération des informations sur le membre
            //et création d'un nouveau participant
            $personne->nom = $_POST['nom'];
            $personne->prenom = $_POST['prenom'];
            $personne->email = $_POST['email'];
            $personne->npa = $_POST['npa'];
            $personne->localite = $_POST['localite'];
            $personne->langue = $_POST['langue'];
            $personne->abonnement = $_POST['abo'];
            $personne->portable = $_POST['telephone'];
            $return = $personne->insertNonMembre();
        }
        
        //Ajout de l'inscription dans la base de données
        $inscription->idPersonne = $personne->id;
        $inscription->date = Date("Y-m-d");
        $inscription->heure = Date('G:i');
        $inscription->status = 1;
        if(isset($_POST['assurance']))
            $inscription->remarque = $_POST['assurance'];
        $nbInscr = $inscription->nombrePlacesLibres();
        $inscription->insertInscription($nbInscr);
        
        //redirection vers la page des inscriptions
        echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=listeInscriptions.php?id=$inscription->idRandonnee' />";
        
    }
    //Si aucun paramètre n'est déclaré
    else{
        $inscription->idRandonnee = $_GET['rando'];
        $randonnee->id = $inscription->idRandonnee;
        $randonnee->getInfoRandonnee();
    }
    
    
?>

<script>
    $(document).ready(function() {
        
        //Cache le formulaire d'inscription
         $("#formulaireInscription").hide();
        
        //Recherche Ajax sur le nom
        $("#nom").keyup(function(){                    
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               data: "statut=" + $("#statut").val() + "&personne=" + $("#nom").val() + "." + $("#prenom").val() + "&rando=" + $("#idRando").val(),
               async: false,
               success: function(data){
                   var text = data;

                   $("#listePersonnes").html(text);
                   $("#infoPersonne[title]").qtip();
               }
            });
        });
        
        //Recherche Ajax sur le prénom
        $("#prenom").keyup(function(){                    
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               async: false,
               data: "statut=" + $("#statut").val() + "&personne=" + $("#nom").val() + "." + $("#prenom").val() + "&rando=" + $("#idRando").val(),
               success: function(data){
                   var text = data;

                   $("#listePersonnes").html(text);
                   $("#infoPersonne[title]").qtip();
               }
            });
        });
        
        //Recherche sur le statut
         $("#statut").change(function(){ 
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               data: "statut=" + $("#statut").val() + "&personne=" + $("#nom").val() + "." + $("#prenom").val() + "&rando=" + $("#idRando").val(),
               success: function(data){
                   var text = data;

                   $("#listePersonnes").html(text);
                   $("#infoPersonne[title]").qtip();
               }
            });
         });
         
         //Affichage du formulaire d'inscription lors du clique
         //sur le bouton nouvelle inscription
         $("#nouvelleInscription").click(function (){
            $("#formulaireInscription").show(500);
        });
        
        //Contrôle qu'un type d'abonnement a bien été séléctionné
         $("#formulaireInscription").submit(function(){
            //Abonnement séléctionné?
            if($("#abo").val() == "no"){
                $("#erreur").html("Il faut séléctionner un type d'abonnement");
                return false;
            }
            
            //Nom renseigné?
            if($("#nomForm").val() == ""){
                $("#erreur").html("Veuillez renseigner le Nom");
                return false;
            }
            
            //Prénom Renseigné
            if($("#prenomForm").val() == ""){
                $("#erreur").html("Veuillez renseigner le prénom");
                return false;
            }
            
            //Email renseigné?
            if($("#emailForm").val() == ""){
                $("#erreur").html("Veuillez renseigner l'email");
                return false;
            }
            
            
        });
    });
    
</script>

<div id="main">
    <h1>Nouvelle inscription</h1>
    
    <h1>Liste de toutes les personnes</h1>
    <!-- FORMULAIRE DE RECHERCHE -->
    <h2>Recherche</h2>
    <form>
        Nom: <input type="text" id="nom" name="nom"/>
        Prénom: <input type="text" id="prenom" name="prenom"/>
        Statut: 
        <select name="statut" id="statut">
            <option value="t">Tous</option>
            <option value="m">Membres</option>
            <option value="p">Participants</option>
        </select>    
    </form>
    
    <h2>Liste</h2>
    <!-- TABLEAU AVEC TOUTES LES PERSONNES EN FONCTION DE LA RECHERCHE -->
    <table id="listePersonnes">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>email</th>
            <th>Statut</th>
            <th>Abonnement de transports publics</th>
            <th>Localité</th>
            <th>Téléphone Mobile</th>
        </tr>
    </table>
    
    <button id="nouvelleInscription">Nouvelle Inscription</button>
    
    <!-- FORMULAIRE POUR UNE NOUVELLE INSCRIPTION -->
    <div id="formulaireInscription">
        <form method="post">
            <input type="hidden" name="idRando" id="idRando" value="<?php echo $inscription->idRandonnee; ?>"
            
            <span class="label">Nom :</span>
            <span class="champ"><input type="text" id="nomForm" name="nom" value="<?PHP echo utf8_encode($personne->nom); ?>" /></span>

            <span class="label_2">Prénom :</span>
            <span class="champ_2"><input type="text" id="prenomForm" name="prenom" value="<?PHP echo utf8_encode($personne->prenom); ?>" /><br /></span>

            <span class="label">Email :</span>
            <span class="champ"><input type="text" id="emailForm" name="email" size="25" value="<?PHP echo utf8_encode($personne->prenom); ?>" /></span>
            <span class="label_2">Téléphone Mobile:</span>
            <span class="champ_2"><input type="text" id="telephone" name="telephone" size="25" value="<?PHP echo utf8_encode($personne->prenom); ?>" /><br /></span>

            <span class="label">Abonnement de transports publics :</span>
            <select class="champ" id="abo" name="abo">
                <option value="no">veuillez sélectionner svp</option>
            <?php
                //Liste des différents abonnements
                $listeAbos = getAbonnements(fr);
                while($ligne = mysql_fetch_array($listeAbos)){
                    echo "<option value='$ligne[0]'>" . utf8_encode($ligne[1]) . "</option>";
                }
            ?>

            </select>
            
            <span class="label_2">Langue :</span>
            <span class="champ_2"><select name="langue">
                <option value="fr">Français</option>
                <option value="de">Allemand</option>
            </select></span><br />
            
            <?php
                if($randonnee->typeTour == 2){
            ?>
            <span class="label">Assurance :</span>
            <select class="champ" id="assurance" name="assurance">
                <option value="no">veuillez sélectionner svp</option>
                <option value='oui'>Oui, valable pour la durée du séjour</option>
                <option value='vaFaire'>Non, va faire le nécessaire</option>
                <option value='aFaire'>Non</option>
            </select><br />
            <?php
                }
            ?>

            <span class="label">NPA :</span>
            <span class="champ"><input type="text" id="npa" name="npa" value="<?PHP echo utf8_encode($personne->npa); ?>" /></span>

            <span class="label_2">Localité :</span>
            <span class="champ_2"><input type="text" id="localite" name="localite" value="<?PHP echo utf8_encode($personne->npa); ?>" /><br /></span>

            <div id="erreur"></div>
            
            <input type="submit" value="Confirmer l'inscription" />
        
        </form>
    </div>
    <!-- Redirection vers la liste des inscriptions -->
    <button onclick="parent.location='listeInscriptions.php?id=<?php echo $inscription->idRandonnee; ?>'">Annuler</button>
</div>

<?php
    //Lien vers le pied de page
    include("../include/footer.inc");
?>
