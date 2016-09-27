<?php
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Classe permettant de gérer toutes les personnes
    ***************************************************************************/

    Class personne{
        
        //Variables utilisées pour une personne
        public $id;
        public $nom;
        public $prenom;
        public $adresse;
        public $email;
        public $motDePasse;
        public $telephone;
        public $portable;
        public $numMembre;
        public $estGuide;
        public $estActif;
        public $npa;
        public $localite;
        public $langue;
        public $abonnement;
        
        /************  INSERTION D'UN MEMBRE   **************************/
        function insertMembre(){
            //connexion à la base de données
            $myConnexion = connexionDB();
            
            //Majuscule à la première lettre du mot
            echo ucfirst($this->langue);
            
            //Quelle langue?
            if(ucfirst($this->langue) == 'Allemand')
                $codeLangue = 'de';
            else
                $codeLangue = 'fr';
            
            //Recherche si le membre n'est pas déjà présent dans la base de données
            if($this->numMembre != 0){
                $requete = "select count(idPersonne) from personne where numMembre = $this->numMembre";

                $nbMembre = executeSQL($requete);
                $nb = mysql_fetch_array($nbMembre);
            }
            
            //Contrôle la localité
            checkLocalite($this->npa, $this->localite);
            
            //si la personne n'est pas présente dans la base de données            
            if($nb[0] == 0 || $this->numMembre == ''){
                //Ajout de la personne
                $requete = "INSERT INTO personne (nom, prenom, adresse, email,
                telephone, portable, numMembre, estActif, npa, localite, idxlangue, idxabonnement, motdepasse)
                VALUES ('$this->nom', '$this->prenom', '$this->adresse', '$this->email',
                        '$this->telephone', '$this->portable',
                        $this->numMembre, '$this->estActif', '$this->npa', '$this->localite',
                        '$codeLangue', $this->abonnement, '" . sha1($this->numMembre) . "')";
            }
            //Sinon
            else{
                //Mise à jour des informations de la personne
                $requete = "update personne set
                nom = '$this->nom',
                prenom = '$this->prenom',
                adresse = '$this->adresse',
                email = '$this->email',
                telephone = '$this->telephone',
                portable = '$this->portable',
                estActif = '$this->estActif',
                npa = '$this->npa',
                localite = '$this->localite',
                idxLangue = '$codeLangue'
                WHERE numMembre = $this->numMembre";
            }
            
            //Exécution de la requête
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  LISTE DE TOUTES LES PERSONNES   **************************/
        function getToutesPersonnes(){
            //connexion à la base de données
            $myConnexion = connexionDB();
            
            //Requête SQL
            $requete = "SELECT * FROM personne, langue, abonnement
                        WHERE personne.idxlangue= langue.codelangue
                        AND personne.idxAbonnement = abonnement.idAbonnement
                        order by nom, prenom
                        limit 0,100";
            $personnes = executeSQL($requete);
            
            //deconnexion de la base de données
            deconnexionDB();
            
            //Renvoi de la liste de toutes les personnes
            return $personnes;
        }
        
        /************  DETAILS D'UNE PERSONNE   **************************/
        function getPersonne($nom, $prenom){
            //connexion à la base de données
            $myConnexion = connexionDB();
            
            //Requête SQL
            $requete = "SELECT * FROM personne WHERE nom = '$nom' and prenom = '$prenom'";
            $info = executeSQL($requete);
            
            //Attribution des informations aux variables
            while($ligne = mysql_fetch_array($info)){
                $this->id = $ligne[0];
                $this->nom = $ligne[1];
                $this->prenom = $ligne[2];
                $this->adresse = $ligne[3];
                $this->email = $ligne[4];
                $this->telephone = $ligne[6];
                $this->portable = $ligne[7];
                $this->numMembre = $ligne[8];
                $this->npa = $ligne[11];
                $this->localite = $ligne[12];
                $this->langue = $ligne[13];
                $this->abonnement = $ligne[10];
            }
            
            //deconnexion de la base de données
            deconnexionDB();
            
        }
        
        /************  DETAILS D'UNE PERSONNE   **************************/
        function getDetailPersonne(){
            //connexion à la base de données
            $myConnexion = connexionDB();
            
            //Requête SQL
            $requete = "SELECT * FROM personne WHERE idPersonne = $this->id";
            $info = executeSQL($requete);
            
            //Attribution des informations dans la base de données
            while($ligne = mysql_fetch_array($info)){
                $this->id = $ligne[0];
                $this->nom = $ligne[1];
                $this->prenom = $ligne[2];
                $this->adresse = $ligne[3];
                $this->npa = $ligne[11];
                $this->localite = $ligne[12];
                $this->email = $ligne[4];
                $this->telephone = $ligne[6];
                $this->portable = $ligne[7];
                $this->numMembre = $ligne[8];
                $this->abonnement = $ligne[10];
            }
            
            //deconnexion de la base de données
            deconnexionDB();
            
        }
        
        /************  INSERTION D'UNE PERSONNE NON-MEMBRE   **************************/
        function insertNonMembre(){
            
            //récupération des informations sur la localité
            $localite = new localite();
            
            $localite->localite = ucfirst($this->localite);
            $localite->getlocaliteParNom();
            
            //Si la localité existe dans la base de données
            $message = "";
            if($localite->npa != ''){
                //connexion à la base de données
                $connexionDB = connexionDB();

                //Contrôle que l'email ne soit pas déjà utilisé, si oui -> utilisation de cet id
                $requete = "select idPersonne from personne WHERE email like '$this->email'";
                $infosRequete = executeSQL($requete);
                $idEmail = mysql_fetch_array($infosRequete);

                //SI l'email n'existe pas encore dans la base de données
                if($idEmail[0] == ''){
                    //Si le numéro de téléphone est vide
                    if($this->telephone == '')
                        $this->telephone = 0;

                    //Requête SQL
                    $requete = "INSERT INTO personne (nom, prenom, email, idxAbonnement, npa, localite, idxLangue, telephone, portable)
                                VALUES ('" . utf8_decode($this->nom) . "','" . utf8_decode($this->prenom) . "', '$this->email', $this->abonnement,
                                '$localite->npa', '" . utf8_decode($this->localite) . "', '$this->langue', '$this->telephone', '$this->portable')";
                    $infosRequete = executeSQL($requete);

                    //Récupération de l'ID de la personne insérée dans la base de données
                    $this->id = mysql_insert_id();
                }
                //Sinon
                else{
                    //L'id de la personne est celui lié à l'email
                    $this->id = $idEmail[0];
                }
            }
            //Sinon
            else{
                //Message indiquant que le npa n'est pas correct
                $message = 'pas de npa';
            }
        
            
            //fermeture de la connexion SQL
            deconnexionDB();
            
            //Retourne le message
            return $message;
            
        }
        
        /************ MODIFICATION D'UN NON-MEMBRE  ***************************/
        function modifNonMembre(){
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //récupération des informations sur la localité
            $localite = new localite();
            $localite->localite = ucfirst($this->localite);
            $localite->getlocaliteParNom();
            
            //Récupére l'identifiant de la personne pour ce numéro de membre
            $requete = "update personne set
                        portable = '$this->portable',
                        npa =  '$localite->npa',
                        localite = '$localite->localite'
                        where idpersonne like $this->id";
            
            //Exécution de la requête SQL
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  RECUPERATION D'UN MEMBRE PAR SON NUMERO   **************************/
        function getPersonneParNumero(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Récupére l'identifiant de la personne pour ce numéro de membre
            $requete = "select idpersonne from personne where numMembre like $this->numMembre";
            $infosPersonne = mysql_fetch_array(executeSQL($requete));
            $this->id = $infosPersonne[0];
            
            //Déconnexion de la base de données
            deconnexionDB();
            
        }
        
        /************  RECUPERATION DE TOUTES LES INFORMATIONS SUR UNE PERSONNE   **************************/
        function getPersonneInfos(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Récupération de toutes les informations sur la personne
            $requete = "select * from personne where idpersonne = $this->id";
            $infospersonne = mysql_fetch_array(executeSQL($requete));
            
            //Assignations des valeurs pour les différentes variables
            $this->nom = $infospersonne[1];
            $this->prenom = $infospersonne[2];
            $this->adresse = $infospersonne[3];
            $this->email = $infospersonne[4];
            $this->telephone = $infospersonne[6];
            $this->portable = $infospersonne[7];
            $this->numMembre = $infospersonne[8];
            $this->abonnement = $infospersonne[11];
            $this->npa = $infospersonne[12];
            $this->localite = $infospersonne[13];
            $this->langue = $infospersonne[14];
            
            //Déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  MODIFICATION DE L'ABONNEMENT D'UNE PERSONNE   **************************/
        function modifAbonnement(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Mise à jour de la valeur de l'abonnement dans la base de données
            $requete = "update personne set idxAbonnement = $this->abonnement where idPersonne = $this->id";
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
            
        }
        
        /************  MODIFICATION DES INFORMATIONS D'UN PARTICIPANT  **************************/
        function modifParticipant(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //Mise à jour des informations de la personne
            $requete = "update personne set
                        nom = '$this->nom',
                        prenom = '$this->prenom',
                        adresse = '". mysql_real_escape_string($this->adresse) . "',
                        npa = '$this->npa',
                        localite = '$this->localite',
                        telephone = '$this->telephone',
                        portable = '$this->portable',
                        idxAbonnement = $this->abonnement
                        where idPersonne = $this->id";
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
        }
        
        /************  SUPPRESSION D'UN PARTICIPANT   **************************/
        function suppressionParticipant(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //modification du status de toutes les inscriptions
            $requete = "update inscription set
                        idxstatus = 4
                        where idpersonne = $this->id";            
            executeSQL($requete);
            
            //Suppression du membre
            $requete = "update personne set
                        estActif = 1
                        where idpersonne = $this->id";            
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
            
        }
        
         /************  MODIFICATION DU MOT DE PASE   **************************/
        function modifMdp(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //modification du status de toutes les inscriptions
            $requete = "update personne set
                        motdepasse = '$this->motDePasse'
                        where idpersonne = $this->id";
            executeSQL($requete);
            
            //Déconnexion de la base de données
            deconnexionDB();
            
        }
        
        /************  MOT DE PASSE D'ORIGINE?   **************************/
        function motDePasseOrigine(){
            
            //Connexion à la base de données
            $connexion = connexionDB();
            
            //modification du status de toutes les inscriptions
            $requete = "select prenom, motdepasse, nummembre
                        from personne
                        where idpersonne = $this->id";
            $infosPersonne = mysql_fetch_array(executeSQL($requete));
            
            //Mot de passe d'origine
            $motdepasseorigine = sha1($infosPersonne[2]);
            
            //Contrôle si c'est bien le mot de passe d'origine
            if($motdepasseorigine == $infosPersonne[1])
                $return = true;
            else
                $return = false;
            
            //Déconnexion de la base de données
            deconnexionDB();
            
            //Retourne le résultat
            return $return;   
        }
    }
?>