<?php
    //Ajout des fichiers nécessaires au bon fonctionnement de l'application
    include("fonctions.inc.php");
    
    //Si le terme de la recherche pour la liste des localités est rempli
    if(isset($_GET['term'])){
        
        //Récupération de la variable
        $recherche = ucfirst($_GET['term']);
        
        
        //connexion à la base de données
        $connexionDB = connexionDB();
        
        //Requête SQL
        $requete = "select localite from localite where localite like '$recherche%'";
        
        //Exécution de la requête SQL
        $localitesDB = executeSQL($requete);
        
        //Création d'un tableau contenant toutes les localité
        $x = 0;
        while($ligne = mysql_fetch_array($localitesDB)){
            
            $localites[$x] = array("localite" => $ligne[0]);
            
            $x++;
        }
        
        //Renvoi le tableau de localité dans un format JSON
        $reponse = $_GET["callback"] . "(" . json_encode($localites) . ")";  
        echo $reponse; 
        
        deconnexionDB();
    }
    
    //Insertion d'un favoris
    if(isset($_GET['idRandonnee']) && isset($_GET['idPersonne'])){
        
        //Connexion à la base de données
        $connexion = connexionDB();
        
        //déjà une entrée pour ce membre avec cette rando dans la db?
        $requete = "select count(idpersonne) from favoris where idpersonne = " .$_GET['idPersonne'] . " 
            and idtour = " . $_GET['idRandonnee'];
        $nbentrees = mysql_fetch_array(executeSQL($requete));
        
        //Ajout dans la base de données
        if($nbentrees[0] == 0){
            $requete = "insert into favoris (idpersonne, idtour, estfavoris)
                        values(". $_GET['idPersonne'] . "," . $_GET['idRandonnee'] . ", 1)";
        }
        //Sinon, modification du favoris
        else{
            $requete = "update favoris set
                        estfavoris = 1
                        where idpersonne = " . $_GET['idPersonne'] . "
                        and idtour = " . $_GET['idRandonnee'];
        }
        
        executeSQL($requete);
        
        return $requete;
        //Déconnexion de la base de données
        deconnexionDB();
        
    }
    
    //Récupération du nom de la localité
    if(isset($_GET['longitude'])){
        
        //Récupération des variables
        $long = $_GET['longitude'];
        $lat = $_GET['latitude'];
        
        //Lien pour récupérer la localité
        $lien = 'http://maps.googleapis.com/maps/api/geocode/xml?latlng=' . $lat . ',' . $long . '&sensor=true';
        
        //Récupération des données et mise en place d'un fichier XML
        $donnees = file_get_contents($lien);
        $xml = new SimpleXMLElement($donnees);

        //Récupération du code postal
        if(isset($xml->result->formatted_address)){
            $adresse = $xml->result->formatted_address;
            $adresse = explode(",", $adresse);
            $return = substr($adresse[1],1);
        }
        else
            $return = "empty";
        
        //Retourne le code postal
        echo $return;
    }
    
    
    //Récupération du NPA de la localité
    if(isset($_GET['npaLocalite'])){
        
        //Récupération des variables
        $npa = $_GET['npaLocalite'];
        
        //Connexion à la base de données
        $connexion = connexionDB();
        
        //Préparation des variables pour la requête
        $adresse = explode(" ", $npa,2);
        
        //Requete pour récupérer la localité et la région
        $requete = "select idxRegion from localite where localite like '$adresse[1]' and npa like $adresse[0]";
        
        $localite = mysql_fetch_array(executeSQL($requete));
        
        //retourne l'identifiant de la région
        echo $localite[0];
    }
    
    //Récupération du code de la région pour l'affichage de la liste des randonnées dans la région
    if(isset($_GET['codeRegion'])){
        //Variables pour le code de la région
        $region = $_GET['codeRegion'];
        $typeRando = $_GET['rando'];
        
        //Récupération de la date
        $date = Date("Y-m-d");
        //Date dans un an
        $dateMax = date("Y-m-d", strtotime(date("Y-m-d") . " +1 year"));
        
        //Connexion à la base de données
        $connexion = connexionDB();
        
        if($typeRando == 6)
            //Requête pour récupérer les randonnées dans la région
            $requete = "select titre, idxtypetour, idtour from tour, tourregion
                        where idxregion like $region
                        and idxtour = idtour
                        and idxtypetour = $typeRando";
        else
            //Requête pour récupérer les randonnées dans la région
            $requete = "select titre, idxtypetour, idtour from tour, tourregion
                        where idxregion like $region
                        and datedebut <= '$dateMax'
                        and datedebut >= '$date'
                        and idxtour = idtour
                        and idxtypetour = $typeRando";
        
        $listeRandos = executeSQL($requete);
        $liste = "";
        
        //Création de la liste des propositions
        while($ligne = mysql_fetch_array($listeRandos)){
       
            $liste .= '<li data-corners="false" data-shadow="false" data-iconshadow="true" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" data-theme="e" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-hover-e">';
            $liste .= '<div class="ui-btn-inner ui-li"><div class="ui-btn-text">';
            
            //Mise en place du lien (proposition ou randonnée)
            if($typeRando == 6){
                $liste .= '<a href="detailProposition.php?id=' . $ligne[2] . '" rel="external" class="ui-link-inherit">';
            }
            else{
                $liste .= '<a href="detailRandonnee.php?id=' . $ligne[2] . '" rel="external" class="ui-link-inherit">';
            }
            
            
            $liste .= "<h3 class='ui-li-heading'>" . utf8_encode($ligne[0]) . "</h3>\n";
            
            $liste .= '</div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow">&nbsp;</span></div></li>';
        }
        
        echo $liste;
    }
    
    
    /****************   RECHERCHE EMAIL PERSONNE   **************************/
    if(isset($_GET['email'])){
        
        //Déclaration variable
        $email = $_GET['email'];
        
        //Connexion à la base de données
        $connexion = connexionDB();
        
        //Requête pour récupérer les informations provenant liées à l'adresse email
        $requete = "select nom, prenom, localite, idxabonnement, portable
                    from personne
                    where email like '$email'";
        $infosPersonne = mysql_fetch_array(executeSQL($requete));
        
        //Récupération des valeurs
        $nom = $infosPersonne[0];
        $prenom = $infosPersonne[1];
        $localite = $infosPersonne[2];
        $abo = $infosPersonne[3];
        $portable = $infosPersonne[4];
        
        //Retourne une chaîne de caractères contenant toutes les informations nécessaires
        $retour = utf8_encode($nom) . "<" . utf8_encode($prenom) . "<" . utf8_encode($localite) . "<" . $abo . "<" .$portable;
        
        echo $retour;
    }
    
     /****************   Suppression d'un favoris   **************************/
    if(isset($_GET['defavoris'])){
        
        //Déclaration variables
        $favoris = explode("_", $_GET['defavoris']);
        $randonnee = $favoris[0];
        $personne = $favoris[1];
        
        //Connexion à la base de données
        $connexion = connexionDB();
        
        //Requête pour passer la randonnée en non favorite
        $requete = "update favoris
                    set estfavoris = 0
                    where idpersonne = $personne
                    and idtour = $randonnee";
        executeSQL($requete);
    }
?>