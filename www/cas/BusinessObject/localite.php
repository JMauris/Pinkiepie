<?php
   /****************************************************************************
    * Auteur:   Pascal Favre
    * Classe:   606_F
    * But:      Classe permettant de gérer toutes les localité
    ***************************************************************************/
    Class localite{
        
        //liste des variables utilisées pour les localités
        public $npa;
        public $localite;
        public $region;
        
        /************  DETAIL D'UNE LOCALITE   **************************/
        function getlocaliteParNom(){
            //Connexion à la base de données
            $connexionDB = connexionDB();
            
            //Récupération des informations liées à une localité
            $requete = "SELECT distinct * FROM localite WHERE localite like '$this->localite'";
            $infosLocalite = executeSQL($requete);
            $localite = mysql_fetch_array($infosLocalite);
            
            //Récupération du NPA et de la région
            $this->npa = $localite[0];
            $this->region = $localite[2];
            
            if($this->npa == ''){
                $loca = str_replace(" ", "%20", $this->localite);
                 $lien = "http://maps.googleapis.com/maps/api/geocode/xml?address=$loca,%20Suisse&sensor=false";
                
                //Récupération des données et mise en place d'un fichier XML
                $donnees = file_get_contents($lien);
                $xml = new SimpleXMLElement($donnees);
                
                //Récupération du code postal
                if(isset($xml->result->geometry->location)){
                    $lat = $xml->result->geometry->location->lat;
                    $longi = $xml->result->geometry->location->lng;
                    $param = $lat . "," . $longi;

                    $lien = "http://maps.googleapis.com/maps/api/geocode/xml?latlng=$param&sensor=false";

                        //Récupération des données et mise en place d'un fichier XML
                        $donnees = file_get_contents($lien);
                        $xml = new SimpleXMLElement($donnees);

                        //Récupération du code postal
                        if(isset($xml->result->formatted_address)){
                            $adresse = $xml->result->formatted_address;
                            $adresse = explode(",", $adresse);
                            $return = substr($adresse[1],1);
                            $return = explode(" ",$return);
                            $this->npa = intval($return[0]);
                            $this->region = 4;
                            $this->insertLocalite();
                        }
                        else
                            $return = "empty";
                }
                
            }
        }
        
        /************  INSERTION D'UNE LOCALITE   **************************/
        function insertLocalite(){
            //Connexion à la base de données
            $connexion = connexionDB();
            
            $requete = "insert into localite(npa, localite, idxregion)
                        values('$this->npa', '". utf8_decode($this->localite) . "', $this->region)";
            
            executeSQL($requete);
            
            //Deconnexion base de données
            deconnexionDB();
        }
        
    }
?>
