<?php

// Form generator database configuration.

define(PHP_EOL, "\r\n"); // Author preference for Windows text editor

$cfg = array();

$display_comments = false; // Verbose comments output to the browser

require_once('generator-includes/generator.functions.php');

// The custom connect_using_mysqli() function should handle errors in a presentable 
// manner, applying the abort() function to halt processing in the event of an error.

// Configure (multiple) databases beginning with $sn = 0;
$sn = 0;
$cfg['server'][$sn]['charset'] = 'utf8';
$cfg['server'][$sn]['log'] = 'change_log'; // Subsequently this suppresses usage of the log table with itself
$cfg['server'][$sn]['hn'] = 'localhost';
$cfg['server'][$sn]['db'] = 'test_e-front';
$cfg['server'][$sn]['un'] = 'root';
$cfg['server'][$sn]['pw'] = '';

// Optionally configure additional database connections.
//$sn++;
//$cfg['server'][$sn]['charset'] = 'utf8';
//$cfg['server'][$sn]['log'] = 'change_log';
//$cfg['server'][$sn]['hn'] = 'localhost';
//$cfg['server'][$sn]['db'] = 'test';
//$cfg['server'][$sn]['pw'] = '';
//$cfg['server'][$sn]['un'] = 'root';

// $sn++;
// $cfg['server'][$sn]['charset'] = 'utf8';
// $cfg['server'][$sn]['log'] = 'change_log';
// $cfg['server'][$sn]['hn'] = 'localhost';
// $cfg['server'][$sn]['db'] = 'test';
// $cfg['server'][$sn]['pw'] = '';
// $cfg['server'][$sn]['un'] = 'root';

// End server configuration.

// Count servers and connect.

$cfg['server_count'] = $sn + 1;

// Has the user selected a server number from a menu link?

if(array_key_exists('sn', $_GET) && $_GET['sn'] != ''){

	$sn_selected = intval($_GET['sn']); 

}

if(!isset($sn_selected)){

	// Upon initial entry, connect to all configured databases.

	for ($i = 0; $i < $cfg['server_count']; $i++) {

		// In the event of a failed connection, connect_using_mysqli() will abort.

		$cfg['server'][$i]['link'] = connect_using_mysqli($i); 

		if($cfg['server'][$i]['link']->server_info < 5.5){

			echo "\n".'<p>';

			echo "\n".'Connecting to '.$cfg['server'][$i]['db'].'. ';

			echo "\n".'Found MySQL&trade; version: '.$cfg['server'][$i]['link']->server_info.' on '.$cfg['server'][$i]['db'].' (5.5+ recommended)';

			echo "\n".'</p>';

		}

	}

}else{

	// Database number $sn_selected has been selected using a link.

	$cfg['server'][$sn_selected]['link'] = connect_using_mysqli($sn_selected); 

}

// Connected OK. Create menus based on the selected step.

require_once('generator-includes/generator.steps.php');

// All done. Close the db connection(s). 

if(!isset($sn_selected)){

	if(isset($cfg['server'][$sn]['db'])){

		for ($i = 0; $i < $cfg['server_count']; $i++) {

			if(isset($cfg['server'][$i]['link'])){

				if(mysqli_close($cfg['server'][$i]['link'])){

					// echo "\n".'<p class="text-muted">Closing connection '.$i.'</p>';

				}

			}

		}

	}

}else{

	if(!mysqli_close($cfg['server'][$sn_selected]['link'])){

		echo "\n".'<p>Cannot close the selected connection: '.$sn_selected.'</p>';

	}

}


?>