<<?php
class Statusinscription{

  private $id;

  private $status_de
  private $status_fr

  public function __construct($id=null,$status_de,$status_fr){

    $this->setId($id);
    $this->setStatus_de($status_de);
    $this->setStatus_fr($status_fr);

  }

  //id
  public function getId(){

    return $this->id;
  }

  public function setId($id)
  {
    $this->id= $id;
  }

  //id
  public function getStatus_de(){

    return $this->id;
  }

  public function setStatus_de($id)
  {
    $this->id= $id;
  }

  //id
  public function getStatus_fr(){

    return $this->id;
  }

  public function setStatus_fr($id)
  {
    $this->id= $id;
  }

}

public static function connectbyId($id){
  $query =  "SELECT * From statusinscription WHERE idStatusInscr='$id' ";
  $result = MySqlConn::getInstance()->selectDB($query);
  $row=$result->fetch();
  if(!$row) return false;

return new Statusinscription($row['idStatusInscr'], $row['statusInscr_de'], $row['statusInscr_fr']);
}


 ?>
