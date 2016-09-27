<?php
session_start();
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Fichier parcourant le fichier Excel du programme afin de tout
    *           ajouter dans la base de données
    ***************************************************************************/
//Ajout du ExcelReader
require_once ('../../ExcelReader/Excel/reader.php');
require_once ('../../BusinessObject/randonnees.php');
require_once ("../../include/fonctions.inc.php");
require_once ('../../BusinessObject/personne.php');


//Ouverture du fichier
$data = new Spreadsheet_Excel_Reader();
$data->read($_FILES['programmeRando']['tmp_name']);

//Lecture du fichier
    //number of sheets
    echo "sheets: " . sizeof($data->sheets) . "<br />\n";
    echo "Number of rows in sheet 1" . ": " . $data->sheets[0]["numRows"] . "<br />\n";
    echo "Number of columns in sheet 1" . ": " . $data->sheets[0]["numCols"] . "<br />\n";
 
    //Ajout des randonnées
    echo "<h1>Randonnées</h1>";
    $x = 7; 
    $randonnee = new randonnee();
    while($x<=$data->sheets[0]['numRows']) {
     
       //Si la date n'est pas vide
       if(is_numeric($data->sheets[0]['cells'][$x][3]) && $data->sheets[0]['cells'][$x][3] != null){
           
          //Date
          $randonnee->date = date("Y-m-d",($data->sheets[0]['cells'][$x][3] - 25569) * 86400);
          
          //Si le genre est défini
          if(strlen($data->sheets[0]['cells'][$x][4]) != 0){
            
            //Genre
            $randonnee->genre = str_replace(' / ',';',$data->sheets[0]['cells'][$x][4]);
            $genres = explode(';', $randonnee->genre);
            
          }
          
          //Si le genre n'est pas cyclotourisme
          if($randonnee->genre != 'cyclotourisme'){
            //Difficulté
            $randonnee->difficulte = strlen($data->sheets[0]['cells'][$x][6]);
            
            //montée
            $randonnee->montee = str_replace("\n", ";",$data->sheets[0]['cells'][$x][7]);
            
            //Descente
            $randonnee->descente = str_replace('\n', ';', $data->sheets[0]['cells'][$x][8]);
            
            //Durée
            $randonnee->duree = str_replace("\n", ";",$data->sheets[0]['cells'][$x][9]);
          }
          
          //Code Programme
          $randonnee->codeprogramme = $data->sheets[0]['cells'][$x][5];
          
          //Région
          $randonnee->region = mysql_escape_string(str_replace(' + ', ';', $data->sheets[0]['cells'][$x][10]));

          //Titre
          $titre = str_replace("\n", ";",$data->sheets[0]['cells'][$x][11]);          
          $titre = explode(';', $titre);
          $randonnee->titre = mysql_escape_string($titre[0]);
          
          //Sous-titre
          if(isset($titre[1]))
              $randonnee->soustitre = mysql_escape_string ($titre[1]);
          
          //Chef de course et assistant
          $randonnee->chefCourse =  mysql_escape_string($data->sheets[0]['cells'][$x][12]);
          $randonnee->assistant =  mysql_escape_string($data->sheets[0]['cells'][$x][13]);
          
          //Lieu de départ et lieu d'arrivée
          if(strpos($data->sheets[0]['cells'][$x][14], "\n")){
              $randonnee->lieuDepart = mysql_escape_string(strstr($data->sheets[0]['cells'][$x][14], "\n", TRUE));
              $randonnee->lieuArrivee = mysql_escape_string(strstr($data->sheets[0]['cells'][$x][14], "\n"));
          }
          else{
             $randonnee->lieuDepart = mysql_escape_string($data->sheets[0]['cells'][$x][14]); 
          }
          
          //Lieu de départ et d'arrivée pour le transport
          $randonnee->departTransport = str_replace("/;","/",str_replace("\n",";", $data->sheets[0]['cells'][$x][15]));
          $randonnee->arriveeTransport = str_replace("/;","/",str_replace("\n",";", $data->sheets[0]['cells'][$x][16]));
          $randonnee->departTransport = mysql_escape_string($randonnee->departTransport);
          $randonnee->arriveeTransport = mysql_escape_string($randonnee->arriveeTransport);
          
          //Lieu de rendez-vous
          $randonnee->rdv = $data->sheets[0]['cells'][$x][17];
          
          //En train ou en bus?
          if(strstr(ucfirst ($randonnee->rdv),'Gare')){
              if(strstr(ucfirst ($randonnee->rdv),'Gare rout'))
                $randonnee->typeTransport = 'Bus';
              else
                $randonnee->typeTransport = 'Train';
          }
          else{
              $randonnee->typeTransport = 'Autre';
          }
          
          //Heure de départ et heure d'arrivée
          $randonnee->heureDepart = str_replace(' h ',':', $data->sheets[0]['cells'][$x][18]);
          $randonnee->heureArrivee = str_replace(' h ',':', $data->sheets[0]['cells'][$x][19]);
          
          //Prix de la randonnée
          if(strpos($data->sheets[0]['cells'][$x][20], "/")){
              $randonnee->prixMin = getNumberInString(strstr($data->sheets[0]['cells'][$x][20], "/", TRUE));
              $randonnee->prixMax = getNumberInString(strstr($data->sheets[0]['cells'][$x][20], "/"));
          }
          else{
             $randonnee->prixMin = getNumberInString($data->sheets[0]['cells'][$x][20]); 
             $randonnee->prixMax = 0;
          }
          
          if(strlen($randonnee->prixMin) == 0)
                  $randonnee->prixMin = 0;
          
          //Nombre maximum d'inscription
          $randonnee->inscriptionMax = getNumberInString($data->sheets[0]['cells'][$x][21]);
          
          //Passage au bon format des informations
          $randonnee->info_fr = mysql_escape_string(strstr($data->sheets[0]['cells'][$x][22], "/", TRUE));
          $randonnee->info_de = mysql_escape_string(str_replace("/\n", "",strstr($data->sheets[0]['cells'][$x][22], "/")));
          $randonnee->typeTour = 1;
          $randonnee->status = true;
          //Ajout dans la base de données
          $randonnee->insertNouvelleRando();
          
       }
       //Nouvelle randonnée
      $randonnee = new randonnee();
      $x++;
    }
    
    //AJOUT DES SÉJOURS DANS LA BASE DE DONNÉES
    echo "<h2>Séjours</h2>";
    $randonnee = new randonnee();
    
    //Évite les en-têtes
    $x = 5;
    
    //Parcours toutes les séjours
    while($x<=$data->sheets[1]['numRows']) {
        //Si la date est définie -> ajout des informations
        if($data->sheets[0]['cells'][$x][3] != null){
          //Date de début
          $randonnee->date = str_replace(" " , "",strstr($data->sheets[1]['cells'][$x][3], " / ", true));
          //Date de fin
          $randonnee->datefin = str_replace(" / ", "", strstr($data->sheets[1]['cells'][$x][3], " / "));
          
          //Format de la date de début
          $dateDebut = explode(".",$randonnee->date);
          $randonnee->date = "20" . $dateDebut[2] ."-" . $dateDebut[1] . "-" . $dateDebut[0];
          
          //Format de la date de fin
          $dateFin = explode(".",$randonnee->datefin);
          $randonnee->datefin = "20" . $dateFin[2] ."-" . $dateFin[1] . "-" . $dateFin[0];
          
          //Si le genre de la randonnée est précisé
          if(strlen($data->sheets[1]['cells'][$x][4]) != 0){
              //récupération du genre
              $randonnee->genre = html_entity_decode(str_replace(' / ',';',$data->sheets[1]['cells'][$x][4]));              
            
          }
          
          //Code Programme
          $randonnee->codeprogramme = $data->sheets[0]['cells'][$x][5];
          
          //Si le genre n'est pas cyclotourisme
          if($randonnee->genre != 'cyclotourisme'){
            //difficulté
            $randonnee->difficulte = strlen($data->sheets[1]['cells'][$x][6]);
            
            //Dénivelé
            $randonnee->montee = 0;
            $randonnee->descente = 0;
            
            //Durée
            $randonnee->duree = str_replace("\n", ";",$data->sheets[1]['cells'][$x][9]);
          }
          //région
          $randonnee->region = mysql_escape_string(str_replace(' + ', ';', $data->sheets[1]['cells'][$x][10]));
          
          //Participants
          $randonnee->chefCourse =  mysql_escape_string($data->sheets[1]['cells'][$x][12]);
          $randonnee->assistant =  mysql_escape_string($data->sheets[1]['cells'][$x][13]);
          
          //Titre
          $titre = str_replace("\n", ";",$data->sheets[1]['cells'][$x][11]);          
          $titre = explode(';', $titre);
          $randonnee->titre = mysql_escape_string($titre[0]);
          
          //Sous-titre
          if(isset($titre[1]))
              $randonnee->soustitre = mysql_escape_string ($titre[1]);
          
          //Lieu de départ et d'arrivée
          if(strpos($data->sheets[0]['cells'][$x][14], "\n")){
              $randonnee->lieuDepart = mysql_escape_string(strstr($data->sheets[1]['cells'][$x][14], "\n", TRUE));
              $randonnee->lieuArrivee = mysql_escape_string(strstr($data->sheets[1]['cells'][$x][14], "\n"));
          }
          else{
             $randonnee->lieuDepart = mysql_escape_string($data->sheets[1]['cells'][$x][14]);
             $randonnee->lieuArrivee = mysql_escape_string($data->sheets[1]['cells'][$x][14]);
          }
          
          //transport
          $randonnee->departTransport = '';
          $randonnee->arriveeTransport = '';
          
          //Type de transport
          $randonnee->rdv = $data->sheets[1]['cells'][$x][17];
          if(utf8_encode($randonnee->rdv) == 'Gare routière'){
              $randonnee->typeTransport = 'Bus';
          }
          else if(strstr(ucfirst ($randonnee->rdv), 'Gare')){
              $randonnee->typeTransport = 'Train';
          }
          else{
              $randonnee->typeTransport = 'Autre';
          }
          
          //Heure de départ et heure d'arrivée
          $randonnee->heureDepart = '00:00';
          $randonnee->heureArrivee = '00:00';
          
          //Prix
          if(strpos($data->sheets[1]['cells'][$x][20], "/")){
              $randonnee->prixMin = getNumberInString(strstr($data->sheets[1]['cells'][$x][20], "/", TRUE));
              $randonnee->prixMax = getNumberInString(strstr($data->sheets[1]['cells'][$x][20], "/"));
          }
          else{
             $randonnee->prixMin = getNumberInString($data->sheets[1]['cells'][$x][20]); 
             $randonnee->prixMax = 0;
          }
          
          if(strlen($randonnee->prixMin) == 0)
                  $randonnee->prixMin = 0;
          
          //Inscriptions maximum
          $randonnee->inscriptionMax = getNumberInString($data->sheets[1]['cells'][$x][21]);
          
          //Informations sur la randonnée
          $randonnee->info_fr = mysql_escape_string(strstr($data->sheets[1]['cells'][$x][22], "/", TRUE));
          $randonnee->info_de = mysql_escape_string(str_replace("/\n", "",strstr($data->sheets[1]['cells'][$x][22], "/")));
          $randonnee->typeTour = 2;
          $randonnee->status = 1;
          
          $randonnee->insertNouvelleRando();
          
       }
      $randonnee = new randonnee();
      $x++;
        
    }
    
    //redirection vers la page des randonnées
    echo "<META HTTP-EQUIV='refresh' CONTENT='0;URL=GestionRando.php?min=0&max=30' />";
?>
