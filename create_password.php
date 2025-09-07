<?php
// Utility to create password hashes
if (isset($_GET['password'])) {
    $password = $_GET['password'];
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    echo "Password: $password<br>";
    echo "Hashed: $hashed";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Password Hash Generator</title>
</head>
<body>
    <form method="GET">
        <input type="text" name="password" placeholder="Enter password">
        <button type="submit">Generate Hash</button>
    </form>
</body>
</html>