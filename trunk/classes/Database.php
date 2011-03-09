<?php
class Database
{
    // property declaration
    public $name;
	private $dbhandle;
    // constructor
    public function __construct() {
        $this->name = "../SQLite/database.db";
    }
    
    //Create a new database
    // Warning: Overwrites current database
    public function createEmptySQLite() {
    	$fileHandle = fread($f, filesize('../SQLite/create.txt'));
    	$dbHandle = sqlite_open("../SQLite/database.db", 0666, $error);
		if (!$dbHandle) die ($error);
		$ok = sqlite_exec($dbHandle, $fileHandle, $error);
		if (!$ok) die("Cannot execute query. $error");
		echo "Database created successfully";
		sqlite_close($dbHandle);
    }
    
    //Create a new database using SQLite3 format instead of SQLite2
    // Warning: Overwrites current database
    public function createEmptySQLite3() {
    	$name = "../SQLite/database.db3";
    	try {
    		$db = new PDO('sqlite:'.$name);
    		$db->exec($this->file);
    		$db = NULL;
    	} catch(PDOException $e) {
    		print 'Exception: '.$e->getMessage();
    	}
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
		$stm = "INSERT INTO ". $table." VALUES( ".$values." )";
 
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
    
    public function insertParticipant($values) {
    	$this->insert("participant", $values);
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
	
	public function deleteExperiment($exp_id) {
		$this->open();
		$result = sqlite_query($this->dbhandle,"DELETE FROM experiment WHERE exp_id = '$exp_id'");
		if (!$result) die("Cannot execute delete query.");
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
		$this->open();
		$result = sqlite_query($this->dbhandle, "SELECT COUNT(exp_id) FROM survey WHERE exp_id='$exp_id'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result);
		$this->close();
		return ($row!=NULL)? $row['COUNT(exp_id)']:'0';
	}
	
	public function printUser(){
		$result = sqlite_query($this->dbhandle, "SELECT * FROM administrator");
		if (!$result) die ("Cannot execute query.");
		$user = sqlite_fetch_object($result);
		echo 'hey user: '.$user->admin_id.' pass: '.$user->password;
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
			$sur_id = $this->insertSurvey("NULL,'".$exp_id."', '".$sur->surveyProperties['name']."', 
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
			$this->close();
			$this->open();
			
			$i = 0;
			while ($i < count($sur->surveyUserInfo)) {
				$this->createUserQuestion('NULL, "'.$sur_id.'","'.$sur->surveyUserInfo[$i].'"');
				$i++;
			}
			
			$i = 0;
			// Insert Questions in Survey
			while ($i < count($sur->surveyItems)) {
				$this->insertQuestion ('NULL, "'.$sur_id.'",
					"'.$sur->surveyItemCodes[$i].'", "'.$sur->surveyItems[$i].'", 
					"'.$sur->surveyResponseTypes[$i].'"');
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
