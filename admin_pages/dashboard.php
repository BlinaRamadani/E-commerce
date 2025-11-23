<?php
include '../connection.php';

$maintenance_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM maintenance"));
$sanitation_count  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM maintenance WHERE photo IS NOT NULL AND photo != ''"))['total'];
$user_count        = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$message_count     = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM message"));
?>

<h3 class="mb-4">Dashboard Overview</h3>
<div class="row g-4">
    <div class="col-md-3">
        <div class="card-dashboard bg-dark">
            <i class="fas fa-tools"></i>
            <h3><?= $maintenance_count ?></h3>
            <p>Maintenance Issues</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card-dashboard bg-blue">
            <i class="fa-solid fa-photo-film"></i>
            <h3><?= $sanitation_count ?></h3>
            <p>Reports with Photos</p>
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