<?php
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Classe permettant de gérer toutes les inscriptions
    ***************************************************************************/

    Class inscription{
        
        //déclaration des variables pour les inscriptions
        public $idPersonne;
        public $idRandonnee;
        public $date;
        public $heure;
        public $status;
        public $remarque;
        
        
        /************  INSERTION D'UNE INSCRIPTION   **************************/
        function insertInscription($inscriptionsMax){
            
            //Connexion à la base de données
            $connexionDB = connexionDB();
            
            //Contrôle que l'utilisateur ne soit pas déjà inscrit
            $requete = "SELECT count(idPersonne) FROM inscription WHERE idpersonne = $this->idPersonne AND idrandonnee = $this->idRandonnee";
            $nbInscription =  mysql_fetch_array(executeSQL($requete));
            $message = '';
            //Si la personne n'est pas encore inscrite
            if($nbInscription[0] == 0){ 

                //Si inscription illimité, alors inscription
                if($inscriptionsMax === 'illimité'){

                    $requete = "INSERT INTO inscription (idpersonne, idrandonnee, date, heure, idxStatus, remarque) VALUES(
                                $this->idPersonne, $this->idRandonnee, '$this->date', '$this->heure', 1, '$this->remarque')";

                    $message = 'Vous avez été inscrit avec succès à ';

                }
                //Si le nombre d'inscriptions restantes est plus petit que 1, passage sur la liste d'attente
                elseif($inscriptionsMax < 1){

                    //Ajout dans la liste d'attente
                    $requete = "INSERT INTO inscription (idpersonne, idrandonnee, date, heure, idxStatus, remarque) VALUES(
                        $this->idPersonne, $this->idRandonnee, '$this->date', '$this->heure', 3, '$this->remarque')";

                    $message = "Vous êtes placés sur liste d'attente pour ";
                }
                //Sinon, ajout dans les inscrits
                else{
                    $requete = "INSERT INTO inscription (idpersonne, idrandonnee, date, heure, idxStatus, remarque) VALUES(
                                $this->idPersonne, $this->idRandonnee, '$this->date', '$this->heure', 1, '$this->remarque')";

                    $message = 'Vous avez été inscrit avec succès à ';
                }
                            
            }
            else {
                //Contrôle que l'utilisateur ne soit pas déjà inscrit
                $requete = "SELECT idxStatus FROM inscription WHERE idpersonne = $this->idPersonne AND idrandonnee = $this->idRandonnee";
                $statusInscription =  mysql_fetch_array(executeSQL($requete));
                
                //Si la personne est en mode annulé, inscription
                if($statusInscription[0] == 2){
                    if($inscriptionsMax > 0 || $inscriptionsMax == 'illimité'){
                        //Inscription
                        $requete = "update inscription set
                                    idxstatus = 1,
                                    date = '$this->date',
                                    heure = '$this->heure',
                                    remarque = '$this->remarque'
                                    where idpersonne = $this->idPersonne
                                    and idrandonnee = $this->idRandonnee";
                    }
                    else{
                        //Liste d'attente
                        $requete = "update inscription set
                                    idxstatus = 3,
                                    date = '$this->date',
                                    heure = '$this->heure',
                                    remarque = '$this->remarque'
                                    where idpersonne = $this->idPersonne
                                    and idrandonnee = $this->idRandonnee";
                    }
                }
                else{
                    //Message d'informations
                    $message = "Vous êtes déjà inscrit à cette randonnée";
                }
            }
            
            //Exécution de la bonne requête SQL
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
            
            //Retourne le message
            return $message;
            
        }
        
        /************  SUPPRESSION D'UNE INSCRIPTION   **************************/
        function desinscription($inscriptionMax, $titre){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Si le nombre d'inscriptions max est défini
            if($inscriptionMax != 0){
                //nombre de personnes avec le statut en attente ou inscrits
                $requete = "select count(idpersonne) from inscription where 
                            idrandonnee = $this->idRandonnee and idxstatus != 2";
                $nbInscriptions = mysql_fetch_array(executeSQL($requete));
                
                //SI le nombre dépasse le nombre d'inscriptions max
                if($nbInscriptions[0] >= $inscriptionMax){
                   
                    //Récupére la première personne sur la liste d'attente
                    $requete = "select idpersonne from inscription where 
                            idrandonnee = $this->idRandonnee and idxstatus = 3 ORDER BY date ASC , heure ASC  limit 0,1";                    
                    $idpersonne = mysql_fetch_array(executeSQL($requete));

                    //Modifie le status de cette personne
                    $requete = "Update inscription set
                                idxstatus = 1
                                where idrandonnee = $this->idRandonnee
                                and idpersonne = $idpersonne[0]";
                   executeSQL($requete);
                   
                   
                   $personneMail = new personne();
                   $personneMail->id = $idpersonne[0];
                   $personneMail->getPersonneInfos();
                   
                   //envoi d'un email indiquant que le status d'inscription a été modifié
                   $message = "Bonjour,\n";
                   $message .= "Les status de votre inscription à la randonnée $titre a été modifié.\n";
                   $message .= "Vous avez été inscrit à la randonnée.\n";
                   $message .= "Bonne journée.\n";
                   $message .= "Valrando";
                   $sujet = "Inscription à la randonnée $titre";
                   $adressemail = "pascalfavre182@gmail.com";
                   
                   $headers = 'To: ' . $adressemail . "\r\n" .
                        'From: Inscriptions Valrando <admin@valrando.ch>' . "\r\n" .
                        'Reply-To: admin@valrando.ch' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                   mail($adressemail, $sujet, $message, $headers);

                   //email = $personneMail->email;
                   //sendMail($message, $email, $sujet);
                }
            }
            
            $connexion = connexionDB();
            
            //Désinscription de la personne
            $requete = "Update inscription set
                        idxstatus = 2
                        where idrandonnee = $this->idRandonnee
                        and idpersonne = $this->idPersonne";
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
        }
        
        
        /************  RECUPERATION DE LA LISTE D'ATTENTE   **************************/
        function listeAttente(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Requête pour récupérer toutes les personnes sur liste d'attente
            $requete = "select nom, prenom, localite, date, heure, personne.idpersonne
                        from inscription, personne
                        where idrandonnee = $this->idRandonnee
                        and inscription.idpersonne = personne.idpersonne
                        and idxstatus = 2
                        order by date asc, heure asc";
            
            //Exécution de la requête SQL
            $listeAttente = executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
            
            //Retourne la liste d'attente à l'application
            return $listeAttente;
        }
        
        //Fonction permettant de modifier la priorité d'une inscription
        function modifPriorite(){
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Requête pour modifier l'inscription
            $requete = "update inscription
                        set heure = '$this->heure',
                        date = '$this->date'
                        where idpersonne = $this->idPersonne
                        and idrandonnee = $this->idRandonnee";
            
            //execution de la requête SQL
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  RECUPERATION DU NOMBRE DE PLACES LIBRES   **************************/
        function nombrePlacesLibres(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Requête pour récupérer le nombre d'inscriptions max, le guide et l'accompagnant
            $requete = "SELECT  `idxAssistant` ,  `idxGuide` ,  `inscriptionMax` 
                        FROM  `tour` 
                        WHERE idtour = $this->idRandonnee";
            $infosRando = mysql_fetch_array(executeSQL($requete));
            
            //Initialisation de la variable pour le nombre de places libres
            $resultat = "";
            
            //Contrôle qu'il n'y ait pas un nombre illimité
            if($infosRando[2] == 0){
                $resultat = "illimité";
            }
            else{
                $nbmax = $infosRando[2];
                
                //Guide présent?
                if($infosRando[1] != '')
                    $nbmax = $nbmax - 1;
                
                //Assistant présent
                if($infosRando[0] != '')
                    $nbmax = $nbmax - 1;
                
                //Récupération du nombre de personnes inscrites à la randonnée
                $requete = "select count(idpersonne) from inscription
                            where idrandonnee = $this->idRandonnee
                            and idxstatus = 1";
                $nbInscrits = mysql_fetch_array(executeSQL($requete));

                $resultat = $nbmax - $nbInscrits[0];
            }
            
            //Déconnexion de la base de données
            deconnexionDB();
            
            //Affichage du résultat
            return $resultat;
        }
        
        /************  contrôle si une personne est inscrite   **************************/
        function estInscrit(){
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Requête contrôlant si le membre est inscrit
            $requete = "select count(idpersonne)
                        from inscription
                        where idpersonne = $this->idPersonne
                        and idrandonnee = $this->idRandonnee";
            $estinscrit = mysql_fetch_array(executeSQL($requete));
            
            //Deconnexion de la base de données
            deconnexionDB();
            
            //Retourne le nombre d'inscriptions
            return $estinscrit;
        }
        
        /************  Récupération de la remarque  **************************/
        function getRemarque(){
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Requête contrôlant si le membre est inscrit
            $requete = "select remarque
                        from inscription
                        where idpersonne = $this->idPersonne
                        and idrandonnee = $this->idRandonnee";
            $remarque = mysql_fetch_array(executeSQL($requete));
            
            //Deconnexion de la base de données
            deconnexionDB();
            
            //Retourne le nombre d'inscriptions
            return $remarque[0];
        }
        
        /***********   LISTE DES INSCRIPTIONS POUR UNE RANDONNEE **********/
        function inscriptionsPourRando(){
            //Connexion à la base de données
            $connexion = connexionDB();

            //Requête SQL 
						/*Modifié 27.02.2013 Sabine Mathieu : ajouter à la requête, chargement telephone et portable*/
            $requete = "select personne.idPersonne, nom, prenom, email, numMembre, idxAbonnement, remarque, telephone, portable 
                        from personne, inscription 
                        where idRandonnee = $this->idRandonnee 
                        and personne.idPersonne = inscription.idpersonne
                        and idxstatus = 1
                        order by nom asc, prenom asc";
            //Exécution de la requête
            $listeInscrits = executeSQL($requete);

            //Déconnexion de la base de données
            deconnexionDB();

            //Retourne la liste des inscrits
            return $listeInscrits;

        }
        
        /***********   LISTE DES INSCRIPTIONS POUR UNE RANDONNEE **********/
        function nbInscrits(){
            //Connexion à la base de données
            $connexion = connexionDB();

            //Requête SQL
            $requete = "select count(idRandonnee) 
                        from inscription 
                        where idRandonnee = $this->idRandonnee";
            //Exécution de la requête
            $nbInscrits = mysql_fetch_array(executeSQL($requete));

            //Déconnexion de la base de données
            deconnexionDB();

            //Retourne la liste des inscrits
            return $nbInscrits[0];

        }
        
        /***********   Forcer une inscription **********/
        function forcerInscription(){
            //Connexion à la base de données
            $connexion = connexionDB();

            //Requête SQL
            $requete = "update inscription
                        set idxstatus = 1
                        where idRandonnee = $this->idRandonnee
                        and idPersonne = $this->idPersonne";
            //Exécution de la requête
            executeSQL($requete);

            //Déconnexion de la base de données
            deconnexionDB();
        }      
    }
?>