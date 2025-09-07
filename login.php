<?php
session_start();
include 'db_connect.php';

$error = '';

// Check if users table exists
$table_check = $conn->query("SHOW TABLES LIKE 'users'");
if ($table_check->num_rows === 0) {
    $error = "Database configuration issue. The users table doesn't exist.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $conn->prepare("SELECT user_id, username, password_hash, full_name, role FROM users WHERE username = ? AND is_active = 1");
            
            if ($stmt === false) {
                throw new Exception("Database error: " . $conn->error);
            }
            
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // Simple password comparison (plain text)
                if ($password === $user['password_hash']) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['logged_in'] = true;
                    
                    // Redirect to the requested page or default to dashboard
                    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard.php';
                    header("Location: $redirect");
                    exit();
                } else {
                    $error = "Invalid username or password.";
                }
            } else {
                $error = "Invalid username or password.";
            }
        } catch (Exception $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        $error = "Please enter both username and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login • Blood Bank Management</title>
    <link rel="stylesheet" href="css/css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .login-header h1 {
            color: var(--primary);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .error {
            color: var(--danger);
            margin-bottom: 15px;
            text-align: center;
            padding: 10px;
            background-color: #ffebee;
            border-radius: 4px;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: var(--gray);
        }
        
        .setup-info {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🔒 Blood Bank Management System</h1>
            <p>Login to access the system</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if (isset($table_check) && $table_check->num_rows === 0): ?>
            <div class="setup-info">
                <strong>Setup Required:</strong> 
                <pre>
                </pre>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn" style="width: 100%;">Login</button>
        </form>
        
        <div class="login-footer">
            <p>Try these credentials:</p>
            <p>Username: <strong>admin</strong> | Password: <strong>admin123</strong></p>
            <p>Username: <strong>staff</strong> | Password: <strong>staff123</strong></p>
            <p><a href="index.php">← Back to Home</a></p>
        </div>
    </div>
</body>
</html>