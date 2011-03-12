<?php
include 'auth.inc.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Cognitive Surveys</title>
		<link rel="stylesheet" href="css/960.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/template.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/colour.css" type="text/css" media="screen" charset="utf-8" />
		<!--[if IE]><![if gte IE 6]><![endif]-->
		<script src="js/glow/1.7.0/core/core.js" type="text/javascript"></script>
		<script src="js/glow/1.7.0/widgets/widgets.js" type="text/javascript"></script>
		<link href="js/glow/1.7.0/widgets/widgets.css" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="images/fav.ico">
		<script type="text/javascript">
			glow.ready(function(){
				new glow.widgets.Sortable(
					'#content .grid_5, #content .grid_6',
					{
						draggableOptions : {
							handle : 'h2'
						}
					}
				);
			});
		</script>
		<!--[if IE]><![endif]><![endif]-->
	</head>
	<body>

		<h1 id="head"><FONT COLOR="#FDF3C1">C</FONT>OGNITIVE<font  COLOR="#FDF3C1" style="font-size:120%"> S</font><FONT COLOR="#FDF3C1">URVEYS</FONT></h1>
		
		<ul id="navigation">
			<li><span class="active">Admin</span></li>
			<li><a href="experimentsView.php">Experiments</a></li>
			<li><a href="Site Front/main_page.html">Site Front</a></li>
            
            <!--
            <li><a href="template.php">About</a></li>
			<li><a href="survey.php">other</a></li>
			-->
            
            <li class="prev"><?php echo $_SESSION['login']?> &nbsp|<a href='logout.php'> Sign out</a></li>
		</ul>
		
			<div id="content" class="container_16 clearfix">
				<div class="grid_6">
					<div class="box">
						<h2>Info</h2>
						<div class="utils">
							<a href="template.php">View More</a>
						</div>
						<p><br/><strong>User : </strong> Professor Jon Sprouse<br/><br/><strong>Date : </strong> <?php echo date("Y.m.d") ?> </b><br/></b></p><br/>
					</div>
					
					<div class="box">
					<h2>Change Password</h2>
					<form method="post" action="<?php $_SERVER['PHP_SELF']?>">
					Old password: <input type="text" name="oldPass">
					New password: <input type="text" name="newPass"/>
					<input type="submit" name="submit" value="submit"/>
					</form>
					<?php
   						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   							require_once '../classes/Database.php';
   							$d = new Database();
   							$res = $d->changePassword($_SESSION['login'],$_POST['oldPass'] ,$_POST['newPass']);
	   						error_reporting(0);
	   						
							if ($res == "error")
								echo '<p class="error">Incorrect Password, try again!</p>';
							else if ($res =="success")
								echo '<p class="success">Password correctly changed to '.$_POST['newPass'].'</p>';
						}
					?>
					</div>
					
				</div>
				
				<div class="grid_10">
					
					<div class="box">
						<h2>Experiments</h2>
						<div class="utils">
							<a href="experimentsView.php">View More</a>
						</div>
						<?php require_once '../classes/Database.php';
							$database = new Database();
							$database->open(); 
							echo '<table> <tbody> <tr>';
							$database->printExperiments(0);
							echo '</tbody> </table>';
							$database->close();?>
					</div>
					
					<div class="box">
						<h2>Upload Experiment</h2>
						<div class="utils">
							<a href="experimentsView.php">View More</a>
						</div>
						<table>
						<form method="post" action="getExperiment.php" enctype="multipart/form-data">
							<tbody>
							<tr> <td> <p></p>
							<label for="file">Experminent description<small></small></label>
							<input type="text" name="name"> </input></p>
							<input type="file"  name="file" value="file"/> </td></tr>
							
							<tr><td><input type="submit" 
									name="submit" value="submit" value="Submit" />	</td>	
									<!-- id="uploadbutton" 
									value="Upload"
									onclick="uploadExperiment()"-->
																	
							</tbody> </tr>
						</table>
						</form>
					</div>
				</div>
			</div>
		<div id="foot">
			<div class="container_16 clearfix">
				<div class="grid_16">
                
                	<!--
					<a href="#">Contact Me</a>
                    -->
                    (c) Copyright 2011. Jon Sprouse. All rights reserved.
                    
				</div>
			</div>
		</div>
	</body>
</html>