<?php
include_once '../includes/PHPExcel/IOFactory.php';
include_once '../classes/Survey.php';
include_once '../classes/Model.php';
include_once '../classes/surveyDB.php';

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
		$m = new Model();
		$survey = $m->getFilename($exp_id);
		
		echo 'Test';
		echo "<br/>$survey";
		
	}
	
	// Incomplete
	public function loadExperimentFromDB($exp_id) {
		$m = new Model();
		//$surveyList =
		
		$surveyDB = new surveyDB();
		$surveyDB->printExperiments($type);
		

		
	}
	
} 

?>