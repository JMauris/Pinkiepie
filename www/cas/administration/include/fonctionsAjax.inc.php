<?php
/****************************************************************************
* Auteur:   Pascal Favre
* Classe:   606_F
* But:      Fichier contenant toutes les fonctions qui seront effectuées
*           lors des différents appels Ajax effectuées par la console d'administration
***************************************************************************/


include("../../include/fonctions.inc.php");
include("../../BusinessObject/personne.php");


/************  RECHERECHE 20 PROCHAINES RANDONNEES   **************************/
if(isset($_GET['dateInscr'])){
    // Titre
    $titre = strtolower($_GET['titrecontientInscr']);
    $titre = " lcase(titre) like '%$titre%'";      
    
    // Date
    $dateRecherche = "";

		//MAE - Ajout controle
		if($_GET['role'] == 'chef'){
			$user = " AND idxGuide like '" . $_GET['login'] . "' ";
		}	
		
    //changement du format de la date
    if(isset($_GET['dateInscr'])){
        if($_GET['dateInscr'] != ""){
            $date = explode(".",$_GET['dateInscr']);        
            $dateRecherche = $date[2] . "-" . $date[1] . "-" . $date[0];
            $dateRecherche = " AND dateDebut >= '$dateRecherche' ";
        }
    }
    
    //connexion à la base de données
    $myConnexion = connexionDB();

    //Séléction des 20 prochaines randonnées
		//MAE - Ajout contrôle rôle
    $query = "SELECT distinct idTour, `dateDebut` , `titre`, datefin, idxtypetour,
            duree, difficulte, lieuRDV, idxdepartlocalite, idxarriveelocalite, montee, 
            descente, idxguide, idxassistant, prixmin, inscriptionmax";
    $query .= " FROM tour
                WHERE " .$titre. $dateRecherche . $user . "
                ORDER BY dateDebut
                LIMIT 0,20";
    $randonnees = executeSQL($query);

    //Affichage du tableau des randonées
    $text = "<tr>\n";
    $text .= "<th>Date de début</th>\n";
    $text .= "<th>Date de fin</th>\n";
    $text .= "<th>Titre</th>\n";
    $text .= "<th>Genre</th>\n";
    $text .= "<th>Voir les inscriptions</th>\n";
    $text .= "</tr>\n";
    $x = 0;
    while($ligne = mysql_fetch_array($randonnees)){
        if($x%2 == 0)
            $text .= "<tr>";
        else
        $text .= "<tr style='background-color:#F6CE61;'>";

        //Date de début
        $dateDebut = explode('-',$ligne[1]);

        $text .= "<td>$dateDebut[2].$dateDebut[1].$dateDebut[0]</td>";

        //Date de fin
        $dateFin = explode('-',$ligne[3]);
        if($dateFin[2] != '00')
            $dateFin = $dateFin[2]. "." . $dateFin[1] . "." .$dateFin[0];
        else
            $dateFin = '';

        $text .= "<td>$dateFin</td>";

        $text .= "<td width='25%'><a id='infoRando' title=\"";
            //Infobulle                        
            if($dateDebut[2] != '00')
                $text .= "$dateDebut[2].$dateDebut[1].$dateDebut[0]<br />";

            $text .= $dateFin . "<br/>";

            if($ligne[4] == 1)
                $typeInfo = "Randonnée";
            else
                $typeInfo = "Séjour";

            $text .= "Genre: " . $typeInfo . "<br />";
            $text .= "Type: " . utf8_encode($ligne[4]) . "<br />";
            $text .= "Durée: " . utf8_encode($ligne[5]) . "<br />";
            $text .= "Difficulté: " . utf8_encode($ligne[6]) . "<br />";
            $text .= "RDV: " . utf8_encode($ligne[7]) . " à " .  utf8_encode($ligne[8]) . "<br />";
            $text .= "Arrivée: " . utf8_encode($ligne[9]) . "<br />";
            if($ligne[10] != 0){
                $text .= "dénivelé pos: " . $ligne[10] . "<br />";
                $text .= "dénivelé nég: " . $ligne[11]. "<br />";
            }
            if($ligne[12] != ''){
                $text .= "Chef(fe) de course: " . utf8_encode($ligne[12]) . "<br />";
            }
            if($ligne[13] != ''){
                $text .= "Assistant(E): " . utf8_encode($ligne[13]) . "<br />";
            }
            if($ligne[14] != 0){
                $text .= "Prix: " . $ligne[14] . "<br />";
            }
            if($ligne[15] != 0){
                $text .= "Insciprtion Max: " . $ligne[15] . "<br />";
            }
        $text .= "\">";
        $text .= utf8_encode($ligne[2]) . "</a></td>";

        $text .= "<td>";
            if($ligne[4] == 1)
                $text .= "Randonnée d'un jour";
            else
                $text .= "Séjour";

        $text .= "</td>";
        $text .= "<td><a href='listeInscriptions.php?id=$ligne[0]'>liste des inscriptions</a></td>";
        $text .= "</tr>";
        $x += 1;
    }   

    //Affichage du tableau
    echo $text;
}

