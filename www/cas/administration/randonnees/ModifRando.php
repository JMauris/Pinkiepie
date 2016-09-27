<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Fichier permetant la modification d'une randonnée existante
    ***************************************************************************/
    
    //Ajout des fichiers nécessaires au bon fonctionnement du site
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/randonnees.php");
    include("../../include/fonctions.inc.php");
    
    //Création d'une nouvelle randonnée
    $randonnee = new randonnee();
    
    //Si affichage de la page
    if(isset($_GET['id']))
        $randonnee->id = $_GET['id'];
    //Si affichage suite à l'envoi du formulaire
    else
        $randonnee->id = $_POST['id'];
    
    //Si le formulaire a été soumis
    if(isset($_POST['id'])){
        //mise à jour des données dans la base de données
        $randonnee->titre = utf8_decode($_POST['titre']);
        
        //Récupération et traitement de la date de début
        $dateDebut = explode(".", $_POST['date']);
        $dateDebut = $dateDebut[2] . "-" . $dateDebut[1] . "-" . $dateDebut[0];
        $randonnee->date = $dateDebut;
        
        //Récupération et traitement de la date de fin
        $dateFin = $_POST['dateFin'];
        if($dateFin == ''){
            $dateFin = '0000-00-00';
        }
        else{
            $dateFin = explode(".", $dateFin);
            $dateFin = $dateFin[2] . "-" . $dateFin[1] . "-" . $dateFin[0];
        }
        $randonnee->datefin = $dateFin;
        $randonnee->difficulte = $_POST['difficulte'];
        $randonnee->montee = $_POST['montee'];
        $randonnee->descente = $_POST['descente'];
        $randonnee->departTransport = utf8_decode($_POST['departTransport']);
        $randonnee->arriveeTransport = utf8_decode($_POST['arriveeTransport']);
        $randonnee->duree = $_POST['duree'];
        $randonnee->genre = $_POST['genreTour'];
        $randonnee->typeTour = $_POST['typeTour'];
        $randonnee->heureArrivee = $_POST['heureArrivee'];
        $randonnee->heureDepart = $_POST['heureDepart'];
        $randonnee->info_de = utf8_decode($_POST['info_de']);
        $randonnee->info_fr = utf8_decode($_POST['info_fr']);
        $randonnee->prixMax = $_POST['prixMax'];
        $randonnee->prixMin = $_POST['prixMin'];
        $randonnee->inscriptionMax = $_POST['inscriptionMax'];
        $randonnee->lieuArrivee = utf8_decode($_POST['lieuArrivee']);
        $randonnee->lieuDepart = utf8_decode($_POST['lieuDepart']);
        $randonnee->status = $_POST['status'];
        $randonnee->carte = $_POST['carte'];
        $randonnee->codeprogramme = $_POST['codeprogramme'];
        $randonnee->rdv = utf8_decode($_POST['lieuRDV']);
        
        if($randonnee->typeTour != 6){
            //Enregistrement des modifications
            $randonnee->modificationTour();
        }
        else{
            //Enregistrement des modifications
            $randonnee->modificationProposition();
        }
        
        //Affichage d'une message de confirmation
        echo "<script>alert('La modification a été effectuée avec succès');</script>";
        
        //redirection vers la page des randonnées
        echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=GestionRando.php?min=0&max=30' />";
    }
    else{
        //Récupération des randonnées
        $randonnee->getInfoRandonnee();
    }
    
    
