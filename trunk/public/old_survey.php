<?php
////////////////////////////////////////
// OUTDATED: Here only as a reference.
////////////////////////////////////////

include('SurveyGeneratorClass.php');
session_start();

//header( "Location: $thankYouPageURL" );

//For debugging
//echo '<pre>';
//	print_r($_POST);
//echo '</pre>';

if (isset($_POST['Reset_Current_Survey']) || !isset($_SESSION['SurveyGeneratorClass'])) {
	
	$inputFilename;
	if (isset($_POST['Reset_Current_Survey'])) {
		$inputFilename = $_SESSION['SurveyGeneratorClass']->getInputFileName();
		session_unset();
		session_start();
	}
	else {//(!isset($_SESSION['SurveyGeneratorClass'])) {
		if ($_POST['Survey_Dropdown_Menu'] != NULL) {
			$inputFilename = '../input/'.$_POST['Survey_Dropdown_Menu'];
		}
		else {
			//echo '<p>Error: input filename not defined, please start the survey again from the beggining</p>';
			header( "Location: ../" );
			exit;
		}
	}
	
	$_SESSION['SurveyGeneratorClass'] = new SurveyGeneratorClass($inputFilename);
	unset($_POST);
	unset($inputFilename);
}

if (isset($_POST['Survey_Dropdown_Menu']) || isset($_POST['submituserinfo'])) {
	$_SESSION['SurveyGeneratorClass']->storeUserInfoAnswers();
}
else {
	$_SESSION['SurveyGeneratorClass']->storeTempAnswers();
}

if (isset($_POST['Submit']) && $_SESSION['SurveyGeneratorClass']->allQuestionsAnswered()) {
	$_SESSION['SurveyGeneratorClass']->writeAnswersToFile();
	
	if ($_SESSION['SurveyGeneratorClass']->getThankYouPageURL() != NULL) {
		$thankYouPageURL = $_SESSION['SurveyGeneratorClass']->getThankYouPageURL();
		session_unset(); //clears all data
		header( "Location: $thankYouPageURL" ); //header must be sent before any html
		exit;
	}
	else {
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<title>Survey</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<?php
			echo '<link href="',$_SESSION['SurveyGeneratorClass']->getCSSFilename(),'" rel="stylesheet" type="text/css" />';
		?>
		</head>
		<body>
		<?php
		echo '<div align="center"><p>Thank you for taking the survey!</p></div>';
		echo '<div align="center"><br/><a href="../">Back</a></div>';
		session_unset(); //clears all data
	}
	//debugging purposes:
	//echo '<form id="form1" name="form1" method="post" action="survey.php">';
	//echo '<div align="center"><br/><input type="submit" name="Reset Current Survey" value="Reset Current Survey"></div>';
	//echo '</form>';
}
else {
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Survey</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
		echo '<link href="',$_SESSION['SurveyGeneratorClass']->getCSSFilename(),'" rel="stylesheet" type="text/css" />';
	?>
	</head>
	<body>
	<?php
	if (!isset($_POST['Previous_Page']) && $_POST != null && !isset($_POST['submituserinfo'])) {
		$missedQuestionsArray = $_SESSION['SurveyGeneratorClass']->getMissedQuestions();
		if (count($missedQuestionsArray) != 0) {
			foreach ($missedQuestionsArray as $missedQuestion) {
				echo '<div align="center"><h1 id="errorMessage"><strong>Error: You skipped question number ',($missedQuestion+1),'</strong></h1></div>'; 
			}
			$_SESSION['SurveyGeneratorClass']->unsetMissedQuestionsArray();
		}
		
		if (isset($_POST['Next_Page']) && count($missedQuestionsArray) == 0) {
			$_SESSION['SurveyGeneratorClass']->nextPage();
		}
		
	}
	
	if (isset($_POST['Previous_Page'])) {
		$_SESSION['SurveyGeneratorClass']->previousPage();
	}
	
	//////////////////////////////////////////////////////////////////
	//////////////////     DISPLAY SURVEY      ///////////////////////
	//////////////////////////////////////////////////////////////////
	
	if ($_SESSION['SurveyGeneratorClass']->allUserInfoQuestionsAnswered()) {
		echo '<form id="form1" name="form1" method="post" action="survey.php" autocomplete="off">';
			if ($_SESSION['SurveyGeneratorClass']->getPaginationTextPosition() == 'top') {
				$_SESSION['SurveyGeneratorClass']->printCurrentPageNumbers();
			}
			$_SESSION['SurveyGeneratorClass']->printCurrentSurveyTable();
			$_SESSION['SurveyGeneratorClass']->printCurrentPageButtons();
			if ($_SESSION['SurveyGeneratorClass']->getPaginationTextPosition() == 'bottom') {
				$_SESSION['SurveyGeneratorClass']->printCurrentPageNumbers();
			}
			//for debugging purposes
			//echo '<div align="center"><br/><input type="submit" name="Reset Current Survey" value="Reset Current Survey"></div>';
			//echo '<div align="center"><br/><a href="../">Start New Survey</a></div>';
			///////////
		echo '</form>'; 
	}
	else { //!$_SESSION['SurveyGeneratorClass']->allUserInfoQuestionsAnswered()
		if (isset($_POST['submituserinfo'])) {
			echo '<div align="center"><h1>Error: Skipped a question.</h1></div>';
			echo '</br>';
		}
		echo '<div align="center"><p>Please enter your information. This data will be kept confidential. If you have any questions, ask your experimenter.</p></div></br>';
		echo '<form id="form1" name="form1" method="post" action="survey.php" autocomplete="off">';
			$_SESSION['SurveyGeneratorClass']->printSubmitUserInfoPage();
		echo '</form>'; 
	}

	
	//for debugging purposes
	//$_SESSION['SurveyGeneratorClass']->printDebug(); 
}

?>

</body>
</html>