<?php

function dbh(){
$hostname = 'localhost';
$username = 'root';
$password = '';

	try {
	    $conn = new PDO("mysql:host=$hostname;dbname=smartstore", $username, $password);
	    }
	catch(PDOException $e)
	    {
	    echo $e->getMessage();
	    }
	return $conn;
 }

 function check_login(){
 	if (!isset($_SESSION['user'])){
 		header("Location: login.php");
 		exit;
 	}
 }
?>