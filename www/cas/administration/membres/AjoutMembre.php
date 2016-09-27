<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Fichier parcourant le fichier Excel des membres afin de les
    *           ajouter dans la base de données
    ***************************************************************************/
//Ajout du ExcelReader
require_once ('../../ExcelReader/Excel/reader.php');
require_once ('../../BusinessObject/personne.php');
require_once ('../../BusinessObject/localite.php');
require_once ("../../include/fonctions.inc.php");

//Ouverture du fichier
$data = new Spreadsheet_Excel_Reader();
echo $_FILES['listeMembres']['tmp_name'];
$data->read($_FILES['listeMembres']['tmp_name']);

//Lecture du fichier
    //Nombre de feuilles, de colones et lignes
    echo "sheets: " . sizeof($data->sheets) . "<br />\n";
    echo "Number of rows in sheet 1" . ": " . $data->sheets[0]["numRows"] . "<br />\n";
    echo "Number of columns in sheet 1" . ": " . $data->sheets[0]["numCols"] . "<br />\n";
 
    //évite les en-têtes
    $x = 8;
    
    //Création d'une nouvelle personne
    $membre = new personne();
    
    while($x<=$data->sheets[0]['numRows']){
        //Récupération des données dans la feuille excel
        //nom
        $membre->nom = mysql_escape_string($data->sheets[0]['cells'][$x][14]);
        //Prénom
        $membre->prenom = mysql_escape_string($data->sheets[0]['cells'][$x][13]);
        //Téléphone
        $membre->telephone = $data->sheets[0]['cells'][$x][5];
        //Numéro de membre
        $membre->numMembre = $data->sheets[0]['cells'][$x][11];
        //Téléphone portable
        $membre->portable = $data->sheets[0]['cells'][$x][6];
        //Adresse email
        $membre->email = $data->sheets[0]['cells'][$x][7];
        //Adresse
        $membre->adresse = mysql_escape_string($data->sheets[0]['cells'][$x][16] . " " . $data->sheets[0]['cells'][$x][17]);
        //Ville et Npa
        $membre->npa = $data->sheets[0]['cells'][$x][18];
        $membre->localite = mysql_escape_string($data->sheets[0]['cells'][$x][19]);
        
        //langue
        $membre->langue = mysql_escape_string($data->sheets[0]['cells'][$x][22]);
        
        //Membre actif?
        if($data->sheets[0]['cells'][$x][12] == 'non membre')
            $membre->estActif = 1;
        else
            $membre->estActif = 0;
        
        $membre->abonnement = 1;
        
        //Enregistrement des informations dans la base de données
        if($membre->numMembre != null){
            $membre->insertMembre();
            echo "test";
        }else{
            $membre->insertNonMembre();
            echo "test";
        }
        
        
        
        $membre = new personne();
        $x++;
    }
    
    //redirection vers la page des randonnées
    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=GestionMembres.php' />";
?>