/************  RECHERCHE RANDO PAR DATE OU TITRE  **************************/
if(isset($_GET['date'])){
    // Date
    $dateRecherche = "";

    //changement du format de la date
    if(isset($_GET['date'])){
        if($_GET['date'] != ""){
            $date = explode(".",$_GET['date']);        
            $dateRecherche = $date[2] . "-" . $date[1] . "-" . $date[0];
            $dateRecherche = " AND dateDebut >= '$dateRecherche' ";
        }
    }
    
    // Titre
    $titre = "";
    
    if(isset($_GET['titrecontient'])){
        $titre = strtolower($_GET['titrecontient']);
        $titre = "AND lcase(titre) like '%$titre%'";      
    }
		
    //MAE - Ajout controle
		if($_GET['role'] == 'chef'){
			$user = " AND idxGuide like '" . $_GET['login'] . "'";
		}	
    
		//echo $_GET['role'] . " " . $_GET['login'] . " " . $user;
    //connexion à la base de données
    $myConnexion = connexionDB();

    //Recherche des randonnées
		//MAE - ajout role et login
    $query = "SELECT distinct idTour, `dateDebut` ,  `dateFin` ,  `titre` , typetour_fr, genreTour_fr,
            duree, difficulte, lieuRDV, idxdepartlocalite, idxarriveelocalite, montee, descente, idxguide,
            idxassistant, prixmin, inscriptionmax, status";
    $query .= " FROM tour, typetour, genretour, tourgenretour
                WHERE idxTypeTour = idTypeTour
                and idxTour = idTour
                AND idxGenreTour = idGenreTour
                ".$dateRecherche."
                ".$titre."
                ".$user."
								ORDER BY dateDebut
                LIMIT 0," . $_GET['nombre'];
    $randonnees = executeSQL($query);
    
    //création du tableau        
    $text = "<tr>\n";
    $text .= "<th>Date de début</th>\n";
    $text .= "<th>Date de fin</th>\n";
    $text .= "<th>Titre</th>\n";
    $text .= "<th>Genre</th>\n";
    $text .= "<th>Type</th>\n";
    $text .= "<th>Modifier</th>\n";
    $text .= "<th>A lieu?</th>\n";
    $text .= "</tr>\n";
    $x = 0;
    while($ligne = mysql_fetch_array($randonnees)){
        if($x%2 == 0)
            $text .= "<tr>";
        else
            $text .= "<tr style='background-color:#F6CE61;'>";


        $dateDebut = explode('-',$ligne[1]);
        $dateFin = explode('-',$ligne[2]);

        if($dateDebut[2] == '00')
            $text .= "<td></td>";
        else
            $text .= "<td>$dateDebut[2].$dateDebut[1].$dateDebut[0]</td>";

        if($dateFin[2] == '00')
            $text .= "<td></td>";
        else
            $text .= "<td>$dateFin[2].$dateFin[1].$dateFin[0]</td>";

        $text .= "<td width='25%'><a id='infoRando' title=\"";
            //Infobulle                        
            if($dateDebut[2] != '00')
                $text .= "$dateDebut[2].$dateDebut[1].$dateDebut[0]<br />";
            if($dateFin[2] != '00')
                $text .= "$dateFin[2].$dateFin[1].$dateFin[0]<br />";

            $text .= "Genre: " . utf8_encode($ligne[4]) . "<br />";
            $text .= "Type: " . utf8_encode($ligne[5]) . "<br />";
            $text .= "Durée: " . utf8_encode($ligne[6]) . "<br />";
            $text .= "Difficulté: " . utf8_encode($ligne[7]) . "<br />";
            $text .= "RDV: " . utf8_encode($ligne[8]) . " à " .  utf8_encode($ligne[9]) . "<br />";
            $text .= "Arrivée: " . utf8_encode($ligne[10]) . "<br />";
            if($ligne[11] != 0){
                $text .= "dénivelé pos: " . $ligne[11] . "<br />";
                $text .= "dénivelé nég: " . $ligne[12] . "<br />";
            }
            if($ligne[13] != ''){
                $text .= "Chef(fe) de course: " . utf8_encode($ligne[13]) . "<br />";
            }
            if($ligne[14] != ''){
                $text .= "Assistant(E): " . utf8_encode($ligne[14]) . "<br />";
            }
            if($ligne[15] != 0){
                $text .= "Prix: " . $ligne[15] . "<br />";
            }
            if($ligne[16] != 0){
                $text .= "Insciprtion Max: " . $ligne[16] . "<br />";
            }
        $text .= "\">";
        $text .= utf8_encode($ligne[3]) . "</a></td>";
        $text .= "<td>" . utf8_encode($ligne[4]) . "</td>";
        $text .= "<td>" . utf8_encode($ligne[5]) . "</td>";
        $text .= "<td><a href='ModifRando.php?id=$ligne[0]'><img height='30' src='../../pictures/edit.png' /></a></td>";
        $checkbox = "<td><input type='checkbox' disabled name='rando' value='$ligne[0]'"; 

        if($ligne[17] == 1)
            $checkbox .= "checked='checked'";

        $checkbox .= "/></td>";

        $text .= $checkbox;
        $text .= "</tr>";
        $x += 1;
    }

    //Affichage du tableau
    echo $text;
}

