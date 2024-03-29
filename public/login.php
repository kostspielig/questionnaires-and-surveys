<?php
session_start();
//filter incoming values
$login = (isset($_POST['login'])) ? trim($_POST['login']) : '';
$password =(isset($_POST['password'])) ? $_POST['login'] : '';
$redirect = (isset($_REQUEST['redirect'])) ? $_REQUEST['redirect'] : 'dashboard.php';

if (isset($_POST['submit'])){
	if (!isset($_SESSION['logged']) || $_SESSION['logged'] != 1) {
		require_once '..\classes\Database.php';
		$database = new Database();
		if ($database->getUser($_POST['login'],$_POST['password'])) {
			$_SESSION['login'] = $login;	
			$_SESSION['logged'] = 1;
			header('REFRESH: 0; URL='. $redirect);
			echo '<p> You will be redirected to your original page request. </p>';
			echo '<p> If your browser does\'t redirect you propertly ' . 'automatically, <a href = "'.$redirect.'"> click here</a>.</p>';
			die();
		} else { // set these explicitly just to make sure
			$_SESSION['login'] = '';
			$_SESSION['logged'] = 0;
			
			$error = 'You have supplied an invalid username and/or ' . ' password!';
			$error = '<p class="error">'.$error.'</p>';	
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Login</title>
	<link rel="stylesheet" href="css/template.css" type="text/css" media="screen" charset="utf-8" />

	<link rel="stylesheet" href="css/colour.css" type="text/css" media="screen" charset="utf-8" />
	<link href="css/login-box.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php
		if (isset($error)) {
			echo $error;
			unset($error);
		}
	?>
	<div style="padding: 100px 0 0 250px;">

		<div id="login-box">

			<br /><br /><br /><br /><br />
		
	<form action="login.php" method="post">
			<div id="login-box-name" style="margin-top:20px;">Login:</div><div id="login-box-field" style="margin-top:20px;"><input name="login" class="form-login" title="Username" value="" size="30" maxlength="2048" /></div>
			<div id="login-box-name">Password:</div><div id="login-box-field"><input name="password" type="password" class="form-login" title="Password" value="" size="30" maxlength="2048" /></div>
			<br />
			<!-- <span class="login-box-options"><input type="checkbox" name="1" value="1"> Remember Me <a href="#" style="margin-left:30px;">Forgot password?</a></span> -->
			<br />
			<br />
			<input type="hidden" name="redirect" value="<?php echo $redirect ?>"/>
			 <input type="submit" name="submit" value="Login" width="103" height="42" style="margin-left:90px;"/>
			<!-- <a href="login_confirmation.php"><img src="images/login-btn.png" width="103" height="42" style="margin-left:90px;" /></a>
		-->
	</form>
		</div>

	</div>

</body>
</html>
