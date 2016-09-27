<?php
    //Ajout des pages nécessaires au fonctionnement du site
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    include('../BusinessObject/personne.php');
    
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page permettant à un utilisateur de modifier ses informations
     *          personnelles
    ***************************************************************************/
    
    //Création d'une nouvelle personne
    $personne = new personne();
    
    if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){
        //Récupération du nom et du prénom
        $personne->nom = $_SESSION['nom'];
        $personne->prenom = $_SESSION['prenom'];

        //Contrôle si le formulaire a été modifié
        if(isset($_POST['idPersonne'])){
            //Récupération des détails de la personne
            $personne->id = $_POST['idPersonne'];
            $personne->getDetailPersonne();

            //Récupération des valeurs pour la personne
            $personne->nom = $_POST['nom'];
            $personne->prenom = $_POST['prenom'];
            $personne->adresse = $_POST['adresse'];
            $personne->npa = $_POST['npa'];
            $personne->localite = $_POST['localite'];
            $personne->telephone = $_POST['telephone'];
            $personne->portable = $_POST['mobile'];
            $personne->email = $_POST['email'];
            
            //Récupération de l'abonnement et modification de l'information
            $personne->abonnement = $_POST['abo'];
            $personne->modifAbonnement();

            //Affichage d'un message de confirmation
            echo "<script>alert('" . $traductions['modificationDonneesEnCours'][$_SESSION['langue']] . "');</script>";
        }

        //Recherche des infos sur la personne
        $personne->getPersonne($personne->nom, $personne->prenom);
    }
?>

<!-- contrôle du formulaire en Javascript -->
<script>
    //Règles pour le téléphone et l'email
    var regexpPhone = new RegExp("([0-9]{3})[/ ]([0-9]{3})[. ]([0-9]{2})[. ]([0-9]{2})");
    var regexpEmail = new RegExp("[A-z0-9._%-]+@[A-z0-9.-]+.[A-z]{2,4}");
    
    //Contrôle du formulaire
    $(document).ready(function(){
       $('.ui-btn-back').click(function() {
          window.location = 'index.php';
          return false;
        });
        
        //Gestion de l'envoi du formulaire
        $('form').submit(function(){
            //nom de la personne
            if($("#nom").val() == ''){
                $("#erreur").html("<?php echo $traductions['champNom'][$_SESSION['langue']] ?>");
                return false
            }
            
            //Prénom de la personne
            if($("#prenom").val() == ''){
                $("#erreur").html("<?php echo $traductions['champPrenom'][$_SESSION['langue']] ?>");
                return false
            }
            
            //Adresse
            if($("#adresse").val() == ''){
                $("#erreur").html("<?php echo $traductions['champAdresse'][$_SESSION['langue']] ?>");
                return false
            }
            
            //NPA
            if($("#npa").val() == ''){
                $("#erreur").html("<?php echo $traductions['champNPA'][$_SESSION['langue']] ?>");
                return false
            }
            
            //Localité
            if($("#localite").val() == ''){
                $("#erreur").html("<?php echo $traductions['champLocalite'][$_SESSION['langue']] ?>");
                return false
            }
            
            //email
            if($("#email").val() == ''){
                $("#erreur").html("<?php echo $traductions['champEmail'][$_SESSION['langue']] ?>");
                return false
            }
            
            //Email
           if(!regexpEmail.test($("#email").val())){
               $("#erreur").html("<?php echo $traductions['formatEmail'][$_SESSION['langue']] ?>");
                return false;
           }
           
           //Téléphone
           if($("#telephone").val() != ''){
               //Email
               if(!regexpPhone.test($("#telephone").val())){
                   $("#erreur").html("<?php echo $traductions['formatTelephone'][$_SESSION['langue']] ?>");
                    return false;
               }
           }
           
           //Téléphone mobile
           if($("#mobile").val() != ''){
               //Email
               if(!regexpPhone.test($("#mobile").val())){
                   $("#erreur").html("<?php echo $traductions['formatNatel'][$_SESSION['langue']] ?>");
                    return false;
               }
           }
           
           //Abonnement
           if($("#abo").val() == "no"){
               $("#erreur").html("<?php echo $traductions['selectAbo'][$_SESSION['langue']] ?>");
                return false;
           }

                
        });
    });
