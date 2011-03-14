<?php
require_once '../includes/classes.php';

class Database
{
    // property declaration
    public $file = '../SQLite/create.txt';
    public $name;
    private $dbhandle;
        
    // constructor
    public function Database($type = 2) {
        $this->name = ($type == 3)? "../SQLite/database.db": "../SQLite/database.db";
    }
    
    public function read_file() {
    	$f = fopen("$this->file", 'r');
        $this->file = fread($f, filesize($this->file ));
        fclose($f);
    }
    //Create a new database
    // Warning: Overwrites current database
    public function createEmptySQLite() {
    	$this->read_file();
        $dbhandle = sqlite_open("$this->name", 0666, $error);
        if (!$dbhandle) die ($error);
        $ok = sqlite_exec($dbhandle, $this->file, $error);
        if (!$ok) die("Cannot execute query. $error");
        echo "Database created successfully";
        sqlite_close($dbhandle);
    }
    
    //Create a new database using SQLite3 format instead of SQLite2
    // Warning: Overwrites current database
    public function createEmptySQLite3() {
    	$this->read_file();
        try {
         	$db = new PDO('sqlite:'.$this->name);
            $db->exec($this->file);
            $db = NULL;
        } catch(PDOException $e) {
                print 'Exception: '.$e->getMessage();
        }
        echo "Database created successfully";
    }

    public function open () {	
    	$this->dbhandle = sqlite_open("$this->name", 0666, $error);
		if (!$this->dbhandle) die ($error);
    }
    
    public function close () {
		sqlite_close($this->dbhandle);
    }
    

    // Using rowid it will autoincrement the ID :)
    public function insert ($table, $values) {
		$stm = "INSERT INTO ".$table." VALUES( ".$values." )";
		
		$ok = sqlite_exec($this->dbhandle, $stm);
		if (!$ok){
			throw new Exception("ERROR: Could not insert values into the table ".$table);
			die("Cannot execute query");
		}
		
		//echo "Data successfully inserted.";
    }
    
    public function insertExperiment($values) {
    	$this->insert("experiment", $values);
    	//sqlite_query($this->dbhandle,"SELECT exp_id FROM experiment WHERE");
    	return sqlite_last_insert_rowid($this->dbhandle);
    }
    
    public function insertSurvey($values) {
    	$this->insert("survey", $values);
    	return sqlite_last_insert_rowid($this->dbhandle);
    }
    
    public function insertQuestion($values) {
    	$this->insert("question", $values);
    	return sqlite_last_insert_rowid($this->dbhandle);
    }
    
    public function insertSurveyQuestionAnswer($values) {
		$this->insert("answer", $values);
    	return sqlite_last_insert_rowid($this->dbhandle);
    }
    
	public function insertUserQuestionAnswer($values) {
		$this->insert("user_answer", $values);
    	return sqlite_last_insert_rowid($this->dbhandle);
    }
    
    public function insertParticipant($values) {
    	$this->insert("participant", $values);
    	return sqlite_last_insert_rowid($this->dbhandle);
    }
    
    public function insertAdministrator ($name, $pass) {
    	$this->open();
    	echo 'inserting admin';
    	$this->insert("administrator", "'$name', '$pass'");
    	echo 'done';
    	$this->close();
    }
    
    public function createUserQuestion($values) {
    	$this->insert("user_questions", $values);
    	return sqlite_last_insert_rowid($this->dbhandle); //Do we need a return here? -> No?
    }
    
    //$_REQUEST['nameofinput']
    public function printExperiments($type){
    	// execute a query    
		$result = sqlite_query($this->dbhandle,"SELECT * FROM experiment");
		if (!$result) die("Cannot execute query.");

		while($user = sqlite_fetch_object($result))
		{
			echo ( ($user->exp_id % 2) ? '<tr>' : '<tr class="alt">' ).'<td>'.$user->exp_id.'</td><td>'.$user->name.'</td><td>'.$user->admin_id.'</td>';	
			echo ( ($type == "0") ? '</tr>' : '<td><a href="#" class="edit">Edit</a></td>  <td><a href="#" class="delete">Delete</a></td></tr>');
		}		
    } 
	
	public function	getExperiments(){
		//$this->open();
		$result = sqlite_query($this->dbhandle,"SELECT * FROM experiment");
		if (!$result) die("Cannot execute query.");
		//$this->close();
		return $result;
	}
	
