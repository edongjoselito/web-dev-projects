<?php
require_once "db.php";

if (isset($_POST['update'])) {
  $id       = (int)$_POST['id'];
  $fullname = trim($_POST['fullname']);
  $email    = trim($_POST['email']);

  $stmt = $conn->prepare("UPDATE students SET fullname=?, email=? WHERE id=?");
  $stmt->bind_param("ssi", $fullname, $email, $id);

  if ($stmt->execute()) {
    header("Location: index.php");
    exit;
  } else {
    echo "Error updating: " . $conn->error;
  }
}
