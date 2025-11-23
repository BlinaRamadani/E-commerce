<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT id, password FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password (using password_verify for hashed passwords)
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            header('Location: admin.php');
            exit();
        } else {
            $error = 'Invalid username or password';
        }
    } else {
        $error = 'Invalid username or password';
    }
    
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Urban Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-500 to-purple-600 min-h-screen flex items-center justify-center">

<div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
    <div class="text-center mb-8">
        <div class="text-6xl mb-4">🏛️</div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Login</h1>
        <p class="text-gray-600">Urban Service Management System</p>
    </div>

    <?php if ($error): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
            <input
                type="text"
                name="username"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none"
                placeholder="Enter your username"
            />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input
                type="password"
                name="password"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none"
                placeholder="Enter your password"
            />
        </div>

        <button
            type="submit"
            class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg"
        >
            Login
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="index.php" class="text-sm text-indigo-600 hover:text-indigo-700">
            ← Back to Home
        </a>
    </div>

    <div class="mt-8 p-4 bg-gray-50 rounded-lg text-sm text-gray-600">
        <p><strong>Default Login:</strong></p>
        <p>Username: <code class="bg-gray-200 px-2 py-1 rounded">admin</code></p>
        <p>Password: <code class="bg-gray-200 px-2 py-1 rounded">admin123</code></p>
    </div>
</div>

</body>
</html>