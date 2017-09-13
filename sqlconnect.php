<?php

	//For server connection
	$server = '127.0.0.1';
	$username = 'student';
	$password = 'student';

	$schema = 'blogging_system';

	$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . 
	$server, $username, $password);

	//$pdo = new PDO('mysql:dbname=blogging_system;host=127.0.0.1, student, student');




?>