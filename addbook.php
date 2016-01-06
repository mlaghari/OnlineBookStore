<?php
	$conn=mysql_connect("localhost", "root", "");
    $db=mysql_select_db("bookstore", $conn);
    // session_id("login_session");
    $isbn = $_POST['isbn'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $genre = $_POST['genre'];
    $format = $_POST['format'];
    $year = $_POST['year'];
    $publisher = $_POST['publisher'];
    $copies = $_POST['copies'];

    $queryAuthor = mysql_query("SELECT AuthorID from authors where Name='$author'");
    $count22 = mysql_num_rows($queryAuthor);
    echo $count22;
    if ($count22 == 1) {
    	echo "in 1";
    	$blah = mysql_fetch_array($queryAuthor);
    	$temp=$blah[0];
    	$queryAuthor = mysql_query("INSERT INTO `bookstore`.`authorbooks`(`ISBN`, `AuthorID`) VALUES ('$isbn', '$temp');");
    } else {
    	echo "in 2";
    	$insertAuthor=mysql_query("INSERT INTO `bookstore`.`authors`(`Name`) VALUES ('$author');");
    	$selectQuery=mysql_query("SELECT AuthorID from authors where Name='$author'");
    	$blah = mysql_fetch_array($selectQuery);
    	$temp=$blah[0];
    	$queryAuthor = mysql_query("INSERT INTO `bookstore`.`authorbooks`(`ISBN`, `AuthorID`) VALUES ('$isbn', '$temp');");
    }

    $query=mysql_query("INSERT INTO `bookstore`.`books`(`ISBN`,`Title`,`YearOfPublication`,`Publisher`,`Price`,`Genre`,`Format`,`NumberOfCopies`)
			VALUES('$isbn','$name','$year','$publisher','$price','$genre','$format','$copies');");
    $count2=mysql_query("SELECT * FROM `bookstore`.`books` where ISBN='$isbn'");
    $rows = mysql_num_rows($count2);
    if ($rows == 1) {
        header("Location:profile.php"); 
    } else {
        header('Location:index.php');
        echo $rows;
    }
?>