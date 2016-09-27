<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page d'accueil de la partie membre de la console d'administration
    ***************************************************************************/

    //Ajout des fichiers nécessaires au bon fonctionnement de la page
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/personne.php");
    include("../../include/fonctions.inc.php");
    
    //Récupération des paramètres
/*    $min = $_GET['min'];
    $max = $_GET['max'];*/
    
    //Création d'une personne
    $personne = new personne();
?>

<script>
    $(document).ready(function(){
        //Recherche par le nom
        $("#nom").keyup(function(){                    
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               data: "statut=" + $("#statut").val() + "&personne=" + $("#nom").val() + "." + $("#prenom").val(),
               async: false,
               success: function(data){
                   var text = data;

                   $("#listePersonnes").html(text);
                   $("#infoPersonne[title]").qtip();
               }
            });
        });
        
        //Recherche par le prénom
        $("#prenom").keyup(function(){                    
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               data: "statut=" + $("#statut").val() + "&personne=" + $("#nom").val() + "." + $("#prenom").val(),
               async: false,
               success: function(data){
                   var text = data;

                   $("#listePersonnes").html(text);
                   $("#infoPersonne[title]").qtip();
               }
            });
        });
        
        //Recherche par le statut
         $("#statut").change(function(){ 
            $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               data: "statut=" + $("#statut").val() + "&personne=" + $("#nom").val() + "." + $("#prenom").val(),
               async: false,
               success: function(data){
                   var text = data;

                   $("#listePersonnes").html(text);
                   $("#infoPersonne[title]").qtip();
               }
            });
         });
         
         $("#infoPersonne[title]").qtip();
    });

</script>
        
<div id="main">
    <div id="aide">
        <a href="../aide/gestionPersonne.php">Aide</a>
    </div>
    <h1>Gestion des membres</h1>
    
    <!-- Lien pour la mise à jour des membres -->
    <h2>Mettre à jour la liste des membres</h2>
    <div class="paragraphe">
        <p>Pour mettre à jour les membres sur le serveur, veuillez
            séléctionner un fichier excel:</p>

        <!-- Formulaire pour l'ajout du fichier -->
        <form action="AjoutMembre.php" method="post" enctype="multipart/form-data">
            <input type="file" name="listeMembres" />
            <input type="submit" name="envoi" value="Mettre à jour les membres" />
        </form>

    </div>
    <!-- Liste de toutes les personnes -->
    <h1>Liste de toutes les personnes</h1>
    <h2>Recherche</h2>
    
    <!-- Formulaire de recherche -->
    <form>
        Nom: <input type="text" id="nom" name="nom"/>
        Prénom: <input type="text" id="prenom" name="prenom"/>
        Statut: 
        <select name="statut" id="statut">
            <option value="t">Tous</option>
            <option value="m">Membres</option>
            <option value="p">Participants</option>
        </select>    
    </form>
    
    <h2>Liste</h2>
    <!-- Liste des personnes -->
    <table id="listePersonnes" width="90%">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Statut</th>
            <th>Abonnement de transports<br /> publics</th>
            <th>Localité</th>
            <th>Téléphone</th>
            <th>Modification</th>
            <th>inscriptions</th>
        </tr>
    
        <?php
            $personnes = $personne->getToutesPersonnes();
            
            $x = 0;
            while($ligne = mysql_fetch_array($personnes)){
                if($x%2 == 0)
                    echo "<tr>";
                else
                    echo "<tr style='background-color:#F6CE61;'>";
                 
                    //Affichage des données
                    echo "<td><a id='infoPersonne' title=\"";
                        //Mise en place de l'infobulle
                        $personne = new personne();
                        $personne->getPersonne($ligne[1], $ligne[2]);
                        echo utf8_encode($personne->nom) . " " . utf8_encode($personne->prenom) . "<br />";
                        echo str_replace("\\", "", utf8_encode($personne->adresse)) . "<br />";
                        echo utf8_encode($personne->npa) . " " . utf8_encode($personne->localite) . "<br />";
                        echo "tél: " . $personne->telephone . "<br />";
                        echo "natel: " . $personne->portable . "<br />";
                        echo "email: " . $personne->email . "<br />";
                        if($personne->numMembre != '')
                            echo "Numéro Membre: " . $personne->numMembre  . "<br />";
                        echo "langue: ";
                        if($personne->langue == 'fr'){
                            echo "Français";
                        }
                        else{
                            echo "Allemand";
                        }
                    echo "\">" . utf8_encode($ligne[1]) . "</a></td>";
                    
                    //prénom
                    echo "<td width='5%'>".  utf8_encode($ligne[2])."</td>";
                    echo "<td>";
                    
                    //Affichage du statut
                    if($ligne[9] != 0){
                        echo "Non-membre";
                    }
                    elseif($ligne[8] == 0 || $ligne[8] == ''){
                        echo "Participant";
                    }
                    else{
                        echo "Membre";
                    }
                    
                    echo "</td>";
                    //Abo
                    echo "<td>".  utf8_encode($ligne[17])."</td>";
                    //localité
                    echo "<td>".  utf8_encode($ligne[12])."</td>";
                    //Téléphone
                    echo "<td>".  utf8_encode($ligne[6])."</td>";
                    echo "<td>";
                    
                    //Lien pour la modification
                    if(($ligne[8] == 0 || $ligne[8] == '') && $ligne[9] == 0){
                        echo "<a href='ModifParticipant.php?id=$ligne[0]'><img src='../../pictures/edit.png' height='20px' /></a>";
                    }
                    else{
                        echo "<a href='ModifParticipant.php?id=$ligne[0]&membre=true'><img src='../../pictures/edit.png' height='20px' /></a>";
                    }
                    echo "</td>";
                    echo "<td><a href='inscriptionsPersonne.php?id=$ligne[0]'><img src='../../pictures/icons/mesRandos.png' height='20px' /></td>";
                echo "</tr>";
                
                $x += 1;
            }

        ?>
        
    </table>
    
</div>

<?php
    //Pied de page
    include("../include/footer.inc");
?>