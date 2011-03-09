<?php

////////////////////////////////////////
// OUTDATED: Here only as a reference.
////////////////////////////////////////


class SurveyGeneratorClass {
	
	//where the first entry for survey item is in input file
	//is used to skip ahead to survey after options have been saved
	var $surveyItemStartLineNumber = 58;
	
	//variables
	var $questionsPerPage;
	var $totalPages;
	var $currentPage;
	var $totalQuestions;
	var $currentQuestion;
	var $tempAnswersArray;       //array
	//var $outputLastLine;
	var $missedQuestionsArray;   //array
	var $userInfoAnswerArray;	 //array
	var $userInfoQuestionsArray; //array
	var $reservedOutputLineNumber;
	
	//display options
	var $tableWidth;
	var $tableAlignment;
	var $borderThickness;
	var $cellPadding;
	var $cellSpacing;
	
	var $headerCustom;
	var $headerTitleLeft;
	var $headerTitleRight;
	var $headerAlignment;
	var $headerBorderThickness;
	var $headerPadding;
	var $headerSpacing;
	
	var $leftColumnWidth;
	var $leftColumnAlignment;
	var $leftColumnBorderThickness;
	var $leftColumnPadding;
	var $leftColumnSpacing;
	
	var $rightColumnWidth;
	var $rightColumnAlignment;
	var $rightColumnBorderThickness;
	var $rightColumnPadding;
	var $rightColumnSpacing;
	
	var $paginationTextView;
	var $paginationTextAlignment;
	var $paginationTextPosition;
	var $paginationButtonsWidth;
	var $paginationButtonsAlignment;
	var $paginationButtonsBorderThickness;
	var $paginationButtonsPadding;
	var $paginationButtonsSpacing;
	
	
	//filenames
	var $inputFileName;
	var $outputFileName;
	var $outputFileNameCurrentID;
	var $outputFileNumber; //unique survery output number
	var $CSSFilename;
	var $thankYouPageURL;
	
	// $inputFileName = which survey to take
	function __construct($inputFileName) {		
		$this->inputFileName = $inputFileName;
		
		//setting up for pagination and table options, and user info
		$this->tempAnswersArray = array();
		$this->userInfoAnswerArray = array();
		$this->userInfoQuestionsArray = array();
		
		//TODO add more comments
		$fhPagination = fopen($this->inputFileName, 'r');
		if (!flock($fhPagination, LOCK_SH)) {//locks input as shared read only, prevents changes while reading
			echo '</br><h1>Error: Unable to lock input file named "',$this->inputFileName,'"</h1>';
			exit;
		}
		
		//filename options
		fgetcsv($fhPagination); 						// [Filename Options]	[Value]	[Value Format]	[Notes]
		$inputOptionLine = fgetcsv($fhPagination); 		// Output Filename:
			if ($inputOptionLine[1]) {
				$this->outputFileName = '../output/'.substr($inputOptionLine[1], 0, -4).'.csv';
				$this->outputFileNameCurrentID = '../output/'.substr($inputOptionLine[1], 0, -4).'_ID.txt';
			} else {
				$this->outputFileName = '../output/'.substr($inputFileName, 9, -4).'_output.csv';
				$this->outputFileNameCurrentID = '../output/'.substr($inputFileName, 9, -4).'_output_ID.txt';
			}
		$inputOptionLine = fgetcsv($fhPagination); 		// CSS Filename:
			$this->CSSFilename = '../css/'.$inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination); 		// Thank You Page: (full url)
			$this->thankYouPageURL = $inputOptionLine[1];
		
