<?php

include_once 'surveyDB.php';
include_once 'Experiment.php';

class Model {
    public $db;   
 
    public function __construct()  
    {  
         $this->db = new surveyDB();  
    }   
	public function getExperimentList() {
		$this->db->open();
		$list = $this->db->getExperiments();
		$this->db->close();
		return $list;
	}

	public function checkUser ($name, $pass) {
		$this->db->open();
		$res = $this->db->getUser ($name, $pass);
		$this->db->close();
		return $res;
	}
	
	public function uploadExperiment(Experiment $exp, $name, $admin) {
		$this->db->open();
		// Insert experiment
		$id = $db->insertExperiment($name,"NULL, '".$name."', '".$admin."'");
		// Insert survey
		$this->db->close();
	}
}
?>