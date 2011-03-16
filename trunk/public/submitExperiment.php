<?php
require_once '../includes/classes.php';
$survey = new Survey();
session_start();
if (!isset($_GET['exp_id'])) {
	echo 'Error: Missing experiment id in the URL.';
}

$survey = $_SESSION['survey'];
$survey->updateSurveyResponses($_POST);

$database = new Database();
$sur_id = $survey->sur_id;
$date = $survey->date;

//var_dump(get_defined_vars());

//add new participant and return part_id
$database->open();
$part_id = $database->insertParticipant('NULL, "'.$sur_id.'", "pName"');

$questions = $survey->surveyQuestions;
$currentQuestion = current($questions);
while ($currentQuestion != null) {
	$database->insertSurveyQuestionAnswer('NULL, "'.$part_id.'",
		"'.$currentQuestion->id.'", 
		"'.$currentQuestion->response.'", "'.$date.'", 
		"'.$currentQuestion->position.'"');
	$currentQuestion = next($questions);
}
$database->close();

//$database->insertResults()


//$toReturn = var_dump($_POST);
//$toReturn += var_dump($survey->surveyQuestions);


//echo $toReturn;
echo 'Survey submitted successfully.';
?>