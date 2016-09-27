<?php
session_start();
/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Fichier parcourant le fichier Excel du programme afin de tout
*           ajouter dans la base de données
***************************************************************************/
//Inclus ExcelReader
require_once ('../../ExcelReader/Excel/reader.php');
require_once ('../../BusinessObject/randonnees.php');
require_once ("../../include/fonctions.inc.php");
require_once ('../../BusinessObject/personne.php');

//Ouvre le fichier
$data = new Spreadsheet_Excel_Reader();
$data->read($_FILES['propositionsRando']['tmp_name']);

//Lecture du fichier
    //Nombre de feuilles, de colones et de lignes
    echo "sheets: " . sizeof($data->sheets) . "<br />\n";
    echo "Number of rows in sheet 1" . ": " . $data->sheets[0]["numRows"] . "<br />\n";
    echo "Number of columns in sheet 1" . ": " . $data->sheets[0]["numCols"] . "<br />\n";
 
    //Ajout des randonnées
    echo "<h1>Propositions</h1>";
    
    $x = 2;
    $randonnee = new randonnee();
    
    while($x<=$data->sheets[0]['numRows']) {
        $randonnee->typeTour = 6;
        $randonnee->genre = 3;
        
        //titre
        $randonnee->titre = mysql_escape_string($data->sheets[0]['cells'][$x][2]);
        
        //Informations en français
        $randonnee->info_fr = mysql_escape_string($data->sheets[0]['cells'][$x][3]);
        
        //Informations en Anglais
        $randonnee->info_de = mysql_escape_string($data->sheets[0]['cells'][$x][4]);
        
        //Régions
        $randonnee->region = mysql_escape_string($data->sheets[0]['cells'][$x][8]);
        
        //Recherche la randonnée
        switch(ucfirst($randonnee->region)){
            case 'Bas-Valais':
                $randonnee->region = 'Bas';
                break;
            case 'Valais centrale':
                $randonnee->region = 'Centre';
                break;
            case 'Haut-Valais':
                $randonnee->region = 'Haut';
                break;
        }
        
        //Difficulté
        $randonnee->difficulte = $data->sheets[0]['cells'][$x][9];
        //Modification de la difficulté
        switch(ucfirst($randonnee->difficulte)){
            case 'Facile':
                $randonnee->difficulte = 2;
                break;
            case 'Moyen':
                $randonnee->difficulte = 3;
                break;
            case 'Difficile':
                $randonnee->difficulte = 4;
                break;
        }
        
        //Durée
        $randonnee->duree = $data->sheets[0]['cells'][$x][11];
        
        //Lieu de départ
        $randonnee->lieuDepart = mysql_escape_string($data->sheets[0]['cells'][$x][16]);
        
        //Lieu d'arrivée
        $randonnee->lieuArrivee = mysql_escape_string($data->sheets[0]['cells'][$x][17]);
        
        //Code du programme
        $randonnee->codeprogramme = $data->sheets[0]['cells'][$x][20];
        
        //Status de la randonnée
        $randonnee->status = true;
        
        //Insertion de la porposition dans la base de données
        $randonnee->insertProposition();
        $x++;
    }
    
    //redirection vers la page des randonnées
    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=GestionRando.php?min=0&max=30' />";

?>