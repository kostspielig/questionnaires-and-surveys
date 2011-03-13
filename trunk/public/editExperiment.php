<?php

include_once 'auth.inc.php';
include_once 'utils.php';


$filename = $_GET['filename'];
 
$download_path = "../experiments/";


// Combine the download path and the filename to create the full path to the file.
$file = "$download_path$filename";

set_time_limit(0);
output_file($file, $filename, "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
echo $file;
unlink($file);

?>