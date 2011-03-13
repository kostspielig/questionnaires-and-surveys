<?php
/**
 * An experiment holds a set of surveys. Each survey holds a set of questions
 * and survey properties (see Survey and Question classes).
 * 
 * @author Kevin Brotcke <brotcke@gmail.com>
 * @package classes
 * @uses PHPExcel, Survey, Question
 */

require_once '../includes/PHPExcel/IOFactory.php';
require_once '../includes/classes.php';

class Experiment {
	
	/**
	 * @var Survey[]
	 */
	public $surveys = array();
	
	/**
	 * @param String $filename
	 * @return void
	 */
	public function loadExperimentFromExcelFile($filename) {
		if (!file_exists("../experiments/".$filename)) {
			exit("Error: File ".$filename." does not exist.");
		}
		$objPHPExcel = PHPExcel_IOFactory::load("../experiments/".$filename);
		
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$survey = new Survey();
			$survey->loadWorksheet($worksheet);
			$this->surveys[] = $survey;
		}
	}
	
	/**
	 * @param String|Integer $exp_id
	 * @return void
	 */
	public function loadExperimentFromDatabase($exp_id) {
		
	}
	
	public function toString() {
		return var_export($this, TRUE);
	}
} 

?>