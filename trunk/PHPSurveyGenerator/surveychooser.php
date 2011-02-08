<?php

/////////////////////////////////////////////////////////////////////
//
// Directions for use:
//
//   1. make sure the filename ends in .php (NOT .html or .htm)
//	 2. make sure the folder 'PHPSurveyGenerator' is in the same directory
//			(along with 'input' and 'output' folder)
//   3. put the line below at the VERY TOP of your file (even before html tag)
/*
		<?php session_start(); session_unset(); ?>
*/
//   4. put the line below where you want the survey chooser dropdown to appear
/*
		<?php include 'PHPSurveyGenerator/surveychooser.php'; ?>
*/
//
/////////////////////////////////////////////////////////////////////

$dirHandle = opendir('input');

//to remove "." and ".." option
$nextFileName = readdir($dirHandle); //$nextFileName is "."
$nextFileName = readdir($dirHandle); //$nextFileName is ".."

$nextFileName = readdir($dirHandle); 

if (!$nextFileName) {
	echo '<p>Unable to load survey list: the input directory is empty.<p>';
}
else {
	echo '<form action="PHPSurveyGenerator/survey.php" method="post">';
	echo '<select name="Survey Dropdown Menu">';
	while ($nextFileName) {
		echo '<option value="',$nextFileName,'">',substr($nextFileName, 0, -4),'</option>';
		$nextFileName = readdir($dirHandle);
	}
	echo '</select>';
	echo '<input type="submit" value="Continue" />';
	echo '</form>';
}

closedir($dirHandle);
?>


