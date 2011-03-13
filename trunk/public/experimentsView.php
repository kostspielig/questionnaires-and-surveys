<?php
include_once 'auth.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".delete-confirm-span").hide();
//	$(".show-properties-span").hide();
	$(".delete").click(function(){
		$(".delete-confirm-span").show();
		$(".delete").hide();
	});
	$(".no-confirm-delete").click(function(){
		$(".delete-confirm-span").hide();
		$(".delete").show();
	});
	$(".show-properties").click(function(){
		$(".show-properties-span").show();
		});

});
</script>
	<?php include '../includes/head.php' ?>

	<body>
		<h1 id="head"><FONT COLOR="#FDF3C1">C</FONT>OGNITIVE<font  COLOR="#FDF3C1" style="font-size:120%"> S</font><FONT COLOR="#FDF3C1">URVEYS</FONT></h1>
		
		<ul id="navigation">
			<li><a href="dashboard.php">Admin</a></li>
			<li><span class="active">Experiments</span></li>
            
            <!--
			<li><a href="template.php">About</a></li>
			<li><a href="survey.php">other</a></li>
            -->
            
		  <li class="prev"><?php echo $_SESSION['login']?> &nbsp|<a href='logout.php'> Sign out</a></li>
		</ul>
		<!--<?php include '../includes/navigationBar.php' ?>-->
		
		<form method="post" action="getExperiment.php" enctype="multipart/form-data">
			<div id="content" class="container_16 clearfix">
					<div class="grid_16">
					
					<?php
						if (isset($error))
							echo '<p class="error">'.$error.'</p>';
						else if (isset($success))
							echo '<p class="success">'.$success.'</p>';
						unset($error, $success);
					?></div>


                <p><h2>Upload Experiment</h2></p>
				<div class="grid_9">
					<p>
						<label for="file">Experiment description<small></small></label>
						<input type="text" name="name" />
					</p>
				</div>
				<!-- <div class="grid_5">
					<p>
						<label>Type</label>
						<input type="text" />
					</p>
				</div> -->
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


                <p>&nbsp;</p>
                <p><h2>List of Experiments</h2></p>
                <div class="grid_16">

					<table>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Owner</th>
								<th colspan="4" width="10%">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="5" class="pagination">
									<!-- <span class="active curved">1</span><a href="#" class="curved">2</a><a href="#" class="curved">3</a><a href="#" class="curved">4</a> ... <a href="#" class="curved">9</a> -->
								</td>
							</tr>
						</tfoot>
						<tbody>
						<?php require_once '../classes/Database.php';
						
							function Up($m, $id) {
								$m->deleteExperiment($id);
							}
							
							$database = new Database();
							$database->open();
							$result = $database->getExperiments();
							while($user = sqlite_fetch_object($result) ) {
								echo ( ($user->exp_id % 2) ? '<tr>' : '<tr class="alt">' ).'<td>'.$user->exp_id.
									'</td><td><a href="experimentsView.php?show='.$user->exp_id.'" class="show-properties">'.$user->name.'</a>';
								if (isset($_GET['show']))
									if ($_GET['show'] == $user->exp_id){
										echo '<table class="show-properties-span"><tr><td>Experiment Id:</td><td>'.$user->exp_id.'</td></tr>
											<tr><td>Administrator:</td><td>'.$user->admin_id.'</td></tr>
											<tr><td>Experiment name:</td><td>'.$user->name.'</td></tr>
											<tr><td>Filename:</td><td>'.$user->filename.'</td></tr>';
											$num = $database->getNumberOfSurveys($user->exp_id);
										echo '<tr><td>Number of surveys:</td><td>'.$num .'</td></tr>';
										if ($num != 0){
											$res = $database->getSurveys($user->exp_id);
											$i = 1;
											while ($sur = sqlite_fetch_object($res)) {
												echo '<tr><td>Survey '.$i.': </td><td>'.$sur->name.'</td></tr>';
												$i++;
											}
										}
										echo '<tr><td><a href="experimentsView.php" >Close</a></td></tr></tr></table>';
									}
								echo'</td><td>'.$user->admin_id.'</td>';	
								
								echo '<td><a href="takeExperiment.php?exp_id='.$user->exp_id.'" class="url">URL</a></td> 
									<td><a href="editExperiment.php?filename='.$user->filename.'" class="result">Download</a></td> 
									<td><a href="getResults.php?exp_id='.$user->exp_id.'&filename='.$user->filename.'" class="edit">Results</a></td> 
									<td><a href="#" class="delete">Delete</a><span class="delete-confirm-span">
									 	<a href="deleteExperiment.php?id='.$user->exp_id.'" class="delete-confirm">Yes</a>
									 	<a href="#" class="no-confirm-delete">No</a></span></td></tr>';
								echo '';
								
							}
							$database->close();
						?>
						</tbody>
				  </table>
			  </div>
			</div>
		</form>
			<div id="foot">
				<p><i>University of California Irvine </i><a href="http://www.uci.edu/">UCI</a>. (c) Copyright 2011. Jon Sprouse. All rights reserved.
			</p></div>
	</body>
</html>