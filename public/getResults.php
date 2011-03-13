<?php

include_once 'auth.inc.php';
include_once 'utils.php';
require_once '../classes/Database.php';

$exp_id = $_GET['exp_id'];
$filename = $_GET['filename'];
$m = new Database();

//Create files with answers
$files_to_zip = $m->extractAnswersToCVS($exp_id, $filename);

$file = '../results/'.$exp_id.'.zip';

//Zip answer files 
$result = create_zip($files_to_zip, $file);
if ($result) $success = 'Zip file with results successfully created';
else $error = 'Could not create results file.';


//Output file
set_time_limit(0);
output_file($file, $filename, "application/zip");
echo $file;
unlink($file);

include 'experimentsView.php';

?>