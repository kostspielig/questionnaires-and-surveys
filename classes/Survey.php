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

	public function loadFromDB(Experiment $experiment) {
		
	}
	
	public function loadWorksheet($worksheet) {
		
		$this->surveyProperties["name"] = $worksheet->getTitle();
		$this->surveyProperties["outputFilename"] = $worksheet->getCell('B2')->getValue();
		$this->surveyProperties["cssFilename"] = $worksheet->getCell('B3')->getValue();
		$this->surveyProperties["thankYouPage"] = $worksheet->getCell('B4')->getValue();

		$this->surveyProperties["surveyTableProperties_questionsPerPage"] = $worksheet->getCell('B7')->getValue();
		$this->surveyProperties["surveyTableProperties_pseudoRandomWidth"] = $worksheet->getCell('B8')->getValue();
		$this->surveyProperties["surveyTableProperties_width"] = $worksheet->getCell('B9')->getValue();
		$this->surveyProperties["surveyTableProperties_alignment"] = $worksheet->getCell('B10')->getValue();
		$this->surveyProperties["surveyTableProperties_borderThickness"] = $worksheet->getCell('B11')->getValue();
		$this->surveyProperties["surveyTableProperties_cellPadding"] = $worksheet->getCell('B12')->getValue();
		$this->surveyProperties["surveyTableProperties_cellSpacing"] = $worksheet->getCell('B13')->getValue();

		$this->surveyProperties["headerProperties_customHeader"] = $worksheet->getCell('B16')->getValue();
		$this->surveyProperties["headerProperties_leftTitle"] = $worksheet->getCell('B17')->getValue();
		$this->surveyProperties["headerProperties_rightTitle"] = $worksheet->getCell('B18')->getValue();
		$this->surveyProperties["headerProperties_alignment"] = $worksheet->getCell('B19')->getValue();
		$this->surveyProperties["headerProperties_borderThickness"] = $worksheet->getCell('B20')->getValue();
		$this->surveyProperties["headerProperties_padding"] = $worksheet->getCell('B21')->getValue();
		$this->surveyProperties["headerProperties_spacing"] = $worksheet->getCell('B22')->getValue();

		$this->surveyProperties["surveyLeftColumnProperties_width"] = $worksheet->getCell('B25')->getValue();
		$this->surveyProperties["surveyLeftColumnProperties_alignment"] = $worksheet->getCell('B26')->getValue();
		$this->surveyProperties["surveyLeftColumnProperties_borderThickness"] = $worksheet->getCell('B27')->getValue();
		$this->surveyProperties["surveyLeftColumnProperties_padding"] = $worksheet->getCell('B28')->getValue();
		$this->surveyProperties["surveyLeftColumnProperties_spacing"] = $worksheet->getCell('B29')->getValue();
		
		$this->surveyProperties["surveyRightColumnProperties_width"] = $worksheet->getCell('B32')->getValue();
		$this->surveyProperties["surveyRightColumnProperties_alignment"] = $worksheet->getCell('B33')->getValue();
		$this->surveyProperties["surveyRightColumnProperties_borderThickness"] = $worksheet->getCell('B34')->getValue();
		$this->surveyProperties["surveyRightColumnProperties_padding"] = $worksheet->getCell('B35')->getValue();
		$this->surveyProperties["surveyRightColumnProperties_spacing"] = $worksheet->getCell('B36')->getValue();
		
		$this->surveyProperties["paginationTextProperties_view"] = $worksheet->getCell('B39')->getValue();
		$this->surveyProperties["paginationTextProperties_alignment"] = $worksheet->getCell('B40')->getValue();
		$this->surveyProperties["paginationTextProperties_position"] = $worksheet->getCell('B41')->getValue();
		
		$this->surveyProperties["paginationButtonsTableProperties_width"] = $worksheet->getCell('B44')->getValue();
		$this->surveyProperties["paginationButtonsTableProperties_alignment"] = $worksheet->getCell('B45')->getValue();
		$this->surveyProperties["paginationButtonsTableProperties_borderThickness"] = $worksheet->getCell('B46')->getValue();
		$this->surveyProperties["paginationButtonsTableProperties_padding"] = $worksheet->getCell('B47')->getValue();
		$this->surveyProperties["paginationButtonsTableProperties_spacing"] = $worksheet->getCell('B48')->getValue();
		
		$count = 51;
		$question = 0;
		$cellValue = $worksheet->getCell('A'.$count)->getValue();
		while ($cellValue != "") {
			$this->surveyUserInfo[$question] = $worksheet->getCell('A'.$count)->getValue();
			$count++;
			$question++;
			$cellValue = $worksheet->getCell('A'.$count)->getValue();
		}
		
		$count += 2;
		$question = 0;
		while ($worksheet->getCell("A".$count)->getValue() != "") {
			$this->surveyItemCodes[$question] = $worksheet->getCell("A".$count)->getValue();
			$this->surveyItems[$question] = $worksheet->getCell("B".$count)->getValue();
			$this->surveyResponseTypes[$question] = $worksheet->getCell("C".$count)->getValue();
			$count++;
			$question++;
		}
		
		//var_dump(get_defined_vars());
	}
}

?>
