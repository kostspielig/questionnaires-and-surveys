<?php
class surveyDB
{
    // property declaration
    public $name;
	private $dbhandle;
    // constructor
    public function __construct() {
        $this->name = "../SQLite/database.db";
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
		if (!$ok) die("Cannot execute query");
 
		echo "Data successfully inserted.";
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
		$result = sqlite_query($this->dbhandle,"SELECT * FROM experiment");
		if (!$result) die("Cannot execute query.");
		return $result;
	}
	public function printUser(){
		$result = sqlite_query($this->dbhandle, "SELECT * FROM administrator");
		if (!$result) die ("Cannot execute query.");
		$user = sqlite_fetch_object($result);
		echo 'hey user: '.$user->admin_id.' pass: '.$user->password;
	}
	//1 TRUE 0 FALSE
	public function getUser ($name, $password) {
		$result = sqlite_query($this->dbhandle, "SELECT * FROM administrator WHERE admin_id='$name' AND password='$password'");
		if (!$result) die ("Cannot execute query.");
		$row = sqlite_fetch_array($result, SQLITE_ASSOC);
		return ($row!=NULL)? 1:0;
	}
}
?>
