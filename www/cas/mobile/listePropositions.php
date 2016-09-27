<?php
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Liste des différentes propositions de randonnées
    ***************************************************************************/
?>
<script>
    //Page affichée
$(document).ready(function() {
    //Bouton retour
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
        <h3><?php echo $traductions['propositions'][$_SESSION['langue']] ?></h3>
       <?php } ?>
        <div class="tableauPage">
            <h3><?php echo $traductions['listePropositions'][$_SESSION['langue']]; ?></h3>
            <a href="rechercheRando.php?propo=oui" data-role="button" data-inline="true" data-mini="true" rel="external">
                <?php echo $traductions['rechercher'][$_SESSION['langue']] ?>
                <img src="../pictures/icons/loupe.png"  height="30px"/>
            </a>
            <a href="proximite.php?rando=6" data-role="button" data-inline="true" data-mini="true" rel="external">
                <?php echo $traductions['dansRegion'][$_SESSION['langue']] ?>
                <img src="../pictures/icons/gps.png"  height="30px"/>
            </a>
            <br/>
            <br/>
            
            <ul data-role="listview" data-filter="true" data-theme="e" 
                data-filter-placeholder="<?php echo $traductions['affinerRecherche'][$_SESSION['langue']] ?>">
                <?php
                $listeProposition = listePropositionsRando($_SESSION['langue']);
                //Affichage de la liste
                while($ligne = mysql_fetch_array($listeProposition)){
                    echo "<li>\n";
                    echo "<a href='detailProposition.php?id=$ligne[0]' rel='external'>\n";
                    echo "<p class='ui-li-aside ui-li-desc'>\n";
                    echo "<strong>$ligne[3]</strong>\n";
                    echo "</p>\n";
                    echo "<h3 class='ui-li-heading'>" . utf8_encode($ligne[1]) . "</h3>\n";
                    echo "<p class='ui-li-desc'>\n";
                    echo "<strong>" . utf8_encode($ligne[2]) . "</strong>";
                    echo "</p>\n";
                    echo "</a>\n";   
                } 
                ?>
                </li>
            </ul>
        </div>
    </div>
<?php
//Pied de page
include('../include/footer.inc');
?>