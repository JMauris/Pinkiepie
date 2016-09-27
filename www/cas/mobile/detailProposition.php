<?php
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    include('../BusinessObject/randonnees.php');
    include('../BusinessObject/personne.php');
    
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Affichage du détail de la randonnée
    ***************************************************************************/
    //Création d'une randonnée
    $randonnee = new randonnee();
    //récupéraiton de l'id de la randonnée et des informations de cette rando
    $randonnee->id = $_GET['id'];
    $randonnee->getInfoRandonnee();
    
    //Si la personne est connectée, récupération des infos personnelles
    if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){
        $personne = new personne();
        $personne->getPersonne($_SESSION['nom'], $_SESSION['prenom']);
    }
    else{
        $personne->id = 0;
    }
?>
<script>
    //Document affiché
    $(document).ready(function(){
        
        //Bouton de retour
       $('.ui-btn-back').click(function() {
          window.location = 'listePropositions.php';
          return false;
        });
        
        //Mise en place de la fonction de vote
        $(".ratingResult").jRating({
            bigStarsPath: '../include/jrating_v2.2/jquery/icons/stars.png',
            rateMax: 5,
            isDisabled: true
        });
        
        //mise en place de la fonction de vote
        $(".rateRando").jRating({
            bigStarsPath: '../include/jrating_v2.2/jquery/icons/stars.png',
            step: false,
            rateMax:5,
            onSuccess: function(){
                 alert('<?php echo $traductions['evalOkay'][$_SESSION['langue']] ?>');
            }
        });
        
        //Clique sur le bouton d'ajout aux favoris
        $("#ajoutFavoris").click(function(){
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               data: "idRandonnee=" + <?php echo $randonnee->id; ?>+ "&idPersonne=" + <?php echo $personne->id; ?>,
               success: function(data){
                   alert('<?php echo $traductions['ajouteFavoris'][$_SESSION['langue']] ?>');
                   window.location.reload();
               }
            });
        })
        
        //Supprime des favoris
        $("#supprimeFavoris").click(function(){
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               data: "defavoris=" + $("#supprimeFavoris").attr('value') + '<?php echo "_" . $personne->id; ?>',
               success: function(data){
                   alert('<?php echo $traductions['supprimeFavoris'][$_SESSION['langue']] ?>');
                   window.location.reload();
               }
            });
        })
    })

