<?php
require_once "db.php";
$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) { die("Student not found."); }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Student</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Edit Student</h2>

  <form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">

    <div class="form-group">
      <label>Full Name</label>
      <input type="text" name="fullname" value="<?= htmlspecialchars($row['fullname']) ?>" required>
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
    </div>

    <button class="btn btn-primary" type="submit" name="update">Update</button>
    <a class="btn" href="index.php">Back</a>
  </form>
</div>
</body>
</html>
