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
				<li class="nav-item"> <a class="nav-link" href="app-about.php">About</a> </li>
				<li class="nav-item active"> <a class="nav-link" href="app-installation.php">Installation</a> </li>
				<li class="nav-item"> <a class="nav-link" href="app-docs.php" title="phpMyEdit Documentation Links">Documentation Links</a> </li>
			</ul>
			<span class="navbar-text float-xs-right text-white">for MySQL&trade; MyISAM tables and PHP</span>
		</div>
	</nav>
	<br>

	<div class="row">
		<div class="col-sm-12">
			<h2>Installation and configuration of the PHP Form Generator</h2>
			<p>The provided files are essentially a copy of this website and include phpMyEdit, mobile friendly <a href="http://v4-alpha.getbootstrap.com//">Bootstrap v4.0.0-alpha.5</a> HTML5 markup, demo schema, and text files.</p>
			<p>Unzipping the archive will create a directory structure with about 150 files.</p>
			<p>Locate and modify the portions of the following 3 files, supplying database credentials.</p>
			<p>1.) <code>./generator-includes/step1.php</code> &mdash; builds the &quot;Select a database connection&quot; menu on the <a class="brand" href="app-form-generator.php" title="PHP Form Generator">PHP Form Generator</a> page.</p>
<pre class="pre-scrollable">
// Configure (multiple) databases beginning with $sn = 0;
$sn = 0;
$cfg['server'][$sn]['charset'] = 'utf8';
$cfg['server'][$sn]['hn'] = 'localhost'; // host
$cfg['server'][$sn]['db'] = 'test'; // database
$cfg['server'][$sn]['un'] = 'root'; // username
$cfg['server'][$sn]['pw'] = ''; // password
// Optionally configure additional database connections.
//$sn++;
//$cfg['server'][$sn]['charset'] = 'utf8';
//$cfg['server'][$sn]['log'] = 'change_log';
//$cfg['server'][$sn]['hn'] = 'localhost';
//$cfg['server'][$sn]['db'] = '';
//$cfg['server'][$sn]['pw'] = '';
//$cfg['server'][$sn]['un'] = '';
//$sn++;
//$cfg['server'][$sn]['charset'] = 'utf8';
//$cfg['server'][$sn]['log'] = 'change_log';
//$cfg['server'][$sn]['hn'] = 'localhost';
//$cfg['server'][$sn]['db'] = '';
//$cfg['server'][$sn]['pw'] = '';
//$cfg['server'][$sn]['un'] = '';
</pre>
			<p>2.) <code>./generator-includes/examples-include.php</code> &mdash; included by the <a href="app-examples.php" title="phpMyEdit Examples">phpMyEdit Examples</a> page; scans for files whose filename includes both the name of a configured database and <code>draft.</code>. This is primarily for the benefit of the online demo though it might be handy to retain while familiarizing yourself with this application.</p>
<pre class="pre-scrollable">
// multiple databases are configured in the online demo.
$db0 = 'test'; // Set this one for sure
$db1 = ''; // Empty if not using a 2nd database
$db2 = ''; // Empty if not using a 3rd database
</pre>
			<p>3.) <code>./inc/pme.config.php</code> &mdash; phpMyEdit script configuration includes many options, most importantly the database credentials.</p>
<pre class="pre-scrollable">
switch($sn) // $sn is written to scripts individually in order to select the appropriate log-in
{
   Case 0: // Your first (and/or only) database connection
      $opts['hn'] = 'localhost'; // host
      $opts['db'] = 'test'; // database
      $opts['un'] = 'root'; // username
      $opts['pw'] = ''; // password
      $opts['charset'] = 'utf8'; // utf8 highly recommended
      break;
   //Case 1: // Optional 2nd database
      //$opts['hn'] = 'localhost';
      //$opts['db'] = '';
      //$opts['un'] = '';
      //$opts['pw'] = '';
      //$opts['charset'] = 'utf8';
      //break;
   Case 2: // Optional 3rd database
      //$opts['hn'] = 'localhost';
      //$opts['db'] = '';
      //$opts['un'] = '';
      //$opts['pw'] = '';
      //$opts['charset'] = 'utf8';
      //break;
   //Optional 4th database would be added as follows
   //Case 3:
      //$opts['hn'] = 'localhost';
      //$opts['db'] = '';
      //$opts['un'] = '';
      //$opts['pw'] = '';
      //$opts['charset'] = '';
      break;
   default:
      abort('No database credentials specified');
      break;
}
</pre>
			<p>Optionally rename the directory and upload to your server. </p>
			<p>Apply password protection to the uploaded directory. Your website control panel may offer a &quot;Protect Directories&quot; utility.</p>
			<p>Use phpMyAdmin or a similar utility to install the <a href="txt/change_log.txt" target="_blank">`change_log`</a> schema which appears below. Rarely will you need to use the change log, yet when someone inadvertently deletes a record, you will be <em>very</em> glad this was implemented. See <a href="http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.logging.html" target="_blank" title="log user actions">logging user actions</a> with phpMyEdit forms. </p>
