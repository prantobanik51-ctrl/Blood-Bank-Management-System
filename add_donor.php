<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Donor</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Add New Donor</h1>

    <form action="insert_donor.php" method="POST" class="form">
        <label>First Name</label>
        <input type="text" name="first_name" required>

        <label>Last Name</label>
        <input type="text" name="last_name" required>

        <label>Email</label>
        <input type="email" name="email">

        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Date of Birth</label>
        <input type="date" name="dob" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label>Blood Type</label>
        <select name="blood_type" required>
            <option value="">Select Blood Type</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>

        <label>Address</label>
        <textarea name="address"></textarea>

        <label>City</label>
        <input type="text" name="city">

        <label>Last Donation Date (if any)</label>
        <input type="date" name="last_donation_date">

        <label>Health Conditions</label>
        <textarea name="health_conditions"></textarea>

        <label>Active Donor</label>
        <select name="is_active">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <button type="submit" class="btn">Add Donor</button>
    </form>

    <p><a href="index.php">← Back to List</a></p>
</body>
</html>