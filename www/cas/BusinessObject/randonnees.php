<?php
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Classe permettant de gérer toutes les randonnées
    ***************************************************************************/

    Class randonnee{
        
        //Variables utilisées pour une randonnée
        public $id;
        public $date;
        public $datefin;
        public $genre;
        public $difficulte;
        public $montee;
        public $descente;
        public $duree;
        public $region;
        public $titre;
        public $soustitre;
        public $codeprogramme;
        public $status;
        public $chefCourse;
        public $assistant;
        public $lieuDepart;
        public $lieuArrivee;
        public $departTransport;
        public $arriveeTransport;
        public $rdv;
        public $heureArrivee;
        public $heureDepart;
        public $prixMin;
        public $prixMax;
        public $inscriptionMax;
        public $info_fr;
        public $info_de;
        public $desc_fr;
        public $desc_de;
        public $typeTour;
        public $typeTransport;
        public $carte;
        
        /************  INSERTION D'UNE RANDONNEE   **************************/
        function insertNouvelleRando(){
            
            //connexion à la base de données
            $myConnexion = connexionDB(); 
            
            //récupère l'ID du type de transport
            $requete = "select idtransport from transport where transport_fr like '$this->typeTransport'";
            $idTransport = mysql_fetch_array(executeSQL($requete));
            
            //Ajout des informations propres à la randonnée dans la base de données
            $requete = "INSERT INTO tour (datedebut, datefin, difficulte, montee, descente, duree, titre, 
            departheure, arriveeheure, prixmin, prixmax, inscriptionmax, information_fr, information_de,
            idxtypetour, idxdepartlocalite, idxarriveelocalite, transportdepart, transportarrivee, idxGuide,
            idxAssistant, codeprogramme, status, soustitre, idxtypetransport, lieuRDV) VALUES
            ('$this->date', '$this->datefin', $this->difficulte, '$this->montee', '$this->descente', '$this->duree',
             '$this->titre', '$this->heureDepart', '$this->heureArrivee', '$this->prixMin', '$this->prixMax',
             '$this->inscriptionMax', '$this->info_fr', '$this->info_de', $this->typeTour, '$this->lieuDepart',
             '$this->lieuArrivee', '$this->departTransport', '$this->arriveeTransport', '$this->chefCourse', 
             '$this->assistant', '$this->codeprogramme', '$this->status', '$this->soustitre', $idTransport[0], '$this->rdv')";
            
            //Exécution de la randonnée
            $informations_requete = executeSQL($requete);
            
            //Récupération de l'identifiant de la dernière randonnée ajoutée
            $id = mysql_insert_id();
            
            //Si la région est vide
            if($this->region == null)
                $this->region = 'Hors';
            
            //partage la liste des régions dans un tableau
            $regions = explode(';', $this->region);
            
            //Pour toutes les régions
            for($i=0; $i < sizeof($regions); $i++){
            
                ///Récupére l'identifiant de la région
                $idRegion = getRegionId(ucfirst($regions[$i]));
                $idRegion = mysql_fetch_array($idRegion);

                //Ajout dans la base de données
                $requete = "insert into tourregion (idxTour, idxRegion) values ($id, $idRegion[0])";
                $informations_requete = executeSQL($requete);
            }
            
            //Si le genre est vite
            if($this->genre == null)
                $this->genre = 'Autre';
            
            //Récupére la liste des genres
            $genres = explode(';', $this->genre);
            
            //Pour chaque genre de tour
            for($i=0; $i < sizeof($genres); $i++){
            
                //Récupère l'id du genre
                $idGenreTour = getGenreTourId(ucfirst($genres[$i]));
                $idGenreTour = mysql_fetch_array($idGenreTour);

                if($idGenreTour[0] == null){
                   $idGenreTour[0] = 5;
                }
                
                //Ajout du genre dans la base de données
                $requete = "insert into tourgenretour (idxTour, idxGenreTour) values ($id, $idGenreTour[0])";
                $informations_requete = executeSQL($requete);
            }
            
            //Déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  LISTE DE TOUTES LES RANDONEES   **************************/
				//MAE - Modification requête
        function listeRandonnées($limitemin, $limitemax, $langue, $role, $nom){
            
            //connexion à la base de données
            $myConnexion = connexionDB();
            
            //Nombre de résultats
            $nbQuery = $limitemax - $limitemin;
            
            //Récupération des randonnées dans la limite
            $query = "SELECT distinct  idTour, `dateDebut` ,  `dateFin` ,  `titre` , typetour_" . $langue. ", status, genreTour_" . $langue . ",
                duree, difficulte, lieuRDV, idxdepartlocalite, idxarriveelocalite, montee, descente, idxguide, idxassistant, prixmin, inscriptionmax";
            $query .= " FROM tour, typetour, genretour, tourgenretour
                    WHERE idxTypeTour = idTypeTour
                    and idxTour = idTour
                    AND idxGenreTour = idGenreTour ";
						if($role == 'chef'){
							$query .= "AND idxGuide like '$nom' ";
						}
            $query .= "ORDER BY dateDebut
                    LIMIT $limitemin , $nbQuery";
            //Exécution de la requête SQL
            $randonnees = executeSQL($query);
            
            //Déconnexion de la base de données
            deconnexionDB();
            
            //Retourne la liste des randonnées
            return $randonnees;
        }
        
        /************  RECUPERATION INFOS RANDONNEE   **************************/
        function getInfoRandonnee(){
            
            //Connexion à la base de données
            $myConnexion = connexionDB();
            
            //Selection des informations liées au tour
            $requete = "select * from tour where idTour = $this->id";
            $informations = executeSQL($requete);
            
            //Assignation des valeurs récupérées aux variables
            while($ligne = mysql_fetch_array($informations)){
                $this->date = $ligne[1];
                $this->datefin = $ligne[2];
                $this->difficulte = $ligne[3];
                $this->montee = $ligne[4];
                $this->descente = $ligne[5];
                $this->duree = $ligne[6];
                $this->titre = $ligne[7];
                $this->soustitre = $ligne[8];
                $this->heureDepart = $ligne[9];
                $this->heureArrivee = $ligne[10];
                $this->prixMin = $ligne[11];
                $this->prixMax = $ligne[12];
                $this->inscriptionMax = $ligne[13];
                $this->departTransport = $ligne[15];
                $this->arriveeTransport = $ligne[16];
                $this->desc_fr = $ligne[17];
                $this->desc_de = $ligne[18];
                $this->info_fr = $ligne[19];
                $this->info_de = $ligne[20];
                $this->status = $ligne[21];
                $this->codeprogramme = $ligne[22];
                $this->lieuDepart = $ligne[23];
                $this->lieuArrivee = $ligne[24];
                $this->typeTour = $ligne[25];
                $this->typeTransport = $ligne[26];
                $this->chefCourse = $ligne[27];
                $this->assistant = $ligne[28];
                $this->carte = $ligne[29];
                $this->rdv = $ligne[30];
            }
            
            //Récupération du genre de randonnée 
            $requete = "select genretour_fr from tourgenretour, genretour where idxtour = $this->id AND idxgenretour = idgenretour";
            $infosGenre = executeSQL($requete);
            
            //Pour tous les genres, ajout dans une liste
            while($ligne = mysql_fetch_array($infosGenre)){
                $this->genre .= $ligne[0] . ";";
            }
            
            //Récupération de la région 
            $requete = "select region_fr from tourregion, region where idxtour = $this->id AND idxregion = idregion";
            $infosregion = executeSQL($requete);
            
            //Pour toutes les régions, ajout dans une liste
            while($ligne = mysql_fetch_array($infosregion)){
                $this->region .= $ligne[0] . ";";
            }
        }
        
        /************  MODIFICATION INFOS RANDONNEE   **************************/
        function modificationTour(){
            //connexion à la base de données
            $connexion = connexionDB();
            
           //Status de la randonnée
            if($this->status == 'on')
                $this->status = 1;
            else
                $this->status = 0;
            
            //Mise à jour des informations
            $requete = "UPDATE tour SET
                        datedebut = '$this->date',
                        datefin = '$this->datefin',
                        difficulte = " . strlen($this->difficulte) .",
                        montee = $this->montee,
                        descente = $this->descente,
                        duree = '$this->duree',
                        titre = '". mysql_real_escape_string($this->titre) ."',
                        departHeure = '$this->heureDepart',
                        arriveeHeure = '$this->heureArrivee',
                        prixMin = '$this->prixMin',
                        prixMax = '$this->prixMax',
                        inscriptionMax = $this->inscriptionMax,
                        transportDepart = '" . mysql_real_escape_string($this->departTransport) . "',
                        transportArrivee = '" . mysql_real_escape_string($this->arriveeTransport) . "',
                        information_fr = '". mysql_real_escape_string($this->info_fr) . "',
                        information_de = '" . mysql_real_escape_string($this->info_de) ."',
                        idxDepartLocalite = '" . mysql_real_escape_string($this->lieuDepart) . "',
                        idxArriveeLocalite = '" . mysql_real_escape_string($this->lieuArrivee) . "',
                        idxTypeTour = $this->typeTour,
                        status = $this->status,
                        lienCarte = '$this->carte',
                        codeprogramme = '$this->codeprogramme',
                        lieuRDV = '" . mysql_real_escape_string($this->rdv) . "'
                        where idtour = $this->id";
            //Exécution de la requête SQL
            executeSQL($requete);
            
            //déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  MODIFICATION INFOS PROPOSITION   **************************/
        function modificationProposition(){
            //connexion à la base de données
            $connexion = connexionDB();
            
            //Mise à jour des informations
            $requete = "UPDATE tour SET
                        difficulte = " . strlen($this->difficulte) .",
                        duree = '$this->duree',
                        titre = '". mysql_real_escape_string($this->titre) ."',
                        description_fr = '". mysql_real_escape_string($this->info_fr) . "',
                        description_de = '" . mysql_real_escape_string($this->info_de) ."',
                        idxTypeTour = $this->typeTour,
                        lienCarte = '$this->carte',
                        codeprogramme = '$this->codeprogramme'
                        where idtour = $this->id";
            //Exécution de la requête SQL
            executeSQL($requete);
            
            //déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  INSERTION D'UNE PROPOSITION   **************************/
        function insertProposition(){
            //connexion à la base de données
            $myConnexion = connexionDB();
            
            //insertion des informations récupérées
            $requete = "insert into tour (titre, duree, description_fr, description_de, 
                    codeprogramme, idxdepartlocalite, idxarriveeLocalite, difficulte, idxtypetour, status)
                    Values ('$this->titre', '$this->duree', '$this->info_fr', '$this->info_de', 
                    '$this->codeprogramme', '$this->lieuDepart', '$this->lieuArrivee', $this->difficulte,
                    $this->typeTour, '$this->status')";
            
            //Exécution de la randonnée
            $informations_requete = executeSQL($requete);
            
            //Récupération de l'identifiant de la dernière randonnée ajoutée
            $id = mysql_insert_id();
            
            //Région vide?
            if($this->region == null)
                $this->region = 'Hors';
            
            //Liste de régions
            $regions = $this->region;
            $idRegion = getRegionId(ucfirst($regions));
            $idRegion = mysql_fetch_array($idRegion);
            
            //Ajout de la région dans la base de données
            $requete = "insert into tourregion (idxTour, idxRegion) values ($id, $idRegion[0])";
            $informations_requete = executeSQL($requete);

            
            //Genre vide?
            if($this->genre == null)
                $this->genre = 'Autre';
           
            //Insertion du genre dans la base de données
            $requete = "insert into tourgenretour (idxTour, idxGenreTour) values ($id, $this->genre)";
            $informations_requete = executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  MOYENNE DES EVALUATIONS POUR UNE RANDO *****************/
        function getMoyenneEvaluation(){
            //Connexion à mysql
            $connexion = connexionDB();
            
            //Moyenne des évaluations
            $requete = "select avg(evaluation) from favoris where idtour = $this->id";
            $avg = mysql_fetch_array(executeSQL($requete));
            
            //Deconnexion DB
            deconnexionDB();
            
            //Retourne la moyenne
            return $avg;
        }
        
        /************  LISTE DES INSCRITS   **************************/
        function listeInscrits(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Requête pour récupérer les données necessaires
            $requete = "select email, portable, idxlangue, telephone, nom, prenom
                        from personne, inscription
                        where personne.idpersonne = inscription.idpersonne
                        and idrandonnee = $this->id
                        and idxstatus = '1'";            
            $listeInscrits = executeSQL($requete);
            
            //Deconnexion de la base de données
            deconnexionDB();
            
            //Retourne la liste de toutes les personne inscrites à la randonnées
            return $listeInscrits;            
        }
        
        /************  SUPRESSION D'UNE RANDONNEE   **************************/
        function supprimerRando(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Requête pour supprimer la randonnée
            $requete = "delete from tour
                        where idtour = $this->id";            
            $listeInscrits = executeSQL($requete);
            
            //Deconnexion de la base de données
            deconnexionDB();
            
            //Retourne la liste de toutes les personne inscrites à la randonnées
            return $listeInscrits;            
        }
				
				/************  MAE - Stats randonnées (membres)   **************************/
				function statsRandoMembres(){
					//Connexion à la base de données
          $connexion = connexionDB();
					
					$dateJour = "'".date("Y-m-d")."'";
					$debutAnnee = "'".date("Y") . "-01-01'";
            
					//Requête pour Récupérer les stats des randonnées
					$requete = "Select tour.idTour, titre, dateDebut, idxGuide, count(idPersonne) as inscrits, membres, status
											FROM tour, inscription,
											(Select idTour, count(personne.idPersonne) as membres
												from tour, inscription, personne
												where idTour = idRandonnee
												and personne.idPersonne = inscription.idPersonne
												and numMembre is not null
												and idxStatus = '1'
												and dateDebut < $dateJour
											and dateDebut >= $debutAnnee
												GROUP BY tour.idTour) as Membres
											where tour.idTour = idRandonnee
											and Membres.idTour = tour.idTour
											and idxStatus = '1'
											and dateDebut < $dateJour
											and dateDebut >= $debutAnnee
											GROUP BY tour.idTour
											ORDER BY tour.dateDebut";            
					$listeInscrits = executeSQL($requete);
					
					//Deconnexion de la base de données
					deconnexionDB();
					
					//Retourne la liste de toutes les personne inscrites à la randonnées
					return $listeInscrits;            
				}
				
				/************  MAE - Stats randonnées   **************************/
				function statsRandoNbTotal(){
					//Connexion à la base de données
          $connexion = connexionDB();
					
					$dateJour = "'".date("Y-m-d")."'";
					$debutAnnee = "'".date("Y") . "-01-01'";
            
					//Requête pour Récupérer les stats des randonnées
					$requete = "Select distinct count(idPersonne) as inscrits
											FROM tour, inscription
											where idTour = idRandonnee
											and idxStatus = '1'
											and dateDebut < $dateJour
											and dateDebut >= $debutAnnee";            
					$listeInscrits = executeSQL($requete);
					
					//Deconnexion de la base de données
					deconnexionDB();
					
					$totalInscrits = mysql_fetch_array($listeInscrits);
					
					//Retourne la liste de toutes les personne inscrites à la randonnées
					return $totalInscrits;            
				}
				
        
    }
?>
