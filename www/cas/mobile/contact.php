<?php
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page de contact
    ***************************************************************************/
?>
<script type="text/javascript">
    //Options pour la carte google
    var myOptions = {
        center: new google.maps.LatLng(46.229283, 7.357077),
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.HYBRID
    };
        
    //Page affichée
    $(document).ready(function () {
        //Mise en place de la carte google
        map = new google.maps.Map(document.getElementById("carteBureau"), myOptions);
        
        //Ajout du point Valrando sur la carte
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(46.229283, 7.357077),
            title:"Valrando"
        });

        //Mise en place du point
        marker.setMap(map);
        
        //Bouton de retour
        $('.ui-btn-back').click(function() {
            window.location = 'index.php';
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
        <h3><?php echo $traductions['contact'][$_SESSION['langue']] ?></h3>
       <?php } ?>
        <div class="tableauPage">
            <b>VALRANDO</b><br />
            <?php echo $traductions['valrandoDef'][$_SESSION['langue']] ?><br />
            Pré-Fleuri 6<br />
            Case postale 23<br />
            CH - 1951 Sion<br />
            <br />
            <?php echo $traductions['heuresOuverture'][$_SESSION['langue']] ?><br />
            <br />
            <a href="tel:+41273273580">Tél. +41 (0)27 / 327 35 80</a><br />
            Fax  +41 (0)27 / 327 35 81<br />
            <br />
            <b><?php echo $traductions['ouEmail'][$_SESSION['langue']] ?>:</b><br />
            <a href="mailto:info@valrando.ch">info[@]valrando.ch</a>
            <br />
            <br />
            <div id="carteBureau">
                
            </div>
            <!--<img src="../pictures/carteValrando.png" height="100%" width="100%" />
        --></div>
    </div>
<?php
include('../include/footer.inc');
?>