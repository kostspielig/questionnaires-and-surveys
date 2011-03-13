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

$database->createEmptySQLite();
//$database->createEmptySQLite3();
$database->insertAdministrator('jonny', 'admin');

$database->printUser();

/*echo 'This is a trial<br/>';
$m = date('m/d/y h:ia' );
echo $m;
*/


?>