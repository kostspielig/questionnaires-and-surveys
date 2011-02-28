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
			<li><a href="experimentsView.php">Experiments</a></li>
			<li><a href="template.php">About</a></li>
			<li><span class="active">other</span></li>
		</ul>
			<div id="content" class="container_16 clearfix">
				<div class="grid_16">
					<h2>Submit Survey </h2>
					<p class="error">Something went wrong.</p>
				</div>

				<div class="grid_5">
					<p>
						<label for="title">Name <small>Must contain alpha characters.</small></label>
						<input type="text" name="name" />
					</p>
				</div>

				<div class="grid_5">
					<p>
						<label for="title">Location <small>Must contain alpha characters.</small></label>
						<input type="text" name="title" />
					</p>
						
				</div>
				<div class="grid_6">
					<p>
						<label for="title">Major</label>
						<select>
							<option>Computer Engineering</option>
							<option>Computer Science</option>
							<option>Informatics</option>
						</select>
					</p>
				</div>

				<div class="grid_16">
					<p>
						<label>Question <small>Will be displayed in search engine results.</small></label>
						<textarea></textarea>
					</p>
				</div>

				<div class="grid_16">
					<p>
						<label>Other Question <small>Markdown Syntax.</small></label>
						<textarea class="big"></textarea>
					</p>
					<p class="submit">
						<input type="reset" value="Reset" />
						<input type="submit" value="Send" />
					</p>
				</div>
			</div>
		
		<div id="foot">
					<a href="jsprouse@uci.edu">Contact Me</a>
		</div>
	</body>
</html>