<?php
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Propositions de randonnées favorites
    ***************************************************************************/
?>

<script>
    $(document).ready(function(){
        //Clique sur la suppression d'un favoris
        $("#supprimerFavoris").click(function(){
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               data: "defavoris=" + $("#supprimerFavoris").attr('value') + '<?php echo "_" . $personne->id; ?>',
               success: function(data){
                   alert('<?php echo $traductions['supprimeFavoris'][$_SESSION['langue']] ?>');
                   window.location.reload();
               }
            });
        })
     });
</script>
<?php
    //Récupération des favoris de cette personne
       $listeFavoris = favorisPropoPersonne($personne->id);

       //Si la liste n'est pas vide => afficher
       if(sizeof(mysql_fetch_array($listeFavoris)) != 1){


    ?>
   <h3><?php echo $traductions['favoris'][$_SESSION['langue']] ?></h3>
   <ul data-role="listview" data-filter="true" data-theme="e">
       <?php
       //Récupération des favoris de cette personne
       $listeFavoris = favorisPropoPersonne($personne->id);

       //mise en place de la liste
       while($ligne = mysql_fetch_array($listeFavoris)){
           echo "<li>\n";

           //Lien pour le détail de la proposition
           echo "<a href='detailProposition.php?id=$ligne[0]' rel='external'>\n";

           //Titre
           echo "<h3 class='ui-li-heading'>" . utf8_encode($ligne[1]) . "</h3>\n";

           //Description
           echo "<p class='ui-li-desc'>\n";
           echo "<a id='supprimerFavoris' href='#' value='$ligne[0]' data-role='button' data-inline='true'><strong>Retirer des favoris</strong></a>";
           echo "</p>";

           echo "</a>";
           echo "</li>";
       }
       ?>
   </ul>
   <?php
       }
       else{
           //Affiche une information indiquant qu'il n'y a aucun favoris pour cette personne
           echo "<p>" .  $traductions['aucunFavoris'][$_SESSION['langue']] . "</p>";
       }
   ?>