</script>
<div data-role="page" id="main">
   <?php include('../include/header.inc'); ?>
    <div data-role="content">
       <?php if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){ ?>
        <div id="titrePage">
            <h3><?php echo $traductions['actuellementConnecte'][$_SESSION['langue']]; ?>
                <div id='logout'>
                    <a href='../include/logout.inc.php' rel="external">
                        <img src='../pictures/exit.png' height='50px' />
                    </a>
                </div>
            </h3>
        </div>
       <?php } ?>
        <div class="tableauPage">
            <h3><?php echo utf8_encode($randonnee->titre); ?></h3>
            <!--Affichage des informations sur le lieux -->
            <div id="horaireValrando">
                <span id="label"><?php echo $traductions['lieuDepart'][$_SESSION['langue']] ?>:</span>
                <span id="info"><?php echo utf8_encode($randonnee->lieuDepart); ?></span><br />
                
                <span id="label"><?php echo $traductions['lieuArrivee'][$_SESSION['langue']] ?> :</span>
                <span id="info"><?php echo utf8_encode($randonnee->lieuArrivee); ?></span><br />
                
                <span id="label"><?php echo $traductions['difficulte'][$_SESSION['langue']] ?> :</span>
                <span id="info">
                    <?php
                    //Affichage du bon nombre d'étoiles
                    for($i = 0; $i < $randonnee->difficulte; $i++)
                        echo "<img src='../pictures/icons/star.png' height='20px' />";
                    ?>
                </span>
                <br />
                <span id="label"><?php echo $traductions['duree'][$_SESSION['langue']] ?> :</span>
                <span id="info"><?php echo $randonnee->duree; ?></span>
                <br />
                
                <!--Affichage de l'icône indiquant le type de transport -->
                <div id="propositionPic">
                    <?php
                    //Si la photo de la proposition existe, l'afficher
                    if(file_exists("../propositions/Photos/$randonnee->codeprogramme.jpg")){
                    ?>
                        <img src="../propositions/Photos/<?php echo $randonnee->codeprogramme; ?>.jpg" style="width: 100%;"/><br />
                    <?php
                    }
                    //Si le croquis de la proposition existe, l'afficher
                    if(file_exists("../propositions/Croquis/$randonnee->codeprogramme.jpg")){
                    ?>
                        <img src="../propositions/Croquis/<?php echo $randonnee->codeprogramme; ?>.jpg" style="width: 100%;"/>
                    <?php
                    }
                    ?>
                </div>
                
                <span id="label"><?php echo $traductions['description'][$_SESSION['langue']] ?>:</span>
                <br />
                <span id="descriptionProposition">
                    <?php
                    //Affichage de la description dans la bonne langue
                    if($_SESSION['langue'] == 'fr')
                        echo utf8_encode ($randonnee->desc_fr);
                    else
                        echo utf8_encode ($randonnee->desc_de);

                    //récupération des resultats des votes sinon, moyenne
                    $rating = $randonnee->getMoyenneEvaluation();
                    $rating = $rating[0];
                    //Si aucun vote, alors moyenne à 3
                    if($rating == '')
                        $rating = 3;
                    ?>
                    <br />
                    <span id="label"><?php echo $traductions['popularite'][$_SESSION['langue']] ?>:</span>
                    <div class="ratingResult" id="<?php echo $rating; ?>_1"></div>
                    
                    <?php
                    //Si la personne est connectée, elle peut évaluer la rando
                    if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){
                    ?>
                        <br /><span id="label"><?php echo $traductions['noterRando'][$_SESSION['langue']] ?></span>
                        <div id ="evaluationRando">
                            <div class="rateRando" id="0_<?php echo strlen($personne->id) . $personne->id . $randonnee->id; ?>">

                            </div>
                        </div>
                    <?php
                    }
                  
                    //Si le profil de la randonnée existe, afficher le bouton pour voir le profil
                    if(file_exists("../propositions/Profil/" . $randonnee->codeprogramme . ".jpg")){
                    ?>
                        <a href="profilProposition.php?code=<?php echo $randonnee->codeprogramme; ?>&id=<?php echo $randonnee->id; ?>" data-role="button"
                        rel="external">
                            <?php echo $traductions['profilRando'][$_SESSION['langue']] ?>
                        </a>
                    <?php
                    }
                    //Si le fichier KML pour afficher sur la carte existe, afficher le lien
                    if(file_exists("../propositions/KML/$randonnee->codeprogramme.kml")){
                    ?>
                        <a href="carteRandonnee.php?proposition=<?php echo $randonnee->id; ?>" data-role="button"
                        rel="external">
                            <?php echo $traductions['carteRando'][$_SESSION['langue']] ?>
                        </a>
                    <?php
                    }
                    
                    //Contrôle si l'utilisateur est connecté afin d'afficher l'ajout aux favoris
                    if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){
                        // Regarde si c'est déjà un favori
                        $favori = false;
                        $listeFavoris = favorisPropoPersonne($personne->id);
                        //Si la liste des favoris compte des enregistrements
                        if(sizeof(mysql_fetch_array($listeFavoris)) != 1){
                            $listeFavoris = favorisPropoPersonne($personne->id);
                            //Affichage des différents favoris
                            while($ligne = mysql_fetch_array($listeFavoris)){
                                if($ligne[0] == $randonnee->id)
                                    $favori = $ligne[0];
                            }
                        }

                        if($favori == false){
                        ?>
                            <a href="#" id="ajoutFavoris" rel="external" data-role="button" data-inline="true">
                                <?php echo $traductions['ajoutFavoris'][$_SESSION['langue']] ?>
                            </a>
                        <?php
                        }
                        else {
                        ?>
                            <br />
                            <a href="#" id="supprimeFavoris" rel="external" data-role="button" data-inline="true" value='<?php echo $favori; ?>'>
                                <?php echo $traductions['supprimerFavoris'][$_SESSION['langue']] ?>
                            </a>
                        <?php
                        }
                    }
                    ?>
                </span>
                <br/>
            </div>
            <div id="partie2_propo">
            </div>
        </div>
    </div>
<?php
    include('../include/footer.inc');
?>