</script>
<div data-role="page" id="main">
   <?php include('../include/header.inc'); ?>
   <div data-role="content">
       <h2><?php echo $traductions['mesInfosPerso'][$_SESSION['langue']] ?></h2>
       <div class="tableauPage">
           <!-- titre -->
           <h3><?php echo $traductions['mesInfos'][$_SESSION['langue']] ?></h3>
           <?php if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){ ?>
           <!-- Lien pour le changement de mot de Passe -->
           <a href="changementMotDePasse.php?id=<?php echo $personne->id ?>" rel="external" data-inline="true" data-role="button">
               <?php echo $traductions['modifMotDePasse'][$_SESSION['langue']] ?>
           </a>
           
           <p><?php echo $traductions['champsObligatoires'][$_SESSION['langue']] ?></p>
           <!-- formulaire pour la modification du membre -->
           <form method="post" data-ajax="false">

               <input type="hidden" name="idPersonne" value="<?php echo $personne->id; ?>" />
              <!-- Nom -->
               <div data-role="fieldcontain">
                   <label for="nom"><?php echo $traductions['nom'][$_SESSION['langue']] ?>: *</label>
                   <input type="text" name="nom" id="nom" value="<?php echo $personne->nom; ?>" />
               </div>
              
               <!-- Prénom -->
               <div data-role="fieldcontain">
                   <label for="prenom"><?php echo $traductions['prenom'][$_SESSION['langue']] ?>: *</label>
                   <input type="text" name="prenom" id="prenom" value="<?php echo $personne->prenom ?>" />
               </div>
              
               <!-- Adresse -->
               <div data-role="fieldcontain">
                   <label for="adresse"><?php echo $traductions['adresse'][$_SESSION['langue']] ?>: *</label>
                   <input type="text" name="adresse" id="adresse" value="<?php echo $personne->adresse ?>" />
               </div>
              
               <!-- NPA -->
              <div data-role="fieldcontain">
                   <label for="npa"><?php echo $traductions['npa'][$_SESSION['langue']] ?>: *</label>
                   <input type="text" name="npa" id="npa" value="<?php echo $personne->npa ?>" />
              </div>
              
              <!-- Localité -->
              <div data-role="fieldcontain">
                   <label for="localite"><?php echo $traductions['ville'][$_SESSION['langue']] ?>: *</label>
                   <input type="text" name="localite" id="localite" value="<?php echo $personne->localite ?>" />
              </div>
              
              <!-- Téléphone -->
              <div data-role="fieldcontain">
                   <label for="telephone"><?php echo $traductions['telephone'][$_SESSION['langue']] ?>:</label>
                   <input type="text" name="telephone" id="telephone" value="<?php echo $personne->telephone ?>" />
              </div>
              <p>Format: 027 000 00 00</p>
              <!-- mobile -->
              <div data-role="fieldcontain">
                   <label for="mobile"><?php echo $traductions['mobile'][$_SESSION['langue']] ?>:</label>
                   <input type="text" name="mobile" id="mobile" value="<?php echo $personne->portable ?>" />
              </div>
              <p>Format: 079 000 00 00</p>
              <p><?php echo $traductions['renseignementsPortable'][$_SESSION['langue']] ?></p>
              <!-- email -->
              <div data-role="fieldcontain">
                   <label for="email">Email: *</label>
                   <input type="text" name="email" id="email" value="<?php echo $personne->email ?>" />
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
               
               <div id="erreur">
                   
               </div>
               
               <input type="submit" value="<?php echo $traductions['transmettreInscr'][$_SESSION['langue']] ?>" />
           </form>
           <p><?php echo $traductions['informationUtilisationDonnées'][$_SESSION['langue']] ?></p>
           
           <?php }else{ 
                echo $traductions['membresUniquement'][$_SESSION['langue']];
           } ?>
       </div>
   </div>
<?php
    //Pied de page
    include('../include/footer.inc');
?>