<?php
require_once "db.php";

if (isset($_GET['id'])) {

  $id = $_GET['id'];

  $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    echo "Record deleted successfully!";
    echo "<br><a href='read.php'>Back to List</a>";
  } else {
    echo "Error deleting record.";
  }

  $stmt->close();
  $conn->close();
}
?>
