<?php

include_once 'auth.inc.php';
require_once '../classes/Experiment.php';
require_once '../classes/Database.php';

if ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
	if ($_FILES["file"]["error"] > 0) {
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else {
		/*echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		echo "Type: " . $_FILES["file"]["type"] . "<br />";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
		*/
		if (file_exists("../experiments/" . $_FILES["file"]["name"])) {
			$error= $_FILES["file"]["name"] . " already exists. ";
		}
		else {
			move_uploaded_file($_FILES["file"]["tmp_name"],
			"../experiments/" . $_FILES["file"]["name"]);
		
			$experiment = new Experiment();
			$experiment->loadExperimentFromExcelFile($_FILES["file"]["name"]);
			
			//Import Experiment to the database!	
			$database = new Database();
			$e = $database->uploadExperiment($experiment, $_POST['name'], $_FILES["file"]["name"], $_SESSION['login']);
			if ($e != null)
				$error = $e;
			$s = 'success';
			$success = 'File '.$_FILES["file"]["name"].' uploaded correctly';
		}
    }
} 
else {
	$error = "Invalid file. The correct format is .xslx ";
}

if ($s == "success")
	header("Location: experimentsView.php?success=$success");
else 
	header("Location: experimentsView.php?error=$error");
exit();
//include'experimentsView.php';
?> 