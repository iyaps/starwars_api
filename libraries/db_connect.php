<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iyappankrishnasamy_characters";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
//echo "Connected successfully";
?>