?>
<!-- Contrôle desactivé suite à la demande du client -->
<script>
    
    $(document).ready(function() {
        setOblig();
//        $("#typeTour").change(function(){            
//            setOblig();
//        });
//        
//        //Contrôle que tous les champs du formulaires soient bien remplis
//        $('form').submit(function () {
//            
//            if($("#titre").val() == ''){
//
//                $("#erreur").html("Veuillez indiquer le titre de la randonnée");
//                return false;
//            }
//            
//            if($("#difficulte").val() == ''){
//
//                $("#erreur").html("Veuillez indiquer la difficulté de la randonnée");
//                return false;
//            }
//            
//            if($("#duree").val() == ''){
//
//                $("#erreur").html("Veuillez indiquer la durée de la randonnée");
//                return false;
//            }
//            
//            if($("#lieuDepart").val() == ''){
//
//                $("#erreur").html("Veuillez indiquer le lieu de départ de la randonnée");
//                return false;
//            }
//            
//            if($("#typeTour").val() == 6){
//                if($("#info_fr").val() == '' || $("#info_de").val() == ''){
//
//                    $("#erreur").html("Veuillez donner une description de la randonnée");
//                    return false;
//                }
//                
//                if($("#codepgrogramme").val() == ''){
//
//                    $("#erreur").html("Veuillez indiquer le numéro de la randonnée dans le champ 'codeprogramme'");
//                    return false;
//                }
//            }
//            else{
//                if($("#dateDebut").val() == ''){
//
//                    $("#erreur").html("Veuillez préciser la date de début de la randonnée");
//                    return false;
//                }
//                
//                if($("#dateFin").val() != '' || $("#dateFin").val() != '0000-00-00'){
//
//                   var startDate = new Date($('#dateDebut').val());
//                   var endDate = new Date($('#dateFin').val());
//
//                   if (startDate >= endDate){
//                       $("#erreur").html("La date de début doit être plus petite que la date de fin");
//                   }
//                }
//                
//                if($("#montee").val() == '' || $("#descente").val() == ''){
//
//                    $("#erreur").html("Veuillez indiquer le dénivelé de la randonnée");
//                    return false;
//                }
//                
//                if($("#heureDepart").val() == '' || $("#heureDepart").val() == '00:00:00'){
//
//                    $("#erreur").html("Veuillez indiquer l'heure de départ de la randonnée");
//                    return false;
//                }
//                
//                 if($("#heureArrivee").val() == '' || $("#heureArrivee").val() == '00:00:00'){
//
//                    $("#erreur").html("Veuillez indiquer l'heure d'arrivée de la randonnée");
//                    return false;
//                }
//                
//                if($("#prixMin").val() == ''){
//
//                    $("#erreur").html("Veuillez indiquer le prix de la randonnée");
//                    return false;
//                }
//                
//                if($("#prixMax").val() != ''){
//                    
//                    if($("#prixMax").val() <= $("#prixMin").val() && $("#prixMax").val() != 0){
//                        $("#erreur").html("Le prix maximum doit être plus élevé que le prix minimum");
//                        return false;
//                    }
//                }
//                
//                if($("#prixMax").val() == ''){
//                    $("#erreur").html("S'il n'y a pas de prix Maximum, veuillez inscrire 0");
//                        return false;
//                }
//                
//                if($("#lieuDepart").val() == ''){
//                    $("#erreur").html("Veuillez indiquer le lieu de départ de la randonnée");
//                        return false;
//                }
//                
//                if($("#departTransport").val() == ''){
//                    $("#erreur").html("Veuillez indiquer le lieu de départ du transport pour la randonnée");
//                        return false;
//                }
//                
//                if($("#arriveeTransport").val() == ''){
//                    $("#erreur").html("Veuillez indiquer le lieu d'arrivée du transport pour la randonnée");
//                        return false;
//                }
//                
//                if($("#lieuRDV").val() == ''){
//                    $("#erreur").html("Veuillez indiquer le lieu de rendez-vous pour la randonnée");
//                        return false;
//                }
//            };            
//        });
    });
    
    function setOblig(){
        if($("#typeTour").val() == 6){
//            $(".randoOblig").html("");
//            $(".propo").html("*");
            $("#infoCode").html("Pour une proposition de randonnée, veuillez indiquer le numéro de la proposition dans le code de la randonée");
            $("#infoCarte").html("Pour une proposition de randonnée, veuillez indiquer la carte sur laquelle on peut trouver la proposition");
            
        }
        else{
//            $(".propo").html("");
//            $(".randoOblig").html("*");
            $("#infoCode").html("");
            $("#infoCarte").html("Pour une randonnée, veuillez indiquer le lien vers le fichier KML");
        }
    }
    
    function suppressionRando(id){
    //Message de confirmation pour la suppression du participant
    if(confirm("Voulez-vous vraiment supprimer cette randonnée?")){
        document.location = 'SupprimerRando.php?id=' + id;
    }
}
</script>
        
