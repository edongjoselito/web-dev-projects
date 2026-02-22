<?php
require_once "db.php";

if (isset($_POST['update'])) {

  $id       = $_POST['id'];
  $fullname = trim($_POST['fullname']);
  $email    = trim($_POST['email']);

  $stmt = $conn->prepare("UPDATE students SET fullname = ?, email = ? WHERE id = ?");
  $stmt->bind_param("ssi", $fullname, $email, $id);

  if ($stmt->execute()) {
    echo "✅ Record updated successfully!";
    echo "<br><a href='read.php'>Back to List</a>";
  } else {
    echo "❌ Error updating record.";
  }

  $stmt->close();
  $conn->close();
}
?>
