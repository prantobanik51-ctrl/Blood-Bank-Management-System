<?php
include 'db_connect.php';

// Check if users table exists
$table_check = $conn->query("SHOW TABLES LIKE 'users'");

if ($table_check->num_rows === 0) {
    // Create users table
    $sql = "CREATE TABLE users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password_hash VARCHAR(255) NOT NULL,
        full_name VARCHAR(100) NOT NULL,
        role ENUM('Admin', 'Staff') DEFAULT 'Staff',
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql)) {
        echo "Users table created successfully.<br>";
        
        // Insert default users
        $insert_sql = "INSERT INTO users (username, password_hash, full_name, role) VALUES
        ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 'Admin'),
        ('staff', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'General Staff', 'Staff')";
        
        if ($conn->query($insert_sql)) {
            echo "Default users added successfully.<br>";
            echo "You can now <a href='login.php'>login</a> with username 'admin' and password 'admin123'.";
        } else {
            echo "Error adding users: " . $conn->error;
        }
    } else {
        echo "Error creating table: " . $conn->error;
    }
} else {
    echo "Users table already exists. <a href='login.php'>Go to login</a>.";
}
?>