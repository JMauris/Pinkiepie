<? php

class Region
{
  private $id;
  private $typeTour_de;
  private $typeTour_fr;


  function __construct($id=null, $typeTour_de, $typeTour_fr)
  {

    $this->setId($id);
    $this->setTypeTour_de($typeTour_de);
    $this->setTypeTour_fr($typeTour_fr);

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
    public function getTypeTour_de(){

      return $this->$typeTour_de;
    }

    public function setTypeTour_de($typeTour_de)
    {
      $this->typeTour_de= $typeTour_de;
    }

      //id
      public function getTypeTour_fr(){

        return $this->$typeTour_fr;
      }

      public function setTypeTour_fr($typeTour_fr)
      {
        $this->typeTour_fr= $typeTour_fr;
      }


      public static function connectbyId($id){
        $query =  "SELECT * From typetour WHERE idTypeTour='$id' ";
        $result = MySqlConn::getInstance()->selectDB($query);
        $row=$result->fetch();
        if(!$row) return false;


        return new Typeretour($row['idTypeTour'],$row['typeTour_de'],$row['typeTour_fr'],)

      }

}



 ?>
