<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Admin Header</title>
</head>
<body>
    <header class="header">
        <div class="flex">
            <a href="admin_panel.php" class="logo">
                <img src="img/logo.png" alt="Logo">
            </a>

            <nav class="navbar">
                <a href="admin_pannel.php">Home</a>
                <a href="admin_product.php">Products</a>
                <a href="admin_order.php">Orders</a>
                <a href="admin_user.php">Users</a>
                <a href="admin_message.php">Messages</a>
            </nav>

            <div class="icons">
                <i class="fa-solid fa-user" id="user-btn"></i>
                <i class="fa-solid fa-bars" id="menu-btn"></i>
            </div>

            <div class="user-box">
                <p>Username: <span><?php echo $_SESSION['admin_name']; ?></span></p>
                <p>Email: <span><?php echo $_SESSION['admin_email']; ?></span></p>
                <form method="post">
                    <button type="submit" class="logout-btn">Log out</button>
                </form>
            </div>
        </div>
    </header>

    <div class="bnner">
        <div class="detail">
            <h1>Admin Dashboard</h1>
            <p>Welcome to the admin panel. Manage products, orders, users, and messages easily.</p>
        </div>
    </div>

    <div class="line"></div>
</body>
</html>
