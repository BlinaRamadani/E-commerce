<?php
include '../connection.php';
session_start();

// ✅ Check admin session
if (!isset($_SESSION['admin_name'])) {
    header('location:../login.php');
    exit();
}

// ✅ Handle delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query = "DELETE FROM message WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Message deleted successfully!');
                window.location.href='messages.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting message.');
                window.location.href='messages.php';
              </script>";
    }
} else {
    header('location:messages.php');
    exit();
}
?>
