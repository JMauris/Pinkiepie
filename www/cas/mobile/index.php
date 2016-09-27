<?php
include('../include/toppage.inc');
include('../include/fonctions.inc.php');

/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Page d'accueil
***************************************************************************/

// Si la personne est connectée
if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){
    $nom = $_SESSION['nom'];
    $prenom = $_SESSION['prenom'];
}
else {
    $nom = "";
    $prenom = "";
}    
?>

<div data-role="page" id="main">
   <?php include('../include/header.inc'); ?>
   <div data-role="content">
       <?php if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){ ?>
            <div id="titrePage">
                <h3>
                    <?php echo $traductions['actuellementConnecte'][$_SESSION['langue']]; ?>
                    <div id='logout'>
                        <a href='../include/logout.inc.php' rel="external">
                            <img src='../pictures/exit.png' alt="déconnexion" height='50px' />
                        </a>
                    </div>
                </h3>
            </div>
       <?php }
       else { ?>
            <h3><?php echo $traductions['bienvenue'][$_SESSION['langue']]; ?></h3>
       <?php } ?>
            
       <div class="tableauPage">
           <table frame="void" class="tabAccueil">
                <tr>
                    <td class="tdIndex">
                        <a href="programmeValrando.php" rel="external">
                            <img src="../pictures/icons/randonnee.png" alt="<?php $traductions['programme'][$_SESSION['langue']] ?>"/>
                            <p><?php echo $traductions['programme'][$_SESSION['langue']] ?></p>
                        </a><br/>
                    </td>
                    <td class="tdIndex">
                        <a href="listePropositions.php" rel="external">
                            <img src="../pictures/icons/tour.gif" alt="<?php echo $traductions['propositions'][$_SESSION['langue']] ?>"/>
                            <p><?php echo $traductions['propositions'][$_SESSION['langue']] ?></p>
                        </a><br/>
                    </td>
                </tr>
                <?php
                if(isset($_SESSION['nom'])  && $_SESSION['nom'] != ''){
                ?>
                <tr>
                    <td class="tdIndex">
                        <a href="mesRandonnees.php" rel="external">
                            <img src="../pictures/icons/calendar.png" alt="<?php echo $traductions['monProgramme'][$_SESSION['langue']] ?>"/>
                            <p><?php echo $traductions['monProgramme'][$_SESSION['langue']] ?></p>
                        </a><br/>
                    </td>
                    <td class="tdIndex">
                        <a href="mesPropositions.php" rel="external">
                            <img src="../pictures/icons/mesRandos.png" alt="<?php echo $traductions['mesPropositions'][$_SESSION['langue']] ?>"/>
                            <p><?php echo $traductions['mesPropositions'][$_SESSION['langue']] ?></p>
                        </a><br/>
                    </td>
                </tr>
                <tr>
                    <td class="tdIndex" colspan="2">
                        <a href="mesInfos.php" rel="external">
                            <img src="../pictures/icons/infosPerso.png" alt="<?php echo $traductions['mesInfosPerso'][$_SESSION['langue']] ?>" />
                            <p><?php echo $traductions['mesInfosPerso'][$_SESSION['langue']] ?></p>
                        </a>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td class="tdIndex">
                        <a href="contact.php" rel="external">
                            <img src="../pictures/icons/mail.png" alt="<?php echo $traductions['contact'][$_SESSION['langue']] ?>"/>
                            <p><?php echo $traductions['contact'][$_SESSION['langue']] ?></p>
                        </a>
                    </td>
                    <td class="tdIndex">
                        <a href="valrando.php" rel="external">
                            <img src="../pictures/logoCas.png" alt="<?php echo $traductions['infos_valrando'][$_SESSION['langue']] ?>"/>
                            <p><?php echo $traductions['infos_valrando'][$_SESSION['langue']] ?></p>
                        </a>
                    </td>
                </tr>
                <?php
                if(!isset($_SESSION['nom']) || $_SESSION['nom'] == ''){
                ?>
                <tr>
                    <td colspan=2 class="tdIndex">
                        <a href="connexion.php" rel="external">
                            <img src="../pictures/icons/lock.png" alt="<?php echo $traductions['monValrando'][$_SESSION['langue']] ?>"/>
                            <p><?php echo $traductions['monValrando'][$_SESSION['langue']] ?></p>
                        </a><br/>
                    </td>
                </tr>
                <?php
                }
                ?>
            </table>
       </div>
   </div>
    
<?php
//Pied de page
include('../include/footer.inc');
?>