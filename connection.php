<?php
// connection.php

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mathematricks2';

// Create a new mysqli connection instance
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
