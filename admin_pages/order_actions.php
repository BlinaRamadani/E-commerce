<?php
include '../connection.php';

$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $user_id = (int)$_POST['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $total_products = mysqli_real_escape_string($conn, $_POST['total_products']);
    $total_price = (float)$_POST['total_price'];
    $placed_on = mysqli_real_escape_string($conn, $_POST['placed_on']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);

    $query = "INSERT INTO `order` (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status)
              VALUES ($user_id, '$name', '$number', '$email', '$method', '$address', '$total_products', $total_price, '$placed_on', '$payment_status')";
    
    if (mysqli_query($conn, $query)) {
        echo "✅ New order added successfully!";
    } else {
        echo "❌ Error adding order: " . mysqli_error($conn);
    }
}

elseif ($action === 'update') {
    $id = (int)$_POST['id'];
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);
    $query = "UPDATE `order` SET payment_status='$payment_status' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "✅ Payment status updated successfully!";
    } else {
        echo "❌ Error updating order: " . mysqli_error($conn);
    }
}

elseif ($action === 'delete') {
    $id = (int)$_POST['id'];
    $query = "DELETE FROM `order` WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        echo "🗑️ Order deleted successfully!";
    } else {
        echo "❌ Error deleting order: " . mysqli_error($conn);
    }
} 

else {
    echo "❌ Invalid action.";
}
?>
