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
		
		$surveyProperties["name"] = $worksheet->getTitle();
		$surveyProperties["outputFilename"] = $worksheet->getCell('B2')->getValue();
		$surveyProperties["cssFilename"] = $worksheet->getCell('B3')->getValue();
		$surveyProperties["thankYouPage"] = $worksheet->getCell('B4')->getValue();

		$surveyProperties["surveyTableProperties_questionsPerPage"] = $worksheet->getCell('B7')->getValue();
		$surveyProperties["surveyTableProperties_pseudoRandomWidth"] = $worksheet->getCell('B8')->getValue();
		$surveyProperties["surveyTableProperties_width"] = $worksheet->getCell('B9')->getValue();
		$surveyProperties["surveyTableProperties_alignment"] = $worksheet->getCell('B10')->getValue();
		$surveyProperties["surveyTableProperties_borderThickness"] = $worksheet->getCell('B11')->getValue();
		$surveyProperties["surveyTableProperties_cellPadding"] = $worksheet->getCell('B12')->getValue();
		$surveyProperties["surveyTableProperties_cellSpacing"] = $worksheet->getCell('B13')->getValue();

		$surveyProperties["headerProperties_customHeader"] = $worksheet->getCell('B16')->getValue();
		$surveyProperties["headerProperties_leftTitle"] = $worksheet->getCell('B17')->getValue();
		$surveyProperties["headerProperties_rightTitle"] = $worksheet->getCell('B18')->getValue();
		$surveyProperties["headerProperties_alignment"] = $worksheet->getCell('B19')->getValue();
		$surveyProperties["headerProperties_borderThickness"] = $worksheet->getCell('B20')->getValue();
		$surveyProperties["headerProperties_padding"] = $worksheet->getCell('B21')->getValue();
		$surveyProperties["headerProperties_spacing"] = $worksheet->getCell('B22')->getValue();

		$surveyProperties["surveyLeftColumnProperties_width"] = $worksheet->getCell('B25')->getValue();
		$surveyProperties["surveyLeftColumnProperties_alignment"] = $worksheet->getCell('B26')->getValue();
		$surveyProperties["surveyLeftColumnProperties_borderThickness"] = $worksheet->getCell('B27')->getValue();
		$surveyProperties["surveyLeftColumnProperties_padding"] = $worksheet->getCell('B28')->getValue();
		$surveyProperties["surveyLeftColumnProperties_spacing"] = $worksheet->getCell('B29')->getValue();
		
		$surveyProperties["surveyRightColumnProperties_width"] = $worksheet->getCell('B32')->getValue();
		$surveyProperties["surveyRightColumnProperties_alignment"] = $worksheet->getCell('B33')->getValue();
		$surveyProperties["surveyRightColumnProperties_borderThickness"] = $worksheet->getCell('B34')->getValue();
		$surveyProperties["surveyRightColumnProperties_padding"] = $worksheet->getCell('B35')->getValue();
		$surveyProperties["surveyRightColumnProperties_spacing"] = $worksheet->getCell('B36')->getValue();
		
		$surveyProperties["paginationTextProperties_view"] = $worksheet->getCell('B39')->getValue();
		$surveyProperties["paginationTextProperties_alignment"] = $worksheet->getCell('B40')->getValue();
		$surveyProperties["paginationTextProperties_position"] = $worksheet->getCell('B41')->getValue();
		
		$surveyProperties["paginationButtonsTableProperties_width"] = $worksheet->getCell('B44')->getValue();
		$surveyProperties["paginationButtonsTableProperties_alignment"] = $worksheet->getCell('B45')->getValue();
		$surveyProperties["paginationButtonsTableProperties_borderThickness"] = $worksheet->getCell('B46')->getValue();
		$surveyProperties["paginationButtonsTableProperties_padding"] = $worksheet->getCell('B47')->getValue();
		$surveyProperties["paginationButtonsTableProperties_spacing"] = $worksheet->getCell('B48')->getValue();
		
		$count = 51;
		$question = 0;
		$cellValue = $worksheet->getCell('A'.$count)->getValue();
		while ($cellValue != "") {
			$surveyUserInfo[$question] = $worksheet->getCell('A'.$count)->getValue();
			$count++;
			$question++;
			$cellValue = $worksheet->getCell('A'.$count)->getValue();
		}
		
		$count += 2;
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
