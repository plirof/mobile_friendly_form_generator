<?php
// Header included by phpMyEdit scripts. 
// $omit_div_container "should" be set individually in each phpMyEdit script, but let's make sure.
// if(!isset($omit_div_container)){ $omit_div_container = 0; }
// Non-US users should modify below: lang="en-US"
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<!-- Required meta tags always come first -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<!-- Latest compiled and minified Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
<!-- default theme includes datepicker style  -->
<link rel="stylesheet" href="css/style.css">
<!-- amendments to Bootstrap + your custom CSS -->
<?php echo isset($pme_css) ? '<link rel="stylesheet" href="'.$pme_css.'">' : ''; ?><!-- see pme.config.php - page mode sensitive -->
<title><?php echo basename($_SERVER['PHP_SELF']); ?></title>
</head>
<body>
<div class="container">
	<nav class="navbar navbar-dark bg-primary">
		<button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">&#9776;</button>
		<div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
			<ul class="nav navbar-nav">
				<li class="nav-item"> <a class="nav-link" href="app-form-generator.php">Create Script <span class="sr-only">(current)</span></a> </li>
				<li class="nav-item"> <a class="nav-link" href="#">Your Link</a> </li>
				<li class="nav-item"> <a class="nav-link" href="#">Your Link</a> </li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> To Do </a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
						<a class="dropdown-item" href="#">Dropdown 1</a>
						<a class="dropdown-item" href="#">Dropdown 2</a>
						<a class="dropdown-item" href="#">Dropdown 3</a>
					</div>
				</li>
			</ul>
			<span class="navbar-text float-xs-right text-white">modify the navigation links to suit your project</span>
		</div>
	</nav>
	<br>

</div><!-- /container -->


<?php 
echo empty($omit_div_container) ? '<div class="container">'."\n" : '<div class="body-content">'."\n";
?>
