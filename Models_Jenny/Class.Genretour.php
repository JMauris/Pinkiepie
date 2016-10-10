<?php

class Genretour {
	
	private $id;
	private $genreTour_fr;
	private $genreTour_de;
	
	public function __construct($id=null, $genreTour_fr, $genreTour_de) {
		$this->setId($id);
		$this->setGenreTour_fr($genreTour_fr);
		$this->setGenreTour_de($genreTour_de);
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id=$id;
	}
	
	public function getGenreTour_fr() {
		return $this->genreTour_fr;
	}
	
	public function setGenreTour_fr($genreTour_fr) {
		$this->genreTour_fr=$genreTour_fr;
	}
	
	public function getGenreTour_de() {
		return $this->genreTour_de;
	}
	
	public function setGenreTour_de($genreTour_de) {
		$this->genreTour_de=$genreTour_de;
	}
	
	public static function connectById($id) {
		$query = "SELECT * From genretour WHERE idGenreTour='$id'";
		$result = MySqlConn::getInstance()->selectDB($query);
	}
	
}

?>