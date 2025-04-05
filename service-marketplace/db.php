<?php
$host = "localhost";
$user = "root"; // Change if you have a different username
$password = ""; // Change if you have a password
$database = "service_marketplace";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
