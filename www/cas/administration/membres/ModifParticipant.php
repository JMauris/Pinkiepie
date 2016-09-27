<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Modification des informations d'une personne
    ***************************************************************************/
    //Mise en place des fichiers nécessaires au bon fonctionnement de la page
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/personne.php");
    include("../../include/fonctions.inc.php");
    
    //Création d'une personne
    $personne = new personne();
    
    //Contrôle si la modification concerne un membre
    $membre = "";
    if(isset($_GET['membre']))
        $membre = "readonly";
    
    //Récupère l'identifiant de la personne
    if(isset($_GET['id'])){
        $personne->id = $_GET['id'];
        $personne->getDetailPersonne();
        
    }
    //Si une modification a été effectuée
    else{
        $personne->id = $_POST['id'];
        
        //Détails de la modification
        $personne->nom = utf8_decode($_POST['nom']);
        $personne->prenom = utf8_decode($_POST['prenom']);
        $personne->adresse = utf8_decode($_POST['adresse']);
        $personne->npa = $_POST['npa'];
        $personne->localite = utf8_decode($_POST['localite']);
        $personne->email = $_POST['email'];
        $personne->telephone = $_POST['telephone'];
        $personne->portable = $_POST['portable'];
        $personne->abonnement = $_POST['abo'];
        
        //Modification des données
        $personne->modifParticipant();
        
        
        //Message de confirmation
        echo "<script>alert('Modification effectuée avec succès');</script>";
    } 
    
?>

<script>
function suppressionParticipant(id){
    //Message de confirmation pour la suppression du participant
    if(confirm("Voulez-vous vraiment supprimer ce participant?")){
        document.location = 'SuppressionParticipant.php?id=' + id;
    }
}


</script>

<div id="main">
    <h1>Modification des informations d'un participant</h1>
    <!-- Formulaire de modification -->
    <?PHP
    //Si ce n'est pas un memrbre
    if($membre == ''){?>
        <form method="post" action="ModifParticipant.php">
    <?php
    //Si la personne est membre
    }else {
    ?>
        <form method="post" action="ModifParticipant.php?membre=true">
    <?php
    }
    ?>      
        <input type="hidden" name="id" value="<?php echo $personne->id; ?>" />
        
        <span class="label">Nom *:</span>
        <span class="champ"><input type="text" name="nom" id="nom" value="<?PHP echo utf8_encode($personne->nom); ?>" <?php echo $membre; ?> /></span>
        
        <span class="label_2">Prénom *:</span>
        <span class="champ_2"><input type="text" name="prenom" id="prenom" value="<?php echo utf8_encode($personne->prenom); ?>" <?php echo $membre; ?>/><br /></span>
        
        <span class="label">Adresse :</span>
        <span class="champ"><input type="text" name="adresse" id="adresse" size="50" value="<?PHP echo str_replace("\\", "",utf8_encode($personne->adresse)); ?>" <?php echo $membre; ?>/></span><br />
        
        <span class="label">NPA :</span>
        <span class="champ"><input type="text" name="npa" id="npa" value="<?PHP echo $personne->npa; ?>" <?php echo $membre; ?>/></span>
        
        <span class="label_2">Localité :</span>
        <span class="champ_2"><input type="text" name="localite" id="localite" value="<?php echo utf8_encode($personne->localite); ?>" <?php echo $membre; ?>/><br /></span>
        
        <span class="label">Email :</span>
        <span class="champ"><input type="text" name="email" id="email" size="50" value="<?PHP echo $personne->email; ?>" readonly/></span><br />
        
        <span class="label">Téléphone :</span>
        <span class="champ"><input type="text" name="telephone" id="telephone" value="<?PHP echo $personne->telephone; ?>" <?php echo $membre; ?>/></span>
        
        <span class="label_2">Portable :</span>
        <span class="champ_2"><input type="text" name="portable" id="portable" value="<?php echo $personne->portable; ?>" <?php echo $membre; ?>/><br /></span>
        
        <span class="label">Abonnement de transports publics:</span>
        <span class="champ">
            <select name="abo" >
                <?php 
                
                    //Liste des abonnements
                    $listeAbo = getAbonnements("fr");
                      
                      while($ligne = mysql_fetch_array($listeAbo)){
                          echo "<option value='$ligne[0]'";
                          if($personne->abonnement == $ligne[0])
                            echo " selected";
                          echo ">" . utf8_encode($ligne[1]) . "</option>";
                      }
                ?>
            </select>
            
        </span><br />
        
        <span class=""><input type="submit" value="Mettre à jour" /></span>
        
    </form>
    <!-- N'affiche le bouton supprimer que si la personne n'est pas membre -->
    <?php
        if($membre != ''){
    ?>
    <button onclick="javascript:suppressionParticipant(<?php echo $personne->id; ?>);">Supprimer</button>
    <?php
        }
    ?>
    <button onclick="parent.location='GestionMembres.php'">Annuler</button>
    
</div>

<?php
    //Pied de page
    include("../include/footer.inc");
?>