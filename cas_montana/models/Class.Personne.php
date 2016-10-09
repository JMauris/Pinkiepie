<?php //15
class Personne{
  private $id;

  private $firstname;
  private $lastname;


  private $email;
  private $password;
  
  private $role;


  private $portable;
  private $phone;

  private $adresse;
  private $localite;
  private $npa;



  private $idxAbonnement;




  //It uses null as the default value for the function argument $id
  public function __construct($id=null, $firstname, $lastname,
                              $email, $password, $idxLangue, $estActif, $numMember, $role,
                               $portable, $phone, $adresse, $localite, $npa, $idxAbonnement){

      $this->setId($id);
      $this->setFirstname($firstname);
      $this->setLastname($lastname);


      $this->setEmail($email);

      $this->setPassword($password);

      $this->setIdxLangue($idxLangue);
      $this->setEstActif($estActif);

      $this->setNumMember($numMember);

      $this->setRole($role);

      $this->setPortable($portable);
      $this->setPhone($phone);

      $this->setAdresse($adresse);
      $this->setLocalite($localite);
      $this->setNpa($npa);

      $this->setIdxAbonnement($idxAbonnement);

      }


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
   $this->localite=$localite;
 }


 public function getNpa()
 {
   return $this->npa;
 }

  public function setNpa($npa){
    $this->npa=$npa;
  }

  public function getPortable()
  {
    return $this->portable;
  }

   public function setPortable($portable){
     $this->portable= $portable;
   }

   public function getPhone()
   {
     return $this->phone;
   }

    public function setPhone($phone){
      $this->phone=$phone;
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
                      , $row['idxLangue'], $row['estActif'] , $row['numMembre'], $row['role'], $row['portable'],
                       $row['telephone'], $row['adresse'], $row['localite'], $row['NPA'], $row['idxAbonnement']);


}









}

 ?>
