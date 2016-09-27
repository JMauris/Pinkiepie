<?php
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    include('../BusinessObject/personne.php');
    
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Programme de Valrando (rando + Séjours)
    ***************************************************************************/
    //Création d'une personne et récupération des données
    if(isset($_SESSION['nom'])){
        $personne = new personne();
        $personne->getPersonne($_SESSION['nom'], $_SESSION['prenom']);
    }
?>

<script>
    //Page affichée
    $(document).ready(function(){
        //Bouton de retour
       $('.ui-btn-back').click(function() {
          window.location = 'index.php';
          return false;
        });
        //Gestion des tabs
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
                <div id='logout'>
                    <a href='../include/logout.inc.php' rel="external">
                        <img src='../pictures/exit.png' height='50px' />
                    </a>
                </div>
                </h3>
            </div>
       <?php }else{ ?>
           <h3><?php echo $traductions['programme'][$_SESSION['langue']] ?></h3>
       <?php } ?>
       <div class="tableauPage">
           <div data-role="navbar">
                <ul>
                    <li>
                        <a href="#" data-href="#a" style="font-size:120%">
                            <?php echo $traductions['randonnees'][$_SESSION['langue']] ?>
                        </a>
                    </li>
                    <li>
                        <a href="#" data-href="#b" style="font-size:120%">
                            <?php echo $traductions['sejours'][$_SESSION['langue']] ?>
                        </a>
                    </li>
                </ul>
           </div>
           <div id="a" class="content_div">
               <?php include('listeRandonnees.php'); ?>
           </div>
           <div id="b" class="content_div">
               <?php include('listeSejours.php'); ?>
           </div>
        </div>
   </div>
<?php
    //Pied de page
    include('../include/footer.inc');
?>