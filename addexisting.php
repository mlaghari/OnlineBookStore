<?php
	$conn=mysql_connect("localhost", "root", "");
	$db=mysql_select_db("bookstore", $conn);
	$isbn = $_POST['isbn'];
	$now = $_POST['quantity'];
	$num = mysql_query("select NumberOfCopies from books where ISBN ='$isbn'");
	$existing = 0;
	while($rows = mysql_fetch_assoc($num)) {
		$existing = $rows['NumberOfCopies'];
	}
	$toadd = $existing + $now;
	$update = mysql_query("UPDATE `bookstore`.`books` SET `NumberOfCopies`='$toadd' WHERE `ISBN`='$isbn'");
	$numUpdated = mysql_query("select NumberOfCopies from books where ISBN ='$isbn'");
	while($rows = mysql_fetch_assoc($numUpdated)) {
		$existingNew = $rows['NumberOfCopies'];
	}
	if ($existingNew = $toadd) {
		header('location: admin_profile.php');
	} else {
		// header('location: error.html');
	}
?>