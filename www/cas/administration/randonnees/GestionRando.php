<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page d'accueil de la gestion des randonnées
    ***************************************************************************/
    
    //Ajout des fichiers nécessaires au bon fonctionnement de la page
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/randonnees.php");
    include("../../include/fonctions.inc.php");
    
    //Récupération des valeurs minimum et maximum
    /*$min = $_GET['min'];
    $max = $_GET['max'];*/
    
    $min = 0;
    $max = 30;
    
    $randonnee = new randonnee();
?>
<script>
    $(document).ready(function() {
        var dateMinRando = "";
        var titreContient = "";
        var max = 30;
        
        // Récupération des randonnées correspondant aux critères
				//MAE - envoi login et role
        function selectRandosCriteres(){
            $.ajax({
                url: '../include/fonctionsAjax.inc.php',
                data: "date=" + dateMinRando + "&titrecontient=" + titreContient + "&nombre=" + max + "&login=" + $("#login").val() + "&role=" + $("#role").val(),
                success: function(data){
                    var text = data;

                    $("#listeRando").html(text);
                    $("#infoRando[title]").qtip();
                }
            });
        }
        
        //Ajout du calendrier
        $("#datedebut").datepicker();

        //Ajout des infobulles
        $("#infoRando[title]").each(function(){
            $(this).qtip();
        });
     
        //Modification de la date de début
        $("#datedebut").change(function(){
            dateMinRando = $("#datedebut").val();
            selectRandosCriteres();
        });

        //Modification du titre
        $("#titrecontient").keyup(function(){
            titreContient = $("#titrecontient").val();
            selectRandosCriteres();
        });
        
        // Modification du nombre de randonnées à afficher
        $("#maxAffichage").keyup(function(){
            max = $("#maxAffichage").val();
            selectRandosCriteres();
        });
    });
