<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// Database Configuration
$host = 'localhost'; // Change this to your database host
$dbname = 'blog'; // Change this to your database name
$username = 'root'; // Change this to your database username
$password = 'KpiNH898G?n39344'; // Change this if your database has a password

// Create connection
$con = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
