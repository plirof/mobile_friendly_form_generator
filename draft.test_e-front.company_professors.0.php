<?php

// Bookmark: generator.steps.php at line 542

/*
 * Database: test_e-front
 * View: company_professors
 * Column count: 2
 * Filename: draft.test_e-front.company_professors.1.php
 * Created Thu, 01 Jun 2017 23:39:58 +0200
 * Key columns: professor_idprofessor, company_idcompany
 * All columns: professor_idprofessor, company_idcompany
*/

// Bookmark: header.php Bootstrap layout options generator.steps.php at line 658

$omit_div_container = 0; // Default is 0. Set 1 for a 100%-wide layout in List mode (1 = omit DIV CONTAINER)

// Bookmark: generator.steps.php at line 667

$opts['tb'] = 'company_professors';

$sn = 0; // server number

require_once('inc/pme.config.php'); // options, db handle, and header

require_once('inc/header.php'); // header

//echo '<h2 class="text-info">'.$opts['db'].'.'.$opts['tb'].'</h2>'."\n";

echo '<div class="alert alert-info" role="alert"> <p>By default, the sort_field is set to descending order of Column 0. Since Column 0 is commonly an autoincrement field, recently added records will be displayed first in List mode. If not desirable, users can easily change this in the generated scripts.</p> </div>'."\n";

$opts['sort_field'] = array('-professor_idprofessor');


// A VIEW is a stored SELECT query, not a MyISAM table.
// Un-editable. Need to do more research on how this might be made editable.
$opts['options'] = 'ACPVDFL'; // ACPVDFL
echo "\n".'<p>Data appearing below is compiled from a MySQL VIEW (a view is essentially a stored query; options restricted to VFL)</p>';

// Bookmark: generator.steps.php at line 794

# TOGGLE PREFERENCE DISABLED. LIMITED COLUMNS FOUND. ALTERING FILE NAME.
# SETTING $pme['tweak']['toggle'] = 0;
# RENAMING OUT PUT FILE: draft.test_e-front.company_professors.0.php

// Example of persistent variables
// $opts['cgi']['persist'] = array('sn' => $sn);



// Begin phpMyEdit column array compilation in generator.steps.php at line 1053

// column 0: `professor_idprofessor` int(11)
// flags: auto_increment

$opts['fdd']['professor_idprofessor'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => 'R',
  'name'       => 'Professor Idprofessor',
  'options'    => 'VDFL', // to remove from display in List mode, or set VD
  'select'     => 'T',
  'size'       => 10,
  'sort'       => true
);
// If the tab feature is implemented, the first column must have a tab
// $opts['fdd']['professor_idprofessor']['tab|ACP'] = 'Professor Idprofessor';


// column 1: `company_idcompany` int(11)

$opts['fdd']['company_idcompany'] = array(
  'css'        => array('postfix' => 'right-justify'),
  'default'    => '',
  'input'      => '',
  'maxlen|ACP' => 10,
//  'number_format|VDFL' => array(0, '.', ','),
  'name'       => 'Company Idcompany',
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
