<?php
include 'db_connect.php';
$result = $conn->query("SELECT * FROM donors ORDER BY donor_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Management • Blood Bank</title>
    <link rel="stylesheet" href="css/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-users"></i> Donor Management</h1>
            <a href="index.php" class="btn"><i class="fas fa-home"></i> Home</a>
        </header>

        <div class="actions">
            <a href="add_donor.php" class="btn"><i class="fas fa-plus"></i> Add Donor</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Blood Type</th>
                    <th>Contact</th>
                    <th>Last Donation</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['donor_id'] ?></td>
                        <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                        <td><span class="blood-type"><?= $row['blood_type'] ?></span></td>
                        <td><?= $row['phone'] ?><br><?= $row['email'] ?></td>
                        <td><?= $row['last_donation_date'] ? $row['last_donation_date'] : 'Never' ?></td>
                        <td><span class="status <?= $row['is_eligible'] ? 'eligible' : 'ineligible' ?>"><?= $row['is_eligible'] ? 'Eligible' : 'Ineligible' ?></span></td>
                        <td class="action-buttons">
                            <a href="view_donor.php?id=<?= $row['donor_id'] ?>" class="btn-icon"><i class="fas fa-eye"></i></a>
                            <a href="edit_donor.php?id=<?= $row['donor_id'] ?>" class="btn-icon"><i class="fas fa-edit"></i></a>
                            <a href="delete_donor.php?id=<?= $row['donor_id'] ?>" 
                               onclick="return confirm('Delete this donor?');" class="btn-icon danger"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="center">No donors found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>