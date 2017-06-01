<?php

// Bookmark: generator.steps.php at line 542

/*
 * Database: test_e-front
 * View: company
 * Column count: 2
 * Filename: draft.test_e-front.company.0.php
 * Created Thu, 01 Jun 2017 23:39:30 +0200
 * Primary key: idcompany
 * Null columns: company_name
 * All columns: idcompany, company_name
*/

// Bookmark: header.php Bootstrap layout options generator.steps.php at line 658

$omit_div_container = 0; // Default is 0. Set 1 for a 100%-wide layout in List mode (1 = omit DIV CONTAINER)

// Bookmark: generator.steps.php at line 667

$opts['tb'] = 'company';

$sn = 0; // server number

require_once('inc/pme.config.php'); // options, db handle, and header

require_once('inc/header.php'); // header

//echo '<h2 class="text-info">'.$opts['db'].'.'.$opts['tb'].'</h2>'."\n";

echo '<div class="alert alert-info" role="alert"> <p>By default, the sort_field is set to descending order of Column 0. Since Column 0 is commonly an autoincrement field, recently added records will be displayed first in List mode. If not desirable, users can easily change this in the generated scripts.</p> </div>'."\n";

$opts['sort_field'] = array('-idcompany');

$opts['key'] = 'idcompany'; // primary key

$opts['key_type'] = 'int';

// A VIEW is a stored SELECT query, not a MyISAM table.
// Un-editable. Need to do more research on how this might be made editable.
$opts['options'] = 'ACPVDFL'; // ACPVDFL
echo "\n".'<p>Data appearing below is compiled from a MySQL VIEW (a view is essentially a stored query; options restricted to VFL)</p>';

// Bookmark: generator.steps.php at line 794
// Example of persistent variables
// $opts['cgi']['persist'] = array('sn' => $sn);



// Begin phpMyEdit column array compilation in generator.steps.php at line 1053

// column 0: `idcompany` int(11)
// flags: auto_increment

$opts['fdd']['idcompany'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => 'R',
  'name'       => 'Idcompany',
  'options'    => 'VDFL', // to remove from display in List mode, or set VD
  'select'     => 'T',
  'size'       => 10,
  'sort'       => true
);
// If the tab feature is implemented, the first column must have a tab
// $opts['fdd']['idcompany']['tab|ACP'] = 'Idcompany';


// column 1: `company_name` varchar(45)

$opts['fdd']['company_name'] = array(
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 45,
  'name'       => 'Company Name',
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
