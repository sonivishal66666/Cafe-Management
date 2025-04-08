<?php
$host = '35.232.108.75';  // Your Cloud SQL public IP
$username = 'root';       // Your DB username
$password = 'password';   // Your DB password
$dbname = 'online_rest';  // Your DB name
$port = 3306;             // Default MySQL port

// Create connection
$db = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>
