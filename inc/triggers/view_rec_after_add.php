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

/**
 * Fails to work as intended when Javascript required = true
 */

if(@$_POST['PME_sys_saveadd'] == 'Save' || @$_POST['PME_sys_savechange'] == 'Save' || @$_POST['PME_sys_savechange'] == 'Submit'){

	$PME_sys_operation = 'PME_op_View';

	$PME_sys_rec = $_POST['PME_sys_rec'];

	$this->operation = 'View';

}

?>
