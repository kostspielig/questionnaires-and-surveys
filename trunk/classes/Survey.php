<?php

class Survey {
	
	public $experimentProperties = array();
	public $experimentUserInfo = array();
	public $experimentItemCodes = array();
	public $experimentItems = array();
	public $experimentResponseTypes = array();
	
//	public function __contruct() {
//		
//	}
	
	public function loadWorksheet($worksheet) {
		
		$experimentProperties["questionsPerPage"] = $worksheet->getCell('B7')->getValue();
		$experimentProperties["name"] = $worksheet->getTitle();		
		
		$count = 55;
		$question = 0;
		while ($worksheet->getCell("A".$count)->getValue() != "") {
			$experimentItemCodes[$question] = $worksheet->getCell("A".$count)->getValue();
			$experimentItems[$question] = $worksheet->getCell("B".$count)->getValue();
			$experimentResponseTypes[$question] = $worksheet->getCell("C".$count)->getValue();
			$count++;
			$question++;
		}
		
		//var_dump(get_defined_vars());
		
	}
	
}

?>
