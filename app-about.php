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
<script src="https://use.fontawesome.com/5317e0bb81.js"></script>
</head>
<body>
<div class="container">
	<nav class="navbar navbar-dark bg-primary">
		<button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">&#9776;</button>
		<div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
			<ul class="nav navbar-nav">
				<li class="nav-item"> <a class="nav-link" href="app-form-generator.php">Create Script</a> </li>
				<li class="nav-item active"> <a class="nav-link" href="#">About</a> </li>
				<li class="nav-item"> <a class="nav-link" href="app-installation.php">Installation</a> </li>
				<li class="nav-item"> <a class="nav-link" href="app-docs.php" title="phpMyEdit Documentation Links">Documentation Links</a> </li>
			</ul>
			<span class="navbar-text float-xs-right text-white">for MySQL&trade; MyISAM tables and PHP</span>
		</div>
	</nav>
	<br>

	<div class="row">
		<div class="col-sm-12">
			<h2>PHP Form Generator Requirements &amp; Information</h2>
			<p><a href="http://www.phpmyedit.com/" target="_blank" title="phpMyEdit">phpMyEdit</a> is adequate for basic MySQL&trade; data management when using MyISAM type tables. Column 0 must be the unique identifier (i.e. multi-key tables are not supported). phpMyEdit's <a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.input-restrictions.html" target="_blank">JOIN syntax</a> can be rather challenging (if possible, use a VIEW created with phpMyAdmin and read by the script your create).</p>
			<p>Please read the Installation Instructions before purchasing this CRUD tool, an application designed to Create, Read, Update, or Delete database records.</p>

			<p class="text-danger"><i class="fa fa-warning" aria-hidden="true"></i> phpMyEdit does <u>not</u> work with multiple key tables, foreign key tables, or complex INNODB tables.</p>
			<p class="text-danger"><i class="fa fa-warning" aria-hidden="true"></i> No user authentication is built in, thus make your own security arrangement (such as placing this project in a password protected directory).</p>
			<p>Buyers must possess basic experience with MySQL&trade;, PHP, LAMP or WAMP environment, and phpMyAdmin. This app built and tested using PHP version 5.5.12 and MySQL&trade; version 5.6.17. This app was briefly and successfully tested under PHP version 7.</p>
			<p>This app uses MySQL&trade; version 5+ with MySQL&trade; Improved Connection and utf8 character set. If using a character set other than utf8, specify that character set when configuring the included database connection. The free version of phpMyEdit does not support Improved Connection methods.</p>
			<p>This app works best with MySQL&trade; MyISAM tables where the first column is the unique key, and PHP version 5+ with MySQLi extensions installed (Improved Connection methods).</p>
			<p>Users must install the provided <a href="txt/change_log.txt" target="_blank">`change_log`</a> schema. This feature essentially records changes made to various records.</p>
			<p>This app relies on a CDN (<a href="http://en.wikipedia.org/wiki/Content_delivery_network" target="_blank" title="content delivery network">content delivery network</a>) for the minified <a href="http://v4-alpha.getbootstrap.com//">Bootstrap v4.0.0-alpha.5</a> style sheet in the header, and in the footer, several minified JavaScript files. If you plan to use this app offline (e.g. without Internet connectivity in a WAMP environment) then you will need to download the remote style sheet and JavaScript files, save them to an appropriate location, and change the HTML links in the included header and footer scripts. View the source code of this page in order to see the links to various CDN locations. CDN usage decreases download time since many users already have those files in their browser cache. In theory, as future <a href="http://v4-alpha.getbootstrap.com//">Bootstrap v4.0.0-alpha.5</a> versions are released, users will be able to adopt new <a href="http://v4-alpha.getbootstrap.com//">Bootstrap v4.0.0-alpha.5</a> versions for this app by simply changing a few links in the included header and footer.</p>
			<p class="text-success">When forms are displayed on smartphones or tablets, <a href="http://v4-alpha.getbootstrap.com//">Bootstrap v4.0.0-alpha.5</a> creates responsive tables. In List mode, tables having a number of columns can be swiped sideways to display columns which aren't initially displayed. This app can be used with <a href="http://fontawesome.io/" target="_blank">FontAwesome</a> (request and embed the CDN script link).</p>
			<p>Scripts are initially configured to display the first 5 columns of data in List mode. Minor changes to the generated script will facilitate displaying additional columns. The default Bootstrap container (1280-pixel width on large displays) can easily be over-ridden to facilitate 100% page width.</p>
			<p>The filenaming convention applied to scripts is <code>draft.database.table.0.php</code> or <code>draft.database.table.1.php</code>. Multiple databases can be easily configured.</p>

			<p>Filenames ending in <code>1.php</code> have &quot;toggle&quot; links used to temporarily display column 6, 7, 8, etc.</p>
			<p>Filenames ending in <code>0.php</code> do not have &quot;toggle&quot; links. Edit the script in order to display additional columns (5 columns displayed by default).</p>
			<p class="text-success"><i class="fa fa-check" aria-hidden="true"></i> See the sample scripts: <a href="txt/example0.txt" target="_blank">example0.txt</a> and <a href="txt/example1.txt" target="_blank">example1.txt</a> while referring to the documentation <a href="app-docs.php#cheat">Cheat Sheet</a>.</p>
			<p>Use the &quot;toggle&quot; links sparingly since they add a LOT of code to the scripts, which may impact performance slightly.</p>

			<div class="alert alert-warning" role="alert">
				<p><b>Triggers and filters can be very useful.</b></p>
				<p>Don't casually delete records. Instead, flag them as deleted and exclude them in List mode by using a filter.</p>
				<p>When creating a MySQL&trade; table, consider adding this field: <code>`deleted` ENUM('0','1') default '0';</code></p>
				<p>Then use the included trigger file <code>./inc/triggers/mark_as_deleted.TDB.php</code> to flag records as deleted instead of actually deleting them. </p>
				<p>Following the author's preference, if your table contains a field named <code>`deleted`</code> then you will find the following code lines will automatically appear in your script.</p>
				<p>Set a filter in your script, which in List mode serves to exclude records where `deleted` = '1'. <br><code>$opts['filters'] = 'PMEtable0.deleted = &quot;0&quot;';</code></p>
				<p>Set a trigger in your script:<br><code>$opts['triggers']['delete']['before'] = './inc/triggers/mark_as_deleted.TDB.php';</code></p>
				<p>Comment out the `deleted` array in the generated script. Make sure the trigger is called (typically set in the config file).</p>
				<p>Test that this works as planned: add a test record, return to List mode, delete the record using the Delete icon, return to List mode and check that the record no longer appears in List mode, then use phpMyAdmin to access the table and confirm the test record exists in the database table.</p>
				<p>Taking the time to configure <code>`deleted` ENUM('0','1') default '0';</code> as a field, and add a trigger and add a filter can seem like a lot of work, but it isn't. Eventually a user will unintentionally delete a record. These precautions will save the data and the project administrator can un-delete the record(s).</p>
			</div>

			<div class="alert alert-info" role="alert">
				<p>phpMyEdit was commercially licensed for this project. Product names, logos, brands, and other trademarks featured or referred to within this website are the property of their respective trademark holders. These trademark holders are not affiliated with this website, nor do they sponsor or endorse this website. Contact the author: <a class="nav-link" title="&#100;&#111;ug&#64;&#104;&#111;c&#107;&#105;&#110;&#115;&#111;&#110;&#46;&#99;&#111;&#109;" href="mailto:d%6fu%67@ho%63%6b%69%6e%73%6f%6e%2eco%6d?subject=bootstrap%204%20beta%20php%20form%20generator">&#100;&#111;ug&#64;&#104;&#111;c&#107;&#105;&#110;&#115;&#111;&#110;&#46;&#99;&#111;&#109;</a></p>
			</div>

		</div>
	</div>

</div> 

<!-- jQuery first, then Tether, then Bootstrap JS, then local JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.8/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous" type="text/javascript"></script>
<script src="js/local.js" type="text/javascript"></script>
<script src="https://use.fontawesome.com/5317e0bb81.js"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rem/1.3.4/js/rem.min.js"></script>
<![endif]-->
</body>
</html>