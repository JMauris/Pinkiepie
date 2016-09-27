<?php
    include('../include/toppage.inc');
    include('../include/fonctions.inc.php');
    include('../BusinessObject/personne.php');
    
    /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page permetant à un utilisateur connecté de changer son mot de passe
    ***************************************************************************/
    
    //Création d'une nouvelle personne
    $personne = new personne();
    
    if(isset($_GET['id'])){
        //Récupération de l'identifiant de la personne
        $personne->id = $_GET['id'];
    }
    else{
        //Récupération de l'identifiant de la personne
        $personne->id = $_POST['idPersonne'];
        
        //récupération du nouveau mot de passe
        $personne->motDePasse = sha1($_POST['pwd']);
        
        //Modification du mot de passe de la personne
        $personne->modifMdp();
    }
    
?>
<!-- Script Javascript pour contrôler que les mots de passes soient identiques  -->
<script>
    $(document).ready(function(){
        
        //Gestion du retour
        $('.ui-btn-back').click(function() {
          window.location = 'mesInfos.php';
          return false;
        });
        
        //Action effectuée lors de la modification du champ mot de passe
        $("#pwd").change(function(){
            if($("#pwd").val().length < 5){
                $("#erreur").html("<?php echo $traductions['infosChangementMdp'][$_SESSION['langue']] ?>");
            }
            else{
                $("#erreur").html('');
            }
        });
        
        //Action effectuée lors de la modification de la confirmation
        $("#conf").change(function(){
            if($("#conf").val() != $("#pwd").val()){
                $("#erreur").html("<?php echo $traductions['erreurMdp'][$_SESSION['langue']] ?>");
            }
            else{
                $("#erreur").html();
            }
        });
        
        //Contrôle que tous les champs du formulaires soient bien remplis
        $('form').submit(function () {
           if($("#pwd").val() == ''){
               $("#erreur").html("<?php echo $traductions['mdpVide'][$_SESSION['langue']] ?>");
               return false;
           }
           if($("#conf").val() == ''){
               $("#erreur").html("<?php echo $traductions['confirmationVide'][$_SESSION['langue']] ?>");
               return false;
           }

           if($("#conf").val() != $("#pwd").val()){
                $("#erreur").html("Le mot de passe et la confirmation ne sont pas identiques");
                return false;
            }
            
            if($("#pwd").val().length < 5){
                $("#erreur").html("<?php echo $traductions['infosChangementMdp'][$_SESSION['langue']] ?>");
                return false;
            }
        });
    });
</script>
<div data-role="page" id="main">
   <?php include('../include/header.inc'); ?>
   <div data-role="content">
       <h2><?php echo $traductions['modifMotDePasse'][$_SESSION['langue']] ?></h2>
       <div class="tableauPage">
           <p><?php echo $traductions['infosChangementMdp'][$_SESSION['langue']] ?></p>
           <!-- Formulaire pour modifier le mot de passe -->
           <form method="post" action="changementMotDePasse.php" data-ajax="false">
               <input type="hidden" name="idPersonne" value="<?php echo $personne->id; ?>" />
              
               <!-- champ pour le nouveau mot de passe -->
               <div data-role="fieldcontain">
                   <label for="name"><?php echo $traductions['nouveauMdp'][$_SESSION['langue']] ?>:</label>
                   <input type="password" name="pwd" id="pwd" value="<?php echo $motDePasse; ?>" />
               </div>
               
               <!-- confirmation du mot de passe -->
               <div data-role="fieldcontain">
                   <label for="name"><?php echo $traductions['confirmationMDP'][$_SESSION['langue']] ?>:</label>
                   <input type="password" name="conf" id="conf" value="<?php echo $motDePasse; ?>" />
               </div>
                              
               <div id="erreur">
                   
               </div>
               
               <input type="submit" value="<?php echo $traductions['modifier'][$_SESSION['langue']] ?>" />
           </form>
       </div>
   </div>
<?php
    //pied de page
    include('../include/footer.inc');
?>