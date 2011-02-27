<?php
include '../includes/PHPExcel/IOFactory.php';

class ExperimentReader {
	
	public $experimentProperties = array();
	public $experimentItemCodes = array();
	public $experimentItems = array();
	public $experimentResponseTypes = array();
	
	public function loadExperiment($filename) {
		
		if (!file_exists("../experiments/".$filename)) {
			exit("Error: File ".$filename." does not exist.");
		}
		
		$objPHPExcel = PHPExcel_IOFactory::load("../experiments/".$filename);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		//echo "Read from cell B7: ",$objPHPExcel->getActiveSheet()->getCell('B7')->getValue();
		
		$experimentProperties["questionsPerPage"] = $objPHPExcel->getActiveSheet()->getCell('B7')->getValue();
		
		$count = 55;
		$question = 0;
		while ($objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue() != "") {
			$experimentItemCodes[$question] = $objPHPExcel->getActiveSheet()->getCell("A".$count)->getValue();
			$experimentItems[$question] = $objPHPExcel->getActiveSheet()->getCell("B".$count)->getValue();
			$experimentResponseTypes[$question] = $objPHPExcel->getActiveSheet()->getCell("C".$count)->getValue();
			$count++;
			$question++;
		}
		
		//var_dump(get_defined_vars());
		
	}
	
} 