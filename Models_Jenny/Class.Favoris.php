<?php

class Favoris {
	
	private $idPersonne;
	private $idTour;
	private $estFavoris;
	private $evaluation;
	
	public function __construct($idPersonne, $idTour, $estFavoris, $evaluation) {
		$this->setIdPersonne($idPersonne);
		$this->setIdTour($idTour);
		$this->setEstFavoris($estFavoris);
		$this->setEvaluation($evaluation);
	}
	
	public function getIdPersonne() {
		return $this->idPersonne;
	}
	
	public function setIdPersonne($idPersonne) {
		$this->idPersonne=$idPersonne;
	}
	
	public function getIdTour() {
		return $this->idTour;
	}
	
	public function setIdTour($idTour) {
		$this->idTour=$idTour;
	}
	
	public function getEstFavoris() {
		return $this->estFavoris;
	}
	
	public function setEstFavoris($estFavoris) {
		$this->estFavoris=$estFavoris;
	}
	
	public function getEvaluation() {
		return $this->evaluation;
	}
	
	public function setEvaluation($evaluation) {
		$this->evaluation=$evaluation;
	}
	
	public static function connectById($idPersonne) {
		$query = "SELECT * From favoris WHERE idPersonne='$idPersonne'";
		$result = MySqlConn::getInstance()->selectDB($query);
	}
	
}

?>