/************  RECHERCHE D'UNE PERSONNE PAR SON NUMERO   **************************/
if(isset($_GET['numMembre'])){

    //Récupération du numéro de membres
    $numMembre = $_GET['numMembre'];

    //Connexion à la base de données
    $connexion = connexionDB();

    //Recherche des informations du membre
    $requete = "select * from personne where numMembre like '$numMembre'";
    $infosPersonne = mysql_fetch_array(executeSQL($requete));

    //Création du texte à afficher
    $text = utf8_encode($infosPersonne[1]) . ";" . utf8_encode($infosPersonne[2]) . ";" . 
            utf8_encode($infosPersonne[4]) . ";" . $infosPersonne[11] .
            ";" . $infosPersonne[12] . ";" . utf8_encode($infosPersonne[13]);

    //Affichage du résultat
    echo $text;
}

/************  RECHERCHE D'UN MEMBRE   **************************/
if(isset($_GET['statut'])){
    //Récupération des vraiables
    $statut = $_GET['statut'];
    $personne = explode(".", $_GET['personne']);

    //Inscription?
    if(isset($_GET['rando'])){
        $inscr = $_GET['rando'];
    }
    else
        $inscr = 0;

    //Récupération du statut des personnes à rechercher
    //Et création de la requête
    if($statut == 't'){
        $statut = 'and estActif like 0';
    }
    elseif($statut == 'm'){
        $statut = 'AND estActif = 0 AND (numMembre is not null or numMembre != 0)';
    }
    elseif($statut == 'p'){
        $statut = 'AND estActif = 0 AND (numMembre is null or numMembre = 0)';
    }

    //Connexion à la base de données
    $connexion = connexionDB();

    //Récupération de la liste des personnes
    $listePersonne = "SELECT * FROM personne, langue, abonnement
                        WHERE personne.idxlangue= langue.codelangue
                        AND personne.idxAbonnement = abonnement.idAbonnement
                        AND lcase(nom) like '" . utf8_decode(strtolower($personne[0])) . "%'
                        AND lcase(prenom) like '" . utf8_decode(strtolower($personne[1])) . "%'
                $statut";
    $personnes = executeSQL($listePersonne);
    //echo $listePersonne;

    //Affichage de la table
    $table = "<tr>\n";
        $table .= "<th>Nom</th>\n";
        $table .= "<th>Prénom</th>\n";
        $table .= "<th>email</th>\n";
        $table .= "<th>Statut</th>\n";
        $table .= "<th>Abonnement de transports publics</th>";
        $table .= "<th>Localité</th>\n";
        $table .= "<th>Téléphone</th>\n";
        if($inscr == 0){
            $table .= "<th>Modification</th>\n";
            $table .= "<th>Inscriptions</th>\n";
        }
    $table .= "</tr>\n";

    $x = 0;

    //Ajout des lignes dans le tableau
    while($ligne = mysql_fetch_array($personnes)){
        if($x%2 == 0)
            $table .= "<tr>";
        else
            $table .= "<tr style='background-color:#F6CE61;'>";

        $table .= "<td>";
        if($inscr != 0)
            $table .= "<a href='AjouterInscription.php?idpersonne=$ligne[0]&idRando=$inscr' 
            onClick=\"s=prompt('Assurance:', 'Assurance');\">";

        //Affichage des données
        $table .= "<a id='infoPersonne' title=\"";
            //Mise en place de l'infobulle
            $personne = new personne();
            $personne->getPersonne($ligne[1], $ligne[2]);
            $table .= utf8_encode($personne->nom) . " " . utf8_encode($personne->prenom) . "<br />";
            $table .= str_replace("\\", "", utf8_encode($personne->adresse)) . "<br />";
            $table .= utf8_encode($personne->npa) . " " . utf8_encode($personne->localite) . "<br />";
            $table .= "tél: " . $personne->telephone . "<br />";
            $table .= "natel: " . $personne->portable . "<br />";
            $table .= "email: " . $personne->email . "<br />";
            if($personne->numMembre != '')
                $table .= "Numéro Membre: " . $personne->numMembre . "<br />";

            $table .= "langue: ";
            if($personne->langue == 'fr'){
                $table .= "Français";
            }
            else{
                $table .= "Allemand";
            }
        $table .= "\">" . utf8_encode($ligne[1]) . "</a>";


        if($inscr != 0)
            $table .= "</a>";
        $table .= "</td>";

        $table .= "<td>";
        if($inscr != 0)
            $table .= "<a href=\"AjouterInscription.php?idpersonne=$ligne[0]&idRando=$inscr\">";
        $table .= utf8_encode($ligne[2]);
        if($inscr != 0)
            $table .= "</a>";
        $table .= "</td>";

        $table .= "<td>".  utf8_encode($ligne[4])."</td>";
        $table .= "<td>";
        if($ligne[9] != 0){
                $table .= "Non-membre";
            }
            elseif($ligne[8] == 0 || $ligne[8] == ''){
                $table .= "Participant";
            }
            else{
                $table .= "Membre";
            }
        $table .= "</td>";
        $table .= "<td>".  utf8_encode($ligne[17])."</td>";
        $table .= "<td>".  utf8_encode($ligne[12])."</td>";
        $table .= "<td>".  utf8_encode($ligne[6])."</td>";

        if($inscr == 0){
            //Affichage de la modification
            $table .= "<td>";
            if(($ligne[8] == 0 || $ligne[8] == '') && $ligne[9] == 0){
                $table .= "<a href='ModifParticipant.php?id=$ligne[0]'><img src='../../pictures/edit.png' height='20px' /></a>";
            }
            else{
                $table .= "<a href='ModifParticipant.php?id=$ligne[0]&membre=true'>
                <img src='../../pictures/edit.png' height='20px' /></a>";
            }

            $table .= "</td>";

            //Affichage de la liste des inscriptions
            $table .= "<td>";
            $table .= "<a href='inscriptionsPersonne.php?id=$ligne[0]'>
            <img src='../../pictures/icons/mesRandos.png' height='20px' /></a>";
            $table .= "</td>";
        }
    $table .= "</tr>";

    $x += 1;
    }

    //Affiche du tableau
    echo $table;
}

/************  Modification de l'assurance ou de la remarque liée à une inscription ********/
if(isset($_GET['idpersonne'])){

    //Récupération des variables
    $idpersonne = $_GET['idpersonne'];
    $idrandonnee = $_GET['idrandonnee'];
    $remarque = utf8_decode($_GET['remarque']);

    //Connexion à la base de données
    $connexion = connexionDB();

    //Requête SQL
    $requete = "update inscription
                set remarque = '$remarque'
                where idpersonne = $idpersonne
                and idrandonnee = $idrandonnee";
    executeSQL($requete);

    //deconnexion de la base de données
    deconnexionDB();

    return "La remarque est enregistrée";
}
?>