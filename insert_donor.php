<?php
include 'db_connect.php';

/* Grab form fields */
$first = $conn->real_escape_string($_POST['first_name']);
$last = $conn->real_escape_string($_POST['last_name']);
$email = $conn->real_escape_string($_POST['email']);
$phone = $conn->real_escape_string($_POST['phone']);
$dob = $conn->real_escape_string($_POST['dob']);
$gender = $conn->real_escape_string($_POST['gender']);
$blood_type = $conn->real_escape_string($_POST['blood_type']);
$address = $conn->real_escape_string($_POST['address']);
$city = $conn->real_escape_string($_POST['city']);
$last_donation = $conn->real_escape_string($_POST['last_donation_date']);
$health_conditions = $conn->real_escape_string($_POST['health_conditions']);
$is_active = intval($_POST['is_active']);

/* Insert into DB */
$sql = "INSERT INTO donors 
        (first_name, last_name, email, phone, date_of_birth, gender, blood_type, 
         address, city, last_donation_date, health_conditions, is_active)
        VALUES ('$first', '$last', '$email', '$phone', '$dob', '$gender', '$blood_type',
                '$address', '$city', " . ($last_donation ? "'$last_donation'" : "NULL") . ", 
                '$health_conditions', $is_active)";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");   // back to list
    exit();
} else {
    echo "❌ Error: " . $conn->error;
}
?>