<?php
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Informations sur Valrando
    ***************************************************************************/
    
?>
<script>
    $(document).ready(function(){
        //Gestion du retour
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
                <div id='logout'><a href='../include/logout.inc.php' rel="external"><img src='../pictures/exit.png' height='50px' /></a></div>
                </h3>
            </div>
       <?php }else{ ?>
           <h3><?php echo $traductions['infos_valrando'][$_SESSION['langue']] ?></h3>
       <?php } ?>
       <div class="tableauPage">
           <table class="fwelement fwtable fwtable1" cellspacing="0" cellpadding="0">
	<tbody>
            <tr>
		<td><p><?php echo $traductions['nom'][$_SESSION['langue']] ?>:</p></td>
		<td><p></p><?php echo $traductions['nomValrando'][$_SESSION['langue']] ?></td>
            </tr>
            <tr>
                <td><p><?php echo $traductions['fondation'][$_SESSION['langue']] ?>:</p></td>
                <td><p>1943</p></td>
            </tr>
            <tr>
                <td><p><?php echo $traductions['siege'][$_SESSION['langue']] ?>:</p></td>
                <td><p>CH-1951 <?php echo $traductions['sion'][$_SESSION['langue']] ?></p></td>
            </tr>
            <tr>
                <td><p><?php echo $traductions['organisationFaitiere'][$_SESSION['langue']] ?>:</p></td>
                <td><?php echo $traductions['suisseRando'][$_SESSION['langue']] ?></td>
            </tr>
            <tr>
                    <td><p><?php echo $traductions['certification'][$_SESSION['langue']] ?>:</p></td>
                    <td><p><a href="http://www.sqs.ch/fr/index/anerkennung.htm" target="_blank">ISO 9001</a>&nbsp;- <a href="http://www.sqs.ch/fr/index/leistungsangebot/h140.htm" target="_blank">ISO 14001</a> - <a href="http://www.valais-excellence.ch/fr" target="_blank">Valais Excellence<br></a></p></td>
            </tr>
            <tr>
                    <td><p><?php echo $traductions['activites'][$_SESSION['langue']] ?>:</p></td>
                    <td>
                        <?php echo $traductions['activitesValrando'][$_SESSION['langue']] ?>
                    </td>
            </tr>
            <tr>
                    <td>
                        <p><?php echo $traductions['nbMembres'][$_SESSION['langue']] ?>:</p>
                    </td>
                    <td>
                        <p>2000</p>
                    </td>
            </tr>
            <tr>
                    <td><p><?php echo $traductions['cotisation'][$_SESSION['langue']] ?>:</p></td>
                    <td>
                        <?php echo $traductions['cotisationTexte'][$_SESSION['langue']] ?>
                    </td>
            </tr>
            <tr>
                    <td><p><?php echo $traductions['avantagesMembres'][$_SESSION['langue']] ?>:</p></td>
                    <td>
                        <?php echo $traductions['avantagesMembresTexte'][$_SESSION['langue']] ?>
                    </td>
            </tr>
            <tr>
                    <td><p><?php echo $traductions['statuts'][$_SESSION['langue']] ?>:</p></td>
                    <td><p><a href="<?php echo $traductions['lienStatusValrando'][$_SESSION['langue']] ?>" target="_blank"><?php echo $traductions['statutsPDF'][$_SESSION['langue']] ?></a></p></td>
            </tr>
       </tbody>
       </table>
       </div>
   </div>
<?php
//Pied de page
    include('../include/footer.inc');
?>