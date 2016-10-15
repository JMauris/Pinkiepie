<?php
/**
 *
 */
class Tour
{
  private $id;

  protected $arriveeHeure;
  protected $codeprogramme;
  protected $dateDebut;
  protected $dateFin;
  protected $dateLimiteInscr;

  protected $departHeure;
  protected $descente;
  protected $description_de;
  protected $description_fr;
  protected $difficulte;

  protected $duree;
  protected $idxArriveeLocalite;
  protected $idxAssistant;
  protected $idxDepartLocalite;
  protected $idxGuide;

  protected $idxTypeTour;
  protected $idxTypeTransport;
  protected $infromation_de;
  protected $information_fr;
  protected $inscriptionMax;

  protected $lienCarte;
  protected $lieuRDV;
  protected $montee;
  protected $prixMax;
  protected $prixMin;

  protected $soustitre;
  protected $status;
  protected $titre;
  protected $transportArrivee;
  protected $transportDepart;



  function __construct($id=null,
                        $arriveeHeure, $codeprogramme, $dateDebut, $dateFin, $dateLimiteInscr,
                        $departHeure, $descente, $description_de, $description_fr, $difficulte,
                        $duree, $idxArriveeLocalite, $idxAssistant, $idxDepartLocalite, $idxGuide,
                        $idxTypeTour, $idxTypeTransport, $infromation_de, $information_fr, $inscriptionMax,
                        $lienCarte, $lieuRDV, $montee, $prixMax, $prixMin,
                        $soustitre, $status, $titre, $transportArrivee, $transportDepart)
  {





      $this->setId($id);

    $this->setArriveeHeure($arriveeHeure);
    $this->setCodeprogramme($codeprogramme);
    $this->setDateDebut($dateDebut);
    $this->setDateFin($dateFin);
    $this->setDateLimiteInscr($dateLimiteInscr);

    $this->setDepartHeure($departHeure);
    $this->setDescente($descente);
    $this->setDescription_de($description_de);
    $this->setDescription_fr($description_fr);
    $this->setDifficulte($difficulte);

    $this->setDuree($duree);
    $this->setIdxArriveeLocalite($idxArriveeLocalite);
    $this->setIdxAssistant($idxAssistant);
    $this->setIdxDepartLocalite($idxDepartLocalite);
    $this->setIdxGuide($idxGuide);

    $this->setIdxTypeTour($idxTypeTour);
    $this->setIdxTypeTransport($idxTypeTransport);
    $this->setInfromation_de($infromation_de);
    $this->setInformation_fr($information_fr);
    $this->setInscriptionMax($inscriptionMax);

    $this->setLienCarte($lienCarte);
    $this->setLieuRDV($lieuRDV);
    $this->setMontee($montee);
    $this->setPrixMax($prixMax);
    $this->setPrixMin($prixMin);

    $this->setSoustitre($soustitre);
    $this->setStatus($status);
    $this->setTitre($titre);
    $this->setTransportArrivee($transportArrivee);
    $this->setTransportDepart($transportDepart);

  }


//id
public function getId(){

  return $this->id;
}

public function setId($id)
{
  $this->id= $id;
}


public function getArriveeHeure(){

  return $this->arriveeHeure;
}

public function setArriveeHeure($arriveeHeure)
{
  $this->arriveeHeure= $arriveeHeure;
}

public function getCodeprogramme(){

  return $this->codeprogramme;
}

public function setCodeprogramme($codeprogramme)
{
  $this->codeprogramme= $codeprogramme;
}


public function getDateDebut(){

  return $this->dateDebut;
}

public function setDateDebut($dateDebut)
{
  $this->dateDebut= $dateDebut;
}


public function getDateFin(){

  return $this->dateFin;
}

public function setDateFin($dateFin)
{
  $this->dateFin= $dateFin;
}


public function getDateLimiteInscr(){

  return $this->dateLimiteInscr;
}

public function setDateLimiteInscr($dateLimiteInscr)
{
  $this->dateLimiteInscr= $dateLimiteInscr;
}


public function getDepartHeure(){

  return $this->departHeure;
}

public function setDepartHeure($departHeure)
{
  $this->departHeure= $departHeure;
}


public function getDescente(){

  return $this->descente;
}

public function setDescente($descente)
{
  $this->descente= $descente;
}


public function getDescription_de(){

  return $this->description_de;
}

public function setDescription_de($description_de)
{
  $this->description_de= $description_de;
}


public function getDescription_fr(){

  return $this->description_fr;
}

public function setDescription_fr($description_fr)
{
  $this->description_fr= $description_fr;
}


public function getDifficulte(){

  return $this->difficulte;
}

public function setDifficulte($difficulte)
{
  $this->id= $difficulte;
}



public function getDuree(){

  return $this->Duree;
}

public function setDuree($duree)
{
  $this->duree= $duree;
}


public function getIdxArriveeLocalite(){

  return $this->idxArriveeLocalite;
}

public function setIdxArriveeLocalite($idxArriveeLocalite)
{
  $this->idxArriveeLocalite= $idxArriveeLocalite;
}


public function getIdxAssistant(){

  return $this->idxAssistant;
}

public function setIdxAssistant($idxAssistant)
{
  $this->idxAssistant= $idxAssistant;
}


public function getIdxDepartLocalite(){

  return $this->idxDepartLocalite;
}

public function setIdxDepartLocalite($idxDepartLocalite)
{
  $this->idxDepartLocalite= $idxDepartLocalite;
}


public function getIdxGuide(){

  return $this->idxGuide;
}

public function setIdxGuide($idxGuide)
{
  $this->idxGuide= $idxGuide;
}


public function getIdxTypeTour(){

  return $this->idxTypeTour;
}

public function setIdxTypeTour($idxTypeTour)
{
  $this->idxTypeTour= $idxTypeTour;
}


public function getIdxTypeTransport(){

  return $this->idxTypeTransport;
}

public function setIdxTypeTransport($idxTypeTransport)
{
  $this->idxTypeTransport= $idxTypeTransport;
}



public function getInfromation_de(){

  return $this->infromation_de;
}

public function setInfromation_de($infromation_de)
{
  $this->infromation_de= $infromation_de;
}


public function getInformation_fr(){

  return $this->information_fr;
}

public function setInformation_fr($information_fr)
{
  $this->information_fr= $information_fr;
}


public function getInscriptionMax(){

  return $this->inscriptionMax;
}

public function setInscriptionMax($inscriptionMax)
{
  $this->inscriptionMax= $inscriptionMax;
}


public function getLienCarte(){

  return $this->lienCarte;
}

public function setLienCarte($lienCarte)
{
  $this->lienCarte= $lienCarte;
}


public function getLieuRDV(){

  return $this->lieuRDV;
}

public function setLieuRDV($lieuRDV)
{
  $this->lieuRDV= $lieuRDV;
}


public function getMontee(){

  return $this->montee;
}

public function setMontee($montee)
{
  $this->montee= $montee;
}


public function getPrixMax(){

  return $this->prixMax;
}

public function setPrixMax($prixMax)
{
  $this->prixMax= $prixMax;
}


public function getPrixMin(){

  return $this->prixMin;
}

public function setPrixMin($prixMin)
{
  $this->prixMin= $prixMin;
}


public function getSoustitre(){

  return $this->soustitre;
}

public function setSoustitre($soustitre)
{
  $this->soustitre= $soustitre;
}


public function getStatus(){

  return $this->status;
}

public function setStatus($status)
{
  $this->status= $status;
}


public function getTitre(){

  return $this->titre;
}

public function setTitre($titre)
{
  $this->titre= $titre;
}


public function getTransportArrivee(){

  return $this->transportArrivee;
}

public function setTransportArrivee($transportArrivee)
{
  $this->transportArrivee= $transportArrivee;
}


public function getTransportDepart(){

  return $this->transportDepart;
}

public function setTransportDepart($transportDepart)
{
  $this->transportDepart= $transportDepart;
}


public static function connectbyId($id)
{
  $query =  "SELECT * From tour WHERE idTour='$id' ";
  $result = MySqlConn::getInstance()->selectDB($query);
  $row=$result->fetch();
  if(!$row) return false;

  return new Tour($row['idTour'],
                  $row['arriveeHeure'], $row['codeprogramme'],$row['dateDebut'], $row['dateFin'], $row['dateLimiteInscr'],
                  $row['departHeure'], $row['descente'],$row['description_de'], $row['description_fr'], $row['difficulte'],
                  $row['duree'], $row['idxArriveeLocalite'],$row['idxAssistant'], $row['idxDepartLocalite'], $row['idxGuide'],
                  $row['idxTypeTour'], $row['idxTypeTransport'],$row['infromation_de'], $row['information_fr'], $row['inscriptionMax'],
                  $row['lienCarte'], $row['lieu'],$row['montee'], $row['prixMax'], $row['prixMin'],
                  $row['soustitre'], $row['status'],$row['titre'], $row['transportArrivee'], $row['transportDepart']);




}


//return and array
public static function connectbyIdType($idxTypeTour)
{
  $query =  "SELECT * From tour WHERE idTypeTour='$idxTypeTour' ";
  $result = MySqlConn::getInstance()->selectDB($query);

  //todo


}
//if programm 1 or and 2 // proposal 6
public static function connectTour($idTour1, $idTour2)
{

  if($idTour1==null && $idTour2 == null)
  {
    $query =  Tour::queryAll();
  }
    elseif ( $idTour2 == null) {
    $query =  Tour::queryOne($idTour1);
    }
    else {
    $query = Tour::queryTwo($idTour1, $idTour2);
    }

  $result = MySqlConn::getInstance()->selectDB($query);


  while($row = $result->fetch())
  {
    $resultArray[] =   new Tour($row['idTour'],
                $row['arriveeHeure'], $row['codeprogramme'],$row['dateDebut'], $row['dateFin'], $row['dateLimiteInscr'],
                $row['departHeure'], $row['descente'],$row['description_de'], $row['description_fr'], $row['difficulte'],
                $row['duree'], $row['idxArriveeLocalite'],$row['idxAssistant'], $row['idxDepartLocalite'], $row['idxGuide'],
                $row['idxTypeTour'], $row['idxTypeTransport'],$row['information_de'], $row['information_fr'], $row['inscriptionMax'],
                $row['lienCarte'], $row['lieuRDV'],$row['montee'], $row['prixMax'], $row['prixMin'],
                $row['soustitre'], $row['status'],$row['titre'], $row['transportArrivee'], $row['transportDepart']);

                }

                $result->closeCursor();

return $resultArray;

}

private static function queryAll()
{
  $query =  "SELECT * From tour ";

  return $query;
}

private static function queryOne($idTour1)
{
  $query =  "SELECT * From tour
              where idxTypeTour = 1";

  return $query;
}
private static function queryTwo($idTour1, $idTour2)
{
  $query =  "SELECT * From tour
              where idxTypeTour = 1
              or idxTypeTour = 2";

  return $query;
}
}

?>
