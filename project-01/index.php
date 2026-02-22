<?php
session_start();
require_once "db.php";

// flash message
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);

// search
$q = trim($_GET['q'] ?? '');
$like = "%" . $q . "%";

if ($q !== '') {
  $stmt = $conn->prepare("
        SELECT * FROM customers
        WHERE first_name LIKE ?
           OR last_name LIKE ?
           OR email LIKE ?
           OR contact_no LIKE ?
        ORDER BY id DESC
    ");
  $stmt->bind_param("ssss", $like, $like, $like, $like);
} else {
  $stmt = $conn->prepare("SELECT * FROM customers ORDER BY id DESC");
}

$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Customer Information System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body class="bg-light">

  <div class="container py-4">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
      <h3 class="m-0">Customer Information System</h3>
      <a href="add.php" class="btn btn-primary">+ Add New Customer</a>
    </div>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <form class="row g-2" method="get" action="index.php">
          <div class="col-md-9">
            <input type="text" class="form-control" name="q" placeholder="Search by name, email, or contact number..."
              value="<?= htmlspecialchars($q) ?>">
          </div>
          <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-dark w-100" type="submit">Search</button>
            <a class="btn btn-outline-secondary w-100" href="index.php">Clear</a>
          </div>
        </form>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr>
                
                <th>Customer Code</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Address</th>
                <th style="width: 160px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result->num_rows === 0): ?>
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">No customers found.</td>
                </tr>
              <?php else: ?>
                <?php $i = 1;
                while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    
                    <td><span class="badge bg-primary"><?= htmlspecialchars($row['customer_code']) ?></span></td>
                    <td><?= htmlspecialchars($row['last_name'] . ", " . $row['first_name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['contact_no']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td>
                      <a class="btn btn-sm btn-warning" href="edit.php?id=<?= (int) $row['id'] ?>">Edit</a>
                      <a class="btn btn-sm btn-danger" href="delete.php?id=<?= (int) $row['id'] ?>"
                        onclick="return confirm('Are you sure you want to delete this customer?');">
                        Delete
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <!-- <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>