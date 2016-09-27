<?php
include('../include/toppage.inc');
include('../include/fonctions.inc.php');

/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Randonnées à proximité
***************************************************************************/
//Si c'est une randonnée ou une proposition
if(isset($_GET['rando'])){
    $typeRando = $_GET['rando'];
    /*$rando = $_GET['rando'];

    if($rando == 'rando')
        $typeRando = 1;
    else
        if($rando == 'sejour')
            $typeRando = 2;
        else
            $typeRando = 6;*/
}
else
    //Message d'erreur
    exit($traductions['erreurTypeRando'][$_SESSION['langue']]);
?>

<script>
    //Page affichée
    $(document).ready(function(){
        //Géolocalisation
        if(navigator.geolocation){
            //Récupère la position actuelle
            navigator.geolocation.getCurrentPosition(function(position){
                longitude = position.coords.longitude;
                latitude = position.coords.latitude;
                //recherche la localité par ses coordonnées
                $.ajax({
                    url: '../include/fonctionsAjax.inc.php',
                    data: "longitude=" + longitude + "&latitude=" + latitude,
                    success: function(data){
                        var npa = data;

                        if(npa != 'empty'){
                            $("#lieu").html(npa);
                            getInformationsLocalite(npa);
                        }
                        else {
                            npa = "1950 Sion"
                            getInformationsLocalite(npa);
                            $("#lieu").html("1950 Sion");
                        }
                    }
                });
            });
        }
        else {
            $("#lieu").html("Sion");
        }
        
        // Bouton retour
        $('.ui-btn-back').click(function() {
            <?php if($typeRando != 6){ ?>
                window.location = 'programmeValrando.php';
            <?php }else{ ?>
                window.location = 'listePropositions.php';
            <?php } ?>
            return false;
        });
    });
    
    //Récupère le NPA de la localité
    function getInformationsLocalite(npa){
        $.ajax({
            url: '../include/fonctionsAjax.inc.php',
            data: "npaLocalite=" + npa,
            success: function(data){
                var region = data;

                if(region == '' || region == 0)
                    region = 4;

                listeRandonnees(region);
            }
        });
    }
    
    //Liste de toutes les randonnées dans la région
    function listeRandonnees(region){
        $.ajax({
            url: '../include/fonctionsAjax.inc.php',
            data: "codeRegion=" + region + "&rando=" + <?php echo $typeRando; ?>,
            success: function(data){
                var liste = data;
                
                if(liste == "")
                    $("#aucunResultat").html("Aucun résultat");
                else
                    $("#aucunResultat").html("");

                $("#listeRandonnees").html(liste);
            }
        });
    }
</script>

<div data-role="page" id="main">
   <?php include('../include/header.inc'); ?>
   <div data-role="content">
       <h3><?php echo $traductions['dansRegion'][$_SESSION['langue']]; ?></h3>
       <div class="tableauPage">
            <h3><?php echo $traductions['listeRandoProximite'][$_SESSION['langue']]; ?></h3>
           
            <?php echo $traductions['lieuActuel'][$_SESSION['langue']]; ?> : <span id="lieu"></span>
           
            <br/>
            <br/>
           
            <ul data-role="listview"  data-filter="true" data-theme="e" id="listeRandonnees"
                data-filter-placeholder="<?php echo $traductions['affinerRecherche'][$_SESSION['langue']] ?>">
            </ul>
            <br/>
            <div id="aucunResultat"></div>
       </div>
   </div>
</div>
<?php
//Pied de page
include('../include/footer.inc');
?>