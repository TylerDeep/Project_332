<?php
$host = "mariadb";
$user = "cs332b9";
$password = "arM0FgFL";
$database = "cs332b9";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>