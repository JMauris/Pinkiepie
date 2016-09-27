<?php
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    include('../BusinessObject/randonnees.php');
    include('../BusinessObject/personne.php');
    include('../BusinessObject/inscription.php');
    
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Affichage du détail d'une randonnée
    ***************************************************************************/
    
    //Création des différents objets à utiliser
    $randonnee = new randonnee();
    $inscription = new inscription();
    
    //Informations propres aux objets créés
    $randonnee->id = $_GET['id'];
    $randonnee->getInfoRandonnee();
    $inscription->idRandonnee = $randonnee->id;
    
    //permet de savoir s'il faut afficher le fait de pouvoir s'inscrire
    $inscriptionPrint = "true";
    if(isset($_GET['inscription'])){
        $inscriptionPrint = "false";
    }
    
    //Information si l'objet est un séjour
    $sejour = false;
    //contrôle si c'es un séjour
    if(isset($_GET['inscr'])){
        $sejour = true;
    }
    
    //Création d'une nouvelle personne, récupération de l'ID et des infos
    $personne = new personne();
    $personne->id = 0;
    if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){
        $personne->getPersonne($_SESSION['nom'], $_SESSION['prenom']);
    }
?>
<script>
    //Page affichée
    $(document).ready(function(){
        //Bouton retour
        $('.ui-btn-back').click(function() {
          window.location = 'programmeValrando.php';
          return false;
        });
        
        //Ajout aux favoris
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
            <h5 class="soustitre"><?php
           //Affichage du sous-titre
           if($_SESSION['langue'] == 'fr')
                echo utf8_encode(strstr($randonnee->soustitre, "/", true));
            else
                echo utf8_encode(str_replace("/ ", "", strstr($randonnee->soustitre, " / ")));

            ?></h5>
            <!--affichage de la date -->
            <span id="label"><?php echo $traductions['date'][$_SESSION['langue']] ?>: </span>
            
            <span id="info">
           <?php
                //Gestion de la date de la randonnée
                $dateRando = explode('-',$randonnee->date);
                
                echo $dateRando[2] . "." . $dateRando[1] . "." . $dateRando[0];
                
                //Gestion de la date de fin de la randonnée
                $dateFinRando = explode('-',$randonnee->datefin);

                if($dateFinRando[2] != '00'){
                    echo" - " . $dateFinRando[2] . "." . $dateFinRando[1] . "." . $dateFinRando[0];
                }
           ?></span><br />
            
           <?php
            
            if($randonnee->info_de != '' && strpos($randonnee->info_de, "Sonderprogramm") !== false){
                $siteInternet = strstr($randonnee->info_de, "http://www.",false);
                //Affichage des informations liées à la randonnée
                if($_SESSION['langue'] == 'fr'){
                    echo utf8_encode($randonnee->info_fr);
                    echo "<br />";
                    echo $siteInternet;
                }
                else{
                    //affichage des informations liées à la randonnées
                    echo utf8_encode(strstr(str_replace("/ ", "", $randonnee->info_de), "http://www.",true));
                    echo "<br />";
                    echo $siteInternet;
                }
            }
            else{
           ?>
            
            <!--Affichage des informations sur le lieux -->
            <div id="horaireValrando">
                
                <!--Affichage du lieu de départ -->
                <span id="label"><?php echo $traductions['lieuDepart'][$_SESSION['langue']] ?>: </span>
                <span id="info_lieu"><?php echo utf8_encode($randonnee->lieuDepart); ?></span><br />
                
                <!--Affichage du lieu d'arrivée si différent du lieu de départ-->
               <?php
               if($randonnee->lieuArrivee != ''){?>
                <span id="label"><?php echo $traductions['lieuArrivee'][$_SESSION['langue']] ?>: </span>
                <span id="info_lieu"><?php echo utf8_encode($randonnee->lieuArrivee); ?></span><br />
               <?php 
               }
               else{?>
                <span id="label"><?php echo $traductions['lieuArrivee'][$_SESSION['langue']] ?>: </span>
                <span id="info_lieu"><?php echo utf8_encode($randonnee->lieuDepart); ?></span><br />
                    <?php
               }
                    ?>
                <!--Affichage de l'icône indiquant le type de transport -->
                <div id="transport">
                    
                    <!--Affichage de l'heure de départ ainsi que de l'heure d'arrivée-->
                    <div id="heuresRando">
                       <?php
                       //Gestion de l'affichage des heures de départ et d'arrivées
                       $heureDepart = explode(':', $randonnee->heureDepart);
                       $heureArrivee = explode(':', $randonnee->heureArrivee);

                       if($heureDepart[0] != '00')
                        echo $heureDepart[0] . "h" . $heureDepart[1];
                       echo "<br />\n";
                       if($heureArrivee[0] != '00')
                        echo $heureArrivee[0] . "h" . $heureArrivee[1]; 
                       echo "<br />\n"?>
                    </div>
                </div>
            </div>
            
            <br/>
            <span id="label"><?php echo $traductions['lieuRDV'][$_SESSION['langue']] ?>: </span><span id="info_lieu"><?php echo utf8_encode($randonnee->rdv); ?></span><br />
            
            <div id="partie2">
                <span id="label"><?php echo $traductions['horraire'][$_SESSION['langue']] ?>: </span>
                <span id="info">
                    <a href="horaireTrain.php?id=<?php echo $randonnee->id; ?>" rel="external">
                        <img id="logocff" src="../pictures/icons/logo_cff.png" style="width:300px;"/></a>
                </span><br /><br />
                
                <span id="label"><?php echo $traductions['difficulte'][$_SESSION['langue']] ?>: </span> 
                   <?php 
                        for($i = 0; $i < $randonnee->difficulte; $i++){
                            echo "<img src='../pictures/icons/star.png' height='30px' />";
                        }
               
                 //Si c'est un séjour, modifier le format, sinon afficher normal  
                 if($sejour){
                     $duree = str_replace(";", " / ", $randonnee->duree);
               ?>
                <span id="label_2"><?php echo $traductions['duree'][$_SESSION['langue']] ?>: </span><span id="info_2"><?php echo $duree; ?></span><br />
               <?php
                     
                 }
                 else{
               ?>
                
                <span id="label_2"><?php echo $traductions['duree'][$_SESSION['langue']] ?>: </span><span id="info_2"><?php echo $randonnee->duree; ?></span><br />
               <?php
                 }
                 
                //Afficher le dénivelé uniquement si c'est une randonnée
               if(!$sejour){
               ?>
                <span id="label">
                    <img src="../pictures/icons/arrow.png" style="height: 40px;" id="montee"/>
                </span><?php echo $randonnee->montee; ?> m
                <span id="label_2">
                    <img src="../pictures/icons/arrow.png" style="height: 40px;" id="descente"/>
                </span><span id="info_2"><?php echo $randonnee->descente; ?> m</span><br />
               <?php
               }
               ?>
                
                <span id="label"><?php echo $traductions['chefCourse'][$_SESSION['langue']] ?>: </span><?php echo utf8_encode($randonnee->chefCourse); ?><br />
               <?php
                if($randonnee->assistant != ''){ ?>
                <span id="label"><?php echo $traductions['assistant'][$_SESSION['langue']] ?>: </span><?php echo utf8_encode($randonnee->assistant); ?><br />
               <?php } ?>
                <span id="label"><?php echo $traductions['prix'][$_SESSION['langue']] ?>: </span><span id="prixRando">
               <?php 
                echo "Fr." . $randonnee->prixMin . ".-";
               
                       if($randonnee->prixMax > 0)
                        echo" / Fr." . $randonnee->prixMax . ".-"; ?>
                    
                </span><br />
                
                
                <span id="label"><?php echo $traductions['remarquesInfos'][$_SESSION['langue']] ?>: </span><br/>
              <?php $picto = explode(',',$randonnee->codeprogramme); 
              for($i = 0; $i < sizeof($picto); $i++){
                    $picto[$i] = str_replace(" ", "", $picto[$i]);
                    if($picto[$i] != '' && $picto[$i] != 'o'){
                        echo "<a class='infobulle'><img src='../pictures/pictogrammes/$picto[$i].png' height='70px'></img><span>" . $traductions[$picto[$i]][$_SESSION['langue']] ." </span></a>";
                    }
                }
               if($randonnee->inscriptionMax > 0){ ?>
                <span id="champ">
                    <a class='infobulle'>
                        <img src='../pictures/pictogrammes/o.png' style="height: 70px;" />
                        <span><?php echo $traductions['o'][$_SESSION['langue']] ?></span>
                    </a>
                    <span id="placeslibres">
                    <?php 
                        $nbPlacesTotal = $randonnee->inscriptionMax;
                        $nbPlacesLibres = $inscription->nombrePlacesLibres();
                        
                        if($nbPlacesLibres == 0){
                            echo "<p style='top: -38px; color: red; position: relative;'>" . $traductions['inscrPlein'][$_SESSION['langue']] . "</p>";
                            
                        }
                        elseif($nbPlacesLibres < ($nbPlacesTotal * 0.15)){
                            echo "<strong style='color:red;'>" . $nbPlacesLibres . "</strong>";
                        }
                        else{
                            echo $nbPlacesLibres;
                        }
                    
                    ?>
                        
                    </span>
                </span>
               <?php } ?>
                
                
            </div>
            <?php if($randonnee->carte){ ?>
            <a href="carteRandonnee.php?id=<?php echo $randonnee->id ?>" rel="external" 
               data-role="button" data-inline="true"><?php echo $traductions['carteRando'][$_SESSION['langue']] ?></a>
            <?php } 
            if($sejour && $personne->id == ''){
                echo $traductions['uniquementPourMembres'][$_SESSION['langue']] . "<br>";
                echo "<a href=\"connexion.php\" data-role='button' data-inline='true' rel=\"external\">" . $traductions['seConnecter'][$_SESSION['langue']] . "</a>";
            }
            else{
                //Récupère la date pour savoir s'il faut afficher l'inscription
                $date = date("Y-m-d");
                if($date <= $randonnee->date && $inscriptionPrint == "true"){
                    
                    //Si c'est un séjour, modifier le lien
                    if($sejour){
           ?>
            <a href="inscriptionRando.php?id=<?php echo $randonnee->id; ?>&type=sejour" id="bouttonInscription" rel="external"
               data-role="button" data-inline="true"><?php echo $traductions['inscrire'][$_SESSION['langue']] ?></a>
           <?php
                    }else{
           ?>
            <a href="inscriptionRando.php?id=<?php echo $randonnee->id; ?>" id="bouttonInscription" rel="external"
               data-role="button" data-inline="true"><?php echo $traductions['inscrire'][$_SESSION['langue']] ?></a>
            <?php
                }
              }
            }
            ?>
            <?php
            //Contrôle si l'utilisateur est connecté afin d'afficher l'ajour aux favoris
            if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){
                // Regarde si c'est déjà un favori
                $favori = false;
                $listeFavoris = favorisPersonne($personne->id);
                //Si la liste des favoris compte des enregistrements
                if(sizeof(mysql_fetch_array($listeFavoris)) != 1){
                    $listeFavoris = favorisPersonne($personne->id);
                    //Affichage des différents favoris
                    while($ligne = mysql_fetch_array($listeFavoris)){
                        if($ligne[0] == $randonnee->id)
                            $favori = $ligne[0];
                    }
                }
                
                if($favori == false){
                ?>
            <br /><a href="#" id="ajoutFavoris" rel="external" data-role="button" data-inline="true">
                        <?php echo $traductions['ajoutFavoris'][$_SESSION['langue']] ?>
            </a>
                <?php
                }
                else {
                ?>
            <br /><a href="#" id="supprimeFavoris" rel="external" data-role="button" data-inline="true" value='<?php echo $favori; ?>'>
                        <?php echo $traductions['supprimerFavoris'][$_SESSION['langue']]; ?>
            </a>
                <?php
                }
            }
        }
       ?>
        </div>
    </div>
<?php
//Pied de page
include('../include/footer.inc');
?>