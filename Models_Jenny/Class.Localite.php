<?php

class Localite {
	
	private $NPA;
	private $localite;
	private $idxRegion;
	
	public function __construct($npa, $localite, $idxRegion) {
		$this->setNPA($npa);
		$this->setLocalite($localite);
		$this->setIdxRegion($idxRegion);
	}
	
	public function getNPA() {
		return $this->NPA;
	}
	
	public function setNPA($npa) {
		$this->NPA=$npa;
	}
	
	public function getLocalite() {
		return $this->localite;
	}
	
	public function setLocalite($localite) {
		$this->localite=$localite;
	}
	
	public function getIdxRegion() {
		return $this->idxRegion;
	}
	
	public function setIdxRegion($idxRegion) {
		$this->idxRegion=$idxRegion;
	}
	
	public static function connectById($localite) {
		$query = "SELECT * From localite WHERE localite='$localite'";
		$result = MySqlConn::getInstance()->selectDB($query);
	}
	
}

?>