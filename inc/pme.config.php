<?php

// Affects all phpMyEdit scripts.

// see datepicker example at end of /js/local.js
//	$('#PME_data_date_column').datepicker({
//		format: 'yyyy-mm-dd'
//	});
// PME_data_ is predended to each column name.
// Look to around line 226 if you need to set the time zone with each query (because your remote server is in a different time zone).
// Use phpMyAdmin to install the change_log schema found in ./sql/change_log.sql 
$opts['log'] = 'change_log'; // becomes $opts['logtable'] in phpMyEdit scripts

// Configure switch($sn) for only Case 0 below (if you only need 1 database connection).
// Configure switch($sn) Case 1 below if you need 2 database connections.

// To facilitate access to multiple databases $sn is written to the generated scripts.

switch($sn) 
{
	Case 0: // Primary database connection
		$opts['hn'] = 'localhost'; // host
		$opts['db'] = 'test_e-front'; // database
		$opts['un'] = 'root'; // username
		$opts['pw'] = ''; // password
		$opts['charset'] = 'utf8'; // utf8 highly recommended
		break;
	// Case 1: // Optional 2nd database
		// $opts['hn'] = 'localhost';
		// $opts['db'] = 'test';
		// $opts['un'] = 'root';
		// $opts['pw'] = '';
		// $opts['charset'] = 'utf8';
		// break;
	// Case 2: // Optional 3rd database
		// $opts['hn'] = 'localhost';
		// $opts['db'] = 'test';
		// $opts['un'] = 'roou';
		// $opts['pw'] = '';
		// $opts['charset'] = 'utf8';
		// break;
	default:
		$errors[] = 'No database credentials specified';
		break;
}

// End of mandatory configuration. 

function htmlLink($qs, $field_name, $display_value, $tmp = 1, $ret = '')
{
	// Function used to generate toggle links. 
	// If you need to pass a page ID number or other variable, alter the unused placeholder incorporated below as tmp
	// $bqs = buffered query string (phpMyEdit system variables). $bqs begins with an ampersand.
   global $bqs;
   $css = empty($display_value) ? '' : ' active';
   $ret .= "\n".'<a class="dropdown-item'.$css.'" tabindex="-1" href="'.basename($_SERVER['PHP_SELF']).'?tmp='.$tmp.htmlspecialchars($bqs.$qs).'" title="'.$field_name.'">'.htmlspecialchars($field_name).'</a>';
   return $ret;
};

function get_cgi_var($name, $default_value = null)
{
	// Resolve $_GET or $_POST variables and/or arrays.
	// Required by scripts having Toggle links.
	static $magic_quotes_gpc = null;
	if($magic_quotes_gpc === null){
		$magic_quotes_gpc = @get_magic_quotes_gpc();
	}
	$var = @$_GET[$name];
	if(!isset($var)){
		$var = @$_POST[$name];
	}
	if(isset($var)){
		if($magic_quotes_gpc){
			if(is_array($var)){
				foreach (array_keys($var) as $key){
					$var[$key] = trim(stripslashes(strip_tags($var[$key])));
				}
			}else{
				$var = trim(stripslashes(strip_tags($var)));
			}
		}else{
			if(is_array($var)){
				foreach (array_keys($var) as $key){
					$var[$key] = trim(strip_tags($var[$key]));
				}
			}else{
				$var = trim(strip_tags($var));
			}
		}
	}else{
		$var = @$default_value;
	}
	return $var;
};

function abort($data = null)
{
	// Errors happen. die() pretty. Terminate the current operation using valid HTML.
	// $data passed to this function can be either a string or an array.
	global $cfg, $opts, $sn;
	if(empty($data)){
		echo "\n".'<p>Processing terminated. No reason specified.</p>';
	}elseif(!empty($data)){
		$tag = "\n".'<li>%s</li>';
		echo "\n".'<div class="alert alert-danger" role="alert"><ul>';
		if(is_array($data)){
			foreach($data as $val){
				if(empty($val)){
					continue;
				}
				if(is_array($val)){
					$val = implode(', ', $val);
				}
				$tmp = strip_tags($val);
				if($val == $tmp){
					printf($tag, htmlentities($val));
				}else{
					printf($tag, $val);
				}
			}
		}else{
			$tmp = strip_tags($data);
			if($data == $tmp){
				printf($tag, htmlentities($data));
			}else{
				printf($tag, $data);
			}
		}
		echo "\n".'</ul>';
		echo "\n".'</div>';
	}
	echo "\n".'</div><!-- /col -->';
	echo "\n".'</div><!-- /fow -->';
	echo "\n".'</div><!-- /container -->';
	require_once('inc/footer.php');	
	exit;
};

