<?php 
include 'db_connect.php';
include 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard • Blood Bank Management System</title>
    <link rel="stylesheet" href="css/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Blood Bank Management System</h1>
            <div>
                <?php if (is_logged_in()): ?>
                    <span class="user-info" style="margin-right: 15px;">
                        Welcome, <?= get_current_full_name() ?> (<?= $_SESSION['role'] ?>)
                    </span>
                    <a href="logout.php" class="btn">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn">Login</a>
                <?php endif; ?>
            </div>
        </header>

        <div class="nav-tabs">
            <a href="dashboard.php" class="nav-tab active">
                <span class="icon-blood"></span> Dashboard
            </a>
            <a href="donors.php" class="nav-tab">
                <span class="icon-donor"></span> Donors
            </a>
            <?php if (is_logged_in() && has_role('Admin')): ?>
                <a href="db_inspector.php" class="nav-tab">
                    <span class="icon-db"></span> DB Inspector
                </a>
            <?php endif; ?>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <div class="card-icon">🩸</div>
                <div class="card-title">Total Donors</div>
                <div class="card-value">
                    <?php
                    $result = $conn->query("SELECT COUNT(*) as total FROM donors");
                    $row = $result->fetch_assoc();
                    echo $row['total'];
                    ?>
                </div>
            </div>
            
            <div class="card">
                <div class="card-icon">💉</div>
                <div class="card-title">Total Donations</div>
                <div class="card-value">
                    <?php
                    $result = $conn->query("SELECT COUNT(*) as total FROM donations");
                    $row = $result->fetch_assoc();
                    echo $row['total'];
                    ?>
                </div>
            </div>
            
            <div class="card">
                <div class="card-icon">🏥</div>
                <div class="card-title">Partner Hospitals</div>
                <div class="card-value">
                    <?php
                    $result = $conn->query("SELECT COUNT(*) as total FROM hospitals");
                    $row = $result->fetch_assoc();
                    echo $row['total'];
                    ?>
                </div>
            </div>
            
            <div class="card">
                <div class="card-icon">⚠️</div>
                <div class="card-title">Pending Requests</div>
                <div class="card-value">
                    <?php
                    $result = $conn->query("SELECT COUNT(*) as total FROM requests WHERE status = 'Pending'");
                    $row = $result->fetch_assoc();
                    echo $row['total'];
                    ?>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="add_donor.php" class="btn">➕ Add New Donor</a>
            <?php if (is_logged_in() && has_role('Admin')): ?>
                <a href="db_inspector.php" class="btn">🔍 Database Inspector</a>
            <?php endif; ?>
        </div>

        <h2>Recent Donors</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Blood Type</th>
                    <th>Phone</th>
                    <th>Last Donation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $result = $conn->query("SELECT * FROM donors ORDER BY donor_id DESC LIMIT 5");
            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['donor_id'] ?></td>
                        <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                        <td><span class="blood-type"><?= $row['blood_type'] ?></span></td>
                        <td><?= $row['phone'] ?></td>
                        <td><?= $row['last_donation_date'] ? $row['last_donation_date'] : 'Never' ?></td>
                        <td class="center">
                            <a href="view_donor.php?id=<?= $row['donor_id'] ?>" class="btn-icon">👁️</a>
                            <a href="edit_donor.php?id=<?= $row['donor_id'] ?>" class="btn-icon">✏️</a>
                            <a href="delete_donor.php?id=<?= $row['donor_id'] ?>" 
                               onclick="return confirm('Delete this donor?');" class="btn-icon danger">🗑️</a>
                        </td>
                    </tr>
                <?php endwhile;
            else: ?>
                <tr><td colspan="6" class="center">No donors found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>