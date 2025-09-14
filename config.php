<?php
// config.php

$host = "localhost";       // Database host
$dbname = "sample_project"; // Database name
$username = "root";        // Database username
$password = "";            // Database password

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Set default fetch mode
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Connection successful
    // echo "Database connection successful!";
} catch (PDOException $e) {
    // Connection failed
    die("Database connection failed: " . $e->getMessage());
}
?>
