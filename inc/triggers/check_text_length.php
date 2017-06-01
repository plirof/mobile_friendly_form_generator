<?php

/*
Display error message if validation fails, include the appropriate footer, and exit.
Variables available within triggers include the following.
$this             object reference
$this->dbh        initialized MySQL database handle
$this->tb         MySQL table
$this->key        primary key name
$this->key_type   primary key type
$this->key_delim  primary key deliminator
$this->rec        primary key value (update and delete only)
$newvals          associative array of new values (update and insert only)
$oldvals          associative array of old values (update and delete only)
$changed          array of keys with changed values
*/

// TEXT type column limited to 65,535 characters
// $opts['triggers']['insert']['before'] = 'inc/triggers/check_text_length.php';
// $opts['triggers']['update']['before'] = 'inc/triggers/check_text_length.php';

$num = strlen($newvals['content']);

if($num > 65535){

	unset($_POST);

	abort('Content field length &gt; than 65535 = '.number_format($num));

}

?>
