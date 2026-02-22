<?php
require_once "db.php";

$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student List</title>
</head>

<body>

    <h2>Student List</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['fullname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>
        <a href='edit.php?id=" . $row['id'] . "'>Edit</a> |
        <a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
      </td>";
                echo "</tr>";

            }
        } else {
            echo "<tr><td colspan='3'>No records found</td></tr>";
        }
        ?>

    </table>

</body>

</html>