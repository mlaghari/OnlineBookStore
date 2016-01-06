<?php
$conn=mysql_connect("localhost", "root", "");
$db=mysql_select_db("bookstore", $conn);
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$display_name = $_POST['display_name'];
$cc = $_POST['ccnumber'];
$phone = $_POST['phone'];
$add = $_POST['add'];
$password1 = $_POST['password'];
$password2 = $_POST['password_confirmation'];

$query = mysql_query("SELECT * FROM customerdata WHERE login_name='$display_name')");
$row=mysql_num_rows($query);
if ($row == 1) {
    echo "Already Exists";
} else {
    $query1 = mysql_query("ALTER TABLE `customerdata` AUTO_INCREMENT = 1");
    $query = "INSERT INTO `bookstore`.`customerdata`(`login_name`,`Password`,`PhoneNumber`,`LastName`,`FirstName`,`Address`,`CreditCardNumber`) 
                VALUES('$display_name','$password1','$phone','$lname','$fname','$add','$cc')";
    $data = mysql_query($query);
    if ($data) {
        header("location: index.php");
    } else {
        echo "Fuck you";
    }
}
?>  