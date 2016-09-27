<?php
include('../include/toppage.inc');
include('../include/fonctions.inc.php');
include('../BusinessObject/personne.php');

/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Mot de passe oublié
***************************************************************************/
// Formulaire rempli et envoyé
if(isset($_POST['email'])){
    $email = $_POST['email'];
    
    //Récupérer le mot de passe par rapport à l'adresse email
    $mdp = rechercherMotPasse($email);

    //Si la personne n'est pas membre, alors message d'avertissement
    if($mdp == 'non-membre')
        echo "<script>alert('" . $traductions['nonMembre'][$_SESSION['langue']] . "');</script>";
    else {
        echo "<script>";
        echo "alert('Votre nouveau de passe est : " . $mdp[0] . "');";
        echo "window.location = 'connexion.php';";
        echo "</script>";
    }
}

?>
<script>
    //Page affichée
    $(document).ready(function(){
        //Gestion du retour
        $('.ui-btn-back').click(function() {
            window.location = 'connexion.php';
            return false;
        });
    });
</script>

<div data-role="page" id="main">
   <?php include('../include/header.inc');?>
    <div data-role="content">
        <h2><?php echo $traductions['motDePasseOubli'][$_SESSION['langue']] ?></h2>
        <div class="tableauPage">
            <p>
               <?php echo $traductions['infoMotDePasseOubli'][$_SESSION['langue']] ?>
            </p>
            <form method="post" data-ajax="false">
                <div data-role="fieldcontain">
                    <label for="name">Email :</label>
                    <input type="email" name="email" id="email" />
                </div>
                
                <input type="submit" name="envoi" value="<?php echo $traductions['transmettreInscr'][$_SESSION['langue']] ?>" />
            </form>
        </div>
    </div>
<?php
    //Pied de page
    include('../include/footer.inc');
    ?>