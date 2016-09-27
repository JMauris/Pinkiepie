<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page affichant la liste des meilleurs randonneurs
    ***************************************************************************/
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/randonnees.php");
    include("../../include/fonctions.inc.php");
?>
<script>
    $(document).ready(function(){
         //Ajout des infobulles
         $("#infoPersonne[title]").each(function(){
             $(this).qtip();
         });
     });
</script>
<div id="main">
    <!-- Titre -->
    <h1>Meilleurs Randonneurs</h1>
    
    <?php
        //récupération de la date
        $jour = date('d');
        $mois = date('m');
    ?>
    
    <h2>Classement du 01.01 au <?php echo $jour . "." . $mois ?></h2>
    <?php
        $listeRandonneurs = top10Randonneurs();
    ?>
    
    <table width="500px">
        <tr>
            <th>Place</th>
            <th>Nom</th>
            <th>Nombre de randonnées</th>
        </tr>
        <?php
            $x = 1;
            //Création de la liste des 10 meilleurs randonneurs
            while($liste = mysql_fetch_array($listeRandonneurs)){
                //Mise en place des lignes de différentes couleurs
                if($x%2 == 0)
                    echo "<tr>";
                else
                    echo "<tr style='background-color:#F6CE61;'>";
                
                    echo "<td>$x</td>";
                    /******************* INFOBULL *******************/
                    echo "<td><a id='infoPersonne' title=\"";
                        echo "Nom: " . utf8_encode($liste[1]) . " " . utf8_encode($liste[0]) . "<br/>";
                        echo "Adresse: " . str_replace("\\", "", utf8_encode($liste[2])) . "<br />";
                        echo "Localité: $liste[3] " . utf8_encode($liste[4]) . "<br />";
                        echo "Email: $liste[5]<br />";
                        echo "Téléphone: $liste[6]<br />";
                        echo "Mobile: $liste[7]";
                    echo "\">";
                    
                    //Affichage du nom et du prénom
                    echo utf8_encode($liste[1]) . " " . utf8_encode($liste[0]) . "</a></td>";
                    
                    echo "<td>$liste[8]</td>";
                
                echo "<tr>\n";
                $x++;
            }
        ?>
    </table>
    
</div>

<?php
    //Pied de page
    include("../include/footer.inc");
?>