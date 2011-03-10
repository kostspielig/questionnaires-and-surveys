<?php
require_once '../includes/PHPExcel/IOFactory.php';
require_once '../includes/classes.php';

//TODO: check format, question spacing

class Experiment {
	
	public $surveys = array();
	
	public function loadExperimentFromExcelFile($filename) {
		
		if (!file_exists("../experiments/".$filename)) {
			exit("Error: File ".$filename." does not exist.");
		}
		
		$objPHPExcel = PHPExcel_IOFactory::load("../experiments/".$filename);
		
		$count = 0;
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$survey = new Survey();
			$survey->loadWorksheet($worksheet);
			$this->surveys[$count] = $survey;
			$count++;
		}
		
		//var_dump(get_defined_vars());	
	}
	
	// Incomplete
	public function loadRandomSurveyFromDB($exp_id) {
		$database = new Database();
		$survey = $database->getFilename($exp_id);
		
		echo 'Test';
		echo "<br/>$survey";
	}
	
	// Incomplete
	public function loadExperimentFromDB($exp_id) {
		$database = new Database();
		//$surveyList =

		
	}
	
} 

?>