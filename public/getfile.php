<?php

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
		//echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
		$success = 'File '.$_FILES["file"]["name"].' uploaded correctly';
		}
    }
} 
else {
	$error = "Invalid file. ";
}

include'experimentsView.php';
?> 