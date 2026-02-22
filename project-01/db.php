<?php
// db.php
// ✅ Database connection (mysqli)

$host = "127.0.0.1";
$user = "root";
$pass = "moth34board";           // change if your MySQL has password
$db   = "customer_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// recommended charset
$conn->set_charset("utf8mb4");