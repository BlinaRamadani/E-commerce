<?php
include '../connection.php';

// Counts for cards
$product_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
$user_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$order_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `order`"));
$message_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM message"));
?>

<h3 class="mb-4">Dashboard Overview</h3>
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
