<?php 
    $conn=mysql_connect("localhost", "root", "");
    $db=mysql_select_db("bookstore", $conn);
    // session_id("login_session");
    session_start();
    $user=$_POST['username'];
    $pass=$_POST['password'];
    $query=mysql_query("SELECT * FROM `bookstore`.`customerdata` WHERE login_name='$user' and Password='$pass'");
    $rows=mysql_num_rows($query);
    if ($rows == 1) {
        echo "here";
        $_SESSION['login_username'] = $user;
        header("Location:profile.php"); 
    } else {
        header('Location:index.php');
    }
?>