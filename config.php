<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting for development (turn off in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to escape strings to prevent SQL injection
function escape($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}
?>
