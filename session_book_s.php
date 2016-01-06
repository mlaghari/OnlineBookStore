<?php
	// $conn=mysql_connect("localhost", "root", "");
	// $db=mysql_select_db("dbdel", $conn);
	session_start();
	$query=$_SESSION['results'];
	// $session=mysql_query("SELECT * FROM `users` WHERE name='$check'");
	while ($row = mysql_fetch_assoc($query)) {
	    echo $row["userid"];
	    echo $row["fullname"];
	    echo $row["userstatus"];
	}

	// $row=mysql_fetch_array($session);
	// $login_session= $row[1];
	// $session_id= $row[0];
	// if(!isset($login_session)) {
	// 	header("Location:e-s.html");
	// }
?>