<div id="main">
    <h1>Modification d'une randonnée</h1>
    
    <form method="post" action="ModifRando.php">
        <input type="hidden" name="id" value="<?php echo $randonnee->id; ?>"/>
        
        <span class="label">Randonnée <span class="propo"></span><span class="randoOblig"></span>:</span>
        <span class="champ"><input type="text" name="titre" id="titre" size="103" value="<?PHP echo utf8_encode($randonnee->titre); ?>" /><br /></span>
        
        <?php
            //Format de la date de début
            $dateDebut = explode("-", $randonnee->date);
            
        ?>
        <span class="label">Date de début <span class="randoOblig"></span>:</span>
        <span class="champ"><input type="text" name="date" id="dateDebut" value="<?PHP echo $dateDebut[2] . "." . $dateDebut[1] . "." . $dateDebut[0]; ?>" /></span>
        
        <?php
            //Format de la date de fin
            $dateFin = explode("-", $randonnee->datefin);
            if($dateFin[2] == '00'){
                $dateFin = '';
            }
            else{
                $dateFin = $dateFin[2] . "." . $dateFin[1] . "." . $dateFin[0];
            }
        ?>
        <span class="label_2">Date de fin :</span>
        <span class="champ_2"><input type="text" name="dateFin" id="dateFin" value="<?php echo $dateFin; ?>" /><br /></span>
        
        <span class="label">difficulté <span class="propo"></span><span class="randoOblig"></span>:</span>
        <span class="champ"><input name="difficulte" id="difficulte" type="text" value="<?php 
            for($x=0; $x<$randonnee->difficulte; $x++)
            {
                echo "*";
                
            } ?>" /></span>
        
        <span class="label_2">Durée (h)<span class="propo"></span><span class="randoOblig"></span>:</span>
        <span class="champ_2"><input type="text" id="duree" name="duree" value="<?php echo $randonnee->duree; ?>" /><br /></span>
        
        <span class="label">Montée (m) <span class="randoOblig"></span>:</span>
        <span class="champ"><input type="text" name="montee" id="montee" value="<?php echo $randonnee->montee; ?>" /></span>
        
        <span class="label_2">Descente (m) <span class="randoOblig"></span>:</span>
        <span class="champ_2"><input type="text" name="descente" id="descente" value="<?php echo $randonnee->descente; ?>" /><br /></span>
        
        
        
        <span class="label">Heure de départ <span class="randoOblig"></span>:</span>
        <span class="champ"><input type="text" name="heureDepart" id="heureDepart" value="<?php echo $randonnee->heureDepart; ?>" /></span>
        
        <span class="label_2">Heure d'arrivée <span class="randoOblig"></span>:</span>
        <span class="champ_2"><input type="text" name="heureArrivee" id="heureArrivee" value="<?php echo $randonnee->heureArrivee; ?>" /><br /></span>
        
        <span class="label">Prix minimum (CHF) <span class="randoOblig"></span>:</span>
        <span class="champ"><input type="text" name="prixMin" id="prixMin" value="<?php echo $randonnee->prixMin; ?>" /></span>
        
        <span class="label_2">Prix maximum (CHF):</span>
        <span class="champ_2"><input type="text" name="prixMax" id="prixMax" value="<?php echo $randonnee->prixMax; ?>" /><br /></span>
        
        <span class="label">Nombre de participants maximum:</span>
        <span class="champ"><input type="text" name="inscriptionMax" value="<?php echo $randonnee->inscriptionMax; ?>" /></span>
        
        <span class="label_2">A lieu?:</span>
        <span class="champ_2"><input type="checkbox" name="status" <?php if($randonnee->status == 1) { echo "checked='checked'"; } ?> /></span><br />
        
        <span class="label">localité de départ <span class="propo"></span><span class="randoOblig"></span>:</span>
        <span class="champ"><input type="text" name="lieuDepart" id="lieuDepart" value="<?php echo utf8_encode($randonnee->lieuDepart); ?>" /></span>
        
        <span class="label_2">localité d'arrivée (vide si identique au lieu de départ):</span>
        <span class="champ_2"><input type="text" name="lieuArrivee" id="lieuArrivee" value="<?php echo utf8_encode($randonnee->lieuArrivee); ?>" /><br /></span>
        
        <span class="label">lieu de Rendez-vous <span class="randoOblig"></span>:</span>
        <span class="champ"><input type="text" name="lieuRDV" id="lieuRDV" value="<?php echo utf8_encode($randonnee->rdv); ?>" /></span>
 
        <span class="label_2">Région:</span>
        <span class="champ_2">
        <?php 
            //Récupération de tous les genres de randonnées
            $genres = getListeRegions('fr');
            $genresRando = explode(';', $randonnee->genre);
            for($i = 0; $i < sizeof($genresRando) -1; $i++){
                
            
        ?>
        
            <select name="genreTour" id="genreTour">
                <?php while($ligne = mysql_fetch_array($genres)){ ?>
                <option value="<?php echo $ligne[0]; ?>" <?php
                    if($ligne[1] == $genresRando[$i])
                        echo "selected='selected'";
                ?> ><?php 
                    if($ligne[0] == 1){
                        echo "Valais central";
                    }
                    elseif($ligne[0] == 2){
                        echo "Haut Valais";
                    }
                    elseif($ligne[0] == 3){
                        echo "Bas Valais";
                    }elseif($ligne[0] == 4){
                        echo "Hors Valais";
                    }
                    else{
                        echo utf8_encode($ligne[1]);
                    }
                    ?></option>
                <?php } ?>
            </select>
            <?php } ?>
        </span><br />
        
        <span class="label">Lieu de départ pour le transport <span class="randoOblig"></span>:</span>
        <span class="champ"><input type="text" name="departTransport" id="departTransport" value="<?php echo utf8_encode($randonnee->departTransport); ?>" /></span>
        
        <span class="label_2">Lieu d'arrivée avec le transport <span class="randoOblig"></span>:</span>
        <span class="champ_2"><input type="text" name="arriveeTransport" id="arriveeTransport" value="<?php echo utf8_encode($randonnee->arriveeTransport); ?>" /><br /></span>
        
        <span class="label">Informations en français <span class="propo"></span>:</span>
        <span class="champ">
            <textarea name="info_fr" id="info_fr" cols="79"><?php 
                    if($randonnee->typeTour != 6){
                        echo utf8_encode($randonnee->info_fr);
                    }
                    else{
                        echo str_replace("\\", "", utf8_encode($randonnee->desc_fr));
                    }
                ?></textarea><br /></span>
        
        <span class="label">Informations en allemand <span class="propo"></span>:</span>
        <span class="champ">
            <textarea name="info_de" id="info_de" cols="79"><?php 
                    if($randonnee->typeTour != 6){
                        echo utf8_encode($randonnee->info_de);
                    }
                    else{
                        echo utf8_encode($randonnee->desc_de);
                    }
                ?></textarea><br /></span>
        
        <span class="label">Type:</span>
        <span class="champ">
        <?php 
            //Récupération de tous les genres de randonnées
            $genres = getGenresRandonnees('fr');
            $genresRando = explode(';', $randonnee->genre);
            for($i = 0; $i < sizeof($genresRando) -1; $i++){
                
            
        ?>
        
            <select name="genreTour" id="genreTour">
                <?php while($ligne = mysql_fetch_array($genres)){ ?>
                <option value="<?php echo $ligne[0]; ?>" <?php
                    if($ligne[1] == $genresRando[$i])
                        echo "selected='selected'";
                ?> ><?php echo utf8_encode($ligne[1]); ?></option>
                <?php } ?>
            </select>
            <?php } ?>
        </span>
        
        <span class="label_2">Genre:</span>
        
        <?php 
            //Récupération de tous les genres de randonnées
            $types = getTypesRandonnees('fr');
            
        ?>
        <span class="champ_2">
            <select name="typeTour" id="typeTour">
                <?php while($ligne = mysql_fetch_array($types)){ ?>
                <option value="<?php echo $ligne[0]; ?>" <?php
                    if($ligne[0] == $randonnee->typeTour)
                        echo "selected='selected'";
                ?> ><?php echo utf8_encode($ligne[1]); ?></option>
                <?php } ?>
            </select>
        </span><br />
        <div id="infoCode"></div>
        <span class="label">Code Programme <span class="propo"></span>:</span>
        <span class="champ"><input type="text" id="codepgrogramme" name="codeprogramme" size="80" value="<?php echo $randonnee->codeprogramme; ?>" /></span><br />
        <div id="infoCarte"></div>
        <span class="label">Lien carte:</span>
        <span class="champ"><input type="text" name="carte" size="80" value="<?php echo $randonnee->carte; ?>" /></span><br />
        
        <div id="erreur">
            
        </div>
        
        
        <span class=""><input type="submit" value="Mettre à jour" /></span>
        
    </form>
    
    <button onclick="parent.location='GestionRando.php?min=0&max=30'">Annuler</button>
    <button onclick="javascript:suppressionRando(<?php echo $randonnee->id ?>)">Supprimer</button>
    
</div>

<?php
    //Pied de page
    include("../include/footer.inc");
?>