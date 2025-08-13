<?php
$host = "localhost";
$user = "root"; // change if you have another MySQL user
$pass = "";     // change if your MySQL has a password
$db   = "hospital_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
