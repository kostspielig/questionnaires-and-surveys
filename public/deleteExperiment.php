<?php

include_once 'auth.inc.php';
require_once '../classes/Model.php';

$exp_id = $_GET['id'];
$m = new Model();

$filename=$m->getFilename($exp_id);
$s = $m->deleteExperiment($exp_id);
if ($s == "success")
	$success = 'Experiment '.$exp_id.' deleted correctly';
		
// ALSO DELETE FILE FROM THE SERVER!!!!

if ($filename != '0') {
	$filename='../experiments/'.$filename;
	unlink($filename);
}else  {
	$error = "Could not delete selected experiment's file." ; 
}
	
include 'experimentsView.php';


?>