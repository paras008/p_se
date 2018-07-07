<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<script src="jquery-1.12.4.js"></script>
	<script type="text/javascript" src="jquery-ui.js"></script>
	<script type="text/javascript" src="bootstrap.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<style type="text/css">
		.nav li a { color: #fff !important; }
		.navbar-inverse .navbar-nav>li>a:focus, .navbar-inverse .navbar-nav>li>a:hover {
			color: #000 !important;
		    background-color: #2196f3;
		}
	</style>
</head>
<body style="background: #a1a1a1;">
    <?php if (isset($_SESSION['username'])) { ?>
    	<nav class="navbar navbar-inverse">
    	  <div class="container-fluid">
    	    <div class="navbar-header">
    	      <a class="navbar-brand" href="index.php">Stock Market</a>
    	    </div>
    	    <ul class="nav navbar-nav">
    	      <li><a href="index.php">Home</a></li>
    	      <li><a href="analysis.php">Analysis</a></li>
    	      <li><a href="watchlist.php">Watchlist</a></li>
    	      <li><a href="portfolio.php">Portfolio</a></li>
    	    </ul>
    	    <ul class="nav navbar-nav pull-right">
    	      <li><a href="logout.php">Log Out</a></li>
    	    </ul>
    	  </div>
    	</nav>
	<?php } else { ?>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.php">Stock Market</a>
		    </div>
		    <ul class="nav navbar-nav">
		      <li><a href="index.php">Home</a></li>
		      <li><a href="analysis.php">Analysis</a></li>
		    </ul>
		    <ul class="nav navbar-nav pull-right">
		      <li><a href="login.php">Log In</a></li>
		      <li><a href="register.php">Register</a></li>
		    </ul>
		  </div>
		</nav>
	<?php } ?>
