<?php
// INCOMPLETE:
// This page will control process to take experiment and get random survey.

require_once '../includes/classes.php';

$database = new Database();
$survey = $database->getRandomSurveyFromExperiment($_GET['exp_id']);

//var_dump(get_defined_vars());

echo '<form>';
echo '<table id="PHPSurveyGenerator_Survey_Table" ';
	if ($survey->surveyProperties['surveyTableProperties_alignment']) {echo 'align="',$survey->surveyProperties['surveyTableProperties_alignment'],'" ';}
	if ($survey->surveyProperties['surveyTableProperties_width']) {echo 'width="',$survey->surveyProperties['surveyTableProperties_width'],'" ';}
	if ($survey->surveyProperties['surveyTableProperties_borderThickness']) {echo 'border="',$survey->surveyProperties['surveyTableProperties_borderThickness'],'" ';}
	if ($survey->surveyProperties['surveyTableProperties_cellSpacing']) {echo 'cellspacing="',$survey->surveyProperties['surveyTableProperties_cellSpacing'],'" ';}
	if ($survey->surveyProperties['surveyTableProperties_cellPadding']) {echo 'cellpadding="',$survey->surveyProperties['surveyTableProperties_cellPadding'],'" ';}
echo '>';

if (($survey->surveyProperties['headerProperties_leftTitle'] != NULL || $survey->surveyProperties['headerProperties_rightTitle'] != NULL) && $survey->surveyProperties['headerProperties_customHeader'] == NULL) {
	echo '<tr id="PHPSurveyGenerator_Survey_TableHeader" ';
		if ($survey->surveyProperties['headerProperties_alignment']) {echo 'align="',$survey->surveyProperties['headerProperties_alignment'],'" ';}
		if ($survey->surveyProperties['headerProperties_borderThickness']) {echo 'border="',$survey->surveyProperties['headerProperties_borderThickness'],'" ';}
		if ($survey->surveyProperties['headerProperties_padding']) {echo 'cellpadding="',$survey->surveyProperties['headerProperties_padding'],'" ';}
		if ($survey->surveyProperties['headerProperties_spacing']) {echo 'cellspacing="',$survey->surveyProperties['headerProperties_spacing'],'" ';}
	echo '><th id="PHPSurveyGenerator_Survey_LeftTableHeader">',$survey->surveyProperties['headerProperties_leftTitle'],'</th><th id="PHPSurveyGenerator_Survey_RightTableHeader">',$survey->surveyProperties['headerProperties_rightTitle'],'</th></tr>';
} else {
	echo $survey->surveyProperties['headerProperties_customHeader'];
}

$count = count($survey->surveyQuestions);
for ($i=0; $i<$count; $i++) {
	
	//prints question
	echo '<tr id="PHPSurveyGenerator_Survey_TableRow">';
	echo '<td id="PHPSurveyGenerator_Survey_LeftTableColumn" ';
		if ($survey->surveyProperties['surveyLeftColumnProperties_width']) {echo 'width="',$survey->surveyProperties['surveyLeftColumnProperties_width'],'" ';}
		if ($survey->surveyProperties['surveyLeftColumnProperties_alignment']) {echo 'align="',$survey->surveyProperties['surveyLeftColumnProperties_alignment'],'" ';}
		if ($survey->surveyProperties['surveyLeftColumnProperties_borderThickness']) {echo 'border="',$survey->surveyProperties['surveyLeftColumnProperties_borderThickness'],'" ';}
		if ($survey->surveyProperties['surveyLeftColumnProperties_padding']) {echo 'cellpadding="',$survey->surveyProperties['surveyLeftColumnProperties_padding'],'" ';}
		if ($survey->surveyProperties['surveyLeftColumnProperties_spacing']) {echo 'cellspacing="',$survey->surveyProperties['surveyLeftColumnProperties_spacing'],'" ';}
	echo '>',$survey->surveyQuestions[$i]->item,'</td>';
	
	echo '<td id="PHPSurveyGenerator_Survey_RightTableColumn ';
		if ($survey->surveyProperties['surveyRightColumnProperties_width']) {echo 'width="',$survey->surveyProperties['surveyRightColumnProperties_width'],'" ';}
		if ($survey->surveyProperties['surveyRightColumnProperties_alignment']) {echo 'align="',$survey->surveyProperties['surveyRightColumnProperties_alignment'],'" ';}
		if ($survey->surveyProperties['surveyRightColumnProperties_borderThickness']) {echo 'border="',$survey->surveyProperties['surveyRightColumnProperties_borderThickness'],'" ';}
		if ($survey->surveyProperties['surveyRightColumnProperties_padding']) {echo 'cellpadding="',$survey->surveyProperties['surveyRightColumnProperties_padding'],'" ';}
		if ($survey->surveyProperties['surveyRightColumnProperties_spacing']) {echo 'cellspacing="',$survey->surveyProperties['surveyRightColumnProperties_spacing'],'" ';}
	echo '">';
	
	//prints type of response
	if ($survey->surveyQuestions[$i]->responseType == ResponseType::YES_NO) {
		echo '<input type="radio" name="',$i,'" value"Yes">Yes</input>';
		echo '&nbsp&nbsp&nbsp';
		echo '<input type="radio" name="',$i,'" value"No">No</input>';
	}
	else if ($survey->surveyQuestions[$i]->responseType == ResponseType::INPUT_BOX) {
		echo '<input name="',$i,'" type="text" value="" size="15" />';
	}
	else {
		$selectBoxCount = $survey->surveyQuestions[$i]->responseType;
		$value = 1;
		for ( $j = 1; $j<=$selectBoxCount; $j++) {
			echo '<input type="radio" name="',$i,'" value="',$value,'">',$j,'</input>';
			echo '&nbsp&nbsp&nbsp';
			$value++;
		}
	}
	
	echo '</td></tr>';
}		

echo '</table>';

echo $survey->toString();

echo '</form>';
?>