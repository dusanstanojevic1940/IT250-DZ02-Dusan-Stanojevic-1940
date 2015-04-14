<?php
	include "student.php";

	if ($_SERVER['REQUEST_METHOD']==="POST") {
		$s = new Student($_POST);
		print_r($s);
		die();
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Make My Shit</title>
	<meta name="description" content="Make My Shit Web Application"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<!-- Loading Bootstrap -->
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">

	<!-- Loading Font Awesome Icons -->
	<link href="css/font-awesome.min.css" rel="stylesheet">

	<!-- Loading Drunken Parrot UI -->
	<link href="css/drunken-parrot.css" rel="stylesheet">
	<link href="css/demo.css" rel="stylesheet">

	<!-- <link rel="shortcut icon" href="../images/favicon.ico"> -->

	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
	<!--[if lt IE 9]>
		<script src="../js/html5shiv.js"></script>
	<![endif]-->
</head>
<body data-spy="scroll" data-target="#sidenav" data-offset="100">
	
	<div class="row d-nav" id="navbars">
						
			<nav class="navbar navbar-inverse" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2"><span class="fa fa-bars"></span></button>
						<a href="index.html"><h1 style="color:white; padding-left:15px;  margin-left:15px;">Dodavanje Studenta</h1></a>
					</div>

				</div>
			</nav>
		</div>


	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-md-8" style="margin: auto; float: none;">
				<form action="index.php" method="POST">
					<div class="panel panel-default">
						<!-- Default panel contents -->
						<div class="panel-heading">Add Student</div>

						<!-- Table -->
						
							<table class="table">
									<tr>
										<th>Ime</th>
										<td><input type="text" class="form-control" name="ime"/></td>
									</tr>
									<tr>
										<th>Prezime</th>
										<td><input type="text" class="form-control" name="prezime"/></td>
									</tr>
									<tr>
										<th>Broj indeksa</th>
										<td><input type="text" class="form-control" name="brojIndeksa"/></td>
									</tr>
									<tr>
										<th>Adresa</th>
										<td><input type="text" class="form-control" name="adresa"/></td>
									</tr>
									<tr>
										<th>Email</th>
										<td><input type="text" class="form-control" name="email"/></td>
									</tr>
									<tr>
										<th>Sifra</th>
										<td><input type="password" class="form-control" name="sifra"/></td>
									</tr>
									<tr>
										<th>JMBG</th>
										<td><input type="text" class="form-control" name="jmbg"/></td>
									</tr>
									
							</table>
					</div>

							<input type="submit" class="btn btn-success pull-right"/>
						</form>
				</div>
			</div>
		</div>

	</div>
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/checkbox.js"></script>
	<script src="js/radio.js"></script>
	<script src="js/bootstrap-switch.js"></script>
	<script src="js/toolbar.js"></script>
	<script src="js/application.js"></script>

	</body>
</html>