<?php
// Database settings for both Codespaces and XAMPP.
// Codespaces gives these values through environment variables.
// XAMPP will use the default values after the ?: signs.
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'uiu_collabhub';

// Connect to MySQL / MariaDB.
$conn = new mysqli($servername, $username, $password, $dbname);

// Stop the page if the database connection fails.
if($conn->connect_error){
    die('Database connection failed: ' . $conn->connect_error);
}
?>
