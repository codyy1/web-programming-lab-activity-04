<?php
$host = "localhost";
$user = "root";   // default for XAMPP
$pass = "";       // leave empty unless you set a password
$dbname = "books1"; // must match exactly with phpMyAdmin

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