$errors = array();

$info = array();

if(empty($opts['hn'])){

	$errors[] = 'Host name is empty in '.basename(__FILE__);

}elseif(empty($opts['un'])){

	$errors[] = 'User name is empty in '.basename(__FILE__);

}elseif(empty($opts['db'])){

	$errors[] = 'Database name is empty in '.basename(__FILE__);

}

$opts['dbh'] = @mysqli_connect($opts['hn'], $opts['un'], $opts['pw'], $opts['db']);

if(!function_exists('mysqli_connect')){

	$errors[] = 'This application requires MySQL Improved connection methods. mysqli_connect() cannot be found.';

}

if(@mysqli_connect_errno()){

    $errors[] = 'MySQLi error number '.mysqli_connect_errno().': '.mysqli_connect_error();

}else{

	$host_info = mysqli_get_host_info($opts['dbh']);

	if($host_info == ''){

	    $errors[] = 'MySQLi error number '.mysqli_connect_errno().': '.mysqli_error($opts['dbh']);

	}

	if(!$link_charset = @mysqli_character_set_name($opts['dbh'])){

	    $info[] = 'Cannot resolve mysqli_character_set_name()';

	}else{

		if($link_charset != $opts['charset']){

			if(!mysqli_set_charset($opts['dbh'], $opts['charset'])){

			    $errors[] = 'Error loading character set: '.mysqli_error($opts['dbh']);

			}

		}

	}

	// Make sure a table is specified and that it exists.

	if(!isset($opts['tb'])){

	    $errors[] = 'Table is not set: $opts[\'tb\']';

	}elseif(!$table_exists = mysqli_query($opts['dbh'], sprintf('SELECT 1 FROM `%s` . `%s` LIMIT 0', $opts['db'], $opts['tb']))){

	    $errors[] = 'MySQLi error number '.mysqli_errno($opts['dbh']).': '.mysqli_error($opts['dbh']);

	}	

	// Implementation of the change_log schema from ./sql/change_log.sql is recommended.

	if($table_exists = mysqli_query($opts['dbh'], sprintf('SELECT 1 FROM `%s` . `%s` LIMIT 0', $opts['db'], $opts['log']))){

		if(isset($opts['tb']) && $opts['tb'] != $opts['log']){

			$opts['logtable'] = $opts['log'];

		}

	}else{

		$opts['logtable'] = ''; // Don't use the change log with itself

	}

	// Optionally set your time zone if the server is not in your time zone and you do not have root access to MySQL
	// http://stackoverflow.com/questions/930900/how-do-i-set-the-time-zone-of-mysql
	// https://en.wikipedia.org/wiki/List_of_UTC_time_offsets
	// Denver "-07:00", Chicago "-06:00", Paris or Slovakia "+01:00"
	// if(!mysqli_query($opts['dbh'], 'SET `time_zone` = "-07:00"')){ $errors[] = 'Failed timezone: '.@mysqli_error($opts['dbh']); }


}

// Possible / optional / conditional link for 'help|ACP' to launch a popup Help window
$help_link = '<a href="popup.php?tb=%s&amp;col=%s" target="_blank" class="pme-tab" onclick="openWinHelp(\'popup.php?tb=%s&amp;col=%s\',\'Help\',\'width=640,height=480,menubar=yes,scrollbars=yes\');return false;">Help</a>';

// To Do: explore Bootstrap Popover
//   'help|ACP'   => '<button type="button" class="btn btn-sm btn-primary" data-toggle="popover" title="Title" data-content="And here is some amazing content. It is very engaging. Right?">Bootstrap Popover</button>',

