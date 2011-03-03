<?php

include_once 'surveyDB.php';
include_once 'Experiment.php';

class Model {
    public $db;   
 
    public function __construct()  
    {  
         $this->db = new surveyDB();  
    }   
	public function getExperimentList() {
		$this->db->open();
		$list = $this->db->getExperiments();
		$this->db->close();
		return $list;
	}

	public function checkUser ($name, $pass) {
		$this->db->open();
		$res = $this->db->getUser ($name, $pass);
		$this->db->close();
		return $res;
	}
	
	public function deleteExperiment ($exp_id) {
		$this->db->open();
		$this->db->deleteExperiment($exp_id);
		$this->db->close();
	}
	
	public function uploadExperiment(Experiment $exp, $name, $filename, $admin) {
		$this->db->open();
		// Insert experiment
		try {
			$exp_id = $this->db->insertExperiment("NULL, '".$admin."', '".$name."','".$filename."'");
		} catch (Exception $e) {
			return 'Error while inserting experiment. '.$e;
		}
		// Insert survey
		try {
			
		foreach ($exp->surveys as $sur) {
			$sur_id = $this->db->insertSurvey("NULL,'".$exp_id."', '".$sur->surveyProperties['name']."', 
			'".$sur->surveyProperties['surveyTableProperties_pseudoRandomWidth']."', '".$sur->surveyProperties['outputFilename']."', 
			'".$sur->surveyProperties['cssFilename']."', '".$sur->surveyProperties['thankYouPage']."', 
			'".$sur->surveyProperties['surveyTableProperties_questionsPerPage']."', '".$sur->surveyProperties['surveyTableProperties_width']."', 
			'".$sur->surveyProperties['surveyTableProperties_alignment']."', '".$sur->surveyProperties['surveyTableProperties_borderThickness']."', 
			'".$sur->surveyProperties['surveyTableProperties_cellPadding']."', '".$sur->surveyProperties['surveyTableProperties_cellSpacing']."', 
			'".$sur->surveyProperties['headerProperties_customHeader']."', '".$sur->surveyProperties['headerProperties_leftTitle']."',
			'".$sur->surveyProperties['headerProperties_rightTitle']."', '".$sur->surveyProperties['headerProperties_alignment']."',
			'".$sur->surveyProperties['headerProperties_borderThickness']."', '".$sur->surveyProperties['headerProperties_padding']."',
			'".$sur->surveyProperties['headerProperties_spacing']."', '".$sur->surveyProperties['surveyLeftColumnProperties_width']."',
			'".$sur->surveyProperties['surveyLeftColumnProperties_alignment']."', '".$sur->surveyProperties['surveyLeftColumnProperties_borderThickness']."',
			'".$sur->surveyProperties['surveyLeftColumnProperties_padding']."', '".$sur->surveyProperties['surveyLeftColumnProperties_spacing']."',
			'".$sur->surveyProperties['surveyRightColumnProperties_width']."', '".$sur->surveyProperties['surveyRightColumnProperties_alignment']."',
			'".$sur->surveyProperties['surveyRightColumnProperties_borderThickness']."', '".$sur->surveyProperties['surveyRightColumnProperties_padding']."',
			'".$sur->surveyProperties['surveyRightColumnProperties_spacing']."', '".$sur->surveyProperties['paginationTextProperties_view']."',
			'".$sur->surveyProperties['paginationTextProperties_alignment']."', '".$sur->surveyProperties['paginationTextProperties_position']."',
			'".$sur->surveyProperties['paginationButtonsTableProperties_width']."', '".$sur->surveyProperties['paginationButtonsTableProperties_alignment']."',
			'".$sur->surveyProperties['paginationButtonsTableProperties_borderThickness']."', '".$sur->surveyProperties['paginationButtonsTableProperties_padding']."',
			'".$sur->surveyProperties['paginationButtonsTableProperties_spacing']."'");
		
			// Insert User Info Questions
			$this->db->close();
			$this->db->open();
			
			$i = 0;
			while ($i < count($sur->surveyUserInfo)) {
				$this->db->createUserQuestion('NULL, "'.$sur_id.'","'.$sur->surveyUserInfo[$i].'"');
				$i++;
			}
			
			$i = 0;
			// Insert Questions in Survey
			while ($i < count($sur->surveyItems)) {
				$this->db->insertQuestion ('NULL, "'.$sur_id.'",
					"'.$sur->surveyItemCodes[$i].'", "'.$sur->surveyItems[$i].'", 
					"'.$sur->surveyResponseTypes[$i].'"');
				$i++;
			}
			
		}
		
		} catch (Exception $e) {
			$this->db->deleteExperiment($exp_id);
			return  '<p class="error">Error while inserting Survey. </p>'.$e;
		}
		
		$this->db->close();
		return $exp_id;
	}
}
?>