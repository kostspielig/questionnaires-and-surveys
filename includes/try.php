<?php
require_once '../classes/dbController.php';
require_once '../classes/surveyDB.php';

//$new_db = new dbController();
//$new_db->createDB();

$survey = new surveyDB();
$survey->open();
//$survey->insert("administrator","'jon', 'admin'");
//$survey->insert("experiment","NULL, 'experimentA', 'jon'");
//$survey->insert("experiment","NULL, 'experimentB', 'jon'");
$name = "experiment CD";
echo $survey->insertExperiment("NULL, '".$name."', 'jon'");

//$survey->printUser();
//$survey->printExperiments(0);
$survey->close();
?>