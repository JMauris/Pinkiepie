<?php
//Ajout des pages nécéssaires au bon fonctionnement du site web
include('../include/toppage.inc');
include('../include/fonctions.inc.php');
include('../BusinessObject/randonnees.php');
include('../BusinessObject/personne.php');
include('../BusinessObject/inscription.php');
include('../BusinessObject/localite.php');

/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Inscription à une randonnée
***************************************************************************/

//Création des objets utilisés dans cette page
$randonnee = new randonnee();
$personne = new personne();
$inscription = new inscription();

//Est-ce un séjour?
$sejour = false;
if(isset($_GET['type'])){
    $sejour = true;
}

$erreur = 0;

// Récupération de l'identifiant de la randonnée
if(isset($_GET['id']))
    //identifiant de la randonnée
    $randonnee->id = $_GET['id'];
else {    
    //Identifiant de la randonnée et récupération des informations
    $randonnee->id = $_POST['id'];
    $randonnee->getInfoRandonnee();

    //Récupération du détail de la persone
    $personne->getPersonne($_POST['nom'], $_POST['prenom']);

    //Si la personne est inconnue
    if($personne->id == ''){
        //ajout de la personne dans la base de données
        $personne->nom = $_POST['nom'];
        $personne->prenom = $_POST['prenom'];
        $personne->portable = $_POST['mobile'];
        $personne->localite = $_POST['localite'];
        $personne->email = $_POST['email'];
        $personne->abonnement = $_POST['abo'];
        $personne->langue = $_SESSION['langue'];
        $personne->insertNonMembre();
    }
    else{
        //Mise à jour des informations de la personne
        $personne->abonnement = $_POST['abo'];
        $personne->portable = $_POST['mobile'];
        $personne->localite = $_POST['localite'];

        //Modification dans la base de données
        $personne->modifAbonnement();
        $personne->modifNonMembre();
    }

    //Si la personne a bien été ajoutée
    if($erreur == 0){
        //ajout de l'inscription dans la base de données
        $inscription = new inscription();

        //Préparation des informations liées à l'inscription
        $inscription->idRandonnee = $randonnee->id;
        $inscription->idPersonne = $personne->id;
        $inscription->date = Date('Y-m-d');
        $inscription->heure = Date('G:i');
        if(isset($_post['assurance'])){
            $inscription->remarque = $_post['assurance']; 
        }
        $nbInscr = $inscription->nombrePlacesLibres();
        $infosInscr = $inscription->insertInscription($nbInscr);
    }
}

//Récupération des informations sur la randonnée
$randonnee->getInfoRandonnee();


//Si la personne est connectée, récupération des informations personnelles
if(isset($_SESSION['nom'])  && $_SESSION['nom'] != ''){
    $personne->nom = $_SESSION['nom'];
    $personne->prenom = $_SESSION['prenom'];

    $personne->getPersonne($personne->nom, $personne->prenom);

    //Prépare l'inscription
    $inscription->idRandonnee = $randonnee->id;
    $inscription->idPersonne = $personne->id;
    //Recherche si la personne est inscrite
    $estinscrit = $inscription->estInscrit();

    //Si la personne et déjà inscrite
    if($estinscrit[0] != 0){
        echo "<script>alert('" . $traductions['dejaInscrit'][$_SESSION['langue']] . "');";

        //redirection vers la page des randonnées
        echo "document.location.href='detailRandonnee.php?id=$randonnee->id'</script>";

    }
}    
?>

