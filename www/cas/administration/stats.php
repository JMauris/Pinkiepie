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
require_once '../ExcelWriter/Classes/PHPExcel/IOFactory.php';
require_once '../ExcelWriter/Classes/PHPExcel.php';
include("../BusinessObject/randonnees.php");
include("../BusinessObject/inscription.php");
include("../include/fonctions.inc.php");

// Création d'une randonnée et recherche les 
// informations concernant la randonnée recherchée
$randonnee = new randonnee();

//Recherche le modèle, si introuvable -> erreur et fin d'exécution
if (!file_exists("../documents/documentStats_Model.xls")) {
	exit("Le fichier est introuvable." . PHP_EOL);
}

//Chargement du fichier en mémoire
$objPHPExcel = PHPExcel_IOFactory::load("../documents/documentStats_Model.xls");


//Récupération de toutes les randonnées
$listeMembres = $randonnee->statsRandoMembres();
$totalInscrits = $randonnee->statsRandoNbTotal();

// Séléction de la première Feuille
$objPHPExcel->setActiveSheetIndex(0);

//Affichage du nombre total d'inscrits
$date = explode("-", $randonnee->date);
$objPHPExcel->getActiveSheet()->setCellValue('B2', $totalInscrits[0]);



//Parcours la liste des personnes inscrites à la randonnée
$colone = 5;
while($ligne = mysql_fetch_array($listeMembres)){
    //ajout du titre
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $colone, utf8_encode($ligne[1]));
		
		//date de début
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $colone, utf8_encode($ligne[2]));
		
		//ajout chef de course
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $colone, utf8_encode($ligne[3]));
		
		//ajout total inscrits
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $colone, $ligne[4]);
		
		//ajout membres
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $colone, $ligne[5]);
		
		//ajout non-membres
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $colone, $ligne[4]-$ligne[5]);
		
		//ajout status
		if($ligne[6] == 1)
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $colone, "oui");
		else
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $colone, "non");
		
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
$objWriter->save('rapportStats.xlsx');
//redirection vers la page des randonnées
echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=index.php?file=rapportStats.xlsx' />";
?>
