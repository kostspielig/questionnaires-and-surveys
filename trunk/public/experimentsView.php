<?php
include 'auth.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php include '../includes/head.php' ?>

	<body>
		<h1 id="head">COGNITI<FONT COLOR="#FFFAA4">VE</FONT><font style="font-size:120%"> S</font>UR<FONT COLOR="#FFFAA4">VEYS</FONT></h1>
		
		<ul id="navigation">
			<li><a href="dashboard.php">Admin</a></li>
			<li><span class="active">Experiments</span></li>
			<li><a href="template.php">About</a></li>
			<li><a href="survey.php">other</a></li>
		</ul>
		<!--<?php include '../includes/navigationBar.php' ?>-->
		
		<form method="post" action="getfile.php" enctype="multipart/form-data">
			<div id="content" class="container_16 clearfix">
					<div class="grid_16">
					<h2>List of Experiments </h2>
					<?php
						if (isset($error))
							echo '<p class="error">'.$error.'</p>';
						else if (isset($success))
							echo '<p class="success">'.$success.'</p>';
						unset($error, $success);
					?>
				</div>

				<div class="grid_4">
					<p>
						<label for="file">Filename<small></small></label>
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
						
						<input type="file" name="file" id="file"/>
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
						<input type="submit" name="submit" value="Submit" />
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
						<?php require_once '../classes/surveyDB.php';
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
				<i>University of California Irvine </i><a href="http://www.uci.edu/">UCI</a>
			</div>
	</body>
</html>