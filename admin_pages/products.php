<?php
// File: E-commerce/admin_pages/products.php
include '../connection.php';
session_start();

// Require admin
if (!isset($_SESSION['admin_name'])) {
    header('Location: ../login.php');
    exit();
}

// Absolute base path from the web root to this project (change if your folder name differs)
$base = '/E-commerce';

// ---------- ADD PRODUCT ----------
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $details = mysqli_real_escape_string($conn, $_POST['product_detail']);

    $image = $_FILES['image']['name'] ?? '';
    $image_tmp = $_FILES['image']['tmp_name'] ?? '';
    $folder = __DIR__ . '/../uploaded_img/' . $image; // filesystem path

    if (!empty($image) && move_uploaded_file($image_tmp, $folder)) {
        $insert = "INSERT INTO products (name, price, product_detail, image)
                   VALUES ('$name', '$price', '$details', '$image')";
        mysqli_query($conn, $insert);
    }

    header("Location: {$base}/admin_pannel.php");
    exit();
}

// ---------- DELETE PRODUCT ----------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    // delete image file if exists
    $get_img = mysqli_query($conn, "SELECT image FROM products WHERE id=$id LIMIT 1");
    if ($get_img && mysqli_num_rows($get_img) > 0) {
        $img_row = mysqli_fetch_assoc($get_img);
        if (!empty($img_row['image'])) {
            $img_path = __DIR__ . '/../uploaded_img/' . $img_row['image'];
            if (file_exists($img_path)) unlink($img_path);
        }
    }

    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: {$base}/admin_pannel.php");
    exit();
}

// ---------- FETCH PRODUCT TO EDIT ----------
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_query = mysqli_query($conn, "SELECT * FROM products WHERE id=$edit_id LIMIT 1");
    if ($edit_query && mysqli_num_rows($edit_query) > 0) {
        $edit_data = mysqli_fetch_assoc($edit_query);
    }
}

// ---------- UPDATE PRODUCT ----------
if (isset($_POST['update_product'])) {
    $update_id = intval($_POST['update_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $details = mysqli_real_escape_string($conn, $_POST['product_detail']);

    $update_sql = "UPDATE products SET name='$name', price='$price', product_detail='$details'";

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $folder = __DIR__ . '/../uploaded_img/' . $image;
        if (move_uploaded_file($image_tmp, $folder)) {
            $update_sql .= ", image='$image'";
        }
    }

    $update_sql .= " WHERE id=$update_id";
    mysqli_query($conn, $update_sql);

    header("Location: {$base}/admin_pannel.php");
    exit();
}

// ---------- FETCH ALL PRODUCTS ----------
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Manage Products</title>
<style>
/* (your existing styles) */
body{font-family:'Poppins',sans-serif;background:#f0f4f7;margin:0;padding:0}
.main-container{margin:40px auto;width:90%;max-width:1000px;background:#fff;border-radius:20px;box-shadow:0 4px 20px rgba(0,0,0,0.1);padding:30px}
h2{color:#333;margin-bottom:20px;text-align:center}
/* rest omitted for brevity — reuse your styles below if needed */
form{display:flex;gap:10px;flex-wrap:wrap;justify-content:center;margin-bottom:20px}
input[type="text"],input[type="number"],input[type="file"]{padding:10px;border:1px solid #ccc;border-radius:8px;width:200px}
button{background:#009879;color:#fff;border:none;padding:10px 20px;border-radius:8px;cursor:pointer}
table{width:100%;border-collapse:collapse;text-align:center}
th,td{padding:12px;border-bottom:1px solid #ddd}
th{background:#009879;color:#fff}
.btn-edit{background:#f0ad4e;padding:8px 12px;border-radius:8px;color:#fff;text-decoration:none}
.btn-delete{background:#d9534f;padding:8px 12px;border-radius:8px;color:#fff;text-decoration:none}
</style>
</head>
<body>
<div class="main-container">
    <h2>Manage Products</h2>

    <!-- Use absolute path so it works when loaded via admin_pannel.php or directly -->
    <form action="<?= $base ?>/admin_pages/products.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="update_id" value="<?= $edit_data ? htmlspecialchars($edit_data['id']) : ''; ?>">
        <input type="text" name="name" placeholder="Product Name" required value="<?= $edit_data ? htmlspecialchars($edit_data['name']) : ''; ?>">
        <input type="number" name="price" placeholder="Price ($)" required value="<?= $edit_data ? htmlspecialchars($edit_data['price']) : ''; ?>">
        <input type="text" name="product_detail" placeholder="Details" required value="<?= $edit_data ? htmlspecialchars($edit_data['product_detail']) : ''; ?>">
        <input type="file" name="image" <?= $edit_data ? '' : 'required'; ?>>

        <?php if ($edit_data): ?>
            <button type="submit" name="update_product">Update Product</button>
            <a href="<?= $base ?>/admin_pages/products.php" style="text-decoration:none;">
                <button type="button" style="background:#6c757d;color:#fff;border:none;padding:10px 15px;border-radius:8px">Cancel</button>
            </a>
        <?php else: ?>
            <button type="submit" name="add_product">+ Add Product</button>
        <?php endif; ?>
    </form>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Price ($)</th><th>Details</th><th>Image</th><th>Actions</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']); ?></td>
                <td><?= htmlspecialchars($row['name']); ?></td>
                <td><?= htmlspecialchars($row['price']); ?></td>
                <td><?= htmlspecialchars($row['product_detail']); ?></td>
                <td>
                    <?php if (!empty($row['image']) && file_exists(__DIR__ . '/../uploaded_img/' . $row['image'])): ?>
                        <img src="<?= $base ?>/uploaded_img/<?= htmlspecialchars($row['image']); ?>" width="60" height="60" alt="">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= $base ?>/admin_pages/products.php?edit=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                    <a href="<?= $base ?>/admin_pages/products.php?delete=<?= $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
