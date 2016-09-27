<?php
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Liste des évaluations effectuées par l'utilisateur
    ***************************************************************************/
?>
<script>
    //Page affichée
    $(document).ready(function(){
        //Ajout de la fonction de rating
        $(".ratingResult").jRating({
            bigStarsPath: '../include/jrating_v2.2/jquery/icons/stars.png',
            rateMax: 5,
            isDisabled: true
        });
       
       
    });

</script>
           <h3><?php echo $traductions['favoris'][$_SESSION['langue']] ?></h3>
           <ul data-role="listview" data-filter="true" data-theme="e" data-filter-placeholder="<?php echo $traductions['affinerRecherche'][$_SESSION['langue']] ?>">
               <?php
               //Récupération des favoris de cette personne
               $listeFavoris = evaluationsPersonne($personne->id);

               while($ligne = mysql_fetch_array($listeFavoris)){
                   echo "<li>\n";
                   echo "<a href='detailProposition.php?id=$ligne[0]' rel='external'>\n";
                   echo "<h3 class='ui-li-heading'>" . utf8_encode($ligne[1]) . "</h3>\n";
                   echo "<p class='ui-li-desc'>\n";
                    echo "<div class='ratingResult' id='$ligne[2]_0'></div>";
                    echo "</p>\n";
                   echo "</a>";
                   echo "</li>";
               }
               ?>
           </ul>