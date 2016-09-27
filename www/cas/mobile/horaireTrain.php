<?php
include('../include/toppage.inc');
include('../include/fonctions.inc.php');
include('../BusinessObject/randonnees.php');

/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Page pour l'horraire CFF
***************************************************************************/
//Nouvelle randonnée
$randonnee = new randonnee();
//Récupère l'ID et les informations de la randonnée
$randonnee->id = $_GET['id'];
$randonnee->getInfoRandonnee();

//Gestion de la date de début
$dateDebut = explode("-", $randonnee->date);
$dateDebut = $dateDebut[2] . "." . $dateDebut[1] . "." . $dateDebut[0];
?>
<script>
    //Page affichée
    $(document).ready(function() {
        //Gestion du retour
       $('.ui-btn-back').click(function() {
          window.location = 'detailRandonnee.php?id=' + <?php echo $randonnee->id; ?>;
          return false;
        });
    });

</script>
<div data-role="page" id="main">
    <?php include('../include/header.inc'); ?>
    <?php if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){ ?>
    <div id="titrePage">
        <h3><?php echo $traductions['actuellementConnecte'][$_SESSION['langue']]; ?>
            <div id='logout'><a href='../include/logout.inc.php' rel="external"><img src='../pictures/exit.png' height='50px' /></a></div>
        </h3>
    </div>
    <?php } ?>
    <div data-role="content">
        <h3>Horaire CFF</h3>
        <div class="tableauPage">
            <div style="width: 500px; margin: 0px; padding: 0px; text-align: right; background-color:#DDDDDD;">
                <img src="../pictures/icons/logo_cff.png" width="190" alt="SBB|CFF|FFS" />
                <h1 style="width:500px; background-color: #DDDDDD; color: #000000; font-family: Arial, Helvetica, sans-serif; font-weight: bold; padding: 2px 0px; margin: 0; text-align: left;clear:both;"> Horaire</h1>
                <div style="width: 100%; background-color: #F8F8F8; margin: 0; padding: 0px;" summary="Layout">
                    <form action="http://fahrplan.sbb.ch/bin/query.exe/fn?externalCall=yes&DCSext.wt_fp_request=partner_mini" name="formular" method="post" style="display:inline" target="_blank">
                        <input type="hidden" name="queryPageDisplayed" value="yes">
                        <table id="tableHoraire" cellspacing="0" cellpadding="4" style="width: 500px; margin: 2px;" class="ig">
                            <tr>
                                <td style="font-family:Arial, Helvetica, sans-serif; text-align:left; vertical-align:middle; padding:2px 3px 2px 0px;">
                                    <select name="REQ0JourneyStopsSA" style="background-color:#fff; border: 1px solid #7F9DB9; color: #000; width: 60px; margin:0px 0px;">
                                        <option selected="selected" value="7">De:</option>
                                        <option  value="1">Gare/Arrêt</option>
                                        <option  value="2">Lieu, rue, numéro</option>
                                        <option  value="4">Tourisme</option>
                                    </select>
                                </td>
                                <td style="font-family:Arial, Helvetica, sans-serif; text-align:left; vertical-align:middle; padding:2px 3px 2px 0px;" colspan="2">
                                    <input type="text" name="REQ0JourneyStopsSG" value="" size="16" style="background-color:#fff; border: 1px solid #7F9DB9; color: #000; width: 340px;" accesskey="f" tabindex="1">
                                    <input type="hidden" name="REQ0JourneyStopsSID">
                                </td>
                            </tr>
                            <tr>
                                <td style="font-family:Arial, Helvetica, sans-serif; text-align:left; vertical-align:middle; padding:2px 3px 2px 0px;">
                                    <select name="REQ0JourneyStopsZA" style="background-color:#fff; border: 1px solid #7F9DB9; color: #000; width: 360px; margin:0px 0px;">
                                        <option selected="selected" value="7">À:</option>
                                        <option  value="1">Gare/Arrêt</option>
                                        <option  value="2">Lieu, rue, numéro</option>
                                        <option  value="4">Tourisme</option>
                                    </select>
                                </td>
                                <td style="font-family:Arial, Helvetica, sans-serif; text-align:left; vertical-align:middle; padding:2px 3px 2px 0px;" colspan="2">
                                    <input type="text" name="REQ0JourneyStopsZG" value="<?php echo $randonnee->lieuDepart; ?>" size="16" style="background-color:#fff; border: 1px solid #7F9DB9; color: #000; width: 340px;" accesskey="t" tabindex="2">
                                    <input type="hidden" name="REQ0JourneyStopsZID">
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap" style="font-family:Arial, Helvetica, sans-serif; text-align:left; vertical-align:middle; font-weight:bold; width: 55px;">
                                     Date: 
                                </td>
                                <td nowrap="nowrap" style="font-family:Arial, Helvetica, sans-serif !important; text-align:left !important; vertical-align:middle !important; padding:2px 3px 2px 0px !important;">
                                    <b><?php echo $dateDebut; ?></b>
                                    <input type="hidden" name="REQ0JourneyDate" value="<?php echo $dateDebut; ?>" accesskey="d">
                                </td>
                            </tr>
                            <tr>
                                <td nowrap="nowrap" style="font-family:Arial, Helvetica, sans-serif; text-align:left; vertical-align:middle; font-weight:bold; width: 55px;">
                                     Heure: 
                                </td>
                                <td nowrap="nowrap" style="font-family:Arial, Helvetica, sans-serif; text-align:left; vertical-align:middle; padding:2px 3px 2px 0px;">
                                    <input type="text" name="REQ0JourneyTime" value="<?php echo $randonnee->heureDepart; ?>" size="5" maxlength="5" style="background-color:#fff; border: 1px solid #7F9DB9; color: #000; width: 340px;" accesskey="c" tabindex="4">
                                </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td nowrap="nowrap" style="font-family:Arial, Helvetica, sans-serif; text-align:left; vertical-align:middle; padding:2px 3px 2px 0px;">
                                    <input class="radio" type="radio" name="REQ0HafasSearchForw" value="1" style="margin-right:3px;">Départ 
                                    <br /><input class="radio" type="radio" name="REQ0HafasSearchForw" value="0" checked  style="margin-right:3px;">Arrivée
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left;">
                                    <input type="hidden" name="start" value="Chercher">
                                    <input type="submit" name="start" value="Chercher correspondances" tabindex="5" data-role="none" style="font-family:Arial, Helvetica, sans-serif; text-align:center; width:475px; vertical-align: middle; cursor:pointer; -moz-border-radius: 3px 3px 3px 3px; background-color:#EE0000 !important; border:1px solid #B20000; color:#FFFFFF; font-weight:bold; line-height:20px; padding:0px 10px; text-decoration:none; white-space:nowrap;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:left;">
                                    <a style="font-family:Arial,Helvetica,sans-serif; text-align:left; margin-top:4px; color: #6B7786; text-decoration:none; display:block;" href="http://www.cff.ch/166" target="_blank" title="Dernières informations sur les grèves / majeures interruptions du trafic ferroviaire."><img src="http://fahrplan.sbb.ch/img/one/icon_arrow_right.png" alt="" style="vertical-align:top; padding-right:2px; border:none;" />Informations sur le trafic</a>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
//Pied de page
include('../include/footer.inc');
?>