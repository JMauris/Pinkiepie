<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page permettant de lister toutes les inscriptions pour une
    *           randonnée précise. Lien vers la page d'ajout d'une nouvelle
    *           inscription
    ***************************************************************************/

    //Ajout des fichiers nécessaires au bon fonctionnement du site
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/randonnees.php");
    include("../../BusinessObject/inscription.php");
    include("../../BusinessObject/personne.php");
    include("../../include/fonctions.inc.php");
    
    //Création d'une nouvelle randonnées
    //recherche des informations sur la rando
    $randonnee = new randonnee();
    $randonnee->id = $_GET['id'];
    $randonnee->getInfoRandonnee();
    
    //Création d'une nouvelle inscription
    $inscription = new inscription();
    $inscription->idRandonnee = $_GET['id'];
    
    //Si la variable 'personne' existe
    if(isset($_GET['personne'])){
        //Récupération de la variable et de la date
        $inscription->idPersonne = $_GET['personne'];
        $inscription->date = explode('-', $_GET['date']);
        
        //Mise en palce de la date d'inscription
        $inscription->date =$inscription->date[0] . "-" . $inscription->date[1] . "-" . $inscription->date[2];
        
        //Récupération de l'heure et mise au bon format
        $heure = $_GET['heure'];
        $heure = explode(":", $heure);
        $heure[0] = $heure[0] -1;
        $inscription->heure = $heure[0] . ":" . $heure[1] . ":" . $heure[2];
        
        //Modification de la priorité dans la liste d'attente
        $requete = $inscription->modifPriorite();
    }
    if(isset($_GET['forcer'])){
        $id = explode(".", $_GET['forcer']);
        $inscription->idPersonne = $id[0];
        $inscription->idRandonnee = $id[1];
        
        $inscription->forcerInscription();
    }
?>
<script>
    $(document).ready(function(){
        //Mise en forme de l'infobulle
        $("#infoPersonne[title]").qtip();
        
        //Ajout d'une remarque ou d'un inscription'
        $(".remarqueInscr").change(function(){
           var idRemarque = $(this).attr('id');
           idRemarque = idRemarque.split("_");
          
           //Modification de la remarque ou de l'assurance pour l'inscription
           $.ajax({
               url: '../include/fonctionsAjax.inc.php',
               async: false,
               data: "idpersonne=" + idRemarque[0] + "&idrandonnee=" + idRemarque[1] + "&remarque=" + $(this).val(),
               success: function(data){
                   alert("Remarque enregistrée");
               }
            });
        });
        
        $(".forcerInscr").click(function(){
            alert($(this).attr(id));
        });
    });
