<?php
include 'db_connect.php';

/* Get the donor ID from the URL */
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die("Invalid donor ID.");
}

/* Fetch the current record */
$result = $conn->query("SELECT * FROM donors WHERE donor_id = $id LIMIT 1");
if ($result->num_rows === 0) {
    die("Donor not found.");
}
$donor = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Donor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Edit Donor</h1>

    <form action="update_donor.php" method="POST" class="form">
        <input type="hidden" name="id" value="<?= $donor['donor_id'] ?>">

        <label>First Name</label>
        <input type="text" name="first_name" value="<?= $donor['first_name'] ?>" required>

        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= $donor['last_name'] ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $donor['email'] ?>">

        <label>Phone</label>
        <input type="text" name="phone" value="<?= $donor['phone'] ?>" required>

        <label>Date of Birth</label>
        <input type="date" name="dob" value="<?= $donor['date_of_birth'] ?>" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="Male" <?= $donor['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= $donor['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= $donor['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
        </select>

        <label>Blood Type</label>
        <select name="blood_type" required>
            <option value="A+" <?= $donor['blood_type'] == 'A+' ? 'selected' : '' ?>>A+</option>
            <option value="A-" <?= $donor['blood_type'] == 'A-' ? 'selected' : '' ?>>A-</option>
            <option value="B+" <?= $donor['blood_type'] == 'B+' ? 'selected' : '' ?>>B+</option>
            <option value="B-" <?= $donor['blood_type'] == 'B-' ? 'selected' : '' ?>>B-</option>
            <option value="AB+" <?= $donor['blood_type'] == 'AB+' ? 'selected' : '' ?>>AB+</option>
            <option value="AB-" <?= $donor['blood_type'] == 'AB-' ? 'selected' : '' ?>>AB-</option>
            <option value="O+" <?= $donor['blood_type'] == 'O+' ? 'selected' : '' ?>>O+</option>
            <option value="O-" <?= $donor['blood_type'] == 'O-' ? 'selected' : '' ?>>O-</option>
        </select>

        <label>Address</label>
        <textarea name="address"><?= $donor['address'] ?></textarea>

        <label>City</label>
        <input type="text" name="city" value="<?= $donor['city'] ?>">

        <label>Last Donation Date (if any)</label>
        <input type="date" name="last_donation_date" value="<?= $donor['last_donation_date'] ?>">

        <label>Health Conditions</label>
        <textarea name="health_conditions"><?= $donor['health_conditions'] ?></textarea>

        <label>Active Donor</label>
        <select name="is_active">
            <option value="1" <?= $donor['is_active'] ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= !$donor['is_active'] ? 'selected' : '' ?>>No</option>
        </select>

        <button type="submit" class="btn">Save Changes</button>
    </form>

    <p><a href="index.php">← Back to List</a></p>
</body>
</html>