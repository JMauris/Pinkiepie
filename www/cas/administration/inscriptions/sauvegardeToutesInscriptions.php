<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page permettant de sauvegarder toutes les inscriptions pour les
    *           randonnées à venir.
    ***************************************************************************/
    
    //Ajout des fichiers nécessaires au bon fonctionnement du site
    include("../include/toppage.inc");
    include("../include/header.inc");
    include("../../BusinessObject/randonnees.php");
    include("../../BusinessObject/inscription.php");
    include("../../include/fonctions.inc.php");
    require_once '../../ExcelWriter/Classes/PHPExcel/IOFactory.php';
    require_once '../../ExcelWriter/Classes/PHPExcel.php';
    
    //Récupération des données concernant la date
    $jour = date("d");
    $mois = date("m");
    $annee = date("Y");
    
    //Liste des randonnées à venir
    $listeRandonnees = getRandonnees($jour, $mois, $annee);
    
    //Parcours toutes les randonnée
    while($ligne = mysql_fetch_array($listeRandonnees)){
        //Création d'une nouvelle randonnée et récupération des informations
        $randonnee = new randonnee();
        $randonnee->id = $ligne[0];
        $randonnee->getInfoRandonnee();
        
        //Contrôle que le model existe
        if (!file_exists("../../documents/documentRando_Model.xls")) {
            exit("Le fichier est introuvable." . PHP_EOL);
        }

        //Ouverture du fichier
        $objPHPExcel = PHPExcel_IOFactory::load("../../documents/documentRando_Model.xls");


        //Séléctionne la première feuille
        $objPHPExcel->setActiveSheetIndex(0);

        //Affichage de la date
        $date = explode("-", $randonnee->date);
        $objPHPExcel->getActiveSheet()->setCellValue('B1', $date[2] . "." . $date[1] . "." . $date[0]);

        //Affichage du titre
        $objPHPExcel->getActiveSheet()->setCellValue('B3', utf8_encode($randonnee->titre));

        //Affichage du lieu de départ
        $objPHPExcel->getActiveSheet()->setCellValue('B6', 'Départ: ' . utf8_encode($randonnee->lieuDepart));

        //Affichage du lieu d'arrivée
        if($randonnee->lieuArrivee == ''){
            $objPHPExcel->getActiveSheet()->setCellValue('B7', 'Retour: ' . utf8_encode($randonnee->lieuDepart));
        }
        else{
            $objPHPExcel->getActiveSheet()->setCellValue('B7', 'Retour: ' . utf8_encode($randonnee->lieuArrivee));
        }

        //Affichage de la durée
        $objPHPExcel->getActiveSheet()->setCellValue('G7', $randonnee->duree);

        //Affichage de la difficulté
        for($i = 0; $i < $randonnee->difficulte; $i++){
            $difficulte .= '*';
        }
        $objPHPExcel->getActiveSheet()->setCellValue('G6', $difficulte);

        //Affichage du lieu de départ pour le transport
        $departTransport = explode(";", $randonnee->departTransport);
        $objPHPExcel->getActiveSheet()->setCellValue('C13', utf8_encode($departTransport[0]));

        $length = sizeof($departTransport) - 1;
        if($length == 2)
            $objPHPExcel->getActiveSheet()->setCellValue('D13', utf8_encode($departTransport[1]));
        elseif($length > 2)
            $objPHPExcel->getActiveSheet()->setCellValue('D13', utf8_encode($departTransport[2]));

        //Affichage du lieu d'arrivée pour le transport
        $arriveeTransport = explode(";", $randonnee->arriveeTransport);
        $objPHPExcel->getActiveSheet()->setCellValue('C14', $arriveeTransport[0]);

        $length = sizeof($arriveeTransport) - 1;
        if($length == 2)
            $objPHPExcel->getActiveSheet()->setCellValue('D14', utf8_encode($arriveeTransport[1]));
        elseif($length > 2)
            $objPHPExcel->getActiveSheet()->setCellValue('D14', utf8_encode($arriveeTransport[2]));


        //Affichage de l'heure de départ
        $objPHPExcel->getActiveSheet()->setCellValue('E13', $randonnee->heureDepart);

        //Affichage de l'heure d'arrivée
        $objPHPExcel->getActiveSheet()->setCellValue('E14', $randonnee->heureArrivee);


        //Récupération de toutes les inscriptions pour une randonnée
        $inscription = new inscription();
        $inscription->idRandonnee = $randonnee->id;
        $listeInscription = $inscription->inscriptionsPourRando($randonnee->id);

        //Affichage de la liste des inscrits
        $objPHPExcel->getActiveSheet()->setCellValue('B21', utf8_encode($randonnee->chefCourse));
        $objPHPExcel->getActiveSheet()->setCellValue('C21', 1);
        $objPHPExcel->getActiveSheet()->setCellValue('G21', "Chef de course");
        $colone = 22;
        
        //Si un assistant est déclaré, ajout dans l'inscription
        if($randonnee->assistant != ''){
            $objPHPExcel->getActiveSheet()->setCellValue('B'. $colone, utf8_encode($randonnee->assistant));
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $colone, 1);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $colone, "Assistant(e)");
            $colone++;
        }
        
        while($ligne = mysql_fetch_array($listeInscription)){
            $prix = 0;
            //ajout du nom
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $colone, utf8_encode($ligne[1]) . " " . utf8_encode($ligne[2]));

            //Contrôle si la personne est membre
            if($ligne[4] != '' || $ligne[4] != 0)
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $colone, 1);
            else{
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $colone, 1);
                $prix = 5;
            }


            //Abonnement de train
            $abo = "";

            switch($ligne[5]){
                case 1:
                    $abo = "non";
                    break;
                case 2:
                    $abo = "AG";
                    break;
                case 3:
                    $abo = "oui";
                    break;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $colone, $abo);

            //Remarque
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $colone, utf8_encode($ligne[6]));


            $colone++;
        }

        //Création d'un module pour la sauvegarde du fichier
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        //$objWriter->save('php://output');
        //Sauvegarde du fichier
        $nomFichier = "sauvegardeRando_" . $randonnee->id . ".xlsx";
        $objWriter->save("backup/$nomFichier");


    }
?>
