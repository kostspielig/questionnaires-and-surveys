<?php
require_once '../includes/classes.php';
$survey = new Survey();
session_start();
if (!isset($_GET['exp_id'])) {
	echo 'Error: Missing experiment id in the URL.';
	die;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<script type="text/javascript" src="js/jquery.js"></script> 
    <script type="text/javascript" src="js/jquery.form.js"></script> 
 
 <script type="text/javascript">
 
        // wait for the DOM to be loaded 
        $(document).ready(function() { 
        	//prepare Options Object 
        	 var options = { 
               		target: '#myDiv',
        	     beforeSubmit:  showRequest,  // pre-submit callback 
        	     success:       showResponse  // post-submit callback 

        	 }; 
        	  
        	 // pass options to ajaxForm 
        	 $('#myForm').ajaxForm(options);
        }); 

     // pre-submit callback 
        function showRequest(formData, jqForm, options) { 
            // formData is an array; here we use $.param to convert it to a string to display it 
            // but the form plugin does this for you automatically when it submits the data 
            var queryString = $.param(formData); 
         
            // jqForm is a jQuery object encapsulating the form element.  To access the 
            // DOM element for the form do this: 
            // var formElement = jqForm[0]; 
         
            //alert('About to submit: \n\n' + queryString); 
         
            // here we could return false to prevent the form from being submitted; 
            // returning anything other than false will allow the form submit to continue 
            
            // formData is an array of objects representing the name and value of each field 
		    // that will be sent to the server;  it takes the following form: 
		    // 
		    // [ 
		    //     { name:  username, value: valueOfUsernameInput }, 
		    //     { name:  password, value: valueOfPasswordInput } 
		    // ] 
		    // 
		    // To validate, we can examine the contents of this array to see if the 
		    // username and password fields have values.  If either value evaluates 
		    // to false then we return false from this method. 
		 
		    for (var i=0; i < formData.length; i++) { 
		        if (!formData[i].value) { 
		            //alert('Please enter a value for both Username and Password');
		            alert('Missing Question #'+formData[i].name); 
		            return false; 
		        } 
		    } 
		    //alert('All fields contain values.')
		    
		    
            
            return true; 
        } 
         
        // post-submit callback 
        function showResponse(responseText, statusText, xhr, $form)  { 
            // for normal html responses, the first argument to the success callback 
            // is the XMLHttpRequest object's responseText property 
         
            // if the ajaxForm method was passed an Options Object with the dataType 
            // property set to 'xml' then the first argument to the success callback 
            // is the XMLHttpRequest object's responseXML property 
         
            // if the ajaxForm method was passed an Options Object with the dataType 
            // property set to 'json' then the first argument to the success callback 
            // is the json data object returned by the server 
         
            //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
            //    '\n\nThe output div should have already been updated with the responseText.'); 
        } 
        
    </script> 
 
<script type="text/javascript" src="js/paging.js"></script>
<style type="text/css">    
	.pg-normal {
		color: black;
		font-weight: normal;
		text-decoration: none;    
		cursor: pointer;    
	}
	.pg-selected {
		color: black;
		font-weight: bold;        
		text-decoration: underline;
		cursor: pointer;
	}
</style>
</head>
<body>



<?php

require_once '../includes/classes.php';

$database = new Database();
$survey = $database->getRandomSurveyFromExperiment($_GET['exp_id']);
$_SESSION['survey'] = $survey;

//var_dump(get_defined_vars());
echo '<div id="myDiv">';

echo '<form id="myForm" action="submitExperiment.php?exp_id=',$_GET['exp_id'],'&submit=true" method="post" enctype="application/x-www-form-urlencoded">';
echo '<table id="myTable" ';
	if ($survey->surveyProperties['surveyTableProperties_alignment']) {echo 'align="',$survey->surveyProperties['surveyTableProperties_alignment'],'" ';}
	if ($survey->surveyProperties['surveyTableProperties_width']) {echo 'width="',$survey->surveyProperties['surveyTableProperties_width'],'" ';}
	if ($survey->surveyProperties['surveyTableProperties_borderThickness']) {echo 'border="',$survey->surveyProperties['surveyTableProperties_borderThickness'],'" ';}
	if ($survey->surveyProperties['surveyTableProperties_cellSpacing']) {echo 'cellspacing="',$survey->surveyProperties['surveyTableProperties_cellSpacing'],'" ';}
	if ($survey->surveyProperties['surveyTableProperties_cellPadding']) {echo 'cellpadding="',$survey->surveyProperties['surveyTableProperties_cellPadding'],'" ';}
echo '>';

if (($survey->surveyProperties['headerProperties_leftTitle'] != NULL || $survey->surveyProperties['headerProperties_rightTitle'] != NULL) && $survey->surveyProperties['headerProperties_customHeader'] == NULL) {
	echo '<tr id="PHPSurveyGenerator_Survey_TableHeader" ';
		if ($survey->surveyProperties['headerProperties_alignment']) {echo 'align="',$survey->surveyProperties['headerProperties_alignment'],'" ';}
		if ($survey->surveyProperties['headerProperties_borderThickness']) {echo 'border="',$survey->surveyProperties['headerProperties_borderThickness'],'" ';}
		if ($survey->surveyProperties['headerProperties_padding']) {echo 'cellpadding="',$survey->surveyProperties['headerProperties_padding'],'" ';}
		if ($survey->surveyProperties['headerProperties_spacing']) {echo 'cellspacing="',$survey->surveyProperties['headerProperties_spacing'],'" ';}
	echo '><th id="PHPSurveyGenerator_Survey_LeftTableHeader">',$survey->surveyProperties['headerProperties_leftTitle'],'</th><th id="PHPSurveyGenerator_Survey_RightTableHeader">',$survey->surveyProperties['headerProperties_rightTitle'],'</th></tr>';
} else {
	echo $survey->surveyProperties['headerProperties_customHeader'];
}

$count = count($survey->surveyQuestions);
for ($i=0; $i<$count; $i++) {
	//TODO record position
	$survey->surveyQuestions[$i]->position = $i;
	
	//prints question
	echo '<tr id="PHPSurveyGenerator_Survey_TableRow">';
	echo '<td id="PHPSurveyGenerator_Survey_LeftTableColumn" ';
		if ($survey->surveyProperties['surveyLeftColumnProperties_width']) {echo 'width="',$survey->surveyProperties['surveyLeftColumnProperties_width'],'" ';}
		if ($survey->surveyProperties['surveyLeftColumnProperties_alignment']) {echo 'align="',$survey->surveyProperties['surveyLeftColumnProperties_alignment'],'" ';}
		if ($survey->surveyProperties['surveyLeftColumnProperties_borderThickness']) {echo 'border="',$survey->surveyProperties['surveyLeftColumnProperties_borderThickness'],'" ';}
		if ($survey->surveyProperties['surveyLeftColumnProperties_padding']) {echo 'cellpadding="',$survey->surveyProperties['surveyLeftColumnProperties_padding'],'" ';}
		if ($survey->surveyProperties['surveyLeftColumnProperties_spacing']) {echo 'cellspacing="',$survey->surveyProperties['surveyLeftColumnProperties_spacing'],'" ';}
	echo '>',$survey->surveyQuestions[$i]->item,'</td>';
	
	echo '<td id="PHPSurveyGenerator_Survey_RightTableColumn ';
		if ($survey->surveyProperties['surveyRightColumnProperties_width']) {echo 'width="',$survey->surveyProperties['surveyRightColumnProperties_width'],'" ';}
		if ($survey->surveyProperties['surveyRightColumnProperties_alignment']) {echo 'align="',$survey->surveyProperties['surveyRightColumnProperties_alignment'],'" ';}
		if ($survey->surveyProperties['surveyRightColumnProperties_borderThickness']) {echo 'border="',$survey->surveyProperties['surveyRightColumnProperties_borderThickness'],'" ';}
		if ($survey->surveyProperties['surveyRightColumnProperties_padding']) {echo 'cellpadding="',$survey->surveyProperties['surveyRightColumnProperties_padding'],'" ';}
		if ($survey->surveyProperties['surveyRightColumnProperties_spacing']) {echo 'cellspacing="',$survey->surveyProperties['surveyRightColumnProperties_spacing'],'" ';}
	echo '">';
	
	//prints type of response
	if ($survey->surveyQuestions[$i]->responseType == ResponseType::YES_NO) {
		echo '<input type="radio" name="',$i,'" value"Yes">Yes</input>';
		echo '&nbsp&nbsp&nbsp';
		echo '<input type="radio" name="',$i,'" value"No">No</input>';
	}
	else if ($survey->surveyQuestions[$i]->responseType == ResponseType::INPUT_BOX) {
		//if ($survey->surveyQuestions[$i]->response)
		echo '<input name="',$i,'" type="text" value="',$survey->surveyQuestions[$i]->response,'" size="15" />';
	}
	else {
		$selectBoxCount = $survey->surveyQuestions[$i]->responseType;
		$value = 1;
		for ( $j = 1; $j<=$selectBoxCount; $j++) {
			echo '<input type="radio" name="',$i,'" value="',$value,'">',$j,'</input>';
			echo '&nbsp&nbsp&nbsp';
			$value++;
		}
	}
	
	echo '</td></tr>';
}		
echo '</table>';
echo '<br/>';
echo '<div id="pageNavPosition"></div>';
echo '<div><input type="submit" /></div>';
echo '</form>';
echo '</div>';
//var_dump(get_defined_vars());
//var_dump($survey);
?>

<script type="text/javascript"><!--
	var pager = new Pager('myTable', <?php echo $survey->surveyProperties['surveyTableProperties_questionsPerPage'] ?>); 
	pager.init(); 
	pager.showPageNav('pager', 'pageNavPosition'); 
	pager.showPage(1);
//--></script>


</body>
</html>

    

</body>
</html>