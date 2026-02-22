<?php
require_once "db.php";

// Search
$q = trim($_GET['q'] ?? '');
$like = "%" . $q . "%";

if ($q !== '') {
  $stmt = $conn->prepare("SELECT * FROM students WHERE fullname LIKE ? OR email LIKE ? ORDER BY id DESC");
  $stmt->bind_param("ss", $like, $like);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Student List</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="topbar">
    <h1>Student List</h1>

    <div class="search-box">
      <form method="GET" action="index.php" style="display:flex; gap:8px;">
        <input type="text" name="q" placeholder="Search name or email..." value="<?= htmlspecialchars($q) ?>">
        <button class="btn btn-primary" type="submit">Search</button>
        <a class="btn" href="index.php">Reset</a>
      </form>

      <a class="btn btn-primary" href="create.php">+ Add Student</a>
    </div>
  </div>

  <div class="small-note">
    Tip: Try searching like “juan” or “gmail”.
  </div>

  <table class="table">
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Email</th>
      <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['fullname']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td>
            <a class="btn btn-warning" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
            <a class="btn btn-danger" href="delete.php?id=<?= $row['id'] ?>"
               onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="4">No records found.</td></tr>
    <?php endif; ?>
  </table>

</div>
</body>
</html>