	// Queries the database and returns survey object
	public function	getRandomSurveyFromExperiment($exp_id){
		$this->open();
		
		//get sur_id's
		$surveys = array();
		$result = sqlite_query($this->dbhandle, "SELECT * FROM survey WHERE exp_id='$exp_id'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result);
		while ($row != null) {
			$surveys[] = $row["sur_id"];
			$row = sqlite_fetch_array($result);
		}
		
		//pick ones with least reponses, then randomize
		$minSurveys = array();
		$minSurveys[] = current($surveys);
		$surveyItem = next($surveys);
		while ($surveyItem != null) {
			$candidatesSurveyItem = $this->getNumberOfSurveyCandidates($surveyItem);
			$candidatesCurrentMinSurvey = $this->getNumberOfSurveyCandidates(current($minSurveys));
			if ($candidatesSurveyItem < $candidatesCurrentMinSurvey) {
				$minSurveys = array();
				$minSurveys[] = $surveyItem;
			}
			else if ($candidatesSurveyItem == $candidatesCurrentMinSurvey){
				$minSurveys[] = $surveyItem;
			}
			
			$surveyItem = next($surveys);
		}
		
		$sur_id = $minSurveys[array_rand($minSurveys, 1)];
		
		//var_dump($sur_id);
		//echo '$sur_id: ',$sur_id;
		
		$result = sqlite_query($this->dbhandle, "SELECT * FROM survey WHERE exp_id='$exp_id' AND sur_id='$sur_id'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result);
		//var_dump($row);
		
		$survey = new Survey();
		$survey->surveyProperties["name"] = $row["name"];
		$survey->surveyProperties["outputFilename"] = $row["output_filename"];
		$survey->surveyProperties["cssFilename"] = $row["css_filename"];
		$survey->surveyProperties["thankYouPage"] = $row["thank_you_page"];

		$survey->surveyProperties["surveyTableProperties_questionsPerPage"] = $row["questions_per_page"];
		$survey->surveyProperties["surveyTableProperties_pseudoRandomWidth"] = $row["pseudo_random_width"];
		$survey->surveyProperties["surveyTableProperties_numberNonRandom"] = $row["numberNonRandom"];
		$survey->surveyProperties["surveyTableProperties_width"] = $row["table_width"];
		$survey->surveyProperties["surveyTableProperties_alignment"] = $row["table_alignment"];
		$survey->surveyProperties["surveyTableProperties_borderThickness"] = $row["table_border_thickness"];
		$survey->surveyProperties["surveyTableProperties_cellPadding"] = $row["table_cell_padding"];
		$survey->surveyProperties["surveyTableProperties_cellSpacing"] = $row["table_cell_spacing"];

		$survey->surveyProperties["headerProperties_customHeader"] = $row["custom_header"];
		$survey->surveyProperties["headerProperties_leftTitle"] = $row["header_left_title"];
		$survey->surveyProperties["headerProperties_rightTitle"] = $row["header_right_title"];
		$survey->surveyProperties["headerProperties_alignment"] = $row["header_alignment"];
		$survey->surveyProperties["headerProperties_borderThickness"] = $row["header_border_thickness"];
		$survey->surveyProperties["headerProperties_padding"] = $row["header_padding"];
		$survey->surveyProperties["headerProperties_spacing"] = $row["header_spacing"];

		$survey->surveyProperties["surveyLeftColumnProperties_width"] = $row["left_column_width"];
		$survey->surveyProperties["surveyLeftColumnProperties_alignment"] = $row["left_column_alignment"];
		$survey->surveyProperties["surveyLeftColumnProperties_borderThickness"] = $row["left_column_border_thickness"];
		$survey->surveyProperties["surveyLeftColumnProperties_padding"] = $row["left_column_padding"];
		$survey->surveyProperties["surveyLeftColumnProperties_spacing"] = $row["left_column_spacing"];
		
		$survey->surveyProperties["surveyRightColumnProperties_width"] = $row["right_column_width"];
		$survey->surveyProperties["surveyRightColumnProperties_alignment"] = $row["right_column_alignment"];
		$survey->surveyProperties["surveyRightColumnProperties_borderThickness"] = $row["right_column_border_thickness"];
		$survey->surveyProperties["surveyRightColumnProperties_padding"] = $row["right_column_padding"];
		$survey->surveyProperties["surveyRightColumnProperties_spacing"] = $row["right_column_spacing"];
		
		$survey->surveyProperties["paginationTextProperties_view"] = $row["pagination_text_view"];
		$survey->surveyProperties["paginationTextProperties_alignment"] = $row["pagination_text_alignment"];
		$survey->surveyProperties["paginationTextProperties_position"] = $row["pagination_text_position"];
		
		$survey->surveyProperties["paginationButtonsTableProperties_width"] = $row["pagination_buttons_width"];
		$survey->surveyProperties["paginationButtonsTableProperties_alignment"] = $row["pagination_buttons_alignment"];
		$survey->surveyProperties["paginationButtonsTableProperties_borderThickness"] = $row["pagination_buttons_border_thickness"];
		$survey->surveyProperties["paginationButtonsTableProperties_padding"] = $row["pagination_buttons_padding"];
		$survey->surveyProperties["paginationButtonsTableProperties_spacing"] = $row["pagination_buttons_spacing"];
		
		$result = sqlite_query($this->dbhandle, "SELECT * FROM question WHERE sur_id='$sur_id'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result);
		while ($row != null) {
			$surveyQuestion = new SurveyQuestion(
				$row['item_code'],
				$row['item'],
				$row['response_type']
			);
			$surveyQuestion->id = $row['que_id'];
			$survey->addSurveyQuestion($surveyQuestion);
			
			$row = sqlite_fetch_array($result);
		}
		
		$result = sqlite_query($this->dbhandle, "SELECT * FROM user_questions WHERE sur_id='$sur_id'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result);
		while ($row != null) {
			$userQuestion = new UserQuestion(
				$row['question']
			);
			$userQuestion->id = $row['user_question_id'];
			$survey->addUserQuestion($userQuestion);
			
			$row = sqlite_fetch_array($result);
		}
		
		$this->close();
		
		$survey->sur_id = $sur_id;
		$survey->exp_id = $exp_id;
		
		return $survey;
	}
	
	public function getItemCode($que_id) {
		$result = sqlite_query($this->dbhandle, "SELECT * FROM question WHERE que_id = $que_id");
		if (!$result) die("Cannot execute query.");
		$row = sqlite_fetch_object($result);
		
		return ($row!= null)?$row->item_code:0;
	}
	
	public function extractAnswersToCVS($exp_id, $name) {
		$this->open();
		$result = sqlite_query($this->dbhandle,"SELECT * FROM survey WHERE exp_id = $exp_id");
		if (!$result) die("Cannot execute query.");

		$list = array();
		$files = array();
		
		while($sur = sqlite_fetch_object($result))
		{
			$title = '../results/'.$name.'_'.$sur->name.'.csv';
			$files[] = $title;
			$fp = fopen($title, 'w');
			
			$res2 = sqlite_query($this->dbhandle,"SELECT * FROM participant WHERE sur_id = $sur->sur_id");
			if (!$res2) die("Cannot execute query.");  
			$i = 1;
			while($par = sqlite_fetch_object($res2)) {
				//print user personal answers
				/*$res3 = sqlite_query($this->dbhandle, "SELECT * FROM user_answer WHERE part_id = $par->part_id");
				if (!$res3) die("Cannot execute query.");
				while($u_ans = sqlite_fetch_object($res3)) {
					//TODO finish
					$list[] = array($par->part_id, $u_ans->);
					
				}*/
				
				//print answers to questions
				$res4 = sqlite_query($this->dbhandle, "SELECT * FROM answer WHERE part_id = $par->part_id ORDER BY position DESC");
				if (!$res4) die("Cannot execute query.");
				while($ans = sqlite_fetch_object($res4)) {
					$item_code = $this->getItemCode($ans->que_id);
					$list[] = array($i, $ans->date, $ans->position, $item_code, $ans->answer);
				}
				$i ++;
			}
			
			foreach ($list as $fields) {
    			fputcsv($fp, $fields);
			}
			
			fclose($fp);
		}
		
		$this->close();
		return $files;
	}
	
	public function deleteExperiment($exp_id) {
		$this->open();
		$res1 = sqlite_query($this->dbhandle, "SELECT * FROM survey WHERE exp_id = '$exp_id'");
		if (!$res1) die ("Cannot execute select query");
		while ($sur = sqlite_fetch_object($res1)) {
			$res2 = sqlite_query($this->dbhandle,"DELETE FROM question WHERE sur_id = '$sur->sur_id'");
			if (!$res2) die("Cannot execute delete query.");
			$res2 = sqlite_query($this->dbhandle,"DELETE FROM user_questions WHERE sur_id = '$sur->sur_id'");
			if (!$res2) die("Cannot execute delete query.");
			$res3 = sqlite_query($this->dbhandle, "SELECT * FROM participant WHERE sur_id = '$sur->sur_id'");
			if (!$res3) die("Cannot execute select query");
			while ($par = sqlite_fetch_object($res3)) {
				$res4 = sqlite_query($this->dbhandle,"DELETE FROM answer WHERE part_id = '$par->part_id'");
				if (!$res4) die("Cannot execute select query");
				$res4 = sqlite_query($this->dbhandle,"DELETE FROM user_answer WHERE part_id = '$par->part_id'");
				if (!$res4) die("Cannot execute select query");
			}
			$res2 = sqlite_query($this->dbhandle,"DELETE FROM participant WHERE sur_id = '$sur->sur_id'");
			if (!$res2) die("Cannot execute delete query.");
		}
		$result = sqlite_query($this->dbhandle,"DELETE FROM survey WHERE exp_id = '$exp_id'");
		if (!$result) die("Cannot execute delete query.");
		
		$res0 = sqlite_query($this->dbhandle,"DELETE FROM experiment WHERE exp_id = '$exp_id'");
		if (!$res0) die("Cannot execute delete query.");
		$this->close();
		return "success";
	}
	
	public function getFilename($exp_id) {
		$this->open();
		$result = sqlite_query($this->dbhandle, "SELECT * FROM experiment WHERE exp_id='$exp_id'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_object($result);
		$this->close();
		return ($row!=NULL)? $row->filename:'0';
	}
	
	public function getNumberOfSurveys($exp_id) {
		$result = sqlite_query($this->dbhandle, "SELECT COUNT(exp_id) FROM survey WHERE exp_id='$exp_id'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result);
		return ($row!=NULL)? $row['COUNT(exp_id)']:'0';
	}
	
	public function getNumberOfSurveyCandidates($sur_id) {
		//$result = sqlite_query($this->dbhandle, "SELECT COUNT(DISTINCT part_id) FROM participant WHERE sur_id ='$sur_id'");
		$result = sqlite_query($this->dbhandle, "SELECT COUNT(part_id) FROM (SELECT DISTINCT part_id from participant WHERE sur_id ='$sur_id')");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result);
		return ($row!=NULL)? $row['COUNT(part_id)']:'0';
	}
	
	public function getSurveys($exp_id) {
		$result = sqlite_query($this->dbhandle, "SELECT * FROM survey WHERE exp_id='$exp_id'");
		if (!$result) die ("Cannot execute query.");
		return $result;
		
	}
	
	public function printUser(){
		$this->open();
		$result = sqlite_query($this->dbhandle, "SELECT * FROM administrator");
		if (!$result) die ("Cannot execute query.");
		$user = sqlite_fetch_object($result);
		echo 'hey user: '.$user->admin_id.' pass: '.$user->password;
		$this->close();
	}
	
	//1 TRUE 0 FALSE
	public function getUser ($name, $password) {
		$this->open();
		$result = sqlite_query($this->dbhandle, "SELECT * FROM administrator WHERE admin_id='$name' AND password='$password'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result, SQLITE_ASSOC);
		$this->close();
		return ($row!=NULL)? 1:0;
	}
	
	public function changePassword($id,$oldPass, $newPass) {
		$isOK = $this->getUser($id, $oldPass);
		$this->open();
		if ($isOK) {
			$stm = "UPDATE administrator SET password = '$newPass' WHERE admin_id = '$id'";
			$ok = sqlite_exec($this->dbhandle, $stm);
			if (!$ok){
				throw new Exception("ERROR: Could not update value in the table.");
				die("Cannot execute query");
			}
			$result = "success";
		} else $result = "error";
		$this->close();
		return $result;
	}
	
	public function uploadExperiment(Experiment $exp, $name, $filename, $admin) {
		$this->open();
		// Insert experiment
		try {
			$exp_id = $this->insertExperiment("NULL, '".$admin."', '".$name."','".$filename."'");
		} catch (Exception $e) {
			return 'Error while inserting experiment. '.$e;
		}
		// Insert survey
		try {
			
		foreach ($exp->surveys as $sur) {
			$sur_id = $this->insertSurvey("NULL, 
			'".$exp_id."', 
			'".$sur->surveyProperties['name']."', 
			'".$sur->surveyProperties['surveyTableProperties_pseudoRandomWidth']."', 
			'".$sur->surveyProperties['surveyTableProperties_numberNonRandom']."', 
			'".$sur->surveyProperties['outputFilename']."', 
			'".$sur->surveyProperties['cssFilename']."', 
			'".$sur->surveyProperties['thankYouPage']."', 
			'".$sur->surveyProperties['surveyTableProperties_questionsPerPage']."', 
			'".$sur->surveyProperties['surveyTableProperties_width']."', 
			'".$sur->surveyProperties['surveyTableProperties_alignment']."', 
			'".$sur->surveyProperties['surveyTableProperties_borderThickness']."', 
			'".$sur->surveyProperties['surveyTableProperties_cellPadding']."', 
			'".$sur->surveyProperties['surveyTableProperties_cellSpacing']."', 
			'".$sur->surveyProperties['headerProperties_customHeader']."', 
			'".$sur->surveyProperties['headerProperties_leftTitle']."',
			'".$sur->surveyProperties['headerProperties_rightTitle']."', 
			'".$sur->surveyProperties['headerProperties_alignment']."',
			'".$sur->surveyProperties['headerProperties_borderThickness']."', 
			'".$sur->surveyProperties['headerProperties_padding']."',
			'".$sur->surveyProperties['headerProperties_spacing']."', 
			'".$sur->surveyProperties['surveyLeftColumnProperties_width']."',
			'".$sur->surveyProperties['surveyLeftColumnProperties_alignment']."', 
			'".$sur->surveyProperties['surveyLeftColumnProperties_borderThickness']."',
			'".$sur->surveyProperties['surveyLeftColumnProperties_padding']."', 
			'".$sur->surveyProperties['surveyLeftColumnProperties_spacing']."',
			'".$sur->surveyProperties['surveyRightColumnProperties_width']."', 
			'".$sur->surveyProperties['surveyRightColumnProperties_alignment']."',
			'".$sur->surveyProperties['surveyRightColumnProperties_borderThickness']."', 
			'".$sur->surveyProperties['surveyRightColumnProperties_padding']."',
			'".$sur->surveyProperties['surveyRightColumnProperties_spacing']."', 
			'".$sur->surveyProperties['paginationTextProperties_view']."',
			'".$sur->surveyProperties['paginationTextProperties_alignment']."', 
			'".$sur->surveyProperties['paginationTextProperties_position']."',
			'".$sur->surveyProperties['paginationButtonsTableProperties_width']."', 
			'".$sur->surveyProperties['paginationButtonsTableProperties_alignment']."',
			'".$sur->surveyProperties['paginationButtonsTableProperties_borderThickness']."', 
			'".$sur->surveyProperties['paginationButtonsTableProperties_padding']."',
			'".$sur->surveyProperties['paginationButtonsTableProperties_spacing']."'");
		
			// Insert User Info Questions
			$i = 0;
			$userQuestionCount = count($sur->userQuestions);
			while ($i < $userQuestionCount) {
				$this->createUserQuestion('NULL, "'.$sur_id.'","'.$sur->userQuestions[$i]->userItem.'"');
				$i++;
			}
			
			$i = 0;
			// Insert Questions in Survey
			$surveyItemsCount = count($sur->surveyQuestions);
			while ($i < $surveyItemsCount) {
				$this->insertQuestion ('NULL, "'.$sur_id.'",
					"'.$sur->surveyQuestions[$i]->itemCode.'", "'.$sur->surveyQuestions[$i]->item.'", 
					"'.$sur->surveyQuestions[$i]->responseType.'"');
				$i++;
			}
			
		}
		
		} catch (Exception $e) {
			$this->deleteExperiment($exp_id);
			return  '<p class="error">Error while inserting Survey. </p>'.$e;
		}
		
		$this->close();
	}
}
?>
