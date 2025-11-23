<?php
include 'connection.php';
session_start();

$error = '';
$success = '';

// Handle Login
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'];

    $select_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('Query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);

        if (password_verify($password, $row['password'])) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('Location: admin_pannel.php');
                exit;
            } else {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('Location: index.php');
                exit;
            }
        } else {
            $error = 'Incorrect password!';
        }
    } else {
        $error = 'Email not found!';
    }
}

// Handle Registration
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, filter_var($_POST['name'], FILTER_SANITIZE_STRING));
    $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('Query failed');
    if (mysqli_num_rows($check_email) > 0) {
        $error = 'Email already exists!';
    } else {
        mysqli_query($conn, "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$password', 'user')") or die('Insert failed');
        $success = 'Registration successful! You can now login.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login / Register</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <!-- Left Panel -->
    <div class="login-left">
        <h1>Urban Service</h1>
        <p>Urban Service Reporting Platform - Report local issues and make your city better with our advanced reporting system.</p>
        <div class="features">
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-paper-plane"></i></div>
                <div>
                    <strong>Easy Reporting</strong>
                    <p style="font-size: 0.9em; opacity: 0.8;">Submit issues in seconds</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-solid fa-chart-line"></i></div>
                <div>
                    <strong>Track Progress</strong>
                    <p style="font-size: 0.9em; opacity: 0.8;">Monitor report status</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon"><i class="fa-regular fa-map"></i></div>
                <div>
                    <strong>Map View</strong>
                    <p style="font-size: 0.9em; opacity: 0.8;">See all reports on map</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="login-right">
        <h2>Welcome Back!</h2>

        <?php if($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <div class="tabs">
            <button class="tab active" onclick="showTab('login')">Login</button>
            <button class="tab" onclick="showTab('register')">Register</button>
        </div>

        <!-- Login Tab -->
        <div id="login" class="tab-content active">
            <form method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
        </div>

        <!-- Register Tab -->
        <div id="register" class="tab-content">
            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="register">Register</button>
            </form>
        </div>
    </div>
</div>

<script>
function showTab(tab) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
    event.target.classList.add('active');
    document.getElementById(tab).classList.add('active');
}
</script>

</body>
</html>
