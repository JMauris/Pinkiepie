<?php //session_start(); ?>
<div data-role="header">
    
    <?php
    //Prépare la langue à afficher dans l'utl
    $flagFR = 'fr';                        
    $flagDE = 'de';
    $currentUrl = 'test';
    if ($_SESSION['langue'] == 'de')
        $flag = 'fr';
    else
        $flag = 'de';

    // Récupération de l'url du site
    // URI (/listeRando.php)
    $uri      = $_SERVER['REQUEST_URI'];

    // Contrôle si un paramètre est déjà existant
    // Sinon
    if($_SERVER['QUERY_STRING'] == null){
        $currentUrlFR = $uri."?lang=".$flagFR;
        $currentUrlDE = $uri."?lang=".$flagDE;
    }
    else 
        //Préparation des différents URL
        if ($_SERVER['QUERY_STRING'] == "lang=de" || $_SERVER['QUERY_STRING'] == "lang=fr") {
            $removeLangParam = explode("?lang=", $uri);
            $currentUrl = $removeLangParam[0];
            $currentUrlFR = $currentUrl."?lang=".$flagFR;
            $currentUrlDE = $currentUrl."?lang=".$flagDE;
        } 
        else {
            $removeLangParam = explode("&lang=", $uri);
            $currentUrl = $removeLangParam[0];
            $currentUrlFR = $currentUrl."&lang=".$flagFR;
            $currentUrlDE = $currentUrl."&lang=".$flagDE;
        }
    ?>
    <table>
        <tr>
            <td>
                <!-- affichage du bouton de retour pour les pages n'étant pas l'index -->
                <?php if(!strpos($currentUrlFR, "index.php")){ ?>
                <a class='ui-btn-left ui-btn-back' rel="external" data-ajax="false" data-role="button" stlye="font-size:250%">
                    <span class="ui-btn-text" style="font-size: 200%;">
                        <?php echo $traductions['retour'][$_SESSION['langue']] ?>
                    </span>
                </a>
                <?php } ?>
            
            </td>
            <td>
                <div id="logo">
                    
                    <a href="index.php" rel="external">
                        <img src="../pictures/logo.png" alt="logo Valrando"/>
                    </a>
                    
                </div>
            </td>
            <td><div id="language">
                    <!-- Affichage du drapeau pour la modification de la langue -->
                 <?php
                    if($_SESSION['langue'] == 'fr'){
                  ?>
                    <a href="<?php echo $currentUrlDE ?>" rel="external" data-corners="false">
                        <img src="../pictures/icons/deutschland.png" alt="Website auf Deutsch" style="height: 55px;"/>
                    </a>
                <?php }else{ ?>
                    <a href="<?php echo $currentUrlFR ?>" rel="external">
                        <img src="../pictures/icons/france.png" alt="Site en français" style="height: 70px;"/>
                    </a>
                <?php } ?>
                </div>
            </td>
        </tr>
    </table>    
</div><!-- /header -->