<?php

// Bookmark: generator.steps.php at line 542

/*
 * Database: phpvs_demo_2017
 * Table: a_test_table
 * Column count: 12
 * Filename: draft.phpvs_demo_2017.a_test_table.0.php
 * Created Tue, 06 Dec 2016 17:21:52 -0700
 * Primary key: smallint_column
 * Null columns: varchar_column
 * Key columns: flag_hidden_enum, deleted
 * All columns: smallint_column, varchar_column, email_varchar_column, http_varchar_column,
float_column, date_column, enum_column, set_column, text_column,
timestamp_column, flag_hidden_enum, deleted
*/

// Bookmark: header.php Bootstrap layout options generator.steps.php at line 658

$omit_div_container = 0; // Default is 0. Set 1 for a 100%-wide layout in List mode (1 = omit DIV CONTAINER)

// Bookmark: generator.steps.php at line 667

$opts['tb'] = 'a_test_table';

$sn = 0; // server number

require_once('inc/pme.config.php'); // options, db handle, and header

require_once('inc/header.php'); // header

// display a message only in List mode
if($list_mode_status){
	echo '<div class="alert alert-danger"> <p>Buyers will need to add the schema <a href="sql/a_test_table.txt" target="_blank">a_test_table.txt</a> to your database, typically by using phpMyAdmin.</p> </div> <div class="alert alert-info" role="alert"><h2 class="text-info">Sample script with Tabs displayed in Add, Change, and coPy modes, using '.$opts['db'].'.'.$opts['tb'].'</h2><p>Select Add, Change, or coPy mode in order to view three tabs configured to illustrate how tabs work. When tabs are initially displayed, Tab 1 is selected. Tabs are most useful when forms contain a large number of fields, or a number of TEXTAREA fields.</p></div><br>'."\n";
}else{
	echo "\n".'<div class="alert alert-info">Note the configured &quot;help|ACP&quot; elements in Add, Change, coPy mode.</div>';

}

$opts['sort_field'] = array('smallint_column');

$opts['key'] = 'smallint_column'; // primary key

$opts['key_type'] = 'smallint';

$opts['options'] = 'ACPVDFL';

// Bookmark: generator.steps.php at line 789
// Example of persistent variables
// $opts['cgi']['persist'] = array('sn' => $sn);

$opts['filters'] = 'PMEtable0.deleted = "0"'; // AND PMEtable0.hidden = "0";

$opts['triggers']['delete']['before'] = 'inc/triggers/mark_as_deleted.TDB.php';


// Begin phpMyEdit column array compilation in generator.steps.php at line 1048

// column 0: `smallint_column` smallint(5)
// flags: auto_increment

$opts['fdd']['smallint_column'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'help|ACP'   => 'comment for smallint_column',
  'input'      => 'R',
  'name'       => 'Smallint Column',
  'options'    => 'VD', // to display in List mode, or set VDFL
  'select'     => 'T',
  'size'       => 5,
  'sort'       => true
);
// If the tab feature is implemented, the first column must have a tab
$opts['fdd']['smallint_column']['tab|ACP'] = 'Tab 1';


// column 1: `varchar_column` varchar(255)

$opts['fdd']['varchar_column'] = array(
  'default'    => '',
  'help|ACP'   => 'comment for varchar_column',
  'input'      => '',
  'maxlen|ACP' => 255,
  'name'       => 'Varchar Column',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 72,
  'sqlw'       => 'IF($val_qas = "", NULL, $val_qas)',
  'sort'       => true
);


// column 2: `email_varchar_column` varchar(255)

$opts['fdd']['email_varchar_column'] = array(
  'default'    => '',
  'help|ACP'   => 'enter an email address e.g. none@foo.net',
  'input'      => '',
  'maxlen|ACP' => 255,
  'name'       => 'Email Varchar Column',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 72,
  'sqlw'       => 'TRIM("$val_as")',
  'URL'        => 'mailto:$value',
  'sort'       => true
);


// column 3: `http_varchar_column` varchar(255)

$opts['fdd']['http_varchar_column'] = array(
  'default'    => '',
  'help|ACP'   => 'Enter a domain name e.g. google.com',
  'input'      => '',
  'maxlen|ACP' => 255,
  'name'       => 'Http Varchar Column',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 72,
  'sqlw'       => 'TRIM("$val_as")',
  'URL'        => 'http://$value',
  'URLtarget'  => '_blank',
//  'URLdisp'    => 'Visit',
  'sort'       => true
);
$opts['fdd']['http_varchar_column']['tab|ACP'] = 'Tab 2';


