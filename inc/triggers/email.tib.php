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

$errors = array();

foreach($newvals as $key => $val){

	switch($key)

	{

		Case 'email':

			if(empty($email)){ 

				$errors[] = 'You did not enter an email address'; 

			}elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE){ 

				$errors[] = 'Invalid e-mail address: '.$email;

			}

			break;

		default:

			break;

	};

}

if(count($errors) > 0){

	abort($errors);

}

?>
