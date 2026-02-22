<?php
require_once "db.php";

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Student</title>
</head>
<body>

<h2>Edit Student</h2>

<form action="update.php" method="POST">
  <input type="hidden" name="id" value="<?= $row['id']; ?>">

  <label>Full Name:</label><br>
  <input type="text" name="fullname" value="<?= $row['fullname']; ?>" required><br><br>

  <label>Email:</label><br>
  <input type="email" name="email" value="<?= $row['email']; ?>" required><br><br>

  <button type="submit" name="update">Update</button>
</form>

</body>
</html>
