<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Page permettant de g�n�rer les fichiers n�cessaires aux chefs de
    *           course. R�cup�ration des inscriptions pour la randonn�e
    ***************************************************************************/

//Mise en place du fuseau horaire
date_default_timezone_set('Europe/Paris');

//Ajout des fichiers n�cessaires � la cr�ation du fichier Excel
require_once '../ExcelWriter/Classes/PHPExcel/IOFactory.php';
require_once '../ExcelWriter/Classes/PHPExcel.php';
include("../BusinessObject/randonnees.php");
include("../BusinessObject/inscription.php");
include("../include/fonctions.inc.php");

// Cr�ation d'une randonn�e et recherche les 
// informations concernant la randonn�e recherch�e
$randonnee = new randonnee();

//Recherche le mod�le, si introuvable -> erreur et fin d'ex�cution
if (!file_exists("../documents/documentStats_Model.xls")) {
	exit("Le fichier est introuvable." . PHP_EOL);
}

//Chargement du fichier en m�moire
$objPHPExcel = PHPExcel_IOFactory::load("../documents/documentStats_Model.xls");


//R�cup�ration de toutes les randonn�es
$listeMembres = $randonnee->statsRandoMembres();
$totalInscrits = $randonnee->statsRandoNbTotal();

// S�l�ction de la premi�re Feuille
$objPHPExcel->setActiveSheetIndex(0);

//Affichage du nombre total d'inscrits
$date = explode("-", $randonnee->date);
$objPHPExcel->getActiveSheet()->setCellValue('B2', $totalInscrits[0]);



//Parcours la liste des personnes inscrites � la randonn�e
$colone = 5;
while($ligne = mysql_fetch_array($listeMembres)){
    //ajout du titre
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $colone, utf8_encode($ligne[1]));
		
		//date de d�but
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


//Cr�ation d'un module permettant d'enregistrer le fichier
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


// Redirect output to a client�s web browser (Excel2007)
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="RapportRandonnee.xlsx"');
//header('Cache-Control: max-age=0');

//Sauvegarde du fichier et affichage de la page du d�tail de la randonn�e
//$objWriter->save('php://output');
$objWriter->save('rapportStats.xlsx');
//redirection vers la page des randonn�es
echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=index.php?file=rapportStats.xlsx' />";
?>
