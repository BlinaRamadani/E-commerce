<?php
include 'connection.php';
session_start();

$admin_id = $_SESSION['admin_name'] ?? null;
if (!$admin_id) {
    header('location:register.php');
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location:login.php');
    exit();
}

// Dashboard summary counts
$product_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
$user_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$order_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `order`"));
$message_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM message"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    background-color: #f0f2f5;
    font-family: 'Poppins', sans-serif;
}
.sidebar {
    width: 240px;
    background: #19183B;
    min-height: 100vh;
    color: white;
    position: fixed;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.sidebar a {
    color: white;
    text-decoration: none;
    display: block;
    padding: 12px 20px;
    border-radius: 8px;
    margin: 5px 10px;
    transition: all 0.3s ease;
}
.sidebar a:hover, .sidebar a.active {
    background-color: #3b3a59;
}
.main-content {
    margin-left: 260px;
    padding: 30px;
    min-height: 100vh;
}
.card-dashboard {
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    color: #fff;
    padding: 20px;
    text-align: center;
}
.card-dashboard i {
    font-size: 2rem;
    margin-bottom: 10px;
}
.bg-blue { background-color: #3b82f6; }
.bg-green { background-color: #22c55e; }
.bg-pink { background-color: #ec4899; }
.bg-dark { background-color: #1f2937; }


</style>
</head>
<body>

<div class="sidebar">
    <div>
        <div class="text-center my-4">
            <h4>Admin Dashboard</h4>
            <small class="text-secondary">Welcome, <?= htmlspecialchars($admin_id) ?></small>
        </div>
        <a href="#" class="active" data-page="dashboard"><i class="fas fa-th-large me-2"></i> Dashboard</a>
        <a href="#" data-page="products"><i class="fas fa-box me-2"></i> Products</a>
        <a href="#" data-page="orders"><i class="fas fa-shopping-cart me-2"></i> Orders</a>
        <a href="#" data-page="users"><i class="fas fa-users me-2"></i> Users</a>
        <a href="#" data-page="messages"><i class="fas fa-envelope me-2"></i> Messages</a>
    </div>
    <form method="post" class="mb-4 text-center">
        <button name="logout" class="btn btn-danger btn-sm w-75">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </button>
    </form>
</div>

<div class="main-content" id="content-area">
    <!-- Default Dashboard -->
    <h3 class="mb-4">Dashboard</h3>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card-dashboard bg-dark">
                <i class="fas fa-box"></i>
                <h3><?= $product_count ?></h3>
                <p>Products</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-dashboard bg-blue">
                <i class="fas fa-shopping-cart"></i>
                <h3><?= $order_count ?></h3>
                <p>Orders</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-dashboard bg-green">
                <i class="fas fa-users"></i>
                <h3><?= $user_count ?></h3>
                <p>Users</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-dashboard bg-pink">
                <i class="fas fa-envelope"></i>
                <h3><?= $message_count ?></h3>
                <p>Messages</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar navigation with AJAX content loading
document.querySelectorAll('.sidebar a[data-page]').forEach(link => {
    link.addEventListener('click', async e => {
        e.preventDefault();
        document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));
        link.classList.add('active');

        const page = link.getAttribute('data-page');
        const contentArea = document.getElementById('content-area');
        contentArea.innerHTML = '<div class="text-center my-5"><div class="spinner-border text-primary"></div><p>Loading...</p></div>';

        try {
            const response = await fetch('admin_pages/' + page + '.php');
            const html = await response.text();
            contentArea.innerHTML = html;
        } catch (error) {
            contentArea.innerHTML = '<div class="alert alert-danger mt-5 text-center">Failed to load content.</div>';
        }
    });
});

// Load dashboard by default on page load
window.addEventListener('DOMContentLoaded', () => {
    document.querySelector('.sidebar a[data-page="dashboard"]').click();
});
</script>

</body>
</html>
