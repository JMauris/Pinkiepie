<?php

include('../include/fonctions.inc.php');
$propo = 2;

$listeRando = rechercher("fr","all","all","all",$propo);


echo "<ul>";
    while($ligne = mysql_fetch_array($listeRando)){
        echo "<li>\n";
        echo "<strong>".utf8_encode($ligne[1])."</strong>";
        echo "<p>\n";
        $date = explode("-", $ligne[3]);

        if($date[2] != '')
            $date = $date[2] . "." . $date[1] . "." . $date[0] . ": ";

        $heureDep = '';
        if($ligne[4] != '00:00:00' || $ligne[4] != '')
            $heureDep = $ligne[4] . " - " . $ligne[5];

        echo $date . $heureDep;
        echo "</p>\n";

    }
echo "</ul>";



function rechercher($langue, $difficulte, $region, $type, $propo){
    //return $propo;

        //Connexion à la base de données
        $connexion = connexionDB();

        //Récupération de la date
        $date = Date("Y-m-d");
        //Date dans un an
        $dateMax = date("Y-m-d", strtotime(date("Y-m-d") . " +1 year"));

        //Région définie?
        $reqRegion = '';
        if($region != 'all')
            $reqRegion = "and idxregion = $region ";

        //Difficulté définie?
        $reqDifficulte = '';
        if($difficulte != 'all')
            $reqDifficulte = "and difficulte = $difficulte ";

        //Type de randonnée défini?
        $reqType = '';
        if($type != 'all')
            $reqType = "and idxgenretour = $type ";

        //Genre de randonnée défini
        $typeTour = "and idxtypetour = " . $propo . " and datedebut >= '$date' and datedebut <= '$dateMax' ";
        if($propo == "oui")
            $typeTour = "and idxtypetour = 6 ";

        //Requête SQL
        $requete = "select idtour, titre, difficulte, datedebut, departheure, arriveeheure
                    from tour, region, tourregion, tourgenretour
                    where tour.idtour = tourregion.idxtour
                    and idregion = idxregion
                    and tour.idtour = tourgenretour.idxtour " .
                    $typeTour .
                    $reqRegion . 
                    $reqDifficulte .
                    $reqType .
                    "order by datedebut
                        limit 5";

        $listeRandos = executeSQL($requete);

        deconnexionDB();

        return $listeRandos; 
   }

/*
$dateMax = date("Y-m-d");
echo $dateMax;
echo "<br/>";
        $dateMax = date("Y-m-d", strtotime(date("Y-m-d") . " +1 year"));
        echo $dateMax;
        
        echo "<br/>";*/
        

/*
$nom = "admin";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "bernard";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "augustine";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "charles";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "pauline";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "simon";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "aline";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "benjamin";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "raoul";
echo $nom . " : " . sha1($nom);
echo "<br/>";
$nom = "jacques";
echo $nom . " : " . sha1($nom);*/
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
