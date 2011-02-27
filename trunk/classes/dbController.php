<?php
class dbController
{
    // property declaration
    public $file;
    public $name;
    
    // constructor
    public function __construct() {
        $this->file = '../SQLite/create.txt';
        $this->name = "../SQLite/database.db";
		$f = fopen("$this->file", 'r');
		$this->file = fread($f, filesize($this->file ));
		fclose($f);
    }
    
    //Create a new database
    public function createDB() {
    	$dbhandle = sqlite_open("$this->name", 0666, $error);
		if (!$dbhandle) die ($error);
		$ok = sqlite_exec($dbhandle, $this->file, $error);
		if (!$ok) die("Cannot execute query. $error");
		echo "Database created successfully";
		sqlite_close($dbhandle);
    }
    
    // Lets check the retrieved file!
    public function displayFile() {
        echo $this->file;
    }
}
?>
