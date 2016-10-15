<? php
/**
 *
 */
class Tourgenretour extends Tour
{

  private $id;
  private $idxTour;
  function __construct($id=null, $idxTour)
  {
    $this->setId($id);
    $this->setIdxTour($idxTour);
  }

  public function getId(){

    return $this->id;
  }

  public function setId($id)
  {
    $this->id= $id;
  }


  public function getIdxTour(){

    return $this->idxTour;
  }

  public function setIdxTour($idxTour)
  {
    $this->idxTour= $idxTour;
  }


public static function connectbyId($id)
{
  $query =  "SELECT * From typetour WHERE idxGenreTour='$id' ";
  $result = MySqlConn::getInstance()->selectDB($query);
  $row=$result->fetch();
  if(!$row) return false;


  return new Typeretour($row['idxGenreTour'],$row['idxTour']);
}

}


 ?>
