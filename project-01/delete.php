<?php
session_start();
require_once "db.php";

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['error'] = "Invalid customer ID.";
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Customer deleted successfully!";
} else {
    $_SESSION['error'] = "Failed to delete customer. " . $conn->error;
}

header("Location: index.php");
exit;