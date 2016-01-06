<?php
	$conn=mysql_connect("localhost", "root", "");
	$db=mysql_select_db("bookstore", $conn);
	session_id("login");
	session_start();
	$check=$_SESSION['login_username'];
	$session=mysql_query("SELECT * FROM `bookstore`.`customerdata` WHERE login_name='$check'");
	$row=mysql_fetch_array($session);
	$login_session= $row[1];
	$session_id= $row[0];
	if ($row[8] == 'A') {
		$type = "Admin";
	} else {
		$type = "User";
	}
	if(!isset($login_session)) {
		header("Location:e-s.html");
	}
?>