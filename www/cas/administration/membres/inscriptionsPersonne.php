<?php
session_start();
    //Ajout des fichiers nécessaires au bon fonctionnement de la page
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/personne.php");
    include("../../BusinessObject/randonnees.php");
    include("../../include/fonctions.inc.php");
    
     //Création d'une personne
    $personne = new personne();
    
    //Récupération de l'identifiant
    $personne->id = $_GET['id'];
    $personne->getDetailPersonne();
    
    //Récupération des inscriptions pour la personne
    $inscriptions = listeRandonneesPourPersonne($personne->id);
?>
<script>
    $(document).ready(function(){
        $("#infoRando[title]").qtip();
    })
</script>
<div id="main">
    <!-- Titre -->
    <h1>Inscriptions pour: <?php echo utf8_encode($personne->prenom) . " " . utf8_encode($personne->nom); ?></h1>
    <!-- Liste des randonnées auxquelles la personne est inscrite -->
    <table>
       <tr>
           <th>Date</th>
           <th>Titre</th>
       </tr>
       
        <?php
            $aVenir = $inscriptions[0];

            //Création du tableau en parcourant toutes les randonnées
            $x = 0;
            while($ligne = mysql_fetch_array($aVenir)){
                if($x%2 == 0)
                    echo "<tr>";
                else
                    echo "<tr style='background-color:#F6CE2B;'>";
                
                $date = $ligne[1];
                $date = explode("-", $date);
                echo "<td>$date[2].$date[1].$date[0]</td>"; 
                echo "<td>";
                $randonnee = new randonnee();
                $randonnee->id = $ligne[2];
                $randonnee->getInfoRandonnee();
                $x++;
                
                //Création de l'infobulle
                echo "<a id='infoRando' title='";
                        //Infobulle  
                        $dateDebut = explode("-", $randonnee->date);
                        if($dateDebut[2] != '00')
                            echo "$dateDebut[2].$dateDebut[1].$dateDebut[0]<br />";
                        
                        $dateFin = explode("-", $randonnee->datefin);
                        if($dateFin[2] != '00')
                            echo "$dateFin[2].$dateFin[1].$dateFin[0]<br />";

                         if($randonnee->typeTour == 1)
                            $typeR = "Randonnée";
                        else
                            $typeR = "Séjour";
                        
                        echo "Type: " . $typeR . "<br />";
                        echo "Durée: " . $randonnee->duree . "<br />";
                        echo "Difficulté: " . $randonnee->difficulte . "<br />";
                        echo "RDV: " . utf8_encode($randonnee->rdv) . " à " . utf8_encode($randonnee->lieuDepart) . "<br />";
                        echo "Arrivée: " . $randonnee->lieuArrivee . "<br />";
                        if($randonnee->montee != 0){
                            echo "dénivelé pos: " . $randonnee->montee . "<br />";
                            echo "dénivelé nég: " . $randonnee->descente;
                        }
                    echo "'>";
                
                echo  utf8_encode($ligne[0]) . "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</div>

<?php
    include("../include/footer.inc");
?>