</script>
<div id="main">
    <div id="aide">
        <a href="../aide/gestionRandonnee.php">Aide</a>
    </div>
    <!-- Titre -->
    <h1>Gestion des randonnées</h1>
    
    <!-- MAE - Affiche uniquement si Admin -->
		<?php
			if($_SESSION['role'] == 'admin'){
		?>
			<!-- MISE EN PLACE DE L'AJOUT D'UN PROGRAMME -->
			<h2>Ajouter un nouveau programme</h2>
			<div class="paragraphe">
					<p>Pour ajouter un nouveau programme dans la base de données, veuillez
							séléctionner un fichier excel:</p>
					<!-- Formulaire pour l'ajout d'une randonnée -->
					<form action="AjoutRando.php" method="post" enctype="multipart/form-data">
							<input type="file" name="programmeRando" />
							<input type="submit" name="envoi" value="Ajouter le programme" />
					</form>
			</div>
			
			
			<!-- MISE EN PLACE DE L'AJOUT DES PROPOSITIONS -->
			<h2>Ajouter des propositions</h2>
			<div class="paragraphe">
					<p>Pour ajouter des propositions dans la base de données, veuillez
							séléctionner un fichier excel:</p>
					<!-- Formulaire pour l'ajout d'une proposition -->
					<form action="AjoutPropositions.php" method="post" enctype="multipart/form-data">
							<input type="file" name="propositionsRando" />
							<input type="submit" name="envoiPropositions" value="Ajouter des propositions de randonnées" />
					</form>
			</div>
    <?php } ?>
		
    <!-- LISTE DES RANDONNÉES EN FONCTION DES CRITÈRES DE RECHERCHE -->
    <h2>Liste des randonnées</h2>
    <div class="paragraphe">
        <h3>Recherche</h3>
        <!-- Formulaire de recherche -->
        <form method="post">
						Date: <input type="text" id="datedebut" name="datedebut" /><br />
            Le titre contient: <input type="text" id="titrecontient" name="titrecontient" /><br />
            
        </form>
        <h3>Randonnées</h3>
        <!--<form method="get">-->
            Affichage de
            <input type="text" size="3" id="maxAffichage" name="max" value="<?php echo $max; ?>" />
            randonnées
            
            <!-- MAE - Ajout champs cachés -->
            <input type="hidden" id="role" name="role" value="<?php echo $_SESSION['role']; ?>" />
            <input type="hidden" id="login" name="login" value="<?php echo $_SESSION['login']; ?>" />
            <?php
							//MAE - Ajout rôle et login
              $randonneesDB = $randonnee->listeRandonnées($min, $max, 'fr', $_SESSION['role'], $_SESSION['login']);
            ?>
        <!-- Liste de toutes les randonnées -->
        <table id="listeRando">
            <tr>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Titre</th>
                <th>Genre</th>
                <th>Type</th>
                <th>Modifier</th>
                <th>A lieu?</th>
            </tr>
            <?php
                //Affichage du tableau pour la liste des randonnées
                $x = 0;
                while($ligne = mysql_fetch_array($randonneesDB)){
                    //Mise en place des lignes de différentes couleurs
                    if($x%2 == 0)
                        echo "<tr>";
                    else
                        echo "<tr style='background-color:#F6CE61;'>";
                    
                    //Dates
                    $dateDebut = explode('-',$ligne[1]);
                    $dateFin = explode('-',$ligne[2]);
                    
                    //Affichage de la date de début
                    if($dateDebut[2] == '00')
                        echo "<td></td>";
                    else
                        echo "<td>$dateDebut[2].$dateDebut[1].$dateDebut[0]</td>";
                    
                    //Affichage de la date de fin
                    if($dateFin[2] == '00')
                        echo "<td></td>";
                    else
                        echo "<td>$dateFin[2].$dateFin[1].$dateFin[0]</td>";
                    echo "<td width='25%'><a id='infoRando' title=\"";
                        /*************  INFOBULLE ****************/
                        if($dateDebut[2] != '00')
                            echo "$dateDebut[2].$dateDebut[1].$dateDebut[0]<br />";
                        if($dateFin[2] != '00')
                            echo "$dateFin[2].$dateFin[1].$dateFin[0]<br />";
                        
                        echo "Genre: " . utf8_encode($ligne[4]) . "<br />";
                        echo "Type: " . utf8_encode($ligne[6]) . "<br />";
                        echo "Durée: " . utf8_encode($ligne[7]) . "<br />";
                        echo "Difficulté: " . utf8_encode($ligne[8]) . "<br />";
                        echo "RDV: " . utf8_encode($ligne[9]) . " à " .  utf8_encode($ligne[10]) . "<br />";
                        echo "Arrivée: " . utf8_encode($ligne[11]) . "<br />";
                        if($ligne[12] != 0){
                            echo "dénivelé pos: " . $ligne[12] . "<br />";
                            echo "dénivelé nég: " . $ligne[13] . "<br />";
                        }
                        if($ligne[14] != '')
                            echo "Chef(fe) de course: " . utf8_encode($ligne[14]) . "<br />";
                        if($ligne[15] != '')
                            echo "Assistant(E): " . utf8_encode($ligne[15]) . "<br />";
                        if($ligne[16] != 0)
                            echo "Prix: " . $ligne[16] . "<br />";
                        if($ligne[17] != 0)
                            echo "Insciprtion Max: " . $ligne[17] . "<br />";
                    echo "\">";
                    //Affichage du titre
                    echo utf8_encode($ligne[3]) . "</a></td>";
                    //Affichage du genre
                    echo "<td>" . utf8_encode($ligne[4]) . "</td>";
                    //Affichage du type
                    echo "<td>" . utf8_encode($ligne[6]) . "</td>";
                    //Modification de la randonnée
                    echo "<td><a href='ModifRando.php?id=$ligne[0]'><img height='30' src='../../pictures/edit.png' /></a></td>";
                    
                    //Est active?
                    $checkbox = "<td><input type='checkbox' name='rando' disabled value='$ligne[0]'"; 

                    if($ligne[5] == 1)
                        $checkbox .= "checked='checked'";
                    
                    $checkbox .= "/></td>";
                    
                    echo $checkbox;
                    echo "</tr>";
                    $x += 1;
                }
            ?>
        </table>
    </div>
</div>

<?php
//Pied de page
include("../include/footer.inc");
?>