// Experimental
$opts['android'] = stristr($_SERVER['HTTP_USER_AGENT'], 'Android') === false ? 0 : 1;

// Navigation display: http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.navigation.html
// GUD = icons up and down; TUD = text labels (V,C,P,D) instead of icons might display more quickly.

if($opts['android']){
	$opts['navigation'] = 'GD';
	$opts['inc'] = 5; // LIMIT n (number of records for List mode)
}else{
	$opts['navigation'] = 'GUD';
	$opts['inc'] = 10; // LIMIT n (number of records for List mode)
}

// Navigation buttons. Available "Go To" buttons seriously degrade performance and are deliberately omitted.
// http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.navigation.html#AEN316

$opts['buttons']['F']['down'] = array('<<', '<', 'add', '>', '>>');

$opts['buttons']['F']['up'] = array('<<', '<', 'add', '>', '>>');

$opts['buttons']['L']['down'] = array('<<', '<', 'add', '>', '>>');

$opts['buttons']['L']['up'] = array('<<', '<', 'add', '>', '>>');

$opts['buttons']['V']['down'] = array('change', 'cancel');

$opts['buttons']['V']['up'] = array('change', 'cancel');

$opts['cgi']['append']['PME_sys_fl'] = 1; // Search row ON

// Special page elements: http://opensource.platon.sk/projects/doc.php/phpMyEdit/html/configuration.common-options.html

$opts['display'] = array('form' => true, 'num_pages' => true, 'num_records' => true, 'query' => true, 'sort' => true, 'tabs' => true, 'time' => false);

$opts['language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'en';

$opts['multiple'] = 4; // SELECT box size for SELECT MULTIPLE

$opts['url'] = array('images' => 'images/'); // Path to icons/images incl. trailing slash

// Determination of the current page mode (prior button click) is not straightforward (very tricky).
// Determination facilitates including different style sheets, or conditionally echo'ing helpful tips.
// $list_mode_status can optionally impact data (or CSS) echo'ed in the header and/or footer file.

if( !isset($_REQUEST['PME_sys_operation']) && !isset($_REQUEST['PME_sys_moreadd']) && !isset($_REQUEST['PME_sys_morechange']) ){

	$list_mode_status = 1; // List mode

	$header_operation_label = 'List';

	$pme_css = 'css/phpmyedit-list-mode.css';

}else{

	$list_mode_status = 0; // View mode or Add mode or Change mode or Delete mode

	$pme_css = 'css/phpmyedit-other-mode.css';

}

if(isset($_REQUEST['PME_sys_morechange']) && $_REQUEST['PME_sys_morechange'] == 'Apply'){

	$header_operation_label = 'Change';

}elseif(isset($_REQUEST['PME_sys_moreadd']) && $_REQUEST['PME_sys_moreadd'] == 'More'){

	$header_operation_label = 'Add';

}

if(array_key_exists('PME_sys_operation', $_REQUEST)){

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

}

if(!empty($errors)){

	require_once('inc/header.php');

	abort($errors);

}


// Frequently used 'values2' arrays might be configured here, and set in script as  'values2' => $OffOn
// $OffOn = array('0' => 'No', '1' => 'Yes');

// summary of possible button clicks
//if(empty($list_mode_status)){
	// List mode, thus $_POST['PME_sys_operation'] is NOT set
//}elseif(isset($_REQUEST['PME_sys_operation']) || isset($_REQUEST['PME_sys_moreadd']) || isset($_REQUEST['PME_sys_morechange']) || isset($_REQUEST['PME_sys_savechange'])){
	// $_POST['PME_sys_operation']: can be one of Add, Change, PME_op_Apply, PME_op_Change, PME_op_Copy, PME_op_Delete, PME_op_View 
	// or $_POST['PME_sys_moreadd']: More
	// or $_POST['PME_sys_morechange']: Apply
	// or $_POST['PME_sys_saveadd']: Save
	// or $_POST['PME_sys_savechange']: may be either Save or Submit
//}

?>

