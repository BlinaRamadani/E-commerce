<?php
include '../connection.php';

$action = $_POST['action'] ?? '';

if ($action === 'add') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    mysqli_query($conn, "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
    echo "✅ User added successfully!";
}

elseif ($action === 'edit') {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    mysqli_query($conn, "UPDATE users SET name='$name', email='$email', role='$role' WHERE id=$id");
    echo "✅ User updated successfully!";
}

elseif ($action === 'delete') {
    $id = (int)$_POST['id'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    echo "🗑️ User deleted successfully!";
}

else {
    echo "❌ Invalid action.";
}
?>