<?php //15
class Personne{
  private $id;

  private $firstname;
  private $lastname;


  private $email;
  private $password;


  private $idxLangue;

  //It uses null as the default value for the function argument $id
  public function __construct($id=null, $firstname, $lastname,
                              $email, $password){

      $this->setId($id);

      $this->setFirstname($firstname);
      $this->setLastname($lastname);

      $this->setEmail($email);
      $this->setPassword($password);





      }

//It uses null as the default value for the function argument $id
/*public function __construct($id=null, $firstname=null, $lastname=null, $email=null, $password=null,
                            $adresse=null, $localite=null, $NPA=null, $portable=null, $phone=null, $numMember=null,
                            $estActif=null, $role=null, $idxAbonnement=null, $idxLangue){



    $this->setNPA($NPA);

    $this->setPortable($portable);
    $this->setPhone($phone);

    $this->setNumMember($numMember);
    $this->setEstActif($estActif);
    $this->setRole($role);

    $this->setIdxAbonnement($idxAbonnement);
    $this->setIdxLangue($idxLangue);
    }

*/


  //id
  public function getId(){

    return $this->id;
  }

  public function setId($id)
  {
    $this->id= $id;
  }

  public function getEmail(){
    return $this->email;
  }

  public function setEmail($email){
    $this->email = $email;
  }

  public function getPassword(){
  		return $this->password;
  	}

	public function setPassword($password){
  		$this->password = $password;
  	}

//firstname
  public function getFirstname(){
    return $this->firstname;
  }

  public function setFirstname($firstname){
    $this->firstname = $firstname;
  }

  //lastname
  public function getLastname(){
    return $this->lastname;
  }

  public function setLastname($lastname){
    $this->lastname = $lastname;
  }
 public function getAdresse(){
   return $this->adresse;
 }

 public function setAdresse($adresse){
   $this->adresse = $adresse;
 }

 public function getLocalite()
 {
   return $this->localite;
 }

 public function setLocalite($localite){
   $this->localite->$localite;
 }


 public function getNpa()
 {
   return $this->npa;
 }

  public function setNpa($npa){
    $this->npa->$npa;
  }

  public function getPortable()
  {
    return $this->portable;
  }

   public function setPortable($portable){
     $this->portable->$portable;
   }

   public function getPhone()
   {
     return $this->phone;
   }

    public function setPhone($phone){
      $this->Phone->$phone;
    }

    public function getNumMember(){
  		return $this->numMember;
  	}

  	public function setNumMember($numMember){
  		$this->numMember = $numMember;
  	}

    public function getEstActif(){
      return $this->estActif;
    }

    public function setEstActif($estActif){
      $this->estActif = $estActif;
    }

    public function getRole(){
      return $this->role;
    }

    public function setRole($role){
      $this->role = $role;
    }

    public function getIdxAbonnement(){
      return $this->idxAbonnement;
    }

    public function setIdxAbonnement($idxAbonnement){
      $this->idxAbonnement = $idxAbonnement;
    }

    public function getIdxLangue(){
      return $this->idxLangue;
    }

    public function setIdxLangue($idxLangue){
      $this->idxLangue = $idxLangue;
    }
public static function connect($adressEmail,$pwd){

  $pwd = sha1($pwd);
  $query = "SELECT * From personne WHERE email='$adressEmail' AND motDePasse='$pwd'";
  $result = MySqlConn::getInstance()->selectDB($query);
  $row = $result->fetch();
  if(!$row) return false;

  return new Personne($row['idPersonne'], $row['prenom'], $row['nom'],$row['email'], $row['motDePasse']
                      , $row['adresse'], $row['Localite'] , $row['NPA']); /*, $row['portable'], $row['telephone'], $row['numMembre'],
                      $row['estActif'], $row['role'], $row['idxAbonnement'], $row['idxLangue']);*/


                      /*, $row['NPA']); /*, $row['portable'], $row['telephone'], $row['numMembre'],
                      $row['estActif'], $row['role'], $row['idxAbonnement'], $row['idxLangue']);*/
}


/*	public function save(){
		$pwd = sha1($this->password);
		$query = "INSERT into user(firstname, lastname, username, password)
		VALUES('$this->firstname', '$this->lastname', '$this->username', '$pwd');";

		return  MySqlConn::getInstance()->executeQuery($query);
	}*/








}

 ?>
