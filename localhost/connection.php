<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "museumdb";
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");
if (mysqli_connect_errno()){
	echo "Failed to connect to MySql: " .mysqli_connect_error();
}
?>
