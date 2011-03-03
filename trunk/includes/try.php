<?php
require_once '../classes/dbController.php';
require_once '../classes/surveyDB.php';
require_once '../classes/Experiment.php';
require_once '../classes/Model.php';

//$new_db = new dbController();
//$new_db->createDB();

$survey = new surveyDB();
$survey->open();
//$survey->insert("administrator","'jon', 'admin'");
$survey->insertExperiment("NULL ,'jon', 'experimentA', 'FILENAME.xlsx'");
$survey->insertExperiment("NULL ,'jon', 'experimentB', 'FILENAME.xlsx'");
$name = "experiment CD ";
echo $survey->insertExperiment("NULL ,'jon', '".$name."', 'FILENAME.xlsx'");

$e = new Experiment();
//$e->loadExperimentFromExcelFile("Experiment A.xlsx");

//$m = new Model();
//$m->deleteExperiment(17);
//echo $m->uploadExperiment($e,"Experimentoooooo A", "Experiment A.xlsx","jon");

//$survey->printUser();
//$survey->printExperiments(0);
$survey->close();
?>