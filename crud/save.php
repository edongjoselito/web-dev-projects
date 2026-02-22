<?php
require_once "db.php";

if (isset($_POST['save'])) {

  $fullname = trim($_POST['fullname']);
  $email    = trim($_POST['email']);

  $stmt = $conn->prepare("INSERT INTO students (fullname, email) VALUES (?, ?)");
  $stmt->bind_param("ss", $fullname, $email);

  if ($stmt->execute()) {
    echo "Student saved successfully!";
    echo "<br><a href='create.php'>Add another</a>";
  } else {
    echo "Error: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}
?>
