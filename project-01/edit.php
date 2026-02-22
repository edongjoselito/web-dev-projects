<?php
session_start();
require_once "db.php";

$errors = [];
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    $_SESSION['error'] = "Invalid customer ID.";
    header("Location: index.php");
    exit;
}

// fetch current record
$stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    $_SESSION['error'] = "Customer not found.";
    header("Location: index.php");
    exit;
}

$first_name = $row['first_name'];
$last_name  = $row['last_name'];
$email      = $row['email'];
$contact_no = $row['contact_no'];
$address    = $row['address'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $contact_no = trim($_POST['contact_no'] ?? '');
    $address    = trim($_POST['address'] ?? '');

    // validation
    if ($first_name === '') $errors[] = "First Name is required.";
    if ($last_name === '')  $errors[] = "Last Name is required.";
    if ($email === '')      $errors[] = "Email is required.";
    if ($contact_no === '') $errors[] = "Contact No. is required.";
    if ($address === '')    $errors[] = "Address is required.";
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format is invalid.";
    }

    if (!$errors) {
        $stmt = $conn->prepare("
            UPDATE customers
            SET first_name = ?, last_name = ?, email = ?, contact_no = ?, address = ?
            WHERE id = ?
        ");
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $contact_no, $address, $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Customer updated successfully!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Failed to update customer. " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Customer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-4" style="max-width: 820px;">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="m-0">Edit Customer</h3>
    <a href="index.php" class="btn btn-outline-secondary">Back</a>
  </div>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="mb-3">
        <span class="badge bg-primary">Customer Code: <?= htmlspecialchars($row['customer_code']) ?></span>
      </div>

      <form method="post" action="edit.php?id=<?= (int)$id ?>" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">First Name *</label>
          <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($first_name) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Last Name *</label>
          <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($last_name) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Email *</label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact No. *</label>
          <input type="text" name="contact_no" class="form-control" value="<?= htmlspecialchars($contact_no) ?>">
        </div>
        <div class="col-12">
          <label class="form-label">Address *</label>
          <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($address) ?></textarea>
        </div>
        <div class="col-12 d-flex gap-2">
          <button type="submit" class="btn btn-warning">Update Customer</button>
          <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>

</div>

<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>