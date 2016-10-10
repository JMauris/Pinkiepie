<?php

class Inscription {
	
	private $idPersonne;
	private $idRandonnee;
	private $date;
	private $heure;
	private $idxStatus;
	private $remarque;
	
	public function __construct($idPersonne, $idRandonnee, $date, $heure, $idxStatus, $remarque) {
		$this->setIdPersonne($idPersonne);
		$this->setIdRandonnee($idRandonnee);
		$this->setDate($date);
		$this->setHeure($heure);
		$this->setIdxStatus($idxStatus);
		$this->setRemarque($remarque);		
	}
	
	public function getIdPersonne() {
		return $this->idPersonne;
	}
	
	public function setIdPersonne($idPersonne) {
		$this->idPersonne=$idPersonne;
	}
	
	public function getIdRandonnee() {
		return $this->idRandonnee;
	}
	
	public function setIdRandonnee($idRandonnee) {
		$this->idRandonnee=$idRandonnee;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function setDate($date) {
		$this->date=$date;
	}
	
	public function getHeure() {
		return $this->heure;
	}
	
	public function setHeure($heure) {
		$this->heure=$heure;
	}
	
	public function getIdxStatus() {
		return $this->idxStatus;
	}
	
	public function setIdxStatus($idxStatus) {
		$this->idxStatus=$idxStatus;
	}
	
	public function getRemarque() {
		return $this->remarque;
	}
	
	public function setRemarque($remarque) {
		$this->remarque=$remarque;
	}
	
	public static function connectById($idPersonne, $idRandonnee) {
		$query = "SELECT * From genretour WHERE idPersonne='$idPersonne' AND idRandonnee='$idRandonnee'";
		$result = MySqlConn::getInstance()->selectDB($query);
	}
	
}

?>