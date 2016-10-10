<?php

class Abonnement {
	
	private $id;
	private $abo_fr;
	private $abo_de;
	
	public function __construct($id=null, $abo_fr, $abo_de) {
		$this->setId($id);
		$this->setAbo_fr($abo_fr);
		$this->setAbo_de($abo_de);
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id=$id;
	}
	
	public function getAbo_fr() {
		return $this->abo_fr;
	}
	
	public function setAbo_fr($abo_fr) {
		$this->abo_fr=$abo_fr;
	}
	
	public function getAbo_de() {
		return $this->abo_de;
	}
	
	public function setAbo_de($abo_de) {
		$this->abo_de=$abo_de;
	}
	
	public static function connectById($id) {
		$query = "SELECT * From abonnement WHERE idAbonnement='$id'";
		$result = MySqlConn::getInstance()->selectDB($query);
	}
	
}

?>