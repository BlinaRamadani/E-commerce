<?php
include '../connection.php';
session_start();


if (!isset($_SESSION['admin_name'])) {
    header('location:../login.php');
    exit();
}


$messages = mysqli_query($conn, "SELECT * FROM message ORDER BY id DESC");
?>

<h3 class="mb-4">User Messages</h3>

<div class="table-responsive">
<table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Number</th>
            <th>Message</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($msg = mysqli_fetch_assoc($messages)) { ?>
        <tr>
            <td><?= $msg['id'] ?></td>
            <td><?= $msg['user_id'] ?></td>
            <td><?= htmlspecialchars($msg['name']) ?></td>
            <td><?= htmlspecialchars($msg['email']) ?></td>
            <td><?= htmlspecialchars($msg['number']) ?></td>
            <td><?= htmlspecialchars($msg['message']) ?></td>
            <td><?= isset($msg['created_at']) ? $msg['created_at'] : '-' ?></td>
            <td>
                
               <a href="admin_pages/message_actions.php?action=delete&id=<?= $msg['id'] ?>" 
   class="btn btn-sm btn-danger"
   onclick="return confirm('Delete this message?')">
   <i class="fas fa-trash"></i> Delete
</a>

            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>

<style>


    


body {
    background-color: #eef0f3;
    font-family: 'Poppins', sans-serif;
}


h3.mb-4 {
    font-size: 30px;
    font-weight: 600;
    color: #222;
    margin: 30px 0 25px 10px;
}


.table-responsive {
    background: transparent;
    padding: 10px 20px;
}


table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}


thead.table-dark {
    background-color: #1f1f1f !important;
    color: #fff;
}

thead th {
    padding: 16px 14px;
    font-size: 16px;
    font-weight: 600;
    text-align: left;
    border: none;
}


tbody td {
    padding: 14px 14px;
    font-size: 15px;
    color: #333;
    border-top: 1px solid #e2e2e2;
}

tbody tr:hover {
    background-color: #f6f6f6;
    transition: 0.3s ease;
}


.btn-danger {
    background-color: #dc3545 !important;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 14px;
    color: #fff !important;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background-color: #b02a37 !important;
}


thead th:first-child {
    border-top-left-radius: 12px;
}

thead th:last-child {
    border-top-right-radius: 12px;
}


main, .main-content, .content {
    padding: 40px;
}


@media (max-width: 768px) {
    table {
        font-size: 13px;
    }
    thead th, tbody td {
        padding: 10px;
    }
}

</style>