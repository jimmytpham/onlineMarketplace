<!-- 
Jimmy Pham
T00629354
COMP 3541
Project
-->

<?php
// Database configuration
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "marketplace"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Start session
session_start();