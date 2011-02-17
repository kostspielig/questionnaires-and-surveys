<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Confirmation</title>
</head>

<body>

<?php

	$password = $_POST["password"];
	
	if($password === 'admin') {
		echo 'Login Successful';
		//log in and re-direct to admin panel.
		//include("admin_page.php");
		include("dashboard.php");
		
	}
	else {
		echo 'Login Failed';
	}
	
?>


</body>
</html>