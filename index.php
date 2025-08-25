<?php
/* 1. bring in the connection */
include 'db_connect.php';

/* 2. fetch all donors */
$result = $conn->query("SELECT * FROM donors ORDER BY donor_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor List • Blood Bank Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Blood Bank Management System</h1>

    <div class="actions">
        <a href="add_donor.php" class="btn">➕ Add Donor</a>
        <a href="db_inspector.php" class="btn">🗄️ DB Inspector</a>
        <a href="index.php" class="btn secondary">⟳ Refresh</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Blood Type</th><th>Phone</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['donor_id'] ?></td>
                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                    <td><?= $row['blood_type'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td class="center">
                        <a href="edit_donor.php?id=<?= $row['donor_id'] ?>">✏️ Edit</a> |
                        <a href="delete_donor.php?id=<?= $row['donor_id'] ?>" 
                           onclick="return confirm('Delete this donor?');">🗑️ Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" class="center">No donors found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>