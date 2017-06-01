<?php

// Bookmark: generator.steps.php at line 542

/*
 * Database: test_e-front
 * View: timeslot_teach
 * Column count: 12
 * Filename: draft.test_e-front.timeslot_teach.1.php
 * Created Thu, 01 Jun 2017 23:40:05 +0200
 * Primary key: idtimeslot_teach, dayslot_iddayslot
 * phpMyEdit does NOT work with multiple primary keys
 * Null columns: start_time, timeslot_work_minutes, timeslot_school_year
 * Key columns: professor_idprofessor, tmima_idtmima
 * All columns: idtimeslot_teach, professor_idprofessor, start_time, timeslot_work_minutes,
timeslot_school_year, tmima_idtmima, tmima_lesson_idlesson,
tmima_lesson_tmima_idtmima, tmima_lesson_tmima_taxi_idtaxi,
tmima_lesson_tmima_taxi_ypokatastima_idypokatastima,
tmima_lesson_tmima_taxi_ypokatastima_company_idcompany, dayslot_iddayslot
*/

// Bookmark: header.php Bootstrap layout options generator.steps.php at line 658

$omit_div_container = 0; // Default is 0. Set 1 for a 100%-wide layout in List mode (1 = omit DIV CONTAINER)

// Bookmark: generator.steps.php at line 667

$opts['tb'] = 'timeslot_teach';

$sn = 0; // server number

require_once('inc/pme.config.php'); // options, db handle, and header

require_once('inc/header.php'); // header

//echo '<h2 class="text-info">'.$opts['db'].'.'.$opts['tb'].'</h2>'."\n";

echo '<div class="alert alert-info" role="alert"> <p>By default, the sort_field is set to descending order of Column 0. Since Column 0 is commonly an autoincrement field, recently added records will be displayed first in List mode. If not desirable, users can easily change this in the generated scripts.</p> </div>'."\n";

$opts['sort_field'] = array('-idtimeslot_teach');

$opts['key'] = 'idtimeslot_teach'; // primary key

$opts['key_type'] = 'int';

// A VIEW is a stored SELECT query, not a MyISAM table.
// Un-editable. Need to do more research on how this might be made editable.
$opts['options'] = 'ACPVDFL'; // ACPVDFL
echo "\n".'<p>Data appearing below is compiled from a MySQL VIEW (a view is essentially a stored query; options restricted to VFL)</p>';

// Bookmark: generator.steps.php at line 794

# TOGGLE PREFERENCE DISABLED. LIMITED COLUMNS FOUND. ALTERING FILE NAME.
# SETTING $pme['tweak']['toggle'] = 0;
# RENAMING OUT PUT FILE: draft.test_e-front.timeslot_teach.0.php

// Example of persistent variables
// $opts['cgi']['persist'] = array('sn' => $sn);



// Begin phpMyEdit column array compilation in generator.steps.php at line 1053

// column 0: `idtimeslot_teach` int(11)
// flags: auto_increment

$opts['fdd']['idtimeslot_teach'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => 'R',
  'name'       => 'Idtimeslot Teach',
  'options'    => 'VDFL', // to remove from display in List mode, or set VD
  'select'     => 'T',
  'size'       => 10,
  'sort'       => true
);
// If the tab feature is implemented, the first column must have a tab
// $opts['fdd']['idtimeslot_teach']['tab|ACP'] = 'Idtimeslot Teach';


// column 1: `professor_idprofessor` int(11)

$opts['fdd']['professor_idprofessor'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Professor Idprofessor',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 2: `start_time` varchar(45)

$opts['fdd']['start_time'] = array(
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 45,
  'name'       => 'Start Time',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 45,
  'sqlw'       => 'IF($val_qas = "", NULL, $val_qas)',
  'sort'       => true
);


// column 3: `timeslot_work_minutes` int(11)

$opts['fdd']['timeslot_work_minutes'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Timeslot Work Minutes',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'IF($val_qas = "", NULL, $val_qas)',
  'sort'       => true
);


// column 4: `timeslot_school_year` varchar(45)

$opts['fdd']['timeslot_school_year'] = array(
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 45,
  'name'       => 'Timeslot School Year',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 45,
  'sqlw'       => 'IF($val_qas = "", NULL, $val_qas)',
  'sort'       => true
);


// column 5: `tmima_idtmima` int(11)

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


// column 6: `tmima_lesson_idlesson` int(11)

$opts['fdd']['tmima_lesson_idlesson'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Lesson Idlesson',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 7: `tmima_lesson_tmima_idtmima` int(11)

$opts['fdd']['tmima_lesson_tmima_idtmima'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Lesson Tmima Idtmima',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 8: `tmima_lesson_tmima_taxi_idtaxi` int(11)

$opts['fdd']['tmima_lesson_tmima_taxi_idtaxi'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Lesson Tmima Taxi Idtaxi',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 9: `tmima_lesson_tmima_taxi_ypokatastima_idypokatastima` int(11)

$opts['fdd']['tmima_lesson_tmima_taxi_ypokatastima_idypokatastima'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Lesson Tmima Taxi Ypokatastima Idypokatastima',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 10: `tmima_lesson_tmima_taxi_ypokatastima_company_idcompany` int(11)

$opts['fdd']['tmima_lesson_tmima_taxi_ypokatastima_company_idcompany'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Tmima Lesson Tmima Taxi Ypokatastima Company Idcompany',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
  'sort'       => true
);


// column 11: `dayslot_iddayslot` int(11)

$opts['fdd']['dayslot_iddayslot'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Dayslot Iddayslot',
  'options'    => 'ACPVDFL',
  'select'     => 'T',
  'size'       => 10,
  'sqlw'       => 'TRIM("$val_as")',
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