<pre class="pre-scrollable">
-- Table structure for table `change_log`
-- Highly recommended, especially for multi-user environments.
-- Disaster prevention.
.. http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.logging.html
CREATE TABLE IF NOT EXISTS `change_log` (
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(50) NOT NULL DEFAULT '',
  `host` varchar(255) NOT NULL DEFAULT '',
  `operation` varchar(50) NOT NULL DEFAULT '',
  `tab` varchar(50) NOT NULL DEFAULT '',
  `rowkey` varchar(255) NOT NULL DEFAULT '',
  `col` varchar(255) NOT NULL DEFAULT '',
  `oldval` mediumtext,
  `newval` mediumtext,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_tab` (`tab`),
  KEY `idx_col` (`col`),
  KEY `idx_operation` (`operation`),
  KEY `idx_rowkey` (`rowkey`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='See the change_log features of phpMyEdit';
</pre>
			<p>Point your web browser to <code>app-form-generator.php</code> and select a database connection.</p>
			<p><b>Make 1-2 scripts for the tables that you are most familiar with. Use the script in Add and Change modes. Determine if there is anything in particular that you do not like and then review <code>./generator-includes/generator.config.php</code> to see if there are configurable options that address your concern. For example display of the <code>'help|ACP'</code> option in Add/Change modes, or the display of column comments entered directly in the database structure using phpMyAdmin.</b></p>
			<p>Create scripts for all your tables after reviewing the above mentioned configuration file. Rename the generated scripts so that you don't inadvertently over-write them in the future after you've made modifications.</p>
			<p><strong>The default filename convention is in the format <code>draft.database.table.0.php</code>. Rename the files if you modify them.</strong></p>
			<p>Eventually you will want to modify the navbar which appears on phpMyEdit scripts, thus edit <code>./inc/header.php</code> and/or <code>./inc/footer.php</code>.</p>
			<p>Multiple style sheets are used. Altering the order in which they are included in <code>./inc/header.php</code> may have unexpected consequences.</p>
			<p>If your language is not English, references in <code>./inc/header.php</code> to <code>&quot;en-US&quot;</code> will need to be changed.</p>
			<p>Multiple JavaScript files may be in use. If you need to add JavaScript, add it to <code>./js/local.js</code>.</p>
<p>If you maintain an <code>.htaccess</code> file in the directory of this installation you may (or may not) want to consider including the following lines if they don't already exist.</p>
<pre class="pre-scrollable">
DirectoryIndex app-form-generator.php index.htm index.html
AddDefaultCharset UTF-8
Options All -Indexes
ServerSignature Off
</pre>
<p>If you maintain a <code>php.ini</code> file in the directory of this installation you may (or may not) want to consider including the following lines.</p>
<pre class="pre-scrollable">
;date.timezone = America/Denver
display_errors = Off
display_startup_errors = Off
;error_log = /home/username/logs/phperrors.txt
log_errors = On
magic_quotes_gpc = Off
mysql.allow_persistent Off
mysqli.allow_persistent Off
register_argc_argv = Off
register_globals = Off
track_errors = On
upload_max_filesize = 64M
zlib.output_compression = 1
zlib.output_compression_level = 1
zlib.output_handler =
</pre>
<p>Each generated script contains something like <code>$omit_div_container = 0;</code> where the value of <code>$omit_div_container</code> defaults to 0 unless Toggle Links are selected.<br><br>With toggle links, the value will be 1, resulting in 100% page width resulting from omission of <code>&lt;div class=&quot;container&quot;&gt;</code>.</p>
<p>However in modes Add, View, Change, Copy, and Delete a 100% wide layout is probably undesirable, thus <code>$omit_div_container</code> is conditionally reset to 0 in the configuration file. <br><br>For example, in Add mode if you really want your (otherwise 100% wide) forms left-justified instead of centered on the display, comment out or delete <code>$omit_div_container = 0;</code> inside /inc/pme.config.php, near lines 313 and/or 342</p>
<pre class="pre-scrollable">if(array_key_exists('PME_sys_operation', $_REQUEST)){

   $omit_div_container = 0; // prevent 100% page width in AVCPD modes

   switch($_REQUEST['PME_sys_operation'])
   {
      Case 'Change':        // if change is accessed from View mode
      Case 'PME_op_Apply':
      Case 'PME_op_Change': // if change is accessed from List mode
         $header_operation_label = 'Change';
         break;
      Case 'PME_op_Copy':
         $header_operation_label = 'Copy';
         break;
      Case 'Add':
         $header_operation_label = 'Add';
         break;
      Case 'PME_op_Delete':
         $header_operation_label = 'Delete';
         break;
      Case 'PME_op_View':
         $header_operation_label = 'View';
         break;
      default:
         break;
   }

}elseif(isset($_REQUEST['PME_sys_moreadd'])){

   $omit_div_container = 0; // prevent 100% page width in AVCPD modes

   $header_operation_label = 'Add';

}</pre>
		</div>
	</div>

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