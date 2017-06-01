<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- Latest compiled and minified Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
<!-- default theme includes datepicker style  -->
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
	<nav class="navbar navbar-dark bg-primary">
		<button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">&#9776;</button>
		<div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
			<ul class="nav navbar-nav">
				<li class="nav-item active"> <a class="nav-link" href="app-form-generator.php">Create Script</a> </li>
				<li class="nav-item"> <a class="nav-link" href="app-about.php">About</a> </li>
				<li class="nav-item"> <a class="nav-link" href="app-installation.php">Installation</a> </li>
				<li class="nav-item"> <a class="nav-link" href="app-docs.php" title="phpMyEdit Documentation Links">Documentation Links</a> </li>
			</ul>
			<span class="navbar-text float-xs-right text-white">mobile friendly form generator for MySQL&trade; MyISAM tables</span>
		</div>
	</nav>
	<br>

	<div class="row">
		<div class="col-sm-12">
			<?php require_once('generator-includes/step1.php'); ?>
			<br>
		</div>
	</div>

	<?php if($step == 2){ ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-block">
					<!-- ultimately, disable the next line and build your own menu here -->
					<?php require_once('generator-includes/examples-include.php'); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12"><br>
				<div class="alert alert-success" role="alert">
					<p>All sales final. No refunds. Basic skills with PHP &amp; MySQL&trade; are required. </p>
					<p>Before purchasing this project, please read the <a class="brand" href="app-installation.php" hreflang="en" title="PHP Form Generator">Installation</a> page. </p>
					<p>If you have questions, contact <a itemprop="email" href="mailto:d%6fu%67@ho%63%6b%69%6e%73%6f%6e%2eco%6d">&#100;&#111;ug&#64;&#104;&#111;c&#107;&#105;&#110;&#115;&#111;&#110;&#46;&#99;&#111;&#109;</a> before buying.</p>
					<p><a href="paypal/xSYu2G75mPHvc1r1.php?item_number=MFG2017" title="Purchase via PayPal" rel="nofollow"><img src="images/btn_xpressCheckout.gif" width="145" height="42" alt="Paypal"></a></p>
				</div>
			</div>
		</div>
	<?php } ?>

</div> 

<!-- jQuery first, then Tether, then Bootstrap JS, then local JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.8/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous" type="text/javascript"></script>
<script src="js/local.js" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rem/1.3.4/js/rem.min.js"></script>
<![endif]-->
</body>
</html>