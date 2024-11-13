<?php
// db_connection.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_musik";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>