<?php
require_once '../classes/dbController.php';
require_once '../classes/surveyDB.php';

//$new_db = new dbController();
//$new_db->createDB();

$survey = new surveyDB();
$survey->open();
//$survey->insert("administrator","'john', 'admin'");
//$survey->insert("experiment","NULL, 'experimentA', 'john'");
//$survey->insert("experiment","NULL, 'experimentB', 'john'");
//$survey->insert("survey", "NULL, 1, ");
$survey->printExperiments();
$survey->close();
?>