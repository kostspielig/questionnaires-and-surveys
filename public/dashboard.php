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

		<h1 id="head">COGNITI<FONT COLOR="#FDF3C1">VE</FONT><font style="font-size:120%"> S</font>UR<FONT COLOR="#FDF3C1">VEYS</FONT></h1>
		
		<ul id="navigation">
			<li><span class="active">Admin</span></li>
			<li><a href="experimentsView.php">Experiments</a></li>
			<li><a href="template.php">About</a></li>
			<li><a href="survey.php">other</a></li>
			<li class="prev"><?php echo $_SESSION['login']?> &nbsp|<a href='logout.php'> Sign out</a></li>
		</ul>
		
			<div id="content" class="container_16 clearfix">
				<div class="grid_6">
					<div class="box">
						<h2>Info</h2>
						<div class="utils">
							<a href="about.html">View More</a>
						</div>
						<p><br/><strong>User : </strong> Professor Jon Sprouse<br/><br/><strong>Date : </strong> <?php echo date("Y.m.d") ?> </b><br/><br/><strong><a href="logout.php">Logout </a> </strong> </b></p><br/>
					</div>
					<div class="box">
						<h2>Upload Experiment</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table>
							<tbody>
							<tr> <td>
							<input type="file" name="upload_file"/> </td></tr>
							
							<tr><td><input type="submit" 
									name="upload_exp" 
									id="uploadbutton" 
									value="Upload"
									onclick="uploadExperiment()" />	</td>									
							</tbody> </tr>
						</table>
					</div>
				</div>
				<div class="grid_10">
					
					<div class="box">
						<h2>Experiments</h2>
						<div class="utils">
							<a href="experimentsView.php">View More</a>
						</div>
						<?php require_once '../classes/surveyDB.php';
							$survey = new surveyDB();
							$survey->open(); 
							echo '<table> <tbody> <tr>';
							$survey->printExperiments(0);
							echo '</tbody> </table>';
							$survey->close();?>
					</div>
				</div>
			</div>
		<div id="foot">
			<div class="container_16 clearfix">
				<div class="grid_16">
					<a href="#">Contact Me</a>
				</div>
			</div>
		</div>
	</body>
</html>