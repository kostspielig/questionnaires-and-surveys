<?php
/**
 * Survey object to encapsulate all survey information. A survey is made up of
 * questions as well as a set of properties.
 * 
 * @author Kevin Brotcke <brotcke@gmail.com>
 * @package classes
 * @uses Question
 */
class Survey {
	
	/**
	 * Array that holds the properties of the survey.
	 * @var String[]
	 */
	public $surveyProperties = array();
	
	/**
	 * Array that holds UserQuestion objects.
	 * @var UserQuestion[]
	 */
	public $userQuestions = array();
	
	/**
	 * Array that holds SurveyQuestion objects
	 * @var SurveyQuestion[]
	 */
	public $surveyQuestions = array();
	
	const USER_QUESTION_START_LINE = 52;
	public $date;
	
	public function Survey() {
		$this->date = date('m/d/y h:ia');
	}
	
	/**
	 * Method to add a SurveyQuestion object to the survey.
	 * @param SurveyQuestion $surveyQuestion
	 * @return void
	 */
	public function addSurveyQuestion($surveyQuestion) {
		$this->surveyQuestions[] = $surveyQuestion;
	}
	
	/**
	 * Method to add a UserQuestion object to the survey.
	 * @param UserQuestion $userQuestion
	 * @return void
	 */
	public function addUserQuestion($userQuestion) {
		$this->userQuestions[] = $userQuestion;
	}
	
	/**
	 * Reads a worksheet file (page from excel file) and saves all the data into
	 * the survey.
	 * @param PHPExcel $worksheet
	 * @return void
	 * @todo Add option to remove unused options.
	 */
	public function loadWorksheet($worksheet) {
		
		$this->surveyProperties["name"] = $worksheet->getTitle();
		$this->surveyProperties["outputFilename"] = $worksheet->getCell('B2')->getValue();
		$this->surveyProperties["cssFilename"] = $worksheet->getCell('B3')->getValue();
		$this->surveyProperties["thankYouPage"] = $worksheet->getCell('B4')->getValue();

		$this->surveyProperties["surveyTableProperties_questionsPerPage"] = $worksheet->getCell('B7')->getValue();
		$this->surveyProperties["surveyTableProperties_pseudoRandomWidth"] = $worksheet->getCell('B8')->getValue();		
		$this->surveyProperties["surveyTableProperties_numberNonRandom"] = $worksheet->getCell('B9')->getValue();
		$this->surveyProperties["surveyTableProperties_width"] = $worksheet->getCell('B10')->getValue();
		$this->surveyProperties["surveyTableProperties_alignment"] = $worksheet->getCell('B11')->getValue();
		$this->surveyProperties["surveyTableProperties_borderThickness"] = $worksheet->getCell('B12')->getValue();
		$this->surveyProperties["surveyTableProperties_cellPadding"] = $worksheet->getCell('B13')->getValue();
		$this->surveyProperties["surveyTableProperties_cellSpacing"] = $worksheet->getCell('B14')->getValue();

		$this->surveyProperties["headerProperties_customHeader"] = $worksheet->getCell('B17')->getValue();
		$this->surveyProperties["headerProperties_leftTitle"] = $worksheet->getCell('B18')->getValue();
		$this->surveyProperties["headerProperties_rightTitle"] = $worksheet->getCell('B19')->getValue();
		$this->surveyProperties["headerProperties_alignment"] = $worksheet->getCell('B20')->getValue();
		$this->surveyProperties["headerProperties_borderThickness"] = $worksheet->getCell('B21')->getValue();
		$this->surveyProperties["headerProperties_padding"] = $worksheet->getCell('B22')->getValue();
		$this->surveyProperties["headerProperties_spacing"] = $worksheet->getCell('B23')->getValue();

		$this->surveyProperties["surveyLeftColumnProperties_width"] = $worksheet->getCell('B26')->getValue();
		$this->surveyProperties["surveyLeftColumnProperties_alignment"] = $worksheet->getCell('B27')->getValue();
		$this->surveyProperties["surveyLeftColumnProperties_borderThickness"] = $worksheet->getCell('B28')->getValue();
		$this->surveyProperties["surveyLeftColumnProperties_padding"] = $worksheet->getCell('B29')->getValue();
		$this->surveyProperties["surveyLeftColumnProperties_spacing"] = $worksheet->getCell('B30')->getValue();
		
		$this->surveyProperties["surveyRightColumnProperties_width"] = $worksheet->getCell('B33')->getValue();
		$this->surveyProperties["surveyRightColumnProperties_alignment"] = $worksheet->getCell('B34')->getValue();
		$this->surveyProperties["surveyRightColumnProperties_borderThickness"] = $worksheet->getCell('B35')->getValue();
		$this->surveyProperties["surveyRightColumnProperties_padding"] = $worksheet->getCell('B36')->getValue();
		$this->surveyProperties["surveyRightColumnProperties_spacing"] = $worksheet->getCell('B37')->getValue();
		
		$this->surveyProperties["paginationTextProperties_view"] = $worksheet->getCell('B40')->getValue();
		$this->surveyProperties["paginationTextProperties_alignment"] = $worksheet->getCell('B41')->getValue();
		$this->surveyProperties["paginationTextProperties_position"] = $worksheet->getCell('B42')->getValue();
		
		$this->surveyProperties["paginationButtonsTableProperties_width"] = $worksheet->getCell('B45')->getValue();
		$this->surveyProperties["paginationButtonsTableProperties_alignment"] = $worksheet->getCell('B46')->getValue();
		$this->surveyProperties["paginationButtonsTableProperties_borderThickness"] = $worksheet->getCell('B47')->getValue();
		$this->surveyProperties["paginationButtonsTableProperties_padding"] = $worksheet->getCell('B48')->getValue();
		$this->surveyProperties["paginationButtonsTableProperties_spacing"] = $worksheet->getCell('B49')->getValue();
		
		// Loads user info questions
		$count = Survey::USER_QUESTION_START_LINE;
		$cellValue = $worksheet->getCell('A'.$count)->getValue();
		while ($cellValue != "") {
			$this->userQuestions[] = new UserQuestion(
				$worksheet->getCell('A'.$count)->getValue()
			);
			
			$count++;
			$cellValue = $worksheet->getCell('A'.$count)->getValue();
		}
		
		// Loads regular survey questions
		$count += 2;
		$cellValue = $worksheet->getCell('A'.$count)->getValue();
		while ($cellValue != "") {
			$this->surveyQuestions[] = new SurveyQuestion(
				$cellValue,
				$worksheet->getCell("B".$count)->getValue(),
				$worksheet->getCell("C".$count)->getValue()
			);
			
			$count++;
			$cellValue = $worksheet->getCell('A'.$count)->getValue();
		}
	}
	
	public function toString() {
		return var_dump($this);
	}
}

?>