		//table properties
		fgetcsv($fhPagination);							//
		fgetcsv($fhPagination);							// [Table Properties]	[Value]	[Value Format]	[Notes] 
		$inputOptionLine = fgetcsv($fhPagination); 		// Questions Per Page:
			$this->questionsPerPage = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination); 		// Width:
			$this->tableWidth = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination); 		// Alignment:
			$this->tableAlignment = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Border Thickness:
			$this->borderThickness = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Cell Padding:
			$this->cellPadding = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Cell Spacing:
			$this->cellSpacing = $inputOptionLine[1];
		
		//header properties
		fgetcsv($fhPagination);							//
		fgetcsv($fhPagination);							// [Header Properties]	[Value]	[Value Format]	[Notes]	
		$inputOptionLine = fgetcsv($fhPagination);		// Custom Header:
			$this->headerCustom = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Left Title:
			$this->headerTitleLeft = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Right Title:
			$this->headerTitleRight = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Alignment:
			$this->headerAlignment = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Border Thickness:
			$this->headerBorderThickness = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Padding:
			$this->headerPadding = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Spacing:
			$this->headerSpacing = $inputOptionLine[1];
		
		//survey left column properties
		fgetcsv($fhPagination);							// 
		fgetcsv($fhPagination);							// [Survey Left Column Properties]
		$inputOptionLine = fgetcsv($fhPagination);		// Width:
			$this->leftColumnWidth = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Alignment:
			$this->leftColumnAlignment = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Border Thickness:
			$this->leftColumnBorderThickness = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Padding:
			$this->leftColumnPadding = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Spacing:
			$this->leftColumnSpacing = $inputOptionLine[1];
			
		//survey right column properties
		fgetcsv($fhPagination);							// 
		fgetcsv($fhPagination);							// [Survey Right Column Properties]
		$inputOptionLine = fgetcsv($fhPagination);		// Width:
			$this->rightColumnWidth = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Alignment:
			$this->rightColumnAlignment = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Border Thickness:
			$this->rightColumnBorderThickness = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Padding:
			$this->rightColumnPadding = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Spacing:
			$this->rightColumnSpacing = $inputOptionLine[1];
			
		fgetcsv($fhPagination); 						// 
		fgetcsv($fhPagination); 						// [Pagination Text Properties]	[Value]	[Value Format]	[Notes]
		$inputOptionLine = fgetcsv($fhPagination);		// View:
			$this->paginationTextView = strtolower($inputOptionLine[1]);
			if (!$this->paginationTextView) {$this->paginationTextView = 'on';}
		$inputOptionLine = fgetcsv($fhPagination);		// Alignment:
			$this->paginationTextAlignment = strtolower($inputOptionLine[1]);
			if (!$this->paginationTextAlignment) {$this->paginationTextAlignment = 'center';}
		$inputOptionLine = fgetcsv($fhPagination);		// Position:
			$this->paginationTextPosition = strtolower($inputOptionLine[1]);
			if (!$this->paginationTextPosition) {$this->paginationTextPosition = 'bottom';}
		
		fgetcsv($fhPagination); 						// 
		fgetcsv($fhPagination); 						// [Pagination Buttons Table Properties]	[Value]	[Value Format]	[Notes]
		$inputOptionLine = fgetcsv($fhPagination);		// Width:
			$this->paginationButtonsWidth = $inputOptionLine[1];
			if (!$this->paginationButtonsWidth) {$this->paginationButtonsWidth = '170';}
		$inputOptionLine = fgetcsv($fhPagination);		// Alignment:
			$this->paginationButtonsAlignment = $inputOptionLine[1];
			if (!$this->paginationButtonsAlignment) {$this->paginationButtonsAlignment = 'center';}
		$inputOptionLine = fgetcsv($fhPagination);		// Border Thickness:
			$this->paginationButtonsBorderThickness = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Padding:
			$this->paginationButtonsPadding = $inputOptionLine[1];
		$inputOptionLine = fgetcsv($fhPagination);		// Spacing:
			$this->paginationButtonsSpacing = $inputOptionLine[1];
		
		fgetcsv($fhPagination); 						// 
		fgetcsv($fhPagination); 						// [Personal Info]	[Value] (blank is off) (all blank skips entering user info)	[Value Format]	[Notes]
		$inputOptionLine = fgetcsv($fhPagination);		// name
			if (strtolower($inputOptionLine[1]) == 'on') {
				array_push($this->userInfoQuestionsArray, 'Name');
			}
			//array_push($array, $var)
		$inputOptionLine = fgetcsv($fhPagination);		// age
			if (strtolower($inputOptionLine[1]) == 'on') {
				array_push($this->userInfoQuestionsArray, 'Age');
			}
		$inputOptionLine = fgetcsv($fhPagination);		// gender
			if (strtolower($inputOptionLine[1]) == 'on') {
				array_push($this->userInfoQuestionsArray, 'Gender');
			}
		$inputOptionLine = fgetcsv($fhPagination);		// major
			if (strtolower($inputOptionLine[1]) == 'on') {
				array_push($this->userInfoQuestionsArray, 'Major');
			}
		$inputOptionLine = fgetcsv($fhPagination);		// email
			if (strtolower($inputOptionLine[1]) == 'on') {
				array_push($this->userInfoQuestionsArray, 'Email');
			}
		$inputOptionLine = fgetcsv($fhPagination);		// any additional questions on this line =>
		$i = 1;
		while ($inputOptionLine[$i] != NULL) {
			array_push($this->userInfoQuestionsArray, $inputOptionLine[$i]);
			$i++;
		}
		
		//survey questions
		fgetcsv($fhPagination);							// 
		fgetcsv($fhPagination);							// [Item Code]	[Item]	[Response Type]	
		
		$inputQuestionCount = 0;
		while(fgetcsv($fhPagination)) {
			$inputQuestionCount++;
		}
		
		if ($this->questionsPerPage == 0) {
			$this->questionsPerPage = $inputQuestionCount;
			$this->totalPages = 1;
		}
		else {
			$this->totalPages = ceil($inputQuestionCount/$this->questionsPerPage);
		}
		$this->currentPage = 1;
		$this->totalQuestions = $inputQuestionCount;
		$this->currentQuestion = 0;
		
		//end lock for pagination input
		flock($fhPagination, LOCK_UN);
		fclose($fhPagination);
		
		
		//updates the ID file
		//$this->outputFileNumber;
		//$this->outputFileNameCurrentID;
		if (!file_exists($this->outputFileNameCurrentID)) {
			$fhOutputFileNameCurrentID = fopen($this->outputFileNameCurrentID, 'w+');
				//Open for reading and writing; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.
			if (flock($fhOutputFileNameCurrentID, LOCK_EX)) {
				fwrite($fhOutputFileNameCurrentID, '1');
				flock($fhOutputFileNameCurrentID, LOCK_UN);
				fclose($fhOutputFileNameCurrentID);
				$this->outputFileNumber = 1;
			}
			else {
				echo '</br><h1>Unable to obtain lock for $this->outputFileNameCurrentID named ',$this->outputFileNameCurrentID;
			}
		}
		else {
			$fhOutputFileNameCurrentID = fopen($this->outputFileNameCurrentID, 'r+');
				//Open for reading and writing; place the file pointer at the beginning of the file.
			if (flock($fhOutputFileNameCurrentID, LOCK_EX)) {
				$id = (int)trim(fgets($fhOutputFileNameCurrentID));
				$id++;
				$this->outputFileNumber = $id;
				rewind($fhOutputFileNameCurrentID);
				fwrite($fhOutputFileNameCurrentID, $id);
				flock($fhOutputFileNameCurrentID, LOCK_UN);
				fclose($fhOutputFileNameCurrentID);
			}
			else {
				echo 'unable to obtain lock for $this->outputFileNameCurrentID named ',$this->outputFileNameCurrentID;
			}
		}
		
		//create output file
		if (!file_exists($this->outputFileName)) {
			$fhOutputFileName = fopen($this->outputFileName, 'a+'); //Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
			if (!$fhOutputFileName) { 
				echo '</br><h1>Error: Unable to create output file named "',$this->outputFileName.'"';
	    		echo '<ul>';
	        		echo '<li>Trying closing the file if it is open and try again.</li>';
	        		echo '<li>Make sure your server has permission to write to folder "output"</li>';
	    		echo '</ul><h1>';
				exit;
			}
			fclose($fhOutputFileName);
		}
		
		
	}
	
	function allQuestionsAnswered() {
		return ($this->totalQuestions) == count($this->tempAnswersArray);
	}
	
	//unused?
	function answeredAllUserInfo() {
		return count($this->userInfoQuestionsArray) == count($this->userInfoAnswerArray);
	}
	
	function allUserInfoQuestionsAnswered() {
		$allAnswered = TRUE;
		foreach ($this->userInfoAnswerArray as $answer) {
			if ($answer == NULL) {
				$allAnswered = FALSE;
			}
		}
		if ($this->userInfoAnswerArray == NULL) {
			$allAnswered = FALSE;
		}
		if (count($this->userInfoQuestionsArray) == 0 ) {
			$allAnswered = TRUE;
		}
		return $allAnswered;
	}
	
	function canShowSubmit() {
		return ($this->totalPages == $this->currentPage);
	}
	
	function canShowPreviousPage() {
		return (1 != $this->currentPage);
	}
	
	function canShowNextPage() {
		return ($this->totalPages != $this->currentPage);
	}
	
	function getCSSFilename() {
		return $this->CSSFilename;
	}
	
	function getInputFileName() {
		return $this->inputFileName;
	}
	
	//returns array with missed questions(moving forward), empty if non missed
	function getMissedQuestions() {
		
		$this->missedQuestionsArray = array();
		
		if ($this->currentPage == $this->totalPages) {
			$tempCountAnswersArray = $this->totalQuestions;
		}
		else {
			$tempCountAnswersArray = $this->currentQuestion+$this->questionsPerPage;
		}
		
		for ($i=0; $i<$tempCountAnswersArray; $i++) {
			if ($this->tempAnswersArray[$i] == NULL) {
				array_push($this->missedQuestionsArray, $i-(($this->currentPage*$this->questionsPerPage)-$this->questionsPerPage));
			}
		}
		
		return $this->missedQuestionsArray;
	}
	
	function getPaginationTextPosition() {
		return $this->paginationTextPosition;
	}
	
	function getUserInfoQuestionsArray() {
		return $this->userInfoQuestionsArray;
	}
	
	function getUserInfoAnswerArray() {
		return $this->userInfoAnswerArray;
	}
	
	function getThankYouPageURL() {
		return $this->thankYouPageURL;
	}
	
	function printCurrentSurveyTable() {
		//echo '<div id="PHPSurveyGeneratorTable">';
		echo '<table id="PHPSurveyGenerator_Survey_Table" ';
			if ($this->tableAlignment) {echo 'align="',$this->tableAlignment,'" ';}
			if ($this->tableWidth) {echo 'width="',$this->tableWidth,'" ';}
			if ($this->borderThickness) {echo 'border="',$this->borderThickness,'" ';}
			if ($this->cellSpacing) {echo 'cellspacing="',$this->cellSpacing,'" ';}
			if ($this->cellPadding) {echo 'cellpadding="',$this->cellPadding,'" ';}
		echo '>';

		if (($this->headerTitleLeft != NULL || $this->headerTitleRight != NULL) && $this->headerCustom == NULL) {
			echo '<tr id="PHPSurveyGenerator_Survey_TableHeader" ';
				if ($this->headerAlignment) {echo 'align="',$this->headerAlignment,'" ';}
				if ($this->headerBorderThickness) {echo 'border="',$this->headerBorderThickness,'" ';}
				if ($this->headerPadding) {echo 'cellpadding="',$this->headerPadding,'" ';}
				if ($this->headerSpacing) {echo 'cellspacing="',$this->headerSpacing,'" ';}
			echo '><th id="PHPSurveyGenerator_Survey_LeftTableHeader">',$this->headerTitleLeft,'</th><th id="PHPSurveyGenerator_Survey_RightTableHeader">',$this->headerTitleRight,'</th></tr>';
		} else {
			echo $this->headerCustom;
		}
		
		$inputDataLine;
		$fh = fopen($this->inputFileName, 'r');
		for ($i = 1; $i<=$this->surveyItemStartLineNumber; $i++) {  //move input line to right before questions start (line number = first entry)
			$inputDataLine = fgetcsv($fh);
		}
		
		$currentQuestion = $this->currentQuestion;
		
		for ($i=0; $i<$currentQuestion; $i++) {
			$inputDataLine = fgetcsv($fh);
		}
		
		for ($i=0; $i<$this->questionsPerPage; $i++) {
			if ($inputDataLine != null) {

				//prints question
				echo '<tr id="PHPSurveyGenerator_Survey_TableRow">';
				echo '<td id="PHPSurveyGenerator_Survey_LeftTableColumn" ';
					if ($this->leftColumnWidth) {echo 'width="',$this->leftColumnWidth,'" ';}
					if ($this->leftColumnAlignment) {echo 'align="',$this->leftColumnAlignment,'" ';}
					if ($this->leftColumnBorderThickness) {echo 'border="',$this->leftColumnBorderThickness,'" ';}
					if ($this->leftColumnPadding) {echo 'cellpadding="',$this->leftColumnPadding,'" ';}
					if ($this->leftColumnSpacing) {echo 'cellspacing="',$this->leftColumnSpacing,'" ';}
				echo '>',$inputDataLine[1],'</td>';
				echo '<td id="PHPSurveyGenerator_Survey_RightTableColumn ';
					if ($this->rightColumnWidth) {echo 'width="',$this->rightColumnWidth,'" ';}
					if ($this->rightColumnAlignment) {echo 'align="',$this->rightColumnAlignment,'" ';}
					if ($this->rightColumnBorderThickness) {echo 'border="',$this->rightColumnBorderThickness,'" ';}
					if ($this->rightColumnPadding) {echo 'cellpadding="',$this->rightColumnPadding,'" ';}
					if ($this->rightColumnSpacing) {echo 'cellspacing="',$this->rightColumnSpacing,'" ';}
				echo '">';
						
				//prints type of response
				if ($inputDataLine[2] != t) {
					$selectBoxCount = $inputDataLine[2];
					$value = 1;
					for ( $j = 1; $j<=$selectBoxCount; $j++) {
						
						if ($this->tempAnswersArray[$currentQuestion] == $j && $this->tempAnswersArray[$currentQuestion] != null) {
							echo '<input type="radio" checked="checked" name="',$currentQuestion,'" value="',$value,'" id="',$currentQuestion,'_',$j,'">',$j,'</input>';
						}
						else  {
							echo '<input type="radio" name="',$currentQuestion,'" value="',$value,'" id="',$currentQuestion,'_',$j,'">',$j,'</input>';
						}
						echo '&nbsp&nbsp&nbsp';
						
						$value++;
					}
				} else {
					if ($this->tempAnswersArray[$currentQuestion] != null) {
						echo '<input name="',$currentQuestion,'" type="text" value="',$this->tempAnswersArray[$currentQuestion],'" size="15" />';
					}
					else {
						echo '<input name="',$currentQuestion,'" type="text" value="" size="15" />';
					}
				}
				echo '</td></tr>';
				
				//goes to next line on input file
				$inputDataLine = fgetcsv($fh);
			}
			$currentQuestion++;
		}
		echo '</table>';
		//echo '</div>';
		fclose($fh);
	}
	
	function printCurrentPageButtons() {
		//this is invisible to the user but makes 'enter' next page/submit
		if ($this->canShowNextPage()) {
			echo '<input type="submit" name="Next Page" value="Next Page" style="display:none">'; 
			//other possible style methods to hide button
			//style=”width: 0px; height: 0px; position: absolute; left: -50px; top: -50px;”
			//style="visibility:hidden"
			//display:none
			//<input type=’submit’ value=’Login’ style=’width:0px; height: 0px; border: none; padding: 0px; font-size: 0px’>
		} else {
			if ($this->canShowSubmit()) {
				echo '<input type="submit" name="Submit" value="Submit" style="display:none">';
			}
		}
		////////////////////////////////////////////////////////////
		
		echo '<table id="PHPSurveyGenerator_Survey_PageButtons" ';
			echo 'align="',$this->paginationButtonsAlignment,'" ';
			if ($this->paginationButtonsBorderThickness) {echo 'border="',$this->paginationButtonsBorderThickness,'" ';}
			if ($this->paginationButtonsPadding) {echo 'cellpadding="',$this->paginationButtonsPadding,'" ';}
			if ($this->paginationButtonsSpacing) {echo 'cellspacing="',$this->paginationButtonsSpacing,'" ';}
		echo '>';
			echo '<tr>';
				//$this->paginationButtonsWidth set to 170 during construction if NULL
				echo '<td width="',$this->paginationButtonsWidth,'" align="center">';
					if ($this->canShowPreviousPage()) {echo '<input type="submit" name="Previous Page" value="Previous Page">';}
				echo '</td>';
				echo '<td width="',$this->paginationButtonsWidth,'" align="center">';
					if ($this->canShowSubmit()) {echo '<input type="submit" name="Submit" value="Submit">';}
				echo '</td>';				
				echo '<td width="',$this->paginationButtonsWidth,'" align="center">';
					if ($this->canShowNextPage()) {echo '<input type="submit" name="Next Page" value="Next Page">';}
				echo '</td>';				
			echo '</tr>';
		echo '</table>';
	}
	
	//return [current page] of [total pages] ie. "1 of 2"
	function printCurrentPageNumbers() {
		//$this->paginationTextView changed to lowercase when constructed
		if ($this->paginationTextView == 'on') {
			echo '</br>';
			echo '<div align="',$this->paginationTextAlignment,'">';
				echo '<p id="PHPSurveyGenerator_Survey_PageNumbers">Page '.$this->currentPage.' of '.$this->totalPages.'</p>';
			echo '</div>';
			echo '</br>';
		}
	}
	
	//used for debugging purposes
	function printDebug() {
		echo '<p>$_POST</p>';
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		
		echo '<p>$tempAnswersArray</p>';
		echo '<pre>';
		print_r($this->tempAnswersArray);
		echo '</pre>';
		
		echo '<p>$this->userInfoAnswerArray</p>';
		echo '<pre>';
		print_r($this->userInfoAnswerArray);
		echo '</pre>';
		
		echo '<p>$this->userInfoQuestionsArray</p>';
		echo '<pre>';
		print_r($this->userInfoQuestionsArray);
		echo '</pre>';
		
		echo '<br/>$this->inputFileName    : ',$this->inputFileName;
		echo '<br/>$this->outputFileName   : ',$this->outputFileName;
		echo '<br/>$this->questionsPerPage : ',$this->questionsPerPage;
		echo '<br/>$this->totalPages       :',$this->totalPages;
		echo '<br/>$this->currentPage      :',$this->currentPage;
		echo '<br/>$this->totalQuestions   :',$this->totalQuestions;
		echo '<br/>$this->currentQuestion  :',$this->currentQuestion;
		echo '<br/>$this->tempAnswersArray :',$this->tempAnswersArray;
		//echo '<br/>$this->outputLastLine   :',$this->outputLastLine;
		echo '<br/>$this->reservedOutputLineNumber   :',$this->reservedOutputLineNumber;
		
		echo '<br/>$this->CSSFilename      : ',$this->CSSFilename;
		echo '<br/>$this->tableWidth       : ',$this->tableWidth;
		echo '<br/>$this->tableAlignment   : ',$this->tableAlignment;
		echo '<br/>$this->borderThickness  : ',$this->borderThickness;
		echo '<br/>$this->cellPadding      : ',$this->cellPadding;
		echo '<br/>$this->cellSpacing      : ',$this->cellSpacing;
		echo '<br/>$this->headerTitleLeft  : ',$this->headerTitleLeft;
		echo '<br/>$this->headerTitleRight : ',$this->headerTitleRight;
		
		echo '<br/>$this->headerAlignment 					: ',$this->headerAlignment;
		echo '<br/>$this->headerBorderThickness 			: ',$this->headerBorderThickness;
		echo '<br/>$this->headerPadding 					: ',$this->headerPadding;
		echo '<br/>$this->headerSpacing 					: ',$this->headerSpacing;
		
		echo '<br/>$this->leftColumnWidth 					: ',$this->leftColumnWidth;
		echo '<br/>$this->leftColumnAlignment 				: ',$this->leftColumnAlignment;
		echo '<br/>$this->leftColumnBorderThickness 		: ',$this->leftColumnBorderThickness;
		echo '<br/>$this->leftColumnPadding 				: ',$this->leftColumnPadding;
		echo '<br/>$this->leftColumnSpacing 				: ',$this->leftColumnSpacing;
		
		echo '<br/>$this->rightColumnWidth 					: ',$this->rightColumnWidth;
		echo '<br/>$this->rightColumnAlignment 				: ',$this->rightColumnAlignment;
		echo '<br/>$this->rightColumnBorderThickness 		: ',$this->rightColumnBorderThickness;
		echo '<br/>$this->rightColumnPadding 				: ',$this->rightColumnPadding;
		echo '<br/>$this->rightColumnSpacing 				: ',$this->rightColumnSpacing;
		
		echo '<br/>$this->paginationTextView 				: ',$this->paginationTextView;
		echo '<br/>$this->paginationTextAlignment 			: ',$this->paginationTextAlignment;
		echo '<br/>$this->paginationTextPosition 			: ',$this->paginationTextPosition;
		echo '<br/>$this->paginationButtonsWidth 			: ',$this->paginationButtonsWidth;
		echo '<br/>$this->paginationButtonsAlignment 		: ',$this->paginationButtonsAlignment;
		echo '<br/>$this->paginationButtonsBorderThickness 	: ',$this->paginationButtonsBorderThickness;
		echo '<br/>$this->paginationButtonsPadding 			: ',$this->paginationButtonsPadding;
		echo '<br/>$this->paginationButtonsSpacing 			: ',$this->paginationButtonsSpacing;
		
		echo '<br/>$this->thankYouPageFilename : ',$this->thankYouPageFilename;
		echo '<br/>$this->reservedOutputLineNumber: ',$this->reservedOutputLineNumber;
	}
	
	function printSubmitUserInfoPage() {
		echo '<table align="center" id="PHPSurveyGenerator_UserInfo_Table"><tr>';
		
		$userInfoQuestionArrayCount = count($this->userInfoQuestionsArray);
		for ($i = 0; $i<$userInfoQuestionArrayCount; $i++) {
			echo '<tr id="PHPSurveyGenerator_UserInfo_TableRow">';
				echo '<td id="PHPSurveyGenerator_UserInfo_LeftTableColumn">',$this->userInfoQuestionsArray[$i],'</td>';
				if ($this->userInfoQuestionsArray[$i] == 'gender' || $this->userInfoQuestionsArray[$i] == 'Gender') {
					echo '<td id="PHPSurveyGenerator_UserInfo_RightTableColumn"><select name="',$i,'">';
					echo '<option value="Female">Female</option>';
					if ($this->userInfoAnswerArray[$i] == 'Male') {
						echo '<option select value="Male">Male</option>';
					}
					else {
						echo '<option value="Male">Male</option>';
					}
					echo '</select></td>';
				}
				else {
					echo '<td id="PHPSurveyGenerator_UserInfo_LeftTableColumn"><input name="',$i,'" value="',$this->userInfoAnswerArray[$i],'" type="text" size="30" /></td>';
				}
			echo '</tr>';
		}
		echo '</table>';
		echo '</br>';
		echo '<div align="center"><input type="submit" name="submituserinfo" value="Continue"></div>';
	}
	
	function setInputFileName($inputFileName) {
		$this->inputFileName = $inputFileName;
	}
	
	//TODO validate user input
	function storeTempAnswers() {
		
		$currentQuestion = $this->currentQuestion;
		
		for ($i = $currentQuestion; ($i<($currentQuestion+$this->questionsPerPage) && $i<=$this->totalQuestions); $i++) {
			if ($_POST[$i] != 'Next Page' && $_POST[$i] != 'Previous Page' && $_POST[$i] != null) {
					$this->tempAnswersArray[$i] = $_POST[$i];
			}
		}
	}
	
	//TODO validate user input
	function storeUserInfoAnswers() {
		for ($i = 0; $i<count($this->userInfoQuestionsArray); $i++) {
			$this->userInfoAnswerArray[$i] = $_POST[$i];
		}
	}
	
	function unsetMissedQuestionsArray() {
		unset($this->missedQuestionsArray);
	}
	
	function nextPage() {
		if ( ($this->currentQuestion + $this->questionsPerPage) <= $this->totalQuestions) {
			$this->currentQuestion += $this->questionsPerPage;
			$this->currentPage++;
		}
	}
	
	function previousPage() {
		if ( ($this->currentQuestion - $this->questionsPerPage) >= 0) {
			$this->currentQuestion -= $this->questionsPerPage;
			$this->currentPage--;
		}
	}
	
	//don't forget to echo session_unset(); at the end
	function writeAnswersToFile() {
		
		//input file
		
		$fhInput = fopen($this->inputFileName, 'r');
		if (!flock($fhInput, LOCK_SH)) {
			echo '</br>Could not lock input file ',$this->inputFileName,' when writing answers to file';
			exit;
		}
		$inputDataLine;
		for ($i = 1; $i<=$this->surveyItemStartLineNumber; $i++) {  //move input line to when questions start
			$inputDataLine = fgetcsv($fhInput);
		}
		
		//output file
		$fhOutput = fopen($this->outputFileName, 'a');
			//Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it.
		if (flock($fhOutput, LOCK_EX)) {
			for ($i=1; $i<$this->reservedOutputLineNumber; $i++) {
				fgetcsv($fhOutput);
			}
			
			foreach ($this->tempAnswersArray as $answer) {
				$date = date("m\/d\/y g:ia");
				$itemCode = $inputDataLine[0];
				$sentence = $inputDataLine[1];
				$outputArray = array($this->outputFileNumber, $date, $sentence, $itemCode, $answer);
				foreach ($this->userInfoAnswerArray as $userInfoAnswer) {
					array_push($outputArray, $userInfoAnswer);
				}
				$inputDataLine = fgetcsv($fhInput);
				fputcsv($fhOutput, $outputArray);
			}
		}
		else {
			echo '</br>Could not lock outpute file ',$this->outputFileName,' for writing answers to file.';
		}
		flock($fhOutput, LOCK_UN);
		flock($fhInput, LOCK_UN);
		fclose($fhOutput);
		fclose($fhInput);
	}
}
?>