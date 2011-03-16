<?php

include_once 'auth.inc.php';
include_once 'utils.php';
require_once '../classes/Database.php';

destroy('../results/');

$exp_id = $_GET['exp_id'];
$filename = $_GET['filename'];
$m = new Database();
$filename = rtrim($filename, ".xlsx");

//Create files with answers
$files_to_zip = $m->extractAnswersToCVS($exp_id, $filename);

$file = '../results/'.$filename.'.zip';

$s = '';
//Zip answer files
$result = create_zip($files_to_zip, $file);
if ($result) {
	$s = 'success';
	$success = 'Zip file with results successfully created';
}
else $error = 'Could not create results file.';


//Output file
//set_time_limit(0);
output_file($file, $filename, "zip");



//delete files
foreach ($files_to_zip as $f) {
	unlink($f);
}

unlink($file);

if ($s == "success")
	header("Location: experimentsView.php?success=$success");
else
	header("Location: experimentsView.php?error=$error");

//include 'experimentsView.php';

?>