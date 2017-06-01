<?php

// Bookmark: generator.steps.php at line 542

/*
 * Database: test_e-front
 * View: lesson
 * Column count: 12
 * Filename: draft.test_e-front.lesson.1.php
 * Created Thu, 01 Jun 2017 23:40:00 +0200
 * Primary key: idlesson, tmima_idtmima, tmima_taxi_idtaxi, tmima_taxi_ypokatastima_idypokatastima, tmima_taxi_ypokatastima_company_idcompany, taxi_id_school_class, taxi_ypokatastima_idypokatastima, taxi_ypokatastima_company_idcompany
 * phpMyEdit does NOT work with multiple primary keys
 * Null columns: mathites_number, speciality_required, lesson_name
 * Key columns: speciality_idspeciality
 * All columns: idlesson, mathites_number, tmima_idtmima, tmima_taxi_idtaxi,
tmima_taxi_ypokatastima_idypokatastima,
tmima_taxi_ypokatastima_company_idcompany, speciality_required,
speciality_idspeciality, taxi_id_school_class, taxi_ypokatastima_idypokatastima,
taxi_ypokatastima_company_idcompany, lesson_name
*/

// Bookmark: header.php Bootstrap layout options generator.steps.php at line 658

$omit_div_container = 0; // Default is 0. Set 1 for a 100%-wide layout in List mode (1 = omit DIV CONTAINER)

// Bookmark: generator.steps.php at line 667

$opts['tb'] = 'lesson';

$sn = 0; // server number

require_once('inc/pme.config.php'); // options, db handle, and header

require_once('inc/header.php'); // header

//echo '<h2 class="text-info">'.$opts['db'].'.'.$opts['tb'].'</h2>'."\n";

echo '<div class="alert alert-info" role="alert"> <p>By default, the sort_field is set to descending order of Column 0. Since Column 0 is commonly an autoincrement field, recently added records will be displayed first in List mode. If not desirable, users can easily change this in the generated scripts.</p> </div>'."\n";

$opts['sort_field'] = array('-idlesson');

$opts['key'] = 'idlesson'; // primary key

$opts['key_type'] = 'int';

// A VIEW is a stored SELECT query, not a MyISAM table.
// Un-editable. Need to do more research on how this might be made editable.
$opts['options'] = 'ACPVDFL'; // ACPVDFL
echo "\n".'<p>Data appearing below is compiled from a MySQL VIEW (a view is essentially a stored query; options restricted to VFL)</p>';

// Bookmark: generator.steps.php at line 794

# TOGGLE PREFERENCE DISABLED. LIMITED COLUMNS FOUND. ALTERING FILE NAME.
# SETTING $pme['tweak']['toggle'] = 0;
# RENAMING OUT PUT FILE: draft.test_e-front.lesson.0.php

// Example of persistent variables
// $opts['cgi']['persist'] = array('sn' => $sn);



// Begin phpMyEdit column array compilation in generator.steps.php at line 1053

// column 0: `idlesson` int(11)
// flags: auto_increment

$opts['fdd']['idlesson'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => 'R',
  'name'       => 'Idlesson',
  'options'    => 'VDFL', // to remove from display in List mode, or set VD
  'select'     => 'T',
  'size'       => 10,
  'sort'       => true
);
// If the tab feature is implemented, the first column must have a tab
// $opts['fdd']['idlesson']['tab|ACP'] = 'Idlesson';


// column 1: `mathites_number` varchar(45)

$opts['fdd']['mathites_number'] = array(
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 45,
  'name'       => 'Mathites Number',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 45,
  'sqlw'       => 'IF($val_qas = "", NULL, $val_qas)',
  'sort'       => true
);


// column 2: `tmima_idtmima` int(11)

$opts['fdd']['tmima_idtmima'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Idtmima',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 3: `tmima_taxi_idtaxi` int(11)

$opts['fdd']['tmima_taxi_idtaxi'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Taxi Idtaxi',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 4: `tmima_taxi_ypokatastima_idypokatastima` int(11)

$opts['fdd']['tmima_taxi_ypokatastima_idypokatastima'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Taxi Ypokatastima Idypokatastima',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 5: `tmima_taxi_ypokatastima_company_idcompany` int(11)

$opts['fdd']['tmima_taxi_ypokatastima_company_idcompany'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Taxi Ypokatastima Company Idcompany',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 6: `speciality_required` varchar(45)

$opts['fdd']['speciality_required'] = array(
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 45,
  'name'       => 'Speciality Required',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 45,
  'sqlw'       => 'IF($val_qas = "", NULL, $val_qas)',
  'sort'       => true
);


// column 7: `speciality_idspeciality` int(11)

$opts['fdd']['speciality_idspeciality'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Speciality Idspeciality',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 8: `taxi_id_school_class` int(11)

$opts['fdd']['taxi_id_school_class'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Taxi Id School Class',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 9: `taxi_ypokatastima_idypokatastima` int(11)

$opts['fdd']['taxi_ypokatastima_idypokatastima'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Taxi Ypokatastima Idypokatastima',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 10: `taxi_ypokatastima_company_idcompany` int(11)

$opts['fdd']['taxi_ypokatastima_company_idcompany'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Taxi Ypokatastima Company Idcompany',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 11: `lesson_name` varchar(45)

$opts['fdd']['lesson_name'] = array(
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 45,
  'name'       => 'Lesson Name',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 45,
  'sqlw'       => 'IF($val_qas = "", NULL, $val_qas)',
  'sort'       => true
);

// Bookmark: generator.steps.php at line 1918

require_once('inc/phpMyEdit.mysqli.php');

new phpMyEdit($opts);

if($warnings = mysqli_get_warnings($opts['dbh'])){
   printf('<p class="text-danger">Warnings: %s</p>', htmlentities(implode(', ', $warnings)));
}

mysqli_close($opts['dbh']);

require_once('inc/footer.php');

// Bookmark: generator.steps.php at line 1987

?>
