<?php
/**
 *
 */
class transport
{

   private $id;
   private $transport_de;
   private $transport_fr;

  function __construct($id, $transport_de, $transport_fr)
  {
    $this->setId($id);
    $this->setTransport_de($transport_de);
    $this->setTransport_fr($transport_fr);

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
  public function getTransport_de(){

    return $this->transport_de;
  }

  public function setTransport_de($transport_de)
  {
    $this->transport_de= $transport_de;
  }

  //id
  public function getTransport_fr(){

    return $this->transport_fr;
  }

  public function setTransport_fr($transport_fr)
  {
    $this->transport_fr= $transport_fr;
  }

  public static function connectbyId($id){
    $query =  "SELECT * From transport WHERE idTransport='$id' ";
    $result = MySqlConn::getInstance()->selectDB($query);
    $row=$result->fetch();
    if(!$row) return false;


    return new Typeretour($row['idTransport'],$row['transport_de'],$row['transport_fr']);

  }


}







 ?>
