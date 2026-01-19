<?php
session_start();

$host = "mariadb-container"; 
$user = "root";
$pass = "rootpassword";
$dbname = "Ionita_Alexandru_Bogdan";
$port = 3307;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Eroare DB: " . $conn->connect_error);
}
?>