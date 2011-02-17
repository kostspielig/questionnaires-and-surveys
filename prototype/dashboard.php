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

		<h1 id="head">COGNITI<FONT COLOR="#FFFAA4">VE</FONT><font style="font-size:120%"> S</font>UR<FONT COLOR="#FFFAA4">VEYS</FONT></h1>
		
		<ul id="navigation">
			<li><span class="active">Admin</span></li>
			<li><a href="template.html">About</a></li>
			<li><a href="survey.html">Other</a></li>
		</ul> 
		
			<div id="content" class="container_16 clearfix">
				<div class="grid_5">
					<div class="box">
						<h2>Info</h2>
						<div class="utils">
							<a href="about.html">View More</a>
						</div>
						<p><strong>User : </strong> John Sprouse<br /><strong>Date : </strong> <?php echo date("Y.m.d") ?> </b></p>
					</div>
					<div class="box">
						<h2>Experiments</h2>
						<div class="utils">
							<a href="experiments.php">View More</a>
						</div>
						<?php require_once 'surveyDB.php';
							$survey = new surveyDB();
							$survey->open(); 
							echo '<table> <tbody> <tr>';
							$survey->printExperiments(0);
							echo '</tbody> </table>';
							$survey->close();?>
					</div>
				</div>
				<div class="grid_6">
					<div class="box">
						<h2>Upload Experiment</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table>
							<tbody>
								<tr>
									<td>1 Post</td>
									<td>2 Comments</td>
								</tr>
								<tr>
									<td>1 Page</td>
									<td>2 Approved</td>
								</tr>
								<tr>
									<td>1 Categories</td>
									<td>0 Pending</td>
								</tr>
								<tr>
									<td>0 Tags</td>
									<td>0 Spam</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="box">
						<h2>Quick Post</h2>
						<div class="utils">
							<a href="#">Advanced</a>
						</div>
						<form action="#" method="post">
							<p>
								<label for="title">Title <small>Alpha-numeric characters only.</small> </label>
								<input type="text" name="title" />
							</p>
							<p>
								<label for="post">Post <small>Parsed by Markdown.</small> </label>
								<textarea name="post"></textarea>
							</p>
							<p>
								<input type="submit" value="post" />
							</p>
						</form>
					</div>
				</div>
				<div class="grid_5">
					<div class="box">
						<h2>Statistics</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table>
							<tbody>
								<tr>
									<td>News</td>
									<td>+ 120%</td>
								</tr>
								<tr>
									<td>Downloads</td>
									<td>+ 220%</td>
								</tr>
								<tr>
									<td>Users</td>
									<td>- 10%</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="box">
						<h2>Schedule</h2>
						<div class="utils">
							<a href="#">View More</a>
						</div>
						<table class="date">
							<caption><a href="#">Prev</a> November 2009 <a href="#">Next</a> </caption>
							<thead>
								<tr>
									<th>Mon</th>
									<th>Tue</th>
									<th>Wed</th>
									<th>Thu</th>
									<th>Fri</th>
									<th>Sat</th>
									<th>Sun</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td><a href="#">1</a></td>
								</tr>
								<tr>
									<td><a href="#">2</a></td>
									<td><a href="#">3</a></td>
									<td><a href="#">4</a></td>
									<td><a href="#">5</a></td>
									<td><a href="#">6</a></td>
									<td><a href="#">7</a></td>
									<td><a href="#">8</a></td>
								</tr>
								<tr>
									<td><a href="#">9</a></td>
									<td><a href="#">10</a></td>
									<td><a href="#" class="active">11</a></td>
									<td><a href="#">12</a></td>
									<td><a href="#">13</a></td>
									<td><a href="#">14</a></td>
									<td><a href="#">15</a></td>
								</tr>
								<tr>
									<td><a href="#">16</a></td>
									<td><a href="#">17</a></td>
									<td><a href="#">18</a></td>
									<td><a href="#">19</a></td>
									<td><a href="#">20</a></td>
									<td><a href="#">21</a></td>
									<td><a href="#">22</a></td>
								</tr>
								<tr>
									<td><a href="#">23</a></td>
									<td><a href="#">24</a></td>
									<td><a href="#">25</a></td>
									<td><a href="#">26</a></td>
									<td><a href="#">27</a></td>
									<td><a href="#">28</a></td>
									<td><a href="#">29</a></td>
								</tr>
								<tr>
									<td><a href="#">30</a></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<ol>
							<li>Draft contract template.</li>
							<li>Draft invoice template.</li>
							<li>Draft business cards.</li>
						</ol>
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