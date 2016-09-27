<?php
include('../include/toppage.inc');
include('../include/fonctions.inc.php');

/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Recherche d'une randonnée
***************************************************************************/

//Proposition ou randonnée?
if(isset($_GET['propo']))
    $propo = $_GET['propo'];

$region = 0;
$difficulte = 0;
$type = 0;

//Formulaire rempli?
if(isset($_POST['region'])){
    $region = $_POST['region'];
    $difficulte = $_POST['difficulte'];
    $type = $_POST['typeRando'];
}
?>

<script>
    $(document).ready(function(){
        //Gestion du retour
        $('.ui-btn-back').click(function() {
            <?php if($propo != 'oui'){ ?>
                window.location = 'programmeValrando.php';
            <?php }else{ ?>
                window.location = 'listePropositions.php';
            <?php } ?>
            return false;
        });
    });
</script>

<div data-role="page" id="main">
    <?php include('../include/header.inc'); ?>
    <div data-role="content">
        <?php if(isset($_SESSION['nom']) && $_SESSION['nom'] != ''){ ?>
        <div id="titrePage">
            <h3>
                <?php echo $traductions['actuellementConnecte'][$_SESSION['langue']]; ?>
                <div id='logout'>
                    <a href='../include/logout.inc.php' rel="external">
                        <img src='../pictures/exit.png' height='50px' />
                    </a>
                </div>
            </h3>
        </div>
        <?php }else{ ?>
        <h3><?php echo $traductions['rechercheRando'][$_SESSION['langue']] ?></h3>
        <?php } ?>
        <div class="tableauPage">
            <h4><?php echo $traductions['rechercher'][$_SESSION['langue']] ?></h4>
            <div class="formulaire">
                <form method="post" action="rechercheRando.php?propo=<?php echo $propo; ?>" rel="external" data-ajax="false" >
                    
                    <div data-role="fieldcontain">
                        <label for="region"><?php echo $traductions['region'][$_SESSION['langue']] ?>:</label>
                        
                        <select name="region" id="region">
                            <option value="all"><?php echo $traductions['toutesRegions'][$_SESSION['langue']] ?></option>
                            <?php 
                                $listeRegions = getListeRegions($_SESSION['langue']);
                                
                                while($ligne = mysql_fetch_array($listeRegions)){
                                    echo "<option value='$ligne[0]'";
                                    if($ligne[0] == $region)
                                        echo "selected='selected'";
                                    echo ">$ligne[1]</option>";
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div data-role="fieldcontain">
                        <label for="difficulte"><?php echo $traductions['difficulte'][$_SESSION['langue']] ?>:</label>
                        <select name="difficulte" id="difficulte">
                            <option value="all"><?php echo $traductions['toutesRegions'][$_SESSION['langue']] ?></option>
                            <?php
                                for($i = 1; $i <= 5 ; $i++){
                                    echo "<option value='$i'";
                                    
                                    if($i == $difficulte)
                                        echo "selected='selected'";
                                    
                                    echo ">";

                                    for($y = 0; $y < $i; $y++)
                                        echo "*";
                                    
                                    echo "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    
                    <div data-role="fieldcontain">
                        <label for="typeRando"><?php echo $traductions['Type'][$_SESSION['langue']] ?>:</label>
                        <select name="typeRando" id="typeRando">
                            <option value="all"><?php echo $traductions['tousTypes'][$_SESSION['langue']] ?></option>
                            <?php
                            $listeGenres = getListeGenre($_SESSION['langue']);
                                
                            while($ligne = mysql_fetch_array($listeGenres)){
                                echo "<option value='$ligne[0]'";

                                if($ligne[0] == $type)
                                    echo "selected='selected'";

                                echo ">" . utf8_encode($ligne[1]) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <input type="submit" value="<?php echo $traductions['rechercher'][$_SESSION['langue']] ?>">
                </form>
            </div>
            
            <h4><?php echo $traductions['randonnees'][$_SESSION['langue']] ?></h4>
            
            <ul data-role="listview" data-filter="true" data-theme="e" 
                data-filter-placeholder="<?php echo $traductions['affinerRecherche'][$_SESSION['langue']] ?>" >
                
               <?php
                if(isset($_POST['region'])){
                    $listeRando = rechercheRando($_SESSION['langue'], $difficulte, $region, $type, $propo);

                    while($ligne = mysql_fetch_array($listeRando)){
                        echo "<li>\n";
                        if($propo != "oui")
                            echo "<a href='detailRandonnee.php?id=$ligne[0]' rel='external'>\n";
                        else
                            echo "<a href='detailProposition.php?id=$ligne[0]' rel='external'>\n";
                        echo "<p class='ui-li-aside ui-li-desc'>\n";
                        echo "<strong>";

                        for($i=0; $i<$ligne[2]; $i++){
                            echo "*";
                        }

                        echo "</strong>\n";
                        echo "</p>\n";
                        echo "<h3 class='ui-li-heading'>" . utf8_encode($ligne[1]) . "</h3>\n";
                        
                        if($propo != "oui"){
                            echo "<p class='ui-li-desc'>\n";
                            $date = explode("-", $ligne[3]);
                            
                            if($date[2] != '')
                                $date = $date[2] . "." . $date[1] . "." . $date[0] . ": ";

                            $heureDep = '';
                            if($ligne[4] != '00:00:00' || $ligne[4] != '')
                                $heureDep = $ligne[4] . " - " . $ligne[5];

                            echo "<strong>" . $date . $heureDep . "</strong>";
                            echo "</p>\n";
                        }
                        echo "</a>\n";
                    }
                }
                ?>
            </ul>
        </div>    
    </div>
    
<?php
//Pied de page
include('../include/footer.inc');
?>