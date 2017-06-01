<?php

/*
 * The main work-horse.
 * Configuration occurs in Step 3 around line 80 to line 180.
 * Do NOT indent HEREDOC variables defined below. 
 * We connected to at least one db before arriving here.
*/

$sn = isset($sn_selected) ? $sn_selected : intval(get_cgi_var('sn')); // Index value in the server array

$tb = get_cgi_var('tb'); // Empty on initial entry. Otherwise a table name.

$view = intval(get_cgi_var('view')); // Empty on initial entry. Default 0. Passed as 1 if a VIEW (as opposed to MyISAM table which is 0)

$step = get_cgi_var('step'); // Empty on initial entry. Passed in links to select a db or tb

if($step == ''){

	$step = 1;

}else{

	if($tb == ''){

		echo '<p>Below is a list of tables found in the database named `'.$cfg['server'][$sn]['db'].'`.</p>';

	}

}

// echo "\n".'<p>Step '.$step.'</p>';

if(!function_exists('mysqli_connect')){

	abort('This application requires MySQL Improved connection methods. mysqli_connect() cannot be found.');

}

if($step == 1){

	$step++;

	echo "\n".'<h2>phpMyEdit based PHP Form Generator<small> - MySQL Table Editor - wrapped in Bootstrap version 4 beta for mobile friendly display of data</small></h2><br>';

	echo my_configured_databases($step); 

}elseif($step == 2){

	// Display a list of tables found in the selected database.

	$step++;

	echo "\n".'<p>Create a phpMyEdit script by clicking either <a href="#" class="btn btn-sm btn-secondary" title="Include toggle links">Yes</a> or <a href="#" class="btn btn-sm btn-secondary" title="Omit toggle links">No</a> under the TOGGLE column. Your TOGGLE selection specifies whether or not to create links that enable you to add columns to List mode on-the-fly. </p>';
	echo "\n".'<p>In order to achieve the fastest performance, select <a href="#" class="btn btn-sm btn-secondary" title="Omit toggle links">No</a> and then consider changing the \'options\' setting for some (or all) of the un-displayed columns from \'ACPVD\' to \'ACPVDFL\'. </p>';


	echo "\n".'<p class="text-muted">Consider using the <a href="#" class="btn btn-sm btn-secondary" title="Include toggle links">Yes</a> selection with tables having a large number of columns. When toggle links are selected, you can optionally set <code>$omit_div_container = 1;</code> to omit the container DIV tag in order to use 100% of the display width.</p>';

	echo "\n".'<p class="text-muted">Column comments found during the next step can be optionally configured using <code>$pme[\'help_method\']</code> to be displayed as Help in the phpMyEdit script.</p>';


	echo my_table_list($step, $sn);

	echo "\n".'<p><a href="javascript:history.go(-1)" onmouseover="self.status=document.referrer;return true" class="pme-header" title="Go Back">Go Back</a></p>';

}elseif($step == 3){

	// Analyze the selected table & create phpMyEdit script
	// This very long loop --- nearly to the end of the script.
	// Be careful if making changes below. Test frequently if making changes.

	require_once('generator-includes/generator.config.php');

	$i = 0;

	$data = array();

	$data['_KEY_ERRORS'] = array();
	$data['_NAME_ERR'] = array();
	$data['AUTO_INCREMENT'] = array();
	$data['CHARACTER_MAXIMUM_LENGTH'] = array();
	$data['COLUMN_COMMENT'] = array();
	$data['COLUMN_DEFAULT'] = array();
	$data['COLUMN_KEY'] = array();
	$data['COLUMN_NAME'] = array();
	$data['COLUMN_NAME_LABEL'] = array();
	$data['COLUMN_NAME_TICK'] = array();
	$data['COLUMN_TYPE'] = array();
	$data['CSS']['ALIGN'] = array();
	$data['DATA_TYPE'] = array();
	$data['ENUM_ARRAY_STRING'] = array();
	$data['EXTRA'] = array();
	$data['FIELDS_QUOTED'] = array();
	$data['FOUND_COLUMN_TYPE'] = array();
	$data['FOUND_DATA_TYPE'] = array();
	$data['HTML_TAG'] = array();
	$data['IS_NULLABLE_FD_ARY'] = array();
	$data['ISNULL_BOOLEAN'] = array();
	$data['MULTI_KEY_FD_ARY'] = array();
	$data['NUMERIC_PRECISION'] = array();
	$data['ORDINAL_POSITION'] = array();
	$data['PRI_KEY_FD_ARY'] = array();
	$data['RESERVED_WORDS'] = array();
	$data['SET_ARRAY_STRING'] = array();
	$data['SQL_INSERT_COLS_TICKED'] = array();
	$data['TOKEN'] = array();
	$data['UNIQUE_KEY_FD_ARY'] = array();

	$qry = sprintf($table_sql, $cfg['server'][$sn]['db'], $tb);

	if($display_comments){

		echo '<p class="text-muted">Collecting information: '. nl2br(htmlentities($qry)).'</p>';

	}

	if($res = mysqli_query( $cfg['server'][$sn]['link'], $qry)){

		$num_rows = mysqli_num_rows($res);

		if(empty($num_rows)){

			abort('No rows returned. Make certain that tables exist in `'.$cfg['server'][$sn]['db'].'` - '.$tb.' - '. $qry);

		}else{

			// close container, row, column so that wide centered table can be rendered
			echo "\n".'</div></div></div>';

			echo "\n".'<table class="table table-bordered table-striped" style="margin: 0 20px 0 20px;">';

			echo "\n".'<tr><th style="text-align:center;" colspan="12">Analysis of `'.$cfg['server'][$sn]['db'].'` . `'.$tb.'`</th></tr>';
			echo "\n".'<tr>';

			echo "\n".'<td>POS</td>';

			echo "\n".'<td>COLUMN</td>';

			echo "\n".'<td>COLUMN<br>TYPE</td>';

			echo "\n".'<td>DATA<br>TYPE</td>';

			echo "\n".'<td>MAX<br>LEN</td>';

			echo "\n".'<td>DEFAULT<br>VALUE</td>';

			//echo "\n".'<td>NUMERIC<br>PRECISION</td>';

			echo "\n".'<td>COLUMN<br>KEY</td>';

			echo "\n".'<td>EXTRA</td>';

			echo "\n".'<td>NULLABLE</td>';

			echo "\n".'<td>CHAR<br>SET</td>';

			echo "\n".'<td>COLLATION</td>';

			echo "\n".'<td>COLUMN<br>COMMENT</td>';

			echo "\n".'</tr>';

			while($row = mysqli_fetch_array($res, MYSQLI_ASSOC)){

				$data['TOKEN'][$i] = 's'; // s,d,u could use some tweaking

				echo "\n".'<tr>';

				printf("\n".'<td>%s</td>', $row['ORDINAL_POSITION']);

				$data['ORDINAL_POSITION'][$i] = $row['ORDINAL_POSITION'];

				printf("\n".'<td>%s</td>', $row['COLUMN_NAME']);

				$data['COLUMN_NAME'][$i] = $row['COLUMN_NAME'];

				$data['COLUMN_NAME_TICK'][$i] = '`'.$row['COLUMN_NAME'].'`';

				if(!preg_match('/[a-z]{1}[a-z0-9_]+/i', $row['COLUMN_NAME'])){

					$data['_NAME_ERR'][$i] = $row['COLUMN_NAME'];

				}

				$data['COLUMN_NAME_LABEL'][$i] = ucwords(strtolower(strtr($row['COLUMN_NAME'], '_-.', '   ')));

				if(!empty($reserved_words) && in_array(strtolower($row['COLUMN_NAME']), $reserved_words)){

					$data['RESERVED_WORDS'][$i] = $row['COLUMN_NAME'];

				}

				$data['COLUMN_TYPE'][$i] = $row['COLUMN_TYPE'];

				if(strlen($row['COLUMN_TYPE']) > 30){

					$tmp = nl2br(wordwrap(htmlentities($row['COLUMN_TYPE']), 20, PHP_EOL, true));

					printf("\n".'<td>%s</td>', $tmp);

				}else{

					printf("\n".'<td>%s</td>', htmlentities($row['COLUMN_TYPE']));

				}

				printf("\n".'<td>%s</td>', $row['DATA_TYPE']);

				$data['DATA_TYPE'][$i] = $row['DATA_TYPE'];

				// Skip first column & skip timestamps when gathering columns for use in SQL statements

				if($i > 0 && $data['DATA_TYPE'][$i] != 'timestamp'){

					$data['SQL_INSERT_COLS_TICKED'][$i] = '`'.$row['COLUMN_NAME'].'`'; // For use with function sql_insert_stmt()

					$data['FIELDS_QUOTED'][$i] = '\''.$row['COLUMN_NAME'].'\'';  // For use with function sql_insert_stmt()

				}

				// Determine the type of HTML form tag.

				switch(strtolower($row['DATA_TYPE']))
				{
					case 'blob':
					case 'longblob':
					case 'longtext':
					case 'mediumblob':
					case 'mediumtext':
					case 'text':
					case 'tinyblob':
					case 'tinytext':
						$data['HTML_TAG'][$i] = 'textarea';
						break;

					case 'enum':
						$data['HTML_TAG'][$i] = 'select';
						$data['ENUM_ARRAY_STRING'][$i] = str_replace('enum(', 'array(', $data['COLUMN_TYPE'][$i]);
						break;

					case 'set':
						$data['HTML_TAG'][$i] = 'select';
						$data['SET_ARRAY_STRING'][$i] = str_replace('SET(', 'array(', $data['COLUMN_TYPE'][$i]);
						break;

					default:
						$data['HTML_TAG'][$i] = 'input';
						break;
				};

				// A FEW TYPES HAVE THEIR LENGTH ARBITRARILY SET BELOW, WHILE MOST ARE CALCULATED.

				// $data['CHARACTER_MAXIMUM_LENGTH'][$i]

				// Certain column types often display best when right-aligned .

				switch(strtolower($row['DATA_TYPE']))
				{

					case 'date':
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = 10;
						$data['CSS']['ALIGN'][$i] = 'right';
						break;

					case 'datetime':
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = 19;
						$data['CSS']['ALIGN'][$i] = 'right';
						break;

					case 'time':
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = 8;
						$data['CSS']['ALIGN'][$i] = 'right';
						break;

					case 'timestamp':
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = 19;
						$data['CSS']['ALIGN'][$i] = 'right';
						break;

					case 'year':
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = 4;
						$data['CSS']['ALIGN'][$i] = 'right';
						break;

					case 'bigint':
					case 'bit':
					case 'boolean':
					case 'decimal': // may need work if decimal (10,5) is picked up as 10; forget; maybe need to look again at NUMERIC_PRECISION
					case 'double':
					case 'float':
					case 'int':
					case 'mediumint':
					case 'real':
					case 'serial':
					case 'smallint':
					case 'tinyint':
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = $row['NUMERIC_PRECISION'];
						$data['CSS']['ALIGN'][$i] = 'right';
						break;

					case 'binary':
					case 'blob':
					case 'char':
					case 'longblob':
					case 'longtext':
					case 'mediumblob':
					case 'mediumtext':
					case 'text':
					case 'tinyblob':
					case 'tinytext':
					case 'varbinary':
					case 'varchar':
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = $row['CHARACTER_MAXIMUM_LENGTH'];
						$data['CSS']['ALIGN'][$i] = 'left';
						break;

					case 'enum':
					case 'set':
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = $row['CHARACTER_MAXIMUM_LENGTH'];
						$data['CSS']['ALIGN'][$i] = 'right';
						break;

					// Unlikely but possible column types
					//case 'geometry':
					//case 'geometrycollection':
					//case 'linestring':
					//case 'multilinestring':
					//case 'multipoint':
					//case 'multipolygon':
					//case 'point':
					//case 'polygon':
						//$data['CHARACTER_MAXIMUM_LENGTH'][$i] = $row['NUMERIC_PRECISION'];
						//$data['CHARACTER_MAXIMUM_LENGTH'][$i] = $row['CHARACTER_MAXIMUM_LENGTH'];
						//$data['CSS']['ALIGN'][$i] = 'right';
						//break;

					default:
						$data['CHARACTER_MAXIMUM_LENGTH'][$i] = 'UNKNOWN';
						$data['CSS']['ALIGN'][$i] = 'left';
						break;
				};

				if(isset($data['CHARACTER_MAXIMUM_LENGTH'][$i])){

					printf("\n".'<td>%s</td>', $data['CHARACTER_MAXIMUM_LENGTH'][$i]);

				}elseif($row['NUMERIC_PRECISION'] != ''){

					printf("\n".'<td>[%s]</td>', $row['NUMERIC_PRECISION']);

				}elseif($row['CHARACTER_MAXIMUM_LENGTH'] != ''){

					printf("\n".'<td>[%s]</td>', '[config error]');

				}

				if(strlen($row['COLUMN_DEFAULT']) > 20){

					$tmp = nl2br(wordwrap(htmlentities($row['COLUMN_DEFAULT']), 20, PHP_EOL, true));

					printf("\n".'<td>%s</td>', $tmp);

				}else{

					printf("\n".'<td>%s</td>', htmlentities($row['COLUMN_DEFAULT']));

				}

				$data['COLUMN_DEFAULT'][$i] = $row['COLUMN_DEFAULT'];

				// printf("\n".'<td>%s</td>', $row['NUMERIC_PRECISION']);

				$data['NUMERIC_PRECISION'][$i] = $row['NUMERIC_PRECISION']; // utilized in any way???

				printf("\n".'<td>%s</td>', $row['COLUMN_KEY']);

				$data['COLUMN_KEY'][$i] = $row['COLUMN_KEY'];

				// Possible bug: if both PRI and UNI attributes appear for the same column, 
				// UNI did not appear to be not picked up during testing (re-test to be certain).

				if($row['COLUMN_KEY'] == 'PRI'){

					$data['PRI_KEY_FD_ARY'][$i] = $row['COLUMN_NAME'];

				}elseif($row['COLUMN_KEY'] == 'UNI'){

					$data['UNIQUE_KEY_FD_ARY'][$i] = $row['COLUMN_NAME'];

				}elseif($row['COLUMN_KEY'] == 'MUL'){

					$data['MULTI_KEY_FD_ARY'][$i] = $row['COLUMN_NAME'];

				}elseif(!empty($row['COLUMN_KEY'])){

					$data['_KEY_ERRORS'][$i] = $row['COLUMN_NAME'];

				}

				printf("\n".'<td>%s</td>', htmlentities($row['EXTRA']));

				$data['EXTRA'][$i] = empty($row['EXTRA']) ? array() : explode(' ', $row['EXTRA']);

				$pos = stripos($row['EXTRA'], 'auto_increment');

				if($pos === false){

					// auto_increment was not found in $row['EXTRA']

				}else{

					$data['AUTO_INCREMENT'][$i] = $row['ORDINAL_POSITION'] - 1;

				}

				printf("\n".'<td>%s</td>', $row['IS_NULLABLE']);

				if($row['IS_NULLABLE'] != 'NO'){

					$data['IS_NULLABLE_FD_ARY'][$i] = $row['COLUMN_NAME']; // Collect the names of NULL columns .

				}

				$data['ISNULL_BOOLEAN'][$i] = $row['IS_NULLABLE'] == 'NO' ? 0 : 1; // ISNULL

				printf("\n".'<td>%s</td>', $row['CHARACTER_SET_NAME']);

				printf("\n".'<td>%s</td>', $row['COLLATION_NAME']);

				printf("\n".'<td>%s</td>', htmlentities($row['COLUMN_COMMENT']));

				$data['COLUMN_COMMENT'][$i] = addslashes($row['COLUMN_COMMENT']);

				echo "\n".'</tr>';

				if(!in_array($row['COLUMN_TYPE'], $data['FOUND_COLUMN_TYPE'])){

					$data['FOUND_COLUMN_TYPE'][] = $row['COLUMN_TYPE'];

				}

				if(!in_array($row['DATA_TYPE'], $data['FOUND_DATA_TYPE'])){

					$data['FOUND_DATA_TYPE'][] = $row['DATA_TYPE'];

				}

				$i++;

			}

			mysqli_free_result($res);

			unset($row);

			echo "\n".'</table><br>';

			echo "\n".'<div class="container">';

			echo "\n".'	<div class="row">';
			echo "\n".'		<div class="col-sm-12">';


			// echo "\n".'<p class="text-muted">`'.$cfg['server'][$sn]['db'].'` . `'.$tb.'`</p>';

			if(!empty($data['_KEY_ERRORS'])){

				$print_r_text = preg_replace('/\n/s', PHP_EOL, print_r($data, true));

				echo !stristr($print_r_text, ']') ? '' : "\n".'<p class="text-danger">$data</p><pre class="text-danger">'.htmlspecialchars($print_r_text).'</pre>';

			}

			$data['NUM_COLS'] = count($data['COLUMN_NAME']);

			if(($tweak['toggle'] > 0) && ($data['NUM_COLS'] <= $pme['list_mode_num_cols'])){

				echo "\n".'<div class="alert alert-warning" role="alert">Omitting the requested toggle links because only '.$data['NUM_COLS'].' columns were found.</div>';

			}

			if(empty($data['AUTO_INCREMENT'])){

				echo "\n".'<div class="alert alert-warning" role="alert">No auto_increment column found. Check that column 0 is unique.</div>';

			}

			if(!empty($data['RESERVED_WORDS'])){

				echo my_list('Column names which are reserved keywords', $data['RESERVED_WORDS']);

				unset($reserved_words);

			}

			if(empty($pme['file']['write'])){

				echo my_list('Data types', $data['FOUND_DATA_TYPE']);

				echo my_list('Column types', $data['FOUND_COLUMN_TYPE']);

				echo my_list('PRI', $data['PRI_KEY_FD_ARY']);

				echo my_list('MUL', $data['MULTI_KEY_FD_ARY']);

				echo my_list('UNI', $data['UNIQUE_KEY_FD_ARY']);

				echo my_list('Key Errors', $data['_KEY_ERRORS']);

				echo my_list('NULL', $data['IS_NULLABLE_FD_ARY']);

			}

		}

	}else{

		abort('Failed: '.$qry);

	}

	if(empty($data)){

		abort('$data array is empty');

	}


	// Buffer the code used for the phpMyEdit script. ////////////////////////////////////////////////////////////

	$output_buffer = '';

	echo "\n".'<p class="text-muted">A Windows compatible line break is written to the scripts as \r\n</p>';

	// echo '<p>Buffering the code in '.basename(__FILE__).' at line '.__LINE__'</p>';

	echo_buffer('<?php');

	echo_buffer('');

	echo_buffer('// Bookmark: '.basename(__FILE__).' at line '.__LINE__);

	echo_buffer('');

	// Comment section atop the generated script.

	echo_buffer('/*');

	echo_buffer(' * Database: '.$cfg['server'][$sn]['db']);

	if($view){

		echo_buffer(' * View: '.$tb);

		// Disable Javascript for VIEW's as it appears unnecessary

		$pme['js']['usage'] = -1;

		// Disable help|ACP for VIEW's as it appears unnecessary

		$pme['help_method'] = 0;

	}else{

		echo_buffer(' * Table: '.$tb);

	}

	echo_buffer(' * Column count: '.$data['NUM_COLS']);

	echo_buffer(' * Filename: '.$pme['file']['format']);

	echo_buffer(' * Created '.date('r'));

	if(!empty($data['PRI_KEY_FD_ARY'])){

		echo_buffer(' * Primary key: '.implode(', ', $data['PRI_KEY_FD_ARY']));

		if(count($data['PRI_KEY_FD_ARY']) > 1){

			echo_buffer(' * phpMyEdit does NOT work with multiple primary keys');

		}

	}

	if(!empty($data['UNIQUE_KEY_FD_ARY'])){

		echo_buffer(' * Unique key: '.implode(', ', $data['UNIQUE_KEY_FD_ARY']).' (unique_key may require input validation triggers)');

	}

	if(!empty($data['IS_NULLABLE_FD_ARY'])){

		echo_buffer(' * Null columns: '.implode(', ', $data['IS_NULLABLE_FD_ARY']));

	}

	if(!empty($data['MULTI_KEY_FD_ARY'])){

		echo_buffer(' * Key columns: '.implode(', ', $data['MULTI_KEY_FD_ARY']));

	}

	if(count($data['RESERVED_WORDS']) > 0){

		echo_buffer(' * Reserved word usage: '.implode(', ', $data['RESERVED_WORDS']));

	}

	// If help|ACP uses the MySQL Comment, suppress it's display in header comments.

	if($pme['help_method'] <> 5){

		for($i = 0; $i < $data['NUM_COLS']; $i++){

			if(!empty($data['COLUMN_COMMENT'][$i])){

				echo_buffer(' * MySQL comment for '.$data['COLUMN_NAME'][$i].': '.$data['COLUMN_COMMENT'][$i]);

			}

		}

	}

	if(!empty($data['COLUMN_NAME'])){

		echo_buffer(' * All columns: '.wordwrap(implode(', ', $data['COLUMN_NAME']), 80, PHP_EOL));

	}

	echo_buffer('*/'); 

	// End of Comment section atop the generated script.

	echo_buffer('');

	// Desisions, decisions, decisions.

	// tinyMCE might be useful, or it might blow up given tons of JavaScript being used in this project.
	// echo_buffer('// Bookmark: tinyMCE options set in '.basename(__FILE__).' at line '.__LINE__);
	// echo_buffer('// tinyMCE include file. For example, set: inc/tinymce.php and it will be included by header.php');
	// echo_buffer('$tinymce_include_file = \'\'; // normally empty/unused');
	// echo_buffer('');
	// echo_buffer('// Note: PME_data_ must be appended to the actual field names in the tinyMCE element list');
	// echo_buffer('');

	// Flexible 724-pixel to 1170-pixel wide responsive layout (depends on display size).
	// Best for most phpMyEdit scripts.
	// $omit_div_container = 0;

	// Full screen, or 100%-wide fluid responsive layout.
	// Best for phpMyEdit scripts having a LOT of columns.
	// $omit_div_container = 1;

	echo_buffer('// Bookmark: header.php Bootstrap layout options '.basename(__FILE__).' at line '.__LINE__);

	echo_buffer('');

	// over-ridden around line 383 of pme.config.php for modes AVCPD
	echo_buffer('$omit_div_container = 0; // Default is 0. Set 1 for a 100%-wide layout in List mode (1 = omit DIV CONTAINER)'); 

	echo_buffer('');

	echo_buffer('// Bookmark: '.basename(__FILE__).' at line '.__LINE__);

	for($i = 0; $i < $data['NUM_COLS']; $i++){

		if($data['COLUMN_NAME'][$i] == 'deleted'){

			$deleted_col_num = $i;

		}

	}

	// common options are often in an include file

	echo_buffer('');

	echo_buffer('$opts[\'tb\'] = \''.$tb.'\';');

	echo_buffer('');

	echo_buffer('$sn = '.$sn.'; // server number');

	echo_buffer('');

	if($tb == $cfg['server'][$sn]['log']){

		echo_buffer('// $opts[\'logtable\'] is suppressed (not to be used with itself)');

		echo_buffer('');

	}

	echo_buffer('require_once(\'inc/pme.config.php\'); // options, db handle, and header'); // includes db handle

	echo_buffer('');

	echo_buffer('require_once(\'inc/header.php\'); // header'); // includes db handle

	echo_buffer('');

	// Good location to echo a page title, optionally applying Bootstrap style class text-info

	echo_buffer('//echo \'<h2 class="text-info">\'.$opts[\'db\'].\'.\'.$opts[\'tb\'].\'</h2>\'."\n";');

	echo_buffer('');

	echo_buffer('echo \'<div class="alert alert-info" role="alert"> <p>By default, the sort_field is set to descending order of Column 0. Since Column 0 is commonly an autoincrement field, recently added records will be displayed first in List mode. If not desirable, users can easily change this in the generated scripts.</p> </div>\'."\n";');

	// Good location to implement an authorization system. If authentication fails, notify the user then include the footer and exit the script.

	echo_buffer('');

	// Sorting: minus sign (-) facilitates DESC order using the first column (column 0) so the last added record appears first in List mode

	echo_buffer('$opts[\'sort_field\'] = array(\'-'.$data['COLUMN_NAME'][0].'\');');

	echo_buffer('');

	if(!$data['COLUMN_KEY'][0] == 'PRI'){

		echo_buffer('### Possible invalid primary key found at column 0. Please manually configure $opts["key"] and $opts["key_type"]');

		echo_buffer('echo \'Suspicious primary key found.\';');

		echo_buffer('echo \'<br>Disable this warning at line \'.__LINE__.\' in \'.basename(__FILE__);');

		echo_buffer('echo \'<br>and verify the values assigned to $opts["key"] and $opts["key_type"]\';');

		echo_buffer('');

		echo_buffer('$opts[\'key\'] = \''.$data['COLUMN_NAME'][0].'\';');

		echo_buffer('');

		echo_buffer('$opts[\'key_type\'] = \''.$data['DATA_TYPE'][0].'\';');

	}elseif($data['COLUMN_KEY'][0] == 'PRI'){

		echo_buffer('$opts[\'key\'] = \''.$data['COLUMN_NAME'][0].'\'; // primary key');

		echo_buffer('');

		echo_buffer('$opts[\'key_type\'] = \''.$data['DATA_TYPE'][0].'\';');

	}elseif($data['COLUMN_KEY'][0] == 'UNI' ){

		echo_buffer('$opts[\'key\'] = \''.$data['COLUMN_NAME'][0].'\'; // unique key');

		echo_buffer('');

		echo_buffer('$opts[\'key_type\'] = \''.$data['DATA_TYPE'][0].'\';');
	}

	echo_buffer('');

	if($view){

		echo_buffer('// A VIEW is a stored SELECT query, not a MyISAM table.');

		echo_buffer('// Un-editable. Need to do more research on how this might be made editable.');

		//echo_buffer('$opts[\'options\'] = \'VFL\'; // ACPVDFL'); //ORIG LINE
		echo_buffer('$opts[\'options\'] = \'ACPVDFL\'; // ACPVDFL');

		echo_buffer('echo "\n".\'<p>Data appearing below is compiled from a MySQL VIEW (a view is essentially a stored query; options restricted to VFL)</p>\';');

	}else{

		if($tb == 'change_log'){

			echo_buffer('$opts[\'options\'] = \'VFL\';');

		}else{

			echo_buffer('$opts[\'options\'] = \'ACPVDFL\';');

		}

	}

	echo_buffer('');

	//echo_buffer('// Bookmark: '.basename(__FILE__).' at line '.__LINE__);
	//echo_buffer('// Trigger example. Use the config file for commonly executed triggers.');
	//echo_buffer('// $opts[\'triggers\'][\'insert\'][\'after\'] = \'inc/triggers/view_rec_after_add.php\';'); // seldom used
	//echo_buffer('');

	echo_buffer('// Bookmark: '.basename(__FILE__).' at line '.__LINE__);

	// Turn off the toggle for tables having few columns

	if(($tweak['toggle'] > 0) && ($data['NUM_COLS'] <= $pme['list_mode_num_cols'])){

		$tweak['toggle'] = 0;

		echo_buffer('');

		echo_buffer('# TOGGLE PREFERENCE DISABLED. LIMITED COLUMNS FOUND. ALTERING FILE NAME.');

		echo_buffer('# SETTING $pme[\'tweak\'][\'toggle\'] = 0;');

		$pme['file']['format'] = $pme['file']['prefix'].$cfg['server'][$sn]['db'].'.'.$tb.'.'.$tweak['toggle'].'.php';

		echo_buffer('# RENAMING OUT PUT FILE: '.$pme['file']['format']);

		echo_buffer('');

	}

	if($tweak['toggle'] && $data['NUM_COLS'] > $pme['list_mode_num_cols']){

		echo_buffer('');

		echo_buffer('// Initialize toggle variables based on column number');

		$buffer_persist = '$opts[\'cgi\'][\'persist\'] = array(';

		$buffer_persist .= '\'sn\' => $sn, ';

		for($k = 0; $k < $data['NUM_COLS']; $k++) {

			if($k >= $pme['list_mode_num_cols']){

				echo_buffer("\$z$k = get_cgi_var('z$k');");

				$buffer_persist .= '\'z'.$k.'\' => $z'.$k.', ';

			}

		}

		$buffer_persist = substr($buffer_persist, 0, -2);

		$buffer_persist .= ');';

		echo_buffer('');

		echo_buffer('// $sn and toggle variables must be persistent.');

		$buffer_persist = trim($buffer_persist);

		echo_buffer($buffer_persist);

		echo_buffer('');

		echo_buffer('// Buffer the togglg links in order to facilitate flexible display');

		echo_buffer('$my_link_buffer = \'\';');

		echo_buffer('');

		// $list_mode_status is set in pme.config.php

		echo_buffer('if($list_mode_status == 1){');

		echo_buffer('   $bqs = \'\'; // buffered query string (phpMyEdit system variables)');

		### multi-line statement follows ###

		echo_buffer('   $ignore_keys = array(
	      \'PME_sys_canceladd\',
	      \'PME_sys_cancelcopy\',
	      \'PME_sys_canceldelete\',
	      \'PME_sys_cancelview\',
	      \'PME_sys_cur_tab\',
	      \'PME_sys_moreadd\',
	      \'PME_sys_qfn\',
	      \'PME_sys_savechange\'
	   );');

		### multi-line statement follows ###

		echo_buffer('   foreach($_REQUEST as $key => $val){
	      if(substr($key, 0, 8) == \'PME_sys_\' && !in_array($key, $ignore_keys)){
	         if(is_array($val)){
	            foreach($val as $k => $v){
	               $bqs .= \'&\'.$k.\'=\'.$v;
	            }
	         }else{
	            $bqs .= \'&\'.$key.\'=\'.$val;
	         }
	      }
	   }
		');


		$tpl = '';

		$buffer_for_sprintf = '';

		echo_buffer('   // calculate opposite values beginning with MySQL column #'.$pme['list_mode_num_cols'].' ($pme[\'list_mode_num_cols\'])');

		for($k = 0; $k < $data['NUM_COLS']; $k++) {

			if($k < $pme['list_mode_num_cols']){ continue; }

			echo_buffer("   \$tmp$k = '&z$k='.(empty(\$z$k) ? 1 : 0);");

			$tpl .= '&z'.$k.'=%s';

			$buffer_for_sprintf .= '$z'.$k.', ';

		}

		$buffer_for_sprintf = substr($buffer_for_sprintf, 0, -2);

		// the above creates, for example, something like
		// $tpl = '&z0=%s&z1=%s&z2=%s&z3=%s&z4=%s&z5=%s&z6=%s&z7=%s&z8=%s&z9=%s';

		echo_buffer('');

		echo_buffer('   // template used to apply the above values');

		echo_buffer('   $tpl = \''.$tpl.'\';');

		echo_buffer('');

		echo_buffer('   // Note the progressive shift from one column to the next');

		$i = 0;

		// example $buffer_for_sprintf:  $z0, $z1, $z2, $z3, $z4, $z5, $z6, $z7, $z8, $z9 (no comma on the end)

		foreach($data['COLUMN_NAME_LABEL'] as $key => $val){

			if($i < $pme['list_mode_num_cols']){

				$i++;

				continue;

			}else{

				if($i == ($data['NUM_COLS'] - 1) ){

					$new_buffer = str_ireplace('$z'.$i, '$tmp'.$i, $buffer_for_sprintf);

				}else{

					$new_buffer = str_ireplace('$z'.$i.',', '$tmp'.$i.',', $buffer_for_sprintf);

				}

				echo_buffer('   $my_link_buffer .= htmlLink(sprintf($tpl, '.$new_buffer.'), \''.$data['COLUMN_NAME_LABEL'][$i].'\', $z'.$i.');');

				$i++;

			}

		}

		echo_buffer('}');

		echo_buffer('');

	}elseif(empty($tweak['toggle'])){

		echo_buffer('// Example of persistent variables');

		echo_buffer('// $opts[\'cgi\'][\'persist\'] = array(\'sn\' => $sn);');

	}

	echo_buffer('');

	if(in_array('deleted', $data['COLUMN_NAME'])){

		if($tweak['toggle']){

			echo_buffer('if(empty($z'.$deleted_col_num.')){ $opts[\'filters\'] = \'PMEtable0.deleted = "0"\'; }');

		}else{

			echo_buffer('$opts[\'filters\'] = \'PMEtable0.deleted = "0"\'; // AND PMEtable0.hidden = "0";');

		}

		echo_buffer('');

		echo_buffer('$opts[\'triggers\'][\'delete\'][\'before\'] = \'inc/triggers/mark_as_deleted.TDB.php\';');

	}

	echo_buffer('');

	if(!empty($data['RESERVED_WORDS'])){

		echo_buffer('### reserved words found in column name(s):');

		echo_buffer('### '.implode(', ', $data['RESERVED_WORDS']));

		echo_buffer('');

	}

	// container necessary only if $tweak['toggle'] && $data['NUM_COLS'] > $pme['list_mode_num_cols']

	if($tweak['toggle'] && $data['NUM_COLS'] > $pme['list_mode_num_cols']){

		// well sidebar-nav for toggle links

		// Container for phpMyEdit form and $my_link_buffer

		echo_buffer('echo "\n".\'<div class="row">\';');

		echo_buffer('');
		echo_buffer('// possibly 2 DIV col entries ahead, usually col-lg-2 and col-lg-10');

		echo_buffer('// if($list_mode_status && !empty($my_link_buffer)){');

		// With toggle links, class="col-sm-2" and class="col-sm-10" generally works OK (grid is 12 units).
		// Yet class="col-sm-1" and class="col-sm-11" work better if all column names are short.
		// Yet class="col-sm-3" and class="col-sm-9" works better if all column names are long.

		echo_buffer('//    echo "\n".\'<div class="col-sm-2">\'."\n";');

		echo_buffer('//    echo "\n".\'<div class="card sidebar-nav">\'."\n";'); // card sidebar-nav applies background color

		echo_buffer('//    echo "\n".\'<ul class="nav nav-pills nav-stacked">\'."\n";');

		echo_buffer('//    echo $my_link_buffer;');

		echo_buffer('//    echo "\n".\'</ul>\'."\n";');

		echo_buffer('//    echo "\n".\'</div><!-- /card -->\';');

		// echo_buffer('//    echo "\n".\'<p><a href="#" title="Set $omit_div_container = 1; for 100% width layout.">Tip</a></p>\';');

		echo_buffer('//    echo "\n".\'</div><!-- /col-lg-2 -->\';');

		echo_buffer('// }');

		echo_buffer('');

		echo_buffer('// Consider un-commenting the above loop and below changing col-lg-12 to col-lg-10');

		echo_buffer('echo "\n".\'<div class="col-sm-12">\'."\n"; // col-lg- for phpMyEdit form');

	}

	echo_buffer('');

	//echo_buffer('// echo empty($header_operation_label) ? \'\' : "\n".\'<span class="label label-info">\'.$header_operation_label.\'</span>\'."\n";');

	//echo_buffer('');

	echo_buffer('// Begin phpMyEdit column array compilation in '.basename(__FILE__).' at line '.__LINE__);

	$i = 0;

	for($i = 0; $i < $data['NUM_COLS']; $i++){

		echo_buffer('');

		$auto_increment = in_array('auto_increment', $data['EXTRA'][$i]) || in_array($data['COLUMN_NAME'][$i], $data['UNIQUE_KEY_FD_ARY']) ? 1 : 0;

		if(empty($i) && empty($auto_increment)){

			echo_buffer('// No auto_increment column found???');

			echo_buffer('');

		}

		// Comment prior to individual $opts['fdd'] arrays

		if($data['DATA_TYPE'][$i] == $data['COLUMN_TYPE'][$i]){

			echo_buffer('// column '.$i.': `'.$data['COLUMN_NAME'][$i].'` '.$data['DATA_TYPE'][$i]);

		}else{

			echo_buffer('// column '.$i.': `'.$data['COLUMN_NAME'][$i].'` '.$data['COLUMN_TYPE'][$i]);

		}

		if(!empty($data['EXTRA'][$i])){

			echo_buffer('// flags: '.implode(', ', $data['EXTRA'][$i]));

		}

		if(!empty($data['collation'][$i])){

			echo_buffer('// collation: '.$data['collation'][$i]);

		}

		if($pme['help_method'] <> 5 && !empty($data['COLUMN_COMMENT'][$i])){

			echo_buffer('// comment: '.$data['COLUMN_COMMENT'][$i]);

		}

		if(in_array('unique_key', $data['EXTRA'][$i])){

			echo_buffer('// As a unique_key field, consider creating a validation trigger');

		}

		// End comments prior to each $opts['fdd'] array

		// Begin the column's $opts['fdd'] array

		echo_buffer('');

		echo_buffer('$opts[\'fdd\'][\''.$data['COLUMN_NAME'][$i].'\'] = array(');

		# CSS/HTML attributes potentially apply style individually to TD tags in a vertical column |FL

		if($i == 4){

			//echo_buffer("// for demonstration purposes, colattrs|FL is applied to column 4");
			//echo_buffer("  'colattrs|FL'   => 'style=\"background-color:#ffcc99; border-bottom:1px solid #cccccc;\"',");

		}

		# right-justify certain column types using CSS

		if($tweak['align_right'] == 1){

			switch($data['DATA_TYPE'][$i])
			{
				case 'bigint':
				case 'bit':
				case 'boolean':
				case 'date':
				case 'datetime':
				case 'decimal':
				case 'double':
				case 'enum':
				case 'float':
				case 'int':
				case 'mediumint':
				case 'real':
				case 'serial':
				case 'set':
				case 'smallint':
				case 'time':
				case 'timestamp':
				case 'tinyint':
				case 'year':
					echo_buffer("  'css'        => array('postfix' => 'right-justify'),");
					break;

				default:
					break;
			};

		}

		# datemask_usage is normally off. It can conflict with the usage of 'sql|VFL' and CONCAT

		if($pme['datemask_usage']){

			if(($data['DATA_TYPE'][$i] == 'timestamp' && $data['CHARACTER_MAXIMUM_LENGTH'][$i] == 14) || $data['DATA_TYPE'][$i] == 'datetime'){

				$datemask = 'Y-m-d H:i:s';

			}else{

				$datemask = '';

			}

			$datemask != '' ? echo_buffer("  'datemask|VFL'   => '$datemask',") : '';

		}
 
		# $opts['fdd']['col_name']['default'] = $data['COLUMN_DEFAULT'][$i]
		# value when adding new records (sometimes it doesn't make sense to apply MySQL's default)

		switch($data['COLUMN_DEFAULT'][$i])
		{
			Case '00:00:00':
			Case '0000-00-00':
			Case '0000-00-00 00:00:00':
			Case 'CURRENT_TIMESTAMP':
				$data['COLUMN_DEFAULT'][$i] = '';
				break;

			default:
				break;
		}

		if($auto_increment) {

			echo_buffer("  'default'    => '',");

		}elseif($data['COLUMN_DEFAULT'][$i] == '1' || $data['COLUMN_DEFAULT'][$i] == '0' || is_int($data['COLUMN_DEFAULT'][$i])){

			echo_buffer("  'default'    => {$data['COLUMN_DEFAULT'][$i]},");

		}elseif($data['DATA_TYPE'][$i] == 'datetime'){

			echo_buffer("  'default'    => date('Y-m-d H:i:s'),");

		}elseif($data['ISNULL_BOOLEAN'][$i] == 1) {

			echo_buffer("  'default'    => '',"); // NULL

		}elseif($data['COLUMN_DEFAULT'][$i] != '' && !empty($data['ISNULL_BOOLEAN'][$i])) {

			echo_buffer("  'default'    => '".$data['COLUMN_DEFAULT'][$i]."',");

		}elseif($data['COLUMN_DEFAULT'][$i] != ''){

			echo_buffer("  'default'    => '{$data['COLUMN_DEFAULT'][$i]}',");

		}else{

			echo_buffer("  'default'    => '',");

		}

		if($data['DATA_TYPE'][$i] == 'text'){

			# $opts['fdd']['col_name']['escape'] --- generally set true only if the column contains HTML markup, the default is false

			echo_buffer("  'escape|VFL' => false, // set true if the column contains HTML markup");

		}

		# $opts['fdd']['col_name']['help|ACP']

		# see configuration options for $pme['label']['select'], $pme['label']['limit']

		// phpMyEdit does not apply htmlspecialchars to 'help'

		// Check column 0 (auto_increment vs. unique)

		if(empty($i) && empty($auto_increment)){

			if(in_array($data['COLUMN_NAME'][$i], $data['UNIQUE_KEY_FD_ARY'])){

				// column 0 is unique

			}else{

				// potential problem for phpMyEdit

				echo_buffer("  'help|ACP'   => 'Not an auto_increment key column',");

			}

		}elseif($pme['help_method'] == 1){

			switch($data['DATA_TYPE'][$i])
			{
				Case 'enum':
				Case 'set':
					echo_buffer("  'help|ACP'   => '".$pme['label']['select']."',");
					break;

				case 'blob':
				case 'longblob':
				case 'longtext':
				case 'mediumblob':
				case 'mediumtext':
				case 'text':
				case 'tinyblob':
				case 'tinytext':

					echo_buffer("  'help|ACP'   => '".$pme['label']['limit']." ".number_format($data['CHARACTER_MAXIMUM_LENGTH'][$i])." ".$pme['label']['characters']."',");

					break;

				Case 'date':

						echo_buffer("  'help|ACP'   => '".$pme['label']['date']."',");

					break;

				Case 'datetime':

					echo_buffer("  'help|ACP'   => '".$pme['label']['datetime']."',");

					break;

				Case 'time':

					echo_buffer("  'help|ACP'   => '".$pme['label']['time']."',");

					break;

				Case 'timestamp':

					echo_buffer("  'help|ACP'   => '".$pme['label']['timestamp']."',");

					break;

				Case 'year':

					$pme['label']['year'] = $data['DATA_TYPE'][$i] == 'year' && $data['CHARACTER_MAXIMUM_LENGTH'][$i] == 2 ? substr($pme['label']['year'],0,2) : $pme['label']['year'];

					echo_buffer("  'help|ACP'   => '".$pme['label']['year']."',");

					break;

				case 'bigint':
				case 'bit':
				case 'boolean':
				case 'decimal':
				case 'double':
				case 'float':
				case 'int':
				case 'mediumint':
				case 'real':
				case 'serial':
				case 'smallint':
				case 'tinyint':
					echo_buffer("  'help|ACP'   => '".$pme['label']['limit']." ".$data['CHARACTER_MAXIMUM_LENGTH'][$i]." ".$pme['label']['digits']."',");
					break;

				default:

					echo_buffer("  'help|ACP'   => '".$pme['label']['limit']." ".$data['CHARACTER_MAXIMUM_LENGTH'][$i]." ".$pme['label']['characters']."',");

					break;

			};

		}elseif($pme['help_method'] == 2){

			echo_buffer("  'help|ACP'   => sprintf(\$help_link, '".$tb."', '".$data['COLUMN_NAME'][$i]."', '".$tb."', '".$data['COLUMN_NAME'][$i]."'),");

		// }elseif($pme['help_method'] == 3){

			// relocated, see below, as a post initialized example, near line 1755

		}elseif($pme['help_method'] == 4){

			// Use the Help cell to display Entry Required, based on $pme['js']['usage']

				switch($pme['js']['usage'])
				{
					Case 0:

						// apply to columns 1-3

						if($i > 0 && $i < 4){

							echo_buffer("  'help|ACP'   => '".htmlspecialchars($pme['label']['required'])."',");

						}

						break;

					Case 1:

						if(!empty($i) && $data['ISNULL_BOOLEAN'][$i] != 1){

							// Skip column 0 and non NULL columns

							echo_buffer("  'help|ACP'   => '".htmlspecialchars($pme['label']['required'])."',");

						}

						break;

					Case -1:

					default:

						// omit

						break;
				}

		}elseif($pme['help_method'] == 5){

			if($data['COLUMN_COMMENT'][$i] == ''){

				echo_buffer("  'help|ACP'   => '".$pme['label']['limit']." ".number_format($data['CHARACTER_MAXIMUM_LENGTH'][$i])." ".$pme['label']['characters']."',");

			}else{

				echo_buffer("  'help|ACP'   => '".htmlentities($data['COLUMN_COMMENT'][$i], ENT_QUOTES, 'UTF-8')."',");

			}

		}

		# $opts['fdd']['col_name']['input']

		# [R]eadonly, pass[W]ord, [H]idden

		if($auto_increment){

			echo_buffer("  'input'      => 'R',");

		}elseif($data['DATA_TYPE'][$i] == 'timestamp') {

			echo_buffer("  'input'      => 'R',");

		}else{

			echo_buffer("  'input'      => '',");

		}

		// Needs refinement, to deal with odd column types which have no default length specified.

		if($data['CHARACTER_MAXIMUM_LENGTH'][$i] > 0){

			// Omit maxlen if length is -1
			# $opts['fdd']['col_name']['maxlen']
			# $opts['fdd']['col_name']['number_format']

			if($auto_increment){

			   // Omitted: 'maxlen' from configuration of auto_increment columns; normally column 0.

			}elseif($data['DATA_TYPE'][$i] == 'int' && $i > 0){

				if($data['CHARACTER_MAXIMUM_LENGTH'][$i]){

					echo_buffer("  'maxlen|ACP' => ".$data['CHARACTER_MAXIMUM_LENGTH'][$i].',');

				}

				if($data['CHARACTER_MAXIMUM_LENGTH'][$i] > 3 && substr($data['COLUMN_NAME'][$i], -3) != '_id'){

					echo_buffer("//  'number_format|VDFL' => array(0, '.', ','),");

				}

			}elseif($data['DATA_TYPE'][$i] == 'real' || $data['DATA_TYPE'][$i] == 'float' || $data['DATA_TYPE'][$i] == 'double'){

				// Determine decimal points required for number_format.

				// Split (e.g.) FLOAT(7,2) into $part[0] (7), $part[1] (2)

				if(stristr($data['COLUMN_TYPE'][$i], ',')){

					$out = preg_replace("/[^0-9,]/", '', $data['COLUMN_TYPE'][$i]);

					$part = @explode(',', $out);

					// Workaround for real numbers lacking (M,D) parameters

					if($data['CHARACTER_MAXIMUM_LENGTH'][$i]){

						echo_buffer("  'maxlen|ACP' => ".(empty($part[0]) && empty($part[0]) ? $data['CHARACTER_MAXIMUM_LENGTH'][$i] : (@$part[0] + @$part[1] + 1)).',');

					}

					if(count($part) < 2){

						// $part[1] = $data['CHARACTER_MAXIMUM_LENGTH'][$i];

						$part[1] = 5; // Arbitrary setting

					}

					echo_buffer("  'number_format|VDFL' => array(".$part[1].", '.', ','),");

				}else{

					// In the event that (M,D) is not defined as (e.g.)

					// float(M,D) but simply float, set arbitrary values.

					if($data['CHARACTER_MAXIMUM_LENGTH'][$i]){

						echo_buffer("  'maxlen|ACP' => {$data['CHARACTER_MAXIMUM_LENGTH'][$i]},");

					}

					echo_buffer("  'number_format|VDFL' => array(3, '.', ','),");

				}

			}else{

				echo_buffer("  'maxlen|ACP' => ".$data['CHARACTER_MAXIMUM_LENGTH'][$i].',');

			}

		}else{

			echo_buffer('  // negative length encountered: '.$data['CHARACTER_MAXIMUM_LENGTH'][$i]);

		}

		# $opts['fdd']['col_name']['mask']
		# an infrequently used parameter (omitted)

		# $opts['fdd']['col_name']['name']

		# Column title. Above, underscore is replaced with space and ucwords() applied to $data['COLUMN_NAME'][$i] (field name)

		if($data['DATA_TYPE'][$i] != 'date'){

			echo_buffer("  'name'       => '".str_replace('\'', '\\\'', $data['COLUMN_NAME_LABEL'][$i])."',");

		}else{

			echo_buffer("  'name'       => '".str_replace('\'', '\\\'', $data['COLUMN_NAME_LABEL'][$i])."',");

		}

		# $opts['fdd']['col_name']['nowrap']

		# nowrap is seldom required, inducing <TD NOWRAP>

		// echo_buffer("//  'nowrap'     => true,");

		# $opts['fdd']['col_name']['options'] = 'ACPVDFLI';

		# L for List is assumed and does not have to be specified.

		# Add/Change/coPy/View/Delete/Filter/List/Initial = ACPVDFLI (F/Filter relates to Search button) + I = initial sort suppressed

		if($auto_increment){

			// input has most likely been set above to 'R' 

			echo_buffer("  'options'    => 'VDFL', // to remove from display in List mode, or set VD");

		}elseif($data['DATA_TYPE'][$i] == 'timestamp'){

			if($tweak['toggle'] && $i >= $pme['list_mode_num_cols']){

				echo_buffer("  'options'    => \$z$i ? 'ACPVDFL' : 'VD',") ;

			}else{

				echo_buffer("  'options'    => 'VDFL',");

			}

		}elseif($data['COLUMN_NAME'][$i] == 'deleted'){

			if($tweak['toggle'] && $i >= $pme['list_mode_num_cols']){

				echo_buffer("  'options'    => \$z$i ? 'ACPVDFL' : '',") ;

			}else{

				echo_buffer("  'options'    => 'ACP',"); // Author preference for column named `deleted`

			}

		}else{

			// $i <= $pme['list_mode_num_cols'] ? echo_buffer("  'options'    => 'ACPVDFL',") : echo_buffer("  'options'    => 'ACPVD',") ;

			if($tweak['toggle']){

				if($i >= $pme['list_mode_num_cols']){

					echo_buffer("  'options'    => \$z$i ? 'ACPVDFL' : 'ACPVD',") ;

				}elseif($i < $pme['list_mode_num_cols']){

					echo_buffer("  'options'    => 'ACPVDFL',") ;

				}

			}else{

				$i < $pme['list_mode_num_cols'] ? echo_buffer("  'options'    => 'ACPVDFL',") : echo_buffer("  'options'    => 'ACPVD',") ;

			}

		}

		# $opts['fdd']['col_name']['select']

		# HTML Filter / Search box - [T]ext = INPUT while [M|N|D] = SELECT box drop down

		switch($data['DATA_TYPE'][$i]){

			Case 'date':
			Case 'datetime':
			Case 'time':
			Case 'timestamp':
				echo_buffer("  'select'     => 'N',");
				break;

			Case 'set':
				echo_buffer("  'select'     => 'M',");
				break;

			Case 'enum':
				echo_buffer("  'select'     => 'D',");
				break;

			default:
				echo_buffer("  'select'     => 'T',");
				break;

		};

		# HTML INPUT size for CHAR/VARCHAR is capped at 60 in the class file
		# size may be -1 in the case of geometry columns

		if($data['CHARACTER_MAXIMUM_LENGTH'][$i] > 0){

			if($data['HTML_TAG'][$i] == 'input'){

				// $tmp = $data['CHARACTER_MAXIMUM_LENGTH'][$i] > 60 ? 60 : $data['CHARACTER_MAXIMUM_LENGTH'][$i]; // Oops???

				// $tmp = $data['CHARACTER_MAXIMUM_LENGTH'][$i] > 60 ? ($data['CHARACTER_MAXIMUM_LENGTH'][$i] > $pme['textarea']['cols'] ? $pme['textarea']['cols'] : $data['CHARACTER_MAXIMUM_LENGTH'][$i]) : $data['CHARACTER_MAXIMUM_LENGTH'][$i];

				// after introducing Twitter Bootstrap this may be better since CSS is fighting with the size parameter.

				$tmp = $data['CHARACTER_MAXIMUM_LENGTH'][$i] > $pme['textarea']['cols'] ? ($pme['textarea']['cols'] - 18) : $data['CHARACTER_MAXIMUM_LENGTH'][$i];

				echo_buffer("  'size'       => ".$tmp.',');

			}

		}


		# $opts['fdd']['col_name']['sqlw'] - alternate possibilities: // 'IF($val_qas = "", NULL, $val_qas)'

		# $opts['fdd']['col_name']['sqlw'] - alternate possibilities: // 'IF($val = "", NULL, $val)' // 'IF(col_name = $val, $val, MD5($val))'

		if($i > 0){

			$data['ISNULL_BOOLEAN'][$i] == 1 ? echo_buffer("  'sqlw'       => 'IF(\$val_qas = \"\", NULL, \$val_qas)',") : echo_buffer("  'sqlw'       => 'TRIM(\"\$val_as\")',");

		}

		// miscellaneous sql plugins, based on column type

		switch($data['DATA_TYPE'][$i])

		{

			Case 'date':

				echo_buffer("//  'sql|VFL'     => 'if($fd > \"\", CONCAT(DATE_FORMAT($fd, \"%a %b %e %Y\")), \"\")',");

				break;

			Case 'datetime':

				break;

			Case 'time':

				echo_buffer("//  'sql|VFL'     => 'if($fd > \"00:00:00\", CONCAT(TIME_FORMAT($fd, \"%h:%i %p\")), \"\")',");

				break;

			default:

				break;

		}


		# $opts['fdd']['col_name']['strip_tags']

		# default is false yet sometimes strip_tags|FL' => true is preferable if the column contains HTML markup

		if($data['HTML_TAG'][$i] == 'textarea' && $pme['textarea']['striptags'] > 0){

			// nested ternary statements ahead

			($pme['textarea']['striptags'] == 1) ? echo_buffer("//  'strip_tags|FL' => true,")  : ( ($pme['textarea']['striptags'] == 2) ? echo_buffer("//  'strip_tags' => false," ) : '') ;

		}

		# $opts['fdd']['col_name']['textarea']

		if($data['HTML_TAG'][$i] == 'textarea'){

			echo_buffer("  'textarea'   => array('rows' => ".$pme['textarea']['rows'].", 'cols' => ".$pme['textarea']['cols']."),");

		}

		# $opts['fdd']['col_name']['trimlen'] - usually applicable only to BLOB columns

		if($data['HTML_TAG'][$i] == 'textarea' && $pme['textarea']['trimlen'] > 0){

			echo_buffer("  'trimlen|FL' => ".$pme['textarea']['trimlen'].",");

		}

		# author preference for email as part of column name in string columns

		if($data['DATA_TYPE'][$i] == 'varchar' || $data['DATA_TYPE'][$i] == 'char'){

			if($tweak['email']){

				if(stristr($data['COLUMN_NAME'][$i], 'email')){

					echo_buffer("  'URL'        => 'mailto:\$value',");

				}

			}

			if($tweak['url']){

				if(stristr($data['COLUMN_NAME'][$i], 'http') || stristr($data['COLUMN_NAME'][$i], 'url')){

					echo_buffer("  'URL'        => 'http://\$value',");

					echo_buffer("  'URLtarget'  => '_blank',");

					echo_buffer("//  'URLdisp'    => 'Visit',");

				}

			}

		}

	   # based on column name or column type

		if($data['DATA_TYPE'][$i] == 'enum'){

			if(in_array($data['COLUMN_NAME'][$i], $tweak['enum'])){

				// If certain defaults are found

				if($data['COLUMN_DEFAULT'][$i] == '0'){

					echo_buffer("  'values2'    => array('0' => 'No', '1' => 'Yes'),");

				}elseif($data['COLUMN_DEFAULT'][$i] == '1'){

					echo_buffer("  'values2'    => array('1' => 'Yes', '0' => 'No'),");

				}

			}else{

				echo_buffer("  'values'     => array".substr($data['COLUMN_TYPE'][$i], 4).', ');

			}

		}elseif($data['DATA_TYPE'][$i] == 'set'){

			echo_buffer("  'values'     => array".substr($data['COLUMN_TYPE'][$i], 3).', ');

		}

		# $opts['fdd']['col_name']['sort'] is generally set false if the column type is TEXT/BLOB

		// last element of array, thus no comma follows this setting

		($data['HTML_TAG'][$i] == 'textarea' && $pme['textarea']['sorting'] == 0) ? echo_buffer("  'sort'       => false") : echo_buffer("  'sort'       => true");

		echo_buffer(');'); // CLOSE THE PHPMYEDIT FIELD OPTIONS ARRAY. ******************************************

		// End phpMyEdit column array options array *******************************

		// Post-initialized fied options follow

		if(empty($i)){

			echo_buffer('// If the tab feature is implemented, the first column must have a tab');

			echo_buffer("// \$opts['fdd']['{$data['COLUMN_NAME'][$i]}']['tab|ACP'] = '".str_replace('\'', '\\\'', $data['COLUMN_NAME_LABEL'][$i])."';");

		}

		if($pme['help_method'] == 3 && empty($i)){

			echo_buffer("// \$opts['fdd']['{$data['COLUMN_NAME'][$i]}']['help|ACP'] = '';");

		}

		// readability induces usage of:

		$fd = $data['COLUMN_NAME'][$i];

		$label = $data['COLUMN_NAME_LABEL'][$i];

		# $opts['fdd']['col_name']['js']['required']

		# $opts['fdd']['col_name']['js']['hint']

		# post-initialized for readability purposes + easier deletion if unwanted

		// $pme['js']['usage'] --- conditionally apply required js status based on column number $i

		if($i == 0 && empty($data['AUTO_INCREMENT'])){

			// column 0 is probably PRI

			if($data['COLUMN_KEY'][0] == 'PRI'){
				
				echo_buffer("\$opts['fdd']['$fd']['js']['required'] = true; // PRI column key, not auto_increment");

			}

		}elseif(empty($i) || $data['ISNULL_BOOLEAN'][0] == 1){

			// Omit MySQL column 0 (usually an auto_increment) or NULL fields

			// echo_buffer('// Bookmark: omit $opts[\'fdd\'][\''.$fd.'\'][\'js\'][\'required\'] = true; for NULL columns or column 0');

		}elseif($data['COLUMN_NAME'][$i] == 'deleted' || $data['COLUMN_NAME'][$i] == 'hidden' || $data['COLUMN_NAME'][$i] == 'nav'){

			// Author preference for specific column names = skip JS
			echo_buffer('// Bookmark: omit [\'js\'][\'required\'] for Author preference for specific column names');

		}else{

			switch($pme['js']['usage'])

			{

				Case 0:

					// Apply to all columns or just few columns

					if($i < 4){

						// required applied to columns 1-3

						echo_buffer("\$opts['fdd']['$fd']['js']['required'] = true;");

						if($data['DATA_TYPE'][$i] == 'int'){

							echo_buffer("\$opts['fdd']['$fd']['js']['regexp'] = '/^[0-9]*$/';");

							echo_buffer("\$opts['fdd']['$fd']['js']['hint'] = '".$pme['label']['js_hint']." $label';");

						}elseif($data['DATA_TYPE'][$i] == 'date'){

							echo_buffer("\$opts['fdd']['$fd']['js']['regexp'] = '/^[1-2]{1}[0-9]{3}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$/';");

							echo_buffer("\$opts['fdd']['$fd']['js']['hint'] = '".$pme['label']['js_hint']." $label YYYY-MM-DD';");

						}else{

							echo_buffer("\$opts['fdd']['$fd']['js']['hint'] = '".$pme['label']['js_hint']." $label';");

						}

					}else{

						// applied but commented out

						echo_buffer("// \$opts['fdd']['$fd']['js']['required'] = true;");

						// echo_buffer("// \$opts['fdd']['$fd']['js']['regexp'] = '/^[a-zA-Z]*$/'; // modify REGEXP to meet your needs");

						if($data['DATA_TYPE'][$i] == 'date'){

							echo_buffer("// \$opts['fdd']['$fd']['js']['regexp'] = '/^[1-2]{1}[0-9]{3}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$/';");

						}else{

							echo_buffer("// \$opts['fdd']['$fd']['js']['regexp'] = '/^[a-zA-Z]*$/'; // modify REGEXP to meet your needs");

						}

						echo_buffer("// \$opts['fdd']['$fd']['js']['hint'] = '".$pme['label']['js_hint']." $label';");

					}

					break;

				Case 1:

					echo_buffer("\$opts['fdd']['$fd']['js']['required'] = true;");

					if($data['DATA_TYPE'][$i] == 'int'){

						echo_buffer("\$opts['fdd']['$fd']['js']['regexp'] = '/^[0-9]*$/';");

						echo_buffer("\$opts['fdd']['$fd']['js']['hint'] = '".$pme['label']['js_hint']." $label';");

					}elseif($data['DATA_TYPE'][$i] == 'date'){

						echo_buffer("\$opts['fdd']['$fd']['js']['regexp'] = '/^[1-2]{1}[0-9]{3}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$/';");

						echo_buffer("\$opts['fdd']['$fd']['js']['hint'] = '".$pme['label']['js_hint']." $label YYYY-MM-DD';");

					}else{

						echo_buffer("\$opts['fdd']['$fd']['js']['hint'] = '".$pme['label']['js_hint']." $label';");

					}

					break;

				Case -1:

				default:

					// Skipped if any other value is applied to $pme['js']['usage']

					break;

			}

		}

		if(stristr($data['COLUMN_TYPE'][$i], 'binary')){

			echo_buffer('');

			echo_buffer('### BINARY field: the above size/maxlen. Check size for accuracy. #######################################');

		}

		echo_buffer('');

	}; // end of long for() loop

	echo_buffer('// Bookmark: '.basename(__FILE__).' at line '.__LINE__);

	echo_buffer('');

	echo_buffer("require_once('inc/phpMyEdit.mysqli.php');");

	echo_buffer('');

	if(in_array('deleted', $data['COLUMN_NAME'])){

		echo_buffer("if(array_key_exists('PME_sys_moreadd', \$_REQUEST) || (isset(\$_REQUEST['PME_sys_operation']) && \$_REQUEST['PME_sys_operation'] == 'Add')){ \$opts['cgi']['overwrite']['deleted'] = '0'; }");

		echo_buffer('');

	}

	echo_buffer('new phpMyEdit($opts);');

	echo_buffer('');

	echo_buffer('if($warnings = mysqli_get_warnings($opts[\'dbh\'])){');

	echo_buffer('   printf(\'<p class="text-danger">Warnings: %s</p>\', htmlentities(implode(\', \', $warnings)));');

	echo_buffer('}');

	echo_buffer('');

	echo_buffer('mysqli_close($opts[\'dbh\']);');

	echo_buffer('');

	// For toggle links - a drop up button may be preferred over sidebar-nav which requires its own column

	if($tweak['toggle'] && $data['NUM_COLS'] > $pme['list_mode_num_cols']){

		// Container table for phpMyEdit form and $my_link_buffer
		// echo_buffer('echo "\n".\'<table border="0" cellpadding="0" cellspacing="0">\';');
		// Replaced the original container table with Bootstrap row/col
		// Bootstrap 3

		echo_buffer('if(!empty($my_link_buffer)){');
		echo_buffer('   echo "\n".\'<div class="btn-group dropup">\'."\n";');
		echo_buffer('   echo "\n".\'<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Field toggle <span class="caret"></span> </button>\'."\n";');
		echo_buffer('   echo "\n".\'<div class="dropdown-menu scrollable-menu" role="menu">\'."\n";');
		echo_buffer('   echo $my_link_buffer;');
		echo_buffer('   echo "\n".\'</div>\'."\n";');
		echo_buffer('   echo "\n".\'</div>\'."\n";');
		echo_buffer('}');
		echo_buffer('');

		// echo_buffer('echo "\n".\'<br><p class="alert alert-info">'.$cfg['server'][$sn]['db'].' . '.$tb.'</p>\';');

		echo_buffer('');

		echo_buffer('echo "\n".\'</div>\'; // close the col');

		echo_buffer('');

		echo_buffer('echo "\n".\'</div>\'; // close the row');

		echo_buffer('');

	}

	echo_buffer("require_once('inc/footer.php');");

	echo_buffer('');

	echo_buffer('// Bookmark: '.basename(__FILE__).' at line '.__LINE__);

	echo_buffer('');

	echo_buffer('?>');


	$filehandle = $pme['file']['dir'].$pme['file']['format'];

	if($pme['file']['write']){

		// echo '<p>Attempting to output: '.$filehandle.'</p>';

		// echo '<p>Checking the configured file backup preference: $pme[\'backup_existing\'] = '.$pme['file']['backup'].'</p>';

		switch($pme['file']['backup'])
		{
			Case 1:
				if(file_exists($filehandle)){
					echo '<p>File exists: '.$filehandle.'</p>';
					// Attempt to rename pre-existing files. Abort if unsuccessful.
					if(rename($filehandle, $filehandle.'.bak')){
						echo '<p>Renaming existing file <br>'.$filehandle.'<br> as <br>'.$filehandle.'.bak</p>';
					}else{
						abort('Cannot rename existing file '.$filehandle);
					}
				}else{
					echo '<p>File does not exist: '.$filehandle.'</p>';
				}
				break;
			Case 0:
			default:
				// echo '<p>Over-writing existing scripts without making a backup:  $pme[\'backup_existing\'] = '.$pme['file']['backup'].'</p>';
				break;
		}


		if(!file_put_contents($filehandle, $output_buffer)){

			echo "\n".'<blockquote class="text-danger">Cannot write '.$filehandle.'</blockquote>';

		}else{

			echo '<div class="alert alert-info" role="alert"><b>Script created:</b>&nbsp;<a href="'.$filehandle.'" target="_blank"><b>'.$filehandle.'</b></a> (new window)</div>';

		}

	}else{

		echo '<p>To output the phpMyEdit script to <code>'.$filehandle.'</code> simply edit <code>./generator-includes/generator.config.php</code> and set <code>$pme[\'write_file\'] = 1;</code>. Also, review other available options in the generator config file.</p>';
		echo "\n".'<pre class="pre-scrollable">'.htmlspecialchars($output_buffer).'</pre>';

	}

	unset($data);
	unset($output_buffer);
	unset($pme);

	echo "\n".'<p><a href="app-form-generator.php" class="pme-header" title="Select a database connection">Select a database connection</a></p>';

	echo "\n".'<p><a href="javascript:history.go(-1)" onmouseover="self.status=document.referrer;return true" class="pme-header" title="Go Back">Go Back</a></p>';

} // end of Step 3


?>
