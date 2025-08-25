<?php
include 'db_connect.php';

/* Gather POST data safely */
$id = intval($_POST['id']);
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

$sql = "UPDATE donors SET
            first_name = '$first',
            last_name = '$last',
            email = '$email',
            phone = '$phone',
            date_of_birth = '$dob',
            gender = '$gender',
            blood_type = '$blood_type',
            address = '$address',
            city = '$city',
            last_donation_date = " . ($last_donation ? "'$last_donation'" : "NULL") . ",
            health_conditions = '$health_conditions',
            is_active = $is_active
        WHERE donor_id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit();
} else {
    echo "❌ Error updating record: " . $conn->error;
}
?>