<!-- SCRIPT JAVASCRIPT ET JQUERY -->
<script type="text/javascript">
    var addition = 'false';
    
    //Règles pour le téléphone et l'email
    var regexpPhone = new RegExp("([0-9]{3})[/ ]([0-9]{3})[. ]([0-9]{2})[. ]([0-9]{2})");
    var regexpEmail = new RegExp("[A-z0-9._%-]+@[A-z0-9.-]+.[A-z]{2,4}");
    
    //page affichée
    $(document).ready(function() {
        //Bouton de retour
        $('.ui-btn-back').click(function() {
          window.location = 'detailRandonnee.php?id=' + <?php echo $randonnee->id ?>;
          return false;
        });
        
        $(function(){  
  
        //Ajout de l'autocomplete 
        $("#localite").autocomplete({  
  
            //Définition du callback 
            source: function(req, add){  
  
                //requête vers le serveur  
                $.getJSON("../include/fonctionsAjax.inc.php?callback=?", req, function(data) {  
  
                    //Tableau pour stocker les réponses
                    var suggestions = [];  
  
                    //Mise à jour des réponses  
                    $.each(data, function(i, val){  
                    suggestions.push(val.localite);  
                });  
  
                //Retourne le tableau de réponses 
                add(suggestions);  
            });  
        },    
  
            //lors de la modification ou séléction
            change: function() {
                //Récupération de la valeur de la localité
                $("#localite").val(); 
            }  
        });  
    });
    
    //Contrôle que tous les champs du formulaires soient bien remplis
    $('form').submit(function () {
        //Nom
        if($("#nom").val() == ''){
            $("#erreur").html("<?php echo $traductions['champNom'][$_SESSION['langue']] ?>");
            return false;
        }
        
        //Prénom
        if($("#prenom").val() == ''){
            $("#erreur").html("<?php echo $traductions['champPrenom'][$_SESSION['langue']] ?>");
            return false;
        }
        
        //Localité
        if($("#localite").val() == ''){
            $("#erreur").html("<?php echo $traductions['champLocalite'][$_SESSION['langue']] ?>");
            return false;
        }
    
        //Email
        if($("#email").val() == ''){
            $("#erreur").html("<?php echo $traductions['champEmail'][$_SESSION['langue']] ?>");
            return false;
        }
        
        //Résultat
        if($('#resultat').val() != parseInt($('#multi1').val()) + parseInt($('#multi2').val())) {
            $('#erreur').html("<?php echo $traductions['confirmationInscrCalcul'][$_SESSION['langue']] ?>");
            return false;
        }

        //Email
        if(!regexpEmail.test($("#email").val())){
            $("#erreur").html("<?php echo $traductions['formatEmail'][$_SESSION['langue']] ?>");
                return false;
        }

        //téléphone
        if(!regexpPhone.test($("#mobile").val())){
            $("#erreur").html("<?php echo $traductions['formatNatel'][$_SESSION['langue']] ?>");
                return false;
        }

        //Abonnement
        if($("#abo").val() == "no"){
            $("#erreur").html("<?php echo $traductions['selectAbo'][$_SESSION['langue']] ?>");
                return false;
        }
       
        //Abonnement
        if($("#assurance").val() == "no"){
            $("#erreur").html("<?php echo $traductions['selectAssurance'][$_SESSION['langue']] ?>");
            return false;
        }
    });
    
    //Modification du nom
    $('#nom').change(function(){
       if($('#nom').val() == '')
           $("#erreur").html("<?php echo $traductions['champNom'][$_SESSION['langue']] ?>");
       else
           $("#erreur").html("");
    });
    
    
    //Modification du prénom
    $('#prenom').change(function(){
       if($('#prenom').val() == '')
           $("#erreur").html("<?php echo $traductions['champPrenom'][$_SESSION['langue']] ?>");
       else
           $("#erreur").html("");
    });
    
    //Modification de l'email
    $('#email').change(function(){
       if($('#email').val() == '')
           $("#erreur").html("<?php echo $traductions['champEmail'][$_SESSION['langue']] ?>");
       else{
           if(!regexpEmail.test($("#email").val()))
               $('#erreur').html("<?php echo $traductions['formatEmail'][$_SESSION['langue']] ?>");
           else{
               //Suppression de l'erreur
               $("#erreur").html("");
               
               //Recherche si l'email est dans la base de données, et récupération des champs
               $.ajax({
                   url: '../include/fonctionsAjax.inc.php',
                   async: false,
                   data: "email=" + $("#email").val(),
                   success: function(data){
                       var infosPersonne = data.split("<");
                       if(infosPersonne[0] != ''){
                           $("#nom").val(infosPersonne[0]) ;
                           $("#prenom").val(infosPersonne[1]) ;
                           $("#localite").val(infosPersonne[2]);
                           //$("#abo").val(infosPersonne[3]);
                           $("#mobile").val(infosPersonne[4]);
                       }
                   }
               });
           } 
       }
    });
    
    //Modification du numéro de portable
    $("#mobile").change(function(){
       if($("#mobile").val() == ''){
           $("#erreur").html("<?php echo $traductions['champNatel'][$_SESSION['langue']] ?>");
       }
       else if(!regexpPhone.test($("#mobile").val())){
           $("#erreur").html("<?php echo $traductions['formatNatel'][$_SESSION['langue']] ?>");
       }
       else{
           $("#erreur").html("");
       };
    });
    
    //Modification de la localité
    $('#localite').change(function(){
       if($('#localite').val() == ''){
           $("#erreur").html("<?php echo $traductions['champLocalite'][$_SESSION['langue']] ?>");
       }
       else{
           $("#erreur").html("");
       }
    });
    
    //Modification du résultat de l'addition
    $('#resultat').keyup(function(){
       if($('#resultat').val() != parseInt($('#multi1').val()) + parseInt($('#multi2').val())) {
           $('#erreur').html("<?php echo $traductions['erreurAddition'][$_SESSION['langue']] ?>");
           addition = 'false';
       }
       else{
           addition = 'true';
           $('#erreur').html("");
       }
    });
    
 });
 

