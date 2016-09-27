<?php
include('../include/toppage.inc');
include('../include/fonctions.inc.php');
include('../BusinessObject/personne.php');

/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Page permettant la connexion au système
***************************************************************************/

$personne = new personne();
$email = '';
$password = '';

// Si le formulaire a été rempli
if(isset($_POST['email'])){

    //Récupération de l'email et du mot de passe
    $personne->email = $_POST['email'];
    $personne->motDePasse = $_POST['password'];

    //contrôle des informations de connexions
    $infosConnexion= connexionMembre($personne->email, $personne->motDePasse);

    $personneInfo = mysql_fetch_array($infosConnexion);

    if($personneInfo[0] != ''){
        //Récupération du nom
        $_SESSION['nom'] = $personneInfo[0];
        $personne->nom = $personneInfo[0];

        //Récupération du prénom
        $_SESSION['prenom'] = $personneInfo[1];
        $personne->prenom = $personneInfo[1];

        //Détail de la personne
        $personne->getPersonne($personne->nom, $personne->prenom);

        //contrôle si le mot de passe est celui d'origine
        $estOrigine = $personne->motDePasseOrigine();
        //si le mot de passe et celui d'origine, redirection vers la page de changement de mot de passe
        if($estOrigine){
            echo "<script>alert('" . $traductions['mdpOrigine'][$_SESSION['langue']] . "');</script>";
        }
    }
    else{
        echo "<script>alert('" . $traductions['erreurMailPassword'][$_SESSION['langue']] . "');</script>";
    }
}

if(isset($_GET['source']))
    $source = $_GET['source'];
else
    $source = "";
?>
<script>
$("#email").change(function(){
    //Verrifcation de l'email
    if($("#email").val() == ''){
        $("#erreur").html("L'adresse email ne peut pas être vide");
    }
    else{
        $("#erreur").html("");
    }
});

//Modification du mot de passe
$("#password").change(function(){
    if($("#password").val() == ''){
        $("#erreur").html("L'adresse email ne peut pas être vide");
    }
    else{
        $("#erreur").html("");
    }
});

$(document).ready(function() { 
    //Gestion du retour
    $('.ui-btn-back').click(function() {
        window.location = 'index.php';
        return false;
    });
    //Envoi du formulaire
    $('form').submit(function () {
        if($("#password").val() == '' || $("#email").val() == ''){
                $("#erreur").html("Merci de renseigner les champs");
            return false; 
        }
    }); 
}); 

</script>
    <div data-role="page" id="main">
        <?php include('../include/header.inc'); ?>
        <div data-role="content">
            <h2><?php echo $traductions['monValrando'][$_SESSION['langue']] ?></h2>
            <div class="tableauPage">
                <p><b>Exemple de login :</b> simon@hesso.ch
                <br/><b>Mot de passe :</b> simon</p>
                <?php
                if(!isset($_SESSION['nom']) || $_SESSION['nom'] == ''){
                ?>
                <form method="post" id="connexion" data-ajax="false">
                    <input type="hidden" value="<?php echo $source; ?>" name="source" />
                    <div data-role="fieldcontain">
                        <label for="name">Email:</label>
                        <input type="email" name="email" id="email" value="<?php echo $email; ?>" />
                    </div>
                    <div data-role="fieldcontain">
                        <label for="name"><?php echo $traductions['motpasse'][$_SESSION['langue']] ?></label>
                        <input type="password" name="password" id="password" />
                    </div>

                    <div id="erreur"></div>

                    <input type="submit" value="<?php echo $traductions['connexionTitre'][$_SESSION['langue']] ?>" data-inline="true" rel="external"/> <!--onclick="sendForm();"-->
                </form>
                <br/>
                <a href="oubliMotDePasse.php" rel="external"><?php echo $traductions['motDePasseOubli'][$_SESSION['langue']] ?></a>
                <?php
                    }
                        else {
                            echo "<h3>" . $traductions['actuellementConnecte'][$_SESSION['langue']];
                            echo "<div id='logout'><a href='../include/logout.inc.php' rel='external'><img src='../pictures/exit.png' height='50px' /></a></div>";
                            echo "</h3>";
                            if(isset($_POST['source']) && $_POST['source'] != ''){
                                //Mot de passe inchangé, redirection vers le changement de mot de passe
                                if($estOrigine){
                                    echo "<script>document.location.href='changementMotDePasse.php?id=" . $_POST['source'] . "' </script>";
                                }
                                else{
                                echo "<script>document.location.href='inscriptionRando.php?id=" . $_POST['source'] . "' </script>";
                                }

                            }
                            else{
                                if($estOrigine){
                                    echo "<script>document.location.href='changementMotDePasse.php?id=" . $_POST['source'] . "' </script>";
                                }
                                else{
                                echo "<script>document.location.href='index.php' </script>";
                                }
                            }
                    }
                ?>

            </div>
        </div><!-- /content -->
<?php
//Pied de page
include('../include/footer.inc');
?>