// column 4: `float_column` float(8,2)

$opts['fdd']['float_column'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '1.23',
  'help|ACP'   => 'comment for float_column',
  'input'      => '',
  'maxlen|ACP' => 11,
  'number_format|VDFL' => array(2, '.', ','),
  'name'       => 'Float Column',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 8,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 5: `date_column` date

$opts['fdd']['date_column'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'help|ACP'   => 'comment for date_column',
  'input'      => '',
  'maxlen|ACP' => 10,
  'name'       => 'Date Column',
  'options'    => 'ACPVD',
  'select'     => 'N',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
//  'sql|VFL'     => 'if(float_column > "", CONCAT(DATE_FORMAT(float_column, "%a %b %e %Y")), "")',
  'sort'       => true
);


// column 6: `enum_column` enum('0','1','2','3','4','5')

$opts['fdd']['enum_column'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => 0,
  'help|ACP'   => 'comment for enum_column',
  'input'      => '',
  'maxlen|ACP' => 1,
  'name'       => 'Enum Column',
  'options'    => 'ACPVD',
  'select'     => 'D',
  'sqlw'       => 'TRIM("$val_as")',
  'values'     => array('0','1','2','3','4','5'), 
  'sort'       => true
);


// column 7: `set_column` set('a','b','c')

$opts['fdd']['set_column'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'help|ACP'   => 'comment for set_column',
  'input'      => '',
  'maxlen|ACP' => 5,
  'name'       => 'Set Column',
  'options'    => 'ACPVD',
  'select'     => 'M',
  'sqlw'       => 'TRIM("$val_as")',
  'values'     => array('a','b','c'), 
  'sort'       => true
);


// column 8: `text_column` text

$opts['fdd']['text_column'] = array(
  'default'    => '',
  'escape|VFL' => false, // set true if the column contains HTML markup
  'help|ACP'   => 'comment for text_column',
  'input'      => '',
  'maxlen|ACP' => 65535,
  'name'       => 'Text Column',
  'options'    => 'ACPVD',
  'select'     => 'T',
  'sqlw'       => 'TRIM("$val_as")',
//  'strip_tags|FL' => true,
  'textarea'   => array('rows' => 10, 'cols' => 90),
  'trimlen|FL' => 50,
  'sort'       => false
);
$opts['fdd']['text_column']['tab|ACP'] = 'Tab 3';



// column 9: `timestamp_column` timestamp
// flags: on, update, CURRENT_TIMESTAMP

$opts['fdd']['timestamp_column'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'help|ACP'   => 'comment for timestamp_column',
  'input'      => 'R',
  'maxlen|ACP' => 19,
  'name'       => 'Timestamp Column',
  'options'    => 'VDFL',
  'select'     => 'N',
  'size'       => 19,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 10: `flag_hidden_enum` enum('0','1')

$opts['fdd']['flag_hidden_enum'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => 0,
  'help|ACP'   => 'comment for flag_hidden_enum',
  'input'      => '',
  'maxlen|ACP' => 1,
  'name'       => 'Flag Hidden Enum',
  'options'    => 'ACPVD',
  'select'     => 'D',
  'sqlw'       => 'TRIM("$val_as")',
  'values'     => array('0','1'), 
  'sort'       => true
);


// column 11: `deleted` enum('0','1')

$opts['fdd']['deleted'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => 0,
  'help|ACP'   => 'comment for deleted',
  'input'      => '',
  'maxlen|ACP' => 1,
  'name'       => 'Deleted',
  'options'    => 'ACP',
  'select'     => 'D',
  'sqlw'       => 'TRIM("$val_as")',
  'values2'    => array('0' => 'No', '1' => 'Yes'),
  'sort'       => true
);
// Bookmark: omit ['js']['required'] for Author preference for specific column names

// Bookmark: generator.steps.php at line 1913

require_once('inc/phpMyEdit.mysqli.php');

if(array_key_exists('PME_sys_moreadd', $_REQUEST) || (isset($_REQUEST['PME_sys_operation']) && $_REQUEST['PME_sys_operation'] == 'Add')){ $opts['cgi']['overwrite']['deleted'] = '0'; }

new phpMyEdit($opts);

if($warnings = mysqli_get_warnings($opts['dbh'])){
   printf('<p class="text-danger">Warnings: %s</p>', htmlentities(implode(', ', $warnings)));
}

mysqli_close($opts['dbh']);

require_once('inc/footer.php');

// Bookmark: generator.steps.php at line 1982

?>
