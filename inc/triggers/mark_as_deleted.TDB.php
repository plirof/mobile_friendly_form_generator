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

$query2 = sprintf('UPDATE %s SET `deleted` = "1" WHERE `%s` = "%s" LIMIT 1', $this->tb, $this->key, $this->rec);

if($this->MyQuery($query2)){

	// Emulate the change_log function, saving a copy of the record flagged as deleted
	if($this->logtable){
		$query3 = sprintf('INSERT INTO %s' .' (updated, user, host, operation, tab, rowkey, col, oldval, newval)' 
			.' VALUES (NOW(), "%s", "%s", "delete", "%s", "%s", "%s", "%s", "")', $this->logtable, addslashes($this->get_server_var('REMOTE_USER')), addslashes($this->get_server_var('REMOTE_ADDR')), addslashes($this->tb), addslashes($this->rec), addslashes($key), addslashes(serialize($oldvals)));
		$this->myquery($query3, __LINE__);
	}

	return false;

}else{

	abort('Error in trigger '.__FILE__.' used to flag a record as deleted: '.mysqli_error());

}

?>
