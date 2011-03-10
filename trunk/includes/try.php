<?php
require_once '../classes/Database.php';
require_once '../classes/Experiment.php';


$database = new Database();

//
//$survey->insertExperiment("NULL ,'jon', 'experimentA', 'FILENAME.xlsx'");
//$survey->insertExperiment("NULL ,'jon', 'experimentB', 'FILENAME.xlsx'");
//$name = "experiment CD ";
//echo $survey->insertExperiment("NULL ,'jon', '".$name."', 'FILENAME.xlsx'");

//$e = new Experiment();
//$e->loadExperimentFromExcelFile("Experiment A.xlsx");

//$database->createEmptySQLite3();
//$database->insertAdministrator('jon', 'admin');

$database->printUser();
//$database->changePassword('jon', 'admin');
//$database->printUser();
//$n = $database->getFilename(11);

//echo $database->getNumberOfSurveys(11);
//echo $m->uploadExperiment($e,"Experimentoooooo A", "Experiment A.xlsx","jon");

//$survey->printUser();
//$survey->printExperiments(0);
//$survey->close();
?>