</script>  
<!-- FIN DES SCRIPTS JS ET JQUERY -->

<div data-role="page" id="main">
   <?php include('../include/header.inc'); ?>
    <div data-role="content">
       <?php if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){ ?>
        <div id="titrePage">
            <h3><?php echo $traductions['actuellementConnecte'][$_SESSION['langue']]; ?>
                <div id='logout'><a href='../include/logout.inc.php' rel="external"><img src='../pictures/exit.png' height='50px' /></a></div>
            </h3>
        </div>
       <?php }else{ ?>
        <h3><?php echo $traductions['inscriptionRando'][$_SESSION['langue']] ?></h3>
       <?php } ?>
        <div class="tableauPage">
            
            <!-- ACTION A EFFECTUER SI L'UTILISATEUR S'EST INSCRIT -->
           <?php if(isset($infosInscr)){
               
               if($infosInscr!= "Vous êtes déjà inscrit à cette randonnée"){
                   echo "<script>alert('". $traductions['confirmationInscr'][$_SESSION['langue']] . "');";

                   //redirection vers la page des randonnées
                   echo "document.location.href='programmeValrando.php'</script>";
               }
               else{
                   echo "<script>alert('" . $traductions['dejaInscrit'][$_SESSION['langue']] . "');";

                    //redirection vers la page des randonnées
                    echo "document.location.href='detailRandonnee.php?id=$randonnee->id'</script>";
                   
               }
           } ?>
            
            <h4>
                <?php echo utf8_encode($randonnee->titre); ?>
            </h4>
            
            <!-- FORMULAIRE D'INSCRIPTION -->
            <form method="post">
                <!-- CHAMP CACHÉ POUR L'IDENTIFIANT DE LA RANDONNEE -->
                <input type="hidden" name="id" id="id" value="<?php echo $randonnee->id; ?>" />
                
                <!-- Date -->
                <span id="label"><?php echo $traductions['date'][$_SESSION['langue']] ?>:</span>
                <span id="champ">
                   <?php
                   //Format de la date de début
                    $date = explode('-', $randonnee->date);
                    echo $date[2] . "." . $date[1] . "." . $date[0]; 
                   
                    //Gestion de la date de fin de la randonnée
                    $dateFinRando = explode('-',$randonnee->datefin);
                    
                    //Si besoin, affichage de la date de fin de la randonnée
                    if($dateFinRando[2] != '00'){
                        echo" - " . $dateFinRando[2] . "." . $dateFinRando[1] . "." . $dateFinRando[0];
                    }
                    
                    ?>
                </span><br />
                
                <!-- Proposition de connexion à un utilisateur connecté -->
                <?php
                    if(!isset($_SESSION['nom']) || $_SESSION['nom'] == ""){
                ?>
                <a href="connexion.php?source=<?php echo $randonnee->id ?>" data-role="button" data-inline="true" rel="external"/>
                        <?php echo $traductions['membreInscrClique'][$_SESSION['langue']] ?>
                </a>
                <?php
                    }
                ?>
                
                <!-- champ pour l'email -->
                <div data-role="fieldcontain">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo $personne->email; ?>"/>
                </div>
                
                <!-- Champ pour le nom -->
                <div data-role="fieldcontain">
                    <label for="nom"><?php echo $traductions['nom'][$_SESSION['langue']] ?>:</label>
                    <input type="text" name="nom" id="nom" value="<?php echo utf8_encode($personne->nom); ?>"/>
                </div>
                
                <!-- Champ pour le prénom -->
                <div data-role="fieldcontain">
                    <label for="prenom"><?php echo $traductions['prenom'][$_SESSION['langue']] ?>:</label>
                    <input type="text" name="prenom" id="prenom" value="<?php echo utf8_encode($personne->prenom); ?>" />
                </div>
                
                <!-- Champ pour le téléphone mobile -->
                <div data-role="fieldcontain">
                    <label for="mobile"><?php echo $traductions['mobile'][$_SESSION['langue']] ?> (079 000 00 00):</label>
                    <input type="text" name="mobile" id="mobile" value="<?php echo $personne->portable; ?>" />
                </div>
                
                <!-- Localité -->
                <div data-role="fieldcontain">
                    <label for="localite"><?php echo $traductions['ville'][$_SESSION['langue']] ?>:</label>
                    <input type="text" name="localite" id="localite" value="<?php echo utf8_encode($personne->localite); ?>"/>
                </div>
                
                <!-- abonnement transport public -->
                <div data-role="fieldcontain">
                    <label for="abo"><?php echo $traductions['abonnementTransportPublic'][$_SESSION['langue']] ?>:</label>
                    <select name="abo" id="abo" data-inline="true"/>
                    <option value='no'><?php echo $traductions['selectSVP'][$_SESSION['langue']] ?></option>
                       <?php
                           //récupération de la liste des abonnements
                           $abos = getAbonnements($_SESSION['langue']);

                           while($ligne = mysql_fetch_array($abos)){
                               echo "<option value='$ligne[0]'";
                               
                               if($ligne[0] == $personne->abonnement)
                                   echo "selected";
                               echo ">" . utf8_encode($ligne[1]) . "</option>\n";
                           }
                       ?>
                    </select>
                </div>
                
                <!-- Assurance inscription, uniquement pour les séjours -->
                <?php
                if($sejour){
                ?>
                <div data-role="fieldcontain">
                    <label for="assurance"><?php echo $traductions['assuranceSejour'][$_SESSION['langue']] ?>:</label>
                    <select name="assurance" id="assurance" data-inline="true"/>
                    <option value='no'><?php echo $traductions['selectSVP'][$_SESSION['langue']] ?></option>
                    <option value='oui'><?php echo $traductions['assuranceSejourOui'][$_SESSION['langue']] ?></option>
                    <option value='vaFaire'><?php echo $traductions['assuranceSejourVaFaire'][$_SESSION['langue']] ?></option>
                    <option value='aFaire'><?php echo $traductions['assuranceSejourNon'][$_SESSION['langue']] ?></option>
                    
                    </select>
                </div> 
               <?php
               }
               ?>
                
                <span id="label"><?php echo $traductions['confirmationInscrCalcul'][$_SESSION['langue']] ?>:</span>
                <div id="calcul">
                    <input type="text" id="multi1" readonly="readonly" value="<?php echo rand(1,9); ?>" size="2" data-inline="true"/>
                    +
                    <input type="text" id="multi2" readonly="readonly" value="<?php echo rand(1,9); ?>" size="2"/>
                    =
                    <input type="text" id="resultat" value="" />
                </div><br />
                
                <div id="erreur" >
                    <?php if($erreur != 0){
                        echo "Veuillez sélectionner une localité existante";
                    }?>
                </div>
                
                <input type="submit" class="boutton" id="validation" 
                       value="<?php echo $traductions['transmettreInscr'][$_SESSION['langue']] ?>" data-inline="true"/>
            </form>
            
            <div id="information">
                <p><?php echo $traductions['inscrPlusieursPersonnes'][$_SESSION['langue']] ?></p>
            </div>
        </div>
    </div>
<?php
//Pied de page
include('../include/footer.inc');
?>