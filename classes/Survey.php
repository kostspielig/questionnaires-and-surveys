<?php

class Survey {
	
	public $surveyProperties = array();
	public $surveyUserInfo = array();
	public $surveyItemCodes = array();
	public $surveyItems = array();
	public $surveyResponseTypes = array();
	
//	public function __contruct() {
//		
//	}
	
	public function loadWorksheet($worksheet) {
		
		$surveyProperties["questionsPerPage"] = $worksheet->getCell('B7')->getValue();
		$surveyProperties["name"] = $worksheet->getTitle();		
		
		$count = 55;
		$question = 0;
		while ($worksheet->getCell("A".$count)->getValue() != "") {
			$surveyItemCodes[$question] = $worksheet->getCell("A".$count)->getValue();
			$surveyItems[$question] = $worksheet->getCell("B".$count)->getValue();
			$surveyResponseTypes[$question] = $worksheet->getCell("C".$count)->getValue();
			$count++;
			$question++;
		}
		
		//var_dump(get_defined_vars());
	}
}

?>
