<?php
session_start();
/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Fichier permettant l'envoi de sms
* 
* REMARQUE: L'envoi de SMS a été désactivé dans le cadre de la simulation
*           Toutes les variables et fonctions nécessaires à cette action
*           ont donc été supprimées. Joëlle Galloni, 26.09.2012
***************************************************************************/

//Ajout des fichiers nécessaires au bon fonctionnement du site
include("../include/toppage.inc");
include("../include/header.inc");
include("../../BusinessObject/randonnees.php");
include("../../BusinessObject/inscription.php");
include("../../include/fonctions.inc.php");

//Ajout d'une nouvelle randonnée
$randonnee = new randonnee();
$inscription = new inscription();

//Messages à envoyer
if(isset($_POST['messageFR'])){
    $msgFR = $_POST['messageFR'];
    $msgDE = $_POST['messageDE'];

    //Encodage des données
    $msgFR = urlencode($msgFR);
    $msgDE = urlencode($msgDE);

    $randonnee->id = $_POST['randonnee'];

    //Récupération de la liste de tous les inscrits à la rando
    $listeInscrits = $randonnee->listeInscrits();
    
    $nbMessages = 0;
        
    //Parcours toutes les personnes à qui il faut envoyer un message
    while($ligne = mysql_fetch_array($listeInscrits)){
        if($ligne[2] == 'fr')
            $msg = $msgFR;
        else
            $msg = $msgDE;

        //Si le numéro de natel est précisé
        if($ligne[1] != '')
            $nbMessages = $nbMessages + 1;
        //Si la personne n'a pas de téléphone portable
        else
            //Affichange du détail de la personne à contacter par téléphone
            echo "<script>alert('La personne suivante n\'a pas pu être contactée : " . 
                utf8_encode($ligne[5]) . " " . utf8_encode($ligne[4]) . " au " . utf8_encode($ligne[3]) . "');</script>";

    }

    //Log du message
    logMessage($msgFR, $msgDE, $nbMessages, $randonnee->id);
}
?>
<script>
    $(document).ready(function(){ 
        //Modification du message en français
        $("#messageFR").keyup(function(){
            $text = $("#messageFR").val();
            
            $("#infoMessageFR").html($text.length + "/160");
        });
        
        //Modification du message en Allemand
        $("#messageDE").keyup(function(){
            $text = $("#messageDE").val();
            
            $("#infoMessageDE").html($text.length + "/160");
        });
    });
</script>
        
<div id="main">
    <div id="aide">
        <a href="../aide/zoneSMS.php">Aide</a>
    </div>
    <h1>Contacter les participants</h1>
    <h2>Crédits restants</h2>
    <span id="label">Messages restants:</span>
    <span id="champ">109</span>
    <form id="sendInfo" method="post">
        <h2>Sélectionner la randonnée</h2>
        <?php
            //Récupération de la liste des prochaines randonnées
						//MAE - Ajout login et rôle
            $listeRandonnees = ProchainesRandonnees(10, $_SESSION['role'], $_SESSION['login']);
            
            //Création d'une liste déroulante avec le titre et l'id comme valeur  
        ?>
        <select name="randonnee" id="randonnee">
        <?php
            while($ligne = mysql_fetch_array($listeRandonnees)){
                //Récupération de la date de la randonnée
                $date = explode("-", $ligne[2]);
                $date = $date[2] . "." . $date[1];
                
                //récupération du nombre 'inscrits
                $inscription->idRandonnee = $ligne[0];
                $nbInscrits = $inscription->nbInscrits();
                
                echo "<option value='$ligne[0]'>" . $date . " - " . utf8_encode($ligne[1]) . " ($nbInscrits inscrits)</option>";
            }
        ?>
        </select>
        <h2>Message</h2>
        <span id="labelTextarea">Français:</span>
        <textarea name="messageFR" id ="messageFR" cols="45" rows="5" maxlength="160"></textarea>

        <span id="labelTextarea">Allemand:</span>
        <textarea name="messageDE" id ="messageDE" cols="45" rows="5" maxlength="160"></textarea>
        
        <div id="infoMessageFR">
        </div>
        
        <div id="infoMessageDE">
        </div>
        <br/>
        <input type="submit" value="Envoyer les messages" name="envoiMessage" />
    </form>
		
    <!-- MAE - Pour Admin -->
		<?php if($_SESSION['role'] == 'admin'){ ?>
			<h3>10 derniers messages envoyés</h3>
			<table>
					<tr>
							<th>Date</th>
							<th>Randonnée</th>
							<th>Nombre de messages envoyés</th>
					</tr>
					
					<?php
							//Récupération des 10 dernières entrées dans le log
							$derniersLogs = recupereLogs();
					
							//Parcours les messages logués et affiche les informations
							while($ligne = mysql_fetch_array($derniersLogs)){
									echo "<tr>";
											echo "<td>";
									
													//Récupération de la date et mise au bon format
													$date = explode("-",$ligne[0]);
													$date = $date[2] . "." . $date[1] . "." . $date[0];
													echo $date;
											echo "</td>";
											echo "<td>";
													echo utf8_encode($ligne[1]);
											echo "</td>";
											echo "<td>$ligne[2]</td>";
									echo "</tr>";
							}
					?>
			</table>
		<?php } ?>
</div>

<?php
//Pied de page
include("../include/footer.inc");
?>