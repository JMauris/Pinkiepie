<?php
    //Connexion à la base de données
    function connexionDB(){

        //Connexion à la base de données - si erreur -> message SQL
        $lien = mysql_connect("localhost", "userCas", "casMontana2013") or die ('Erreur: ' . mysql_error());

        //Choix de la DB - Si erreur, affichage du message d'erreur
        mysql_select_db("CasMontana") or die ('Erreur: ' . mysql_error());

        return $lien;
    }//Fin connectionDB()

    //Exécution d'une requête SQL
    function executeSQL($strSQL)
    {
        //Exécution de la requête et récupération de l'état
        $SQLQuery = mysql_query($strSQL);

        //La requête ne passe pas
        if($SQLQuery == 0){
            $message = "Erreur SQL: " . mysql_error() . "<br>\n";
            $message .= "SQL string: " . $strSQL . "<br>\n";
            die($message);
        }

        //Si la requête passe, renvoyer son résultat
        return $SQLQuery;
    }//Fin de executeSQL

    //Déconnexion de la base de données
    function deconnexionDB(){
        //fermeture de la conenxion
        mysql_close();
    }
    
    /***********  Convertion d'int en String **********/
    function getNumberInString($string)
    {
        //Comparaison afin d'être sûr d'avoir des chiffres
        preg_match_all('/[0-9]+/',$string,$matches);
        $values = array_shift($matches);
        $lastnum = array_pop($values);

        //renvoi le dernier numéro
        return $lastnum;
    }

    /***********  Récupération de l'id du genre de tour **********/
    function getGenreTourId($genreTour){
        
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $requete = 'SELECT idGenretour FROM genretour WHERE genretour_fr = "' . $genreTour . '"';

        //exécution de la requête
        $id = executeSQL($requete);
        
        //Retourne l'id
        return $id;

    }

    /***********   RÉCUPÉRATION DE L'ID DE LA RÉGION **********/
    function getRegionId($region){
        //Connexion à la base de données
       $myConnexion = connexionDB();

       //Requête SQL
       $requete = 'SELECT idRegion FROM region WHERE region_fr = "' . $region . '"';

       //Exécution de la requête SQL
       $id = executeSQL($requete);
       
       //retourne l'identifiant
       return $id;

    }

    /***********   RÉCUPÉRATION DU CODE LANGUE **********/
    function getCodeLangue($langue){
        //Connexion à la base de données
       $myConnexion = connexionDB();

       //Requête SQL
       $requete = "SELECT codelangue FROM langue WHERE langue = '$langue'";

       //Exécution de la requête
       $codeLangue = mysql_fetch_array(executeSQL($requete));
       
       //Retourne le code langue
       return $codeLangue[0];

    }

    /***********   CONTRÔLE SI LA LOCALITE EXISTE **********/
    function checkLocalite($npa, $localite){
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $requete = "select count(npa) from localite where npa = $npa and localite = '$localite'";
        $nbLocalite = mysql_fetch_array(executeSQL($requete));

        //Si la localité est inconnue, ajout dans la base de données
        if($nbLocalite[0] == 0){
            //insert la nouvelle localité
            $requete = "insert into localite (npa, localite) values ($npa, '$localite')";
            executeSQL($requete);
        }
        
        //Déconnexion de la base de données
        //deconnexionDB();

    }

    /***********   CONNEXION ENTANT QUE MEMBRE **********/
    function connexionMembre($email, $mdp){
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $query = 'SELECT nom, prenom FROM personne WHERE email like "' . $email . '" 
                  AND motdepasse = "' . sha1($mdp) .'" AND numMembre is not null';

        //Exécution de la requête
        $resultat = executeSQL($query);

        //Déconnexion de la base de données
        deconnexionDB();
        
        //Retourne le résultat de la requête
        return $resultat;
    }
    
        /***********   CONNEXION ENTANT QU'ADMINISTRATEUR **********/
    function connexionAdmin($email, $mdp){
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
				/* Sabine Mathieu : Ajout gestion du rôle admin, 
				insertion dans la db d'une colonne supplémentaire 
				en dernier de la table 'personne' avec le nom 'role' 
				et contenu 'admin' pour les administrateurs du site,
				sinon 'NULL'*/
        //MAE - enlever Admin
        $query = 'SELECT nom, prenom, role FROM personne WHERE email like "' . $email . '" 
                  AND motdepasse = "' . sha1($mdp) .'"';

        //Exécution de la requête
        $resultat = executeSQL($query);

        //Déconnexion de la base de données
        deconnexionDB();
        
        //Retourne le résultat de la requête
        return $resultat;
    }

    /***********   LISTE DES RANDONNEES à VENIR **********/
    function getRandonnees($jour, $mois, $annee){
        //Mise en forme de la valeur du mois
        if($mois < 10)
            $mois = '0' . $mois;

        //récupère toutes les randonnées pour le mois sélecitonné
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $requete = " SELECT distinct idTour, `dateDebut` ,  `dateFin` ,  `titre` , genretour_fr, soustitre
                    FROM tour, typetour, genretour, tourgenretour
                    WHERE idxTypeTour = idTypeTour
                    and idxTour = idTour
                    AND idxGenreTour = idGenreTour
                    AND idxTypeTour = 1
                    AND dateDebut > '$annee-$mois-$jour'
                    AND status = 1
                    ORDER BY dateDebut";
        //Exécution de la requête SQL
        $randonnees = executeSQL($requete);
        
        //Déconnexion de la base de données
        deconnexionDB();

        //Retourne le liste des randonnées
        return $randonnees;
    }

    /***********   RÉCUPÉRATION DU GENRE DE LA RANDONNEE **********/
    function getGenresRandonnees($langue){
        //récupère toutes les randonnées pour le mois sélecitonné
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $requete = "SELECT IdGenreTour, genreTour_" . $langue . " FROM genretour order by genreTour_" . $langue ." asc";
        
        //Exécution de la requête
        $randonnees = executeSQL($requete);
        
        //Déconnexion de la base de données
        deconnexionDB();

        //Affichage du genre des randonnées
        return $randonnees;
    }

    /***********  RÉCUPÉRATION DU TYPE DE RANDONNEE **********/
    function getTypesRandonnees($langue){
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $requete = "SELECT IdTypeTour, typeTour_" . $langue . " FROM typetour order by typeTour_" . $langue ." asc";

        //Exécution de la requête
        $randonnees = executeSQL($requete);
        
        //Déconnexion de la base de données
        deconnexionDB();

        //Affichage du type de la randonnée
        return $randonnees;
    }

    /***********   SUPPRESSION D'UNE RANDONNEE **********/
    function suppressionRando($id){
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $requete = "DELETE FROM tour WHERE IdTour = $id";
        
        //Exécution de la requête SQL
        $randonnees = executeSQL($requete);
        
        //Déconnexion de la base de données
        deconnexionDB();

    }

    /***********   LISTE DES ABONNEMENTS **********/
    function getAbonnements($langue){

        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $requete = "Select idAbonnement, abonnement_" . $langue . " FROM abonnement";
        
        //Exécution de la requête SQL
        $abos = executeSQL($requete);

        //Déconnexion de la base de données
        deconnexionDB();

        //Retourne la liste des abonnements
        return $abos;        
    }

    /***********   LISTE DES PROCHAINES RANDONNEES **********/
    function ProchainesRandonnees($nombre, $role, $nom){

        //Récupération de la date actuelle
        $date = Date("Y-m-d");

        //Connexion à la base de données
        $connexion = connexionDB();

        //Requête SQL
        $requete = "Select idtour, titre, datedebut, datefin, idxtypetour,
                duree, difficulte, lieuRDV, idxdepartlocalite, idxarriveelocalite, montee, descente
                    from tour 
										where datedebut > '$date'";
				//MAE - uniquement chef de course
				if($role == 'chef'){
					$requete .= " and idxGuide like '$nom'";
				}
				$requete .= " order by datedebut limit 0,$nombre";

        //Exécution de la requête SQL
        $listeRandonnees = executeSQL($requete);

        //Déconnexion de la base de données
        deconnexionDB();

        //Retourne la liste des randonnées
        return $listeRandonnees;

    }

    /***********   LISTE DES RANDONNEES POUR UNE PERSONNE **********/
    function listeRandonneesPourPersonne($idpersonne){
        //Connexion à la base de données
        $connexion = connexionDB();

        //Requête SQL pour récupérer les randonnées à venir
        $requete = "select titre, datedebut, idtour from tour, inscription 
                    where idtour = idrandonnee
                    and idpersonne = $idpersonne
                    and datedebut >= '" . Date("Y-m-d") . "'
                    and idxStatus = 1
                    order by datedebut asc";

        //Exécution de la requête SQL
        $randosFuture = executeSQL($requete);

        //Récupération des inscriptions passées
        $requete = "select titre, datedebut, idtour from tour, inscription where idtour = idrandonnee
                    and idpersonne = $idpersonne
                    and datedebut < '" . Date("Y-m-d") . "'
                    and idxStatus = 1
                    order by datedebut desc";

        //Exécution de la requête SQL
        $randosPasse = executeSQL($requete);
        
        //Création d'un tableau pour stocker les différents résultats
        $randos = array();
        $randos[0] = $randosFuture;
        $randos[1] = $randosPasse;

        //Déconnexion de la base de données
        deconnexionDB();

        //Retourne les listes d'inscriptions
        return $randos;
    }

    /***********   LISTE DES REGIONS **********/
    function getListeRegions($langue){
        //Connexion à la base de données
        $connexion = connexionDB();

        //Requête SQL
        $requete = "Select idRegion, region_" . $langue . " from region";

        $listeRegions = executeSQL($requete);

        deconnexionDB();

        return $listeRegions;
    }

    /***********   LISTE DES GENRES DE RANDONNEES **********/
    function getListeGenre($langue){
        //Connexion à la base de données
        $connexion = connexionDB();

        //Requête SQL
        $requete = "Select idGenretour, genretour_" . $langue . " from genretour";

        $listeRegions = executeSQL($requete);

        deconnexionDB();

        return $listeRegions;
    }

    /***********   LISTE DE TOUTES LES PROPOSITIONS **********/
    function listePropositionsRando($langue){

        //Connexion à la base de données
        $connexion = connexionDB();

        //Requête SQL
        $requete = "select idTour, titre, description_" . $langue . ", region_" . $langue . "
                    from tour, region, tourregion
                    where idtour = idxtour
                    and idregion = idxregion
                    and idxtypetour = 6";

        $listeRandos = executeSQL($requete);

        deconnexionDB();

        return $listeRandos;


   }

   /***********   Recherche une randonnée **********/
   function rechercheRando($langue, $difficulte, $region, $type, $propo){

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
                    "order by datedebut";

        $listeRandos = executeSQL($requete);

        deconnexionDB();

        return $listeRandos; 
   }

   /***********   Ajout d'une évaluation pour une personne **********/
   function insertRating($personne, $tour, $note){
       //Connexion à la base de données
       $connexion = connexionDB();

       $requete = "select count(idpersonne) from favoris where idpersonne = $personne and idtour = $tour";

       $favorisExiste = mysql_fetch_array(executeSQL($requete));

       if($favorisExiste[0] == 0){
           //Requête SQL
           $requete = "insert into favoris (idpersonne, idtour, evaluation)
                       values($personne, $tour, $note)";
       }
       else{
           //Requête SQL
           $requete = "update favoris set
                       evaluation = $note
                       where idpersonne = $personne
                       and idtour = $tour";
       }

       executeSQL($requete);

       //Déconnexion de la base de données
       deconnexionDB();

       return $requete;
   }

   /***********   Liste des favoris pour une personne **********/
   function favorisPersonne($id){
       //connexion à la base de données
       $connexion = connexionDB();

       //requête SQL
       $requete = "select tour.idtour, titre from tour, favoris
                   where favoris.idtour = tour.idtour
                   and idpersonne = $id
                   and estFavoris = 1
                   and idxtypetour != 6";

       $listeRando = executeSQL($requete);

       //Deconnexion DB
       deconnexionDB();

       return $listeRando;
   }

   /***********   Evaluation réalisée par une personne **********/
   function evaluationsPersonne($id){
        //connexion à la base de données
       $connexion = connexionDB();

       //requête SQL
       $requete = "select tour.idtour, titre, evaluation
                   from tour, favoris
                   where favoris.idtour = tour.idtour
                   and idpersonne = $id
                   and idxtypetour = 6
                   and evaluation != ''";

       $listeRando = executeSQL($requete);

       //Deconnexion DB
       deconnexionDB();

       return $listeRando;
   }

   function favorisPropoPersonne($id){
       //connexion à la base de données
       $connexion = connexionDB();

       //requête SQL
       $requete = "select tour.idtour, titre from tour, favoris
                   where favoris.idtour = tour.idtour
                   and idpersonne = $id
                   and estFavoris = 1
                   and idxtypetour = 6";

       $listeRando = executeSQL($requete);

       //Deconnexion DB
       deconnexionDB();

       return $listeRando;

   }
   /***********   LISTE DES SÉJOURS à VENIR **********/    
    function rechercherMotPasse($email){
        //Connexion à la base de données
        $connexion = connexionDB();

        //Requête SQL
        $requete = "select idpersonne, nom, prenom from personne
                    where email like '$email'
                    and nummembre != ''";
       
        
        $infosPersonne = mysql_fetch_array(executeSQL($requete));

        
        if($infosPersonne[0] != ''){
        
            //Création du tableau d'informations
            $memberInfo[0] = "valrando" . rand(0, 999);
            $memberInfo[1] = $infosPersonne[1];
            $memberInfo[2] = $infosPersonne[2];
            
            //requête SQL
            $requete = "update personne set
                        motdepasse = '" . sha1($memberInfo[0]) . "'
                        where idpersonne = $infosPersonne[0]";
            
            executeSQL($requete);
            
        }
        else{
            $memberInfo = 'non-membre';
        }
        
        
        //Déconnexion de la base de données
        deconnexionDB();
        
        //Retourne les informations recherchées
        return $memberInfo;
   }
   
   /***********   LISTE DES SÉJOURS à VENIR **********/
   function getSejours($jour, $mois, $annee){

        if($mois < 10)
            $mois = '0' . $mois;

        //récupère toutes les randonnées pour le mois sélecitonné
        //Connexion à la base de données
        $myConnexion = connexionDB();

        //Requête SQL
        $query = " SELECT distinct idTour, `dateDebut` ,  `dateFin` ,  `titre` , genretour_fr, soustitre
                    FROM tour, typetour, genretour, tourgenretour
                    WHERE idxTypeTour = idTypeTour
                    and idxTour = idTour
                    AND idxGenreTour = idGenreTour
                    AND idxTypeTour = 2
                    AND dateDebut > '$annee-$mois-$jour'
                    AND status = 1
                    ORDER BY dateDebut";
        $randonnees = executeSQL($query);

        return $randonnees;
    }
    
    /***********   LISTE DES 10 meilleurs randonneurs **********/
    function top10Randonneurs(){
        //connexion à la base de données
        $connexion = connexionDB();
        
        $dateJour = date("Y-m-d");
        $debutAnnee = date("Y") . "-01-01";
        
        //requête SQL
        $requete = "select nom, prenom, adresse, npa, localite, email, telephone, portable, count(idrandonnee)
                    from personne, inscription, tour
                    where personne.idpersonne = inscription.idpersonne
                    and idrandonnee = idtour
                    and datedebut < '$dateJour'
                    and datedebut > '$debutAnnee'
                    group by personne.idpersonne
                    order by count(idrandonnee) desc, nom, prenom
                    LIMIT 0,10";
        
        $listeRandonneurs = executeSQL($requete);
        
        //Deconnexion Base de données
        deconnexionDB();
        
        return $listeRandonneurs;
    }
    
    //log des informations sur l'envoi des messages
    function logMessage($msgFR, $msgDE, $nbMessages, $randonneeId){
        //connexion à la base de données
        $connexion = connexionDB();
        
        //Récupération de la date
        $date = date("Y-m-d");
        
        //Requête SQL
        $requete  = "insert into logmessages (idrandonnee, message_fr, message_de, nombremessages, dateenvoi)
                    values ($randonneeId, '" . mysql_real_escape_string(utf8_decode($msgFR)) . "', '" . mysql_real_escape_string(utf8_decode($msgDE)) . "',
                        $nbMessages, '$date')";
        executeSQL($requete);
        
        //Déconnexion de la base de données
        deconnexionDB();
    }
    
    //Récupère les 10 dernières entrées dans le log
    function recupereLogs(){
        //connexion à la base de données
        $connexion = connexionDB();
        
        //Requête SQL
        $requete  = "select dateenvoi, titre, nombremessages
                     from logmessages, tour
                     where idrandonnee = tour.idtour
                     order by dateenvoi desc
                     limit 0,10";
        $messagesLogs = executeSQL($requete);
        
        //Déconnexion de la base de données
        deconnexionDB();
        
        return $messagesLogs;
    }
?>
