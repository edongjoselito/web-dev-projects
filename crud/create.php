<!DOCTYPE html>
<html>
<head>
  <title>Add Student</title>
</head>
<body>

<h2>Add New Student</h2>

<form action="save.php" method="POST">
  <label>Full Name:</label><br>
  <input type="text" name="fullname" required><br><br>

  <label>Email:</label><br>
  <input type="email" name="email" required><br><br>

  <button type="submit" name="save">Save</button>
</form>

</body>
</html>
