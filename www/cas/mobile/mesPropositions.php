<?php
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    include('../BusinessObject/personne.php');
    
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Affichage des propositions favorites d'une personne
    ***************************************************************************/
    //Création d'une personne et récupération des informations personnelles
    $personne = new personne();
    
    if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){
        $personne->getPersonne($_SESSION['nom'], $_SESSION['prenom']);
    }
?>

<script>
    //Page affichée
    $(document).ready(function(){
        //Affichage du contenu
        $('div[data-role="navbar"] a').live('click', function () {
            $(this).addClass('ui-btn-active');
            $('div.content_div').hide();
            $($(this).attr('data-href')).show();
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
           <h3><?php echo $traductions['mesPropositions'][$_SESSION['langue']] ?></h3>
       <?php } ?>
       <div class="tableauPage">
           <?php if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){ ?>
           <div data-role="navbar">
                <ul>
                    <li><a href="#" data-href="#a" style="font-size:120%"><?php echo $traductions['mesFavoris'][$_SESSION['langue']] ?></a></li>
                    <li><a href="#" data-href="#b" style="font-size:120%"><?php echo $traductions['mesEvaluations'][$_SESSION['langue']] ?></a></li>
                </ul>
           </div>
           <div id="a" class="content_div">
               <?php include('favorisProposition.inc.php'); ?>
           </div>
           <div id="b" class="content_div">
               <?php include('mesEvaluations.inc.php'); ?>
           </div>
           <?php }else{ 
                echo $traductions['membresUniquement'][$_SESSION['langue']];
           } ?>
        </div>
   </div>
<?php
    //Pied de page
    include('../include/footer.inc');
?>