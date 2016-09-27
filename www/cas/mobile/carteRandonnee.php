<?php
    include('../include/toppage.inc'); //En-tête de la page
    include('../include/fonctions.inc.php');
    include('../BusinessObject/randonnees.php');
    
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Affichage de la carte d'une randonnée ou d'une proposition
    ***************************************************************************/
    $randonnee = new randonnee();
    
    //récupération de l'ID de la randonnée
    if(isset($_GET['id']))
        $randonnee->id = $_GET['id'];
    else
        $randonnee->id = $_GET['proposition'];
    
    //récupère toutes les informations liées à la randonnée
    $randonnee->getInfoRandonnee();
    
    //Si c'est une proposition, chargement du fichier enregistré sur le serveur
    if(isset($_GET['proposition'])){
        $xml = simplexml_load_file("../propositions/KML/$randonnee->codeprogramme.kml");
    }
    //Si c'est une randonnée, utilisation du lien pour la carte
    else{
        $xml = simplexml_load_file($randonnee->carte);
    }
    
    //Parcours du fichier afin de récupérer le lien vers le fichier KML
    foreach($xml->children() as $child)
    {
        foreach($child->children() as $child2){
             foreach($child2->children() as $child3){
                 foreach($child3->children() as $child4){
                     //récupération du lien
                     if($child4->getname() == 'href')
                         $randonnee->carte = $child4;
                 }
            }
        }
    }
?>

<script type="text/javascript">
    //Options pour la carte Google (centrée sur Sion)
    var myOptions = {
        center: new google.maps.LatLng(46.255760, 7.425260),
        zoom: 8,
        mapTypeId: google.maps.MapTypeId.HYBRID
    };
        
      
    $(document).ready(function () {
        //Ajout de la carte sur la page
        map = new google.maps.Map(document.getElementById("carteRando"), myOptions);

        //Ajout du parcours sur la carte
        var ctaLayer = new google.maps.KmlLayer('<?php echo $randonnee->carte; ?>');
        ctaLayer.setMap(map);

        //Gestion du retour
        $('.ui-btn-back').click(function() {
            <?php if($randonnee->typeTour != 6){ ?>
                window.location = 'detailRandonnee.php?id=' + <?php echo $randonnee->id ?>;
            <?php }else{ ?>
                window.location = 'detailProposition.php?id=' + <?php echo $randonnee->id ?>;
            <?php } ?>
            return false;
        });
    });
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
        <?php }else{ ?>
            <h3>Carte pour: <?php echo utf8_encode($randonnee->titre); ?></h3>
        <?php } ?>
        <div class="tableauPage">
            <div id="carteRando" ></div>
        </div>
    </div>
<?php
//Pied de page
include('../include/footer.inc');
?>