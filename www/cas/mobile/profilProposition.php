<?php
    include('../include/toppage.inc');
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Affichage du profil de la randonnée
    ***************************************************************************/
    //Code de la randonnée
    $code = $_GET['code'];
?>
<script>
    //Page affichée
    $(document).ready(function(){
        //Gestion du retour
       $('.ui-btn-back').click(function() {
          window.location = 'detailProposition.php?id=' + <?php echo $_GET['id']; ?>;
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
                <div id='logout'><a href='../include/logout.inc.php' rel="external"><img src='../pictures/exit.png' height='50px' /></a></div>
                </h3>
            </div>
       <?php }else{ ?>
           <h3>Profil</h3>
       <?php } ?>
       <div class="tableauPage">
           <img src="../propositions/Profil/<?php echo $code; ?>.jpg" />
       </div>
   </div>
<?php
//Pied de page
    include('../include/footer.inc');
?>