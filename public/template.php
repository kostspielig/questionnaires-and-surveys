<?php
include 'auth.inc.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php include '../includes/head.php' ?>
	<body>
		<h1 id="head">COGNITI<FONT COLOR="#FDF3C1">VE</FONT><font style="font-size:120%"> S</font>UR<FONT COLOR="#FDF3C1">VEYS</FONT></h1>

		<ul id="navigation">
			<li><a href="dashboard.php">Admin</a></li>
			<li><a href="experimentsView.php">Experiments</a></li>
			<li><span class="active">About</span></li>
			<li><a href="survey.php">other</a></li>
			<li class="prev"><?php echo $_SESSION['login']?> &nbsp|<a href='logout.php'> Sign out</a></li>
		</ul>
		
		<div id="content" class="container_16 clearfix">
			<div class="grid_11">
				<h2>About</h2>
				<p>Assistant professor in the Department of Cognitive Sciences at the University of California, Irvine. </p>
				<h3>Academic</h3>
								
				<table class="academic">
					<tr>
						<td>2007-present</td>
						<td>Assistant Professor. Department of Cognitive Sciences, University of California, Irvine.</td>
					</tr>					
					<tr>
						<td>2007</td>

						<td>Ph.D. in Linguistics. University of Maryland, College Park.</td>
					</tr>
					<tr>
						<td>2003</td>
						<td>A.B. in Linguistics, summa cum laude. Princeton University.</td> 
					</tr>
				</table>
		</div>
			<div class="grid_5">
				<h2>Picture</h2>
				<ol>
				<IMG SRC="css/john2.jpg">
				<!--
					<li><a href="dashboard.html">Home (Dashboard)</a></li>
					<li><a href="news.html">Submit News Article (Forms)</a></li>
					<li><a href="user.html">User Listing (Tables &amp; Pagination)</a></li>
				-->
				</ol>
			</div>
		</div>

			<div id="foot">
				<i>University of California Irvine </i><a href="http://www.uci.edu/">UCI</a>
			</div><a href="Site Front/about_page.html">about_page</a>
		
	</body>
</html>