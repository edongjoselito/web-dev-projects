<!DOCTYPE html>
<html>
<head>
  <title>Add Student</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h2>Add Student</h2>

  <form action="save.php" method="POST">
    <div class="form-group">
      <label>Full Name</label>
      <input type="text" name="fullname" required>
    </div>

    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>

    <button class="btn btn-primary" type="submit" name="save">Save</button>
    <a class="btn" href="index.php">Back</a>
  </form>
</div>
</body>
</html>
