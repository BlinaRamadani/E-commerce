<?php
include 'connection.php';

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $details = $_POST['details'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "../uploaded_img/" . $image);

    mysqli_query($conn, "INSERT INTO products (name, price, details, image) VALUES ('$name', '$price', '$details', '$image')");
    header("Location: products.php");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $details = $_POST['details'];
    $image = $_FILES['image']['name'];

    if ($image != "") {
        $image_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($image_tmp, "../uploaded_img/" . $image);
        $query = "UPDATE products SET name='$name', price='$price', details='$details', image='$image' WHERE id=$id";
    } else {
        $query = "UPDATE products SET name='$name', price='$price', details='$details' WHERE id=$id";
    }
    mysqli_query($conn, $query);
    header("Location: products.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: products.php");
    exit;
}
?>
