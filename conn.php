<?php
// Database connection
$host = 'localhost';
$db_username = 'root';
$db_password = '';
$dbname = 'booking_system';

// Create connection
$conn = new mysqli($host, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>