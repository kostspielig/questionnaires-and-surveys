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
    
    //Create a new database using SQLite3 format instead of SQLite2
    public function createDB3() {
    	$this->name = "../SQLite/database.db3";
    	try {
    		$db = new PDO('sqlite:'.$this->name);
    		$db->exec($this->file);
    		$db = NULL;
    	} catch(PDOException $e) {
    		print 'Exception: '.$e->getMessage();
    	}
    }
    
    // Lets check the retrieved file!
    public function displayFile() {
        echo $this->file;
    }
}
?>