</script>      
<div id="main">
    <div id="aide">
        <a href="../aide/listeInscription.php">Aide</a>
    </div>
    <h1>Gestion des inscriptions</h1>
    
    <h2>Inscriptions pour <?php echo utf8_encode($randonnee->titre); ?></h2>
    <!-- Lien pour l'impression du rapport de course -->
    <div class="paragraphe">
        <p>
            <a href="ImpressionRapportChefCourse.php?id=<?PHP echo $randonnee->id; ?>">
                Générer le rapport de la course:
                <img src="../../pictures/icons/notes.png" height="40px"/>
            </a>
        </p>
        
        <?php
            //Si le lien du fichier est en paramètre, afficher le lien
            if(isset($_GET['file'])){
                echo "<a href='" . $_GET['file'] . "'>Récupérer le fichier</a>";
            }
        ?>
    </div>
    <!-- Lien pour une nouvelle inscription -->
    <h4>Ajouter une inscription</h4>
    <p>Nouvelle inscription: <a href="AjouterInscription.php?rando=<?php echo $randonnee->id; ?>"><img src="../../pictures/icons/add.png" height="50px"/></a></p>
    
    <!-- Liste des personnes inscrites -->
    <h3>Inscrits</h3>
    <?php
               $inscriptions = $inscription->inscriptionsPourRando();
            ?>
        <table id="listeRando">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone portable</th>
                <th>Abonnement de transports<br/> publics</th>
                <th>Membre</th>
                <th>Remarque</th>
                <th>Supprimer</th>
            </tr>
            <?php
                //Chef de course
                echo "<tr>";
                    echo "<td colspan='2'>" . utf8_encode($randonnee->chefCourse) . "</td>";
                    echo "<td>Chef de course</td>";
                echo "</tr>";
                $x = 1;
                
                //Assistant
                if($randonnee->assistant != '')
                echo "<tr style='background-color:#F6CE61;'>";
                    echo "<td colspan='2'>". utf8_encode($randonnee->assistant) . "</td>";
                    echo "<td>Assistant(e)</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td></td>";
                echo "</tr>";
                $x = $x + 1;
                
                while($ligne = mysql_fetch_array($inscriptions)){
                    $prix = 0;
                    if($x%2 == 0)
                        echo "<tr>";
                    else
                        echo "<tr style='background-color:#F6CE61;'>";
                    
                    echo "<td><a id='infoPersonne' title=\"";
                        //Mise en place de l'infobulle
                        $personne = new personne();
                        $personne->getPersonne($ligne[1], $ligne[2]);
                        echo utf8_encode($personne->nom) . " " . utf8_encode($personne->prenom) . "<br />";
                        echo utf8_encode($personne->adresse) . "<br />";
                        echo utf8_encode($personne->npa) . " " . utf8_encode($personne->localite) . "<br />";
                        echo "tél: " . $personne->telephone . "<br />";
                        echo "natel: " . $personne->portable . "<br />";
                        echo "email: " . $personne->email . "<br />";
                        if($personne->numMembre != '')
                            echo "Numéro Membre: " . $personne->numMembre . "<br />";
                        
                        echo "langue: ";
                        if($personne->langue == 'fr'){
                            echo "Français";
                        }
                        else{
                            echo "Allemand";
                        }
                    echo "\">" . utf8_encode($ligne[1]) . "</a></td>";
                    echo "<td>" . utf8_encode($ligne[2]) . "</td>";
                    echo "<td>" . $personne->portable . "</td>";
                    
                    echo "<td>";
                        if($ligne[5] == 1)
                            echo "Aucun";
                        elseif($ligne[5] == 2) {
                            echo "Abonnement Général";
                        }
                        else{
                            echo "Demi-tarif";
                        }
                    echo "</td>";
                    
                    echo "<td>";
                        if($ligne[4] != 0)
                            echo "Oui";
                        else {
                            echo "Non";
                        }
                    echo "</td>";
                    //Récupération de l'assurance ou de la remarque
                    $inscription = new inscription();
                    $inscription->idPersonne = $personne->id;
                    $inscription->idRandonnee = $randonnee->id;
                    $remarque = $inscription->getRemarque()
                    ?>
                    <td><input type="text" class="remarqueInscr" id="<?php echo $personne->id . "_" . $randonnee->id ?>" value="<?php echo utf8_encode($remarque) ?>" /></td>
                    <?php
                    
                    echo "<td><a href='SuppressionInscription.php?id=$ligne[0].$randonnee->id' onclick=\"return confirm('Voulez-vous vraiment supprimer cette inscription?')\"><img height='30' src='../../pictures/delete.png'' /></a></td>";
                    
                    $x += 1;
                    echo "</tr>";
                }
            ?>
        </table>
        <?php
            $nbPlaceslibres = $inscription->nombrePlacesLibres();
        ?>
        <!-- Affichage du nombre de places libres -->
        <p>Nombre de places Restantes: <strong> <?php echo $nbPlaceslibres; ?></strong></p>
        
        <!-- Récupration de la liste d'attente -->
        <h3>Liste d'attente</h3>
        <!-- tableau liste d'attente -->
        <table id="listeattente">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Localité</th>
                <th>Ordre de priorité</th>
                <th>Supprimer</th>
                <th>Forcer l'inscription</th>
            </tr>
            <?php
                $listeAttente = $inscription->listeAttente();
                
                //Compteur pour l'affichage des différentes couleurs de ligne
                $x = 0;
                $text = "";
                while($ligne = mysql_fetch_array($listeAttente)){
                    if($x%2 == 0)
                        $text .= "<tr>";
                    else
                        $text .= "<tr style='background-color:#F6CE61;'>";
                        
                        echo "<td>" . utf8_encode($ligne[0]) . "</td>";
                        echo "<td>" . utf8_encode($ligne[1]) . "</td>";
                        echo "<td>" . utf8_encode($ligne[2]) . "</td>";
                        echo "<td>";
                        if($x == 0){
                            $date = $ligne[3];
                            $heure = $ligne[4];
                        }
                        else{
                            //Affichage du lien pour modifier la priorité
                            echo "<a href='listeInscriptions.php?id=$randonnee->id&date=$date&heure=$heure&personne=$ligne[5]'>
                                    <img src='../../pictures/icons/priorite.png' height='30px' />
                                    </a>";
                        }
                        
                        echo "</td>";
                        //Lien pour supprimer l'inscription
                        echo "<td><a href='SuppressionInscription.php?id=$ligne[5].$randonnee->id' onclick=\"return confirm('Voulez-vous vraiment supprimer cette inscription?')\"><img height='30' src='../../pictures/delete.png'' /></a></td>";
                        echo "<td><a href='listeInscriptions.php?forcer=$ligne[5].$randonnee->id' id='$ligne[0].$randonnee->id' class='forcerInscr'>forcer l'inscription</a></td>";
                    echo "</tr>";
                    
                    $x++;
                }


            ?>
            
        </table>
    </div>

<?php
    include("../include/footer.inc");
?>