<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page permettant de générer les fichiers nécessaires aux chefs de
    *           course. Récupération des inscriptions pour la randonnée
    ***************************************************************************/

//Mise en place du fuseau horaire
date_default_timezone_set('Europe/Paris');

//Ajout des fichiers nécessaires à la création du fichier Excel
require_once '../../ExcelWriter/Classes/PHPExcel/IOFactory.php';
require_once '../../ExcelWriter/Classes/PHPExcel.php';
include("../../BusinessObject/randonnees.php");
include("../../BusinessObject/inscription.php");
include("../../include/fonctions.inc.php");

// Création d'une randonnée et recherche les 
// informations concernant la randonnée recherchée
$randonnee = new randonnee();
$randonnee->id = $_GET['id'];
$randonnee->getInfoRandonnee();


//Recherche le modèle, si introuvable -> erreur et fin d'exécution
if (!file_exists("../../documents/documentRando_Model.xls")) {
	exit("Le fichier est introuvable." . PHP_EOL);
}

//Chargement du fichier en mémoire
$objPHPExcel = PHPExcel_IOFactory::load("../../documents/documentRando_Model.xls");


// Séléction de la première Feuille
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
$objPHPExcel->getActiveSheet()->setCellValue('H7', $randonnee->duree);

//Affichage de la difficulté
$difficulte = "";
for($i = 0; $i < $randonnee->difficulte; $i++){
    $difficulte .= '*';
}
$objPHPExcel->getActiveSheet()->setCellValue('H6', $difficulte);

//Affichage du lieu de départ pour le transport
$departTransport = explode(";", $randonnee->departTransport);
$objPHPExcel->getActiveSheet()->setCellValue('C13', utf8_encode($departTransport[0]));

//Affichage du transport
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
$objPHPExcel->getActiveSheet()->setCellValue('H21', "Chef de course");
$colone = 22;

//Si un assistant est inscrit, l'ajouter à la liste
if($randonnee->assistant != ''){
    $objPHPExcel->getActiveSheet()->setCellValue('B'. $colone, utf8_encode($randonnee->assistant));
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $colone, 1);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $colone, "Assistant(e)");
    $colone++;
}

//Parcours la liste des personnes inscrites à la randonnée
while($ligne = mysql_fetch_array($listeInscription)){
    //ajout du nom
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $colone, utf8_encode($ligne[1]) . " " . utf8_encode($ligne[2]));
    
    //Contrôle si la personne est membre
    if($ligne[4] != '' || $ligne[4] != 0)
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $colone, 1);
    else{
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $colone, 1);
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
    
		/*Modifié 27.02.2013 Sabine Mathieu : ajouter une colonne téléphone + natel + affichage de l'email si pas de remarque*/
		
		//Téléphone
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $colone, utf8_encode($ligne[7]));
    
    //Natel
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $colone, utf8_encode($ligne[8]));
		
		//Remarque ou si non, Email
		if($ligne[6] != '')
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $colone, utf8_encode($ligne[6]));
		else{
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $colone, utf8_encode($ligne[3]));
		}
		
    $colone++;
}


//Création d'un module permettant d'enregistrer le fichier
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


// Redirect output to a client’s web browser (Excel2007)
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="RapportRandonnee.xlsx"');
//header('Cache-Control: max-age=0');

//Sauvegarde du fichier et affichage de la page du détail de la randonnée
//$objWriter->save('php://output');
$objWriter->save('rapportRando.xlsx');
//redirection vers la page des randonnées
echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=listeInscriptions.php?id=$randonnee->id&file=rapportRando.xlsx' />";
?>
