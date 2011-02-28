<?php
include_once '../includes/PHPExcel/IOFactory.php';
include_once '../classes/Survey.php';

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
			$surveys[$count] = $survey;
			$count++;
		}
		
		//var_dump(get_defined_vars());	
	}
} 

?>