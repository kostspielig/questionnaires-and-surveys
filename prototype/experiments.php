<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>Cognitive Surveys</title>
		<link rel="stylesheet" href="css/960.css" type="text/css" media="screen" charset="utf-8" />
		<!--<link rel="stylesheet" href="css/fluid.css" type="text/css" media="screen" charset="utf-8" />-->
		<link rel="stylesheet" href="css/template.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/colour.css" type="text/css" media="screen" charset="utf-8" />
	</head>
	<body>
		<form method="post" action="">
		<h1 id="head">COGNITI<FONT COLOR="#FFFAA4">VE</FONT><font style="font-size:120%"> S</font>UR<FONT COLOR="#FFFAA4">VEYS</FONT></h1>
		
		<ul id="navigation">
			<li><a href="dashboard.php">Admin</a></li>
			<li><span class="active">experiments</span></li>
			<li><a href="template.html">About</a></li>
			<li><a href="#">other</a></li>
		</ul>
		
			<div id="content" class="container_16 clearfix">
				<div class="grid_4">
					<p>
						<label>Experiment name<small></small></label>
						<input type="text" />
					</p>
				</div>
				<div class="grid_5">
					<p>
						<label>Type</label>
						<input type="text" />
					</p>
				</div>
				<div class="grid_5">
					<p>
						<label>&nbsp;</label>
						<input type="file" value="Upload" />
						<!--<label>Department</label>
						<select>
							<option>Development</option>
							<option>Marketing</option>
							<option>Design</option>
							<option>IT</option>
						</select> -->
					</p>
				</div>
				<div class="grid_2">
					<p>
						<label>&nbsp;</label>
						<input type="submit" value="Upload" />
					</p>
				</div>
				<div class="grid_16">
					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Owner</th>
								<th colspan="2" width="10%">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="5" class="pagination">
									<span class="active curved">1</span><a href="#" class="curved">2</a><a href="#" class="curved">3</a><a href="#" class="curved">4</a> ... <a href="#" class="curved">9</a>
								</td>
							</tr>
						</tfoot>
						<tbody>
						<?php require_once 'surveyDB.php';
							$survey = new surveyDB();
							$survey->open(); 
							$survey->printExperiments(1);
							$survey->close();?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
		<div id="foot">
					<a href="#">Contact Me</a>
				
		</div>
	</body>
</html>