<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page d'accueil de la partie inscriptions, liste des prochaines
    *           randonnées par défaut, recherche d'une randonnée par son titre
    ***************************************************************************/

    //Ajout des fichiers nécessaires au bon fonctionnement du site
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/randonnees.php");
    include("../../include/fonctions.inc.php");
    
    //Création d'une nouvelle randonnée
    $randonnee = new randonnee();
?>
<script>
    $(function() {
        var dateMinRando = "";
        var titreContient = "";
        
        // Récupération des randonnées correspondant aux critères
				//MAE - Ajout login et role
        function selectRandosCriteres(){
            $.ajax({
                url: '../include/fonctionsAjax.inc.php',
                data: "dateInscr=" + dateMinRando + "&titrecontientInscr=" + titreContient+ "&login=" + $("#login").val() + "&role=" + $("#role").val(),
                async: false,
                success: function(data){
                    var text = data;

                    $("#listeRando").html(text);
                    $("#infoRando[title]").qtip();
                }
            });
        }
        
        
        //Ajout du calendrier dans la page
        $("#datedebut" ).datepicker();
        
        //Mise en place des infobulles
        $("#infoRando[title]").qtip();
        
        
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
    });
</script>
        
<div id="main">
    <div id="aide">
        <a href="../aide/gestionInscription.php">Aide</a>
    </div>
    <h1>Gestion des inscriptions</h1>
    <!-- MAE - Ajout champs cachés -->
    <input type="hidden" id="role" name="role" value="<?php echo $_SESSION['role']; ?>" />
    <input type="hidden" id="login" name="login" value="<?php echo $_SESSION['login']; ?>" />
		
    <h2>Rechercher une randonnée</h2>
    <div class="paragraphe">
        <!-- Formulaire de recherche d'une randonnée -->
        <form method="post">
						Date: <input type="text" id="datedebut" name="datedebut" /><br />
            Le titre contient: <input type="text" id="titrecontient" name="titrecontient" /><br />
        </form>
    </div>
    <!-- Affichage de la liste de toutes les randonnées -->
    <h2>Liste des randonnées</h2>
    <div class="paragraphe">
        
    </div>
    
        <?php
           //Récupération des prochaines randonnées
					 //MAE - Ajout role et login
           $randonneesDB = ProchainesRandonnees(20, $_SESSION['role'], $_SESSION['login']);
        ?>
        <!-- Affichage de la liste des randonnées -->
        <table id="listeRando">
            <tr>
                <th>Date de début</th>
                <th>Date de fin</th>
                <th>Titre</th>
                <th>Genre</th>
                <th>Voir les inscriptions</th>
            </tr>
            <?php
                //Affichage de la liste des prochaines randonnées
                $x = 0;
                while($ligne = mysql_fetch_array($randonneesDB)){
                    if($x%2 == 0)
                        echo "<tr>";
                    else
                        echo "<tr style='background-color:#F6CE61;'>";
                    
                    $dateDebut = explode('-',$ligne[2]);
                    
                    echo "<td>$dateDebut[2].$dateDebut[1].$dateDebut[0]</td>";
                    $dateFin = explode('-',$ligne[3]);
                    
                    if($dateFin[2] != '00')
                        $dateFin = $dateFin[2]. "." . $dateFin[1] . "." .$dateFin[0];
                    else
                        $dateFin = '';
                    
                    echo "<td>$dateFin</td>";
                   echo "<td width='25%'><a id='infoRando' title='";
                        //Infobulle                        
                        if($dateDebut[2] != '00')
                            echo "$dateDebut[2].$dateDebut[1].$dateDebut[0]<br />";
                        echo $dateFin . "<br />";

                         if($ligne[4] == 1)
                            $typeR = "Randonnée";
                        else
                            $typeR = "Séjour";
                        
                        echo "Type: " . $typeR . "<br />";
                        echo "Genre: " . utf8_encode($ligne[4]) . "<br />";
                        echo "Durée: " . utf8_encode($ligne[5]) . "<br />";
                        echo "Difficulté: " . utf8_encode($ligne[6]) . "<br />";
                        echo "RDV: " . utf8_encode($ligne[7]) . " à " .  utf8_encode($ligne[8]) . "<br />";
                        echo "Arrivée: " . utf8_encode($ligne[9]) . "<br />";
                        if($ligne[10] != 0){
                            echo "dénivelé pos: " . $ligne[10] . "<br />";
                            echo "dénivelé nég: " . $ligne[11];
                        }
                    echo "'>";
                    echo utf8_encode($ligne[1]) . "</a></td>";
                    echo "<td>";
                        if($ligne[4] == 1)
                            echo "Randonnée d'un jour";
                        else
                            echo "Séjour";
                    
                    echo "</td>";
                    //Lien vers le détail des inscriptions
                    echo "<td><a href='listeInscriptions.php?id=$ligne[0]'>liste des inscriptions</a></td>";
                    
                    $x += 1;
                }
            ?>
        </table>
    </div>

<?php
    //Mise en place du pied de page
    include("../include/footer.inc");
?>