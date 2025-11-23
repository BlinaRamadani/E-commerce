<?php
include 'connection.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $latitude = isset($_POST['latitude']) ? floatval($_POST['latitude']) : null;
    $longitude = isset($_POST['longitude']) ? floatval($_POST['longitude']) : null;
    $urgency = mysqli_real_escape_string($conn, $_POST['urgency']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $photo = isset($_POST['photo']) ? $_POST['photo'] : null;

    // Insert into database
    $query = "INSERT INTO city_reports (user_id, category, title, description, location, latitude, longitude, urgency, photo, status, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issssddss", $user_id, $category, $title, $description, $location, $latitude, $longitude, $urgency, $photo);

    if (mysqli_stmt_execute($stmt)) {
        $report_id = mysqli_insert_id($conn);
        echo json_encode([
            'success' => true, 
            'message' => 'Report submitted successfully!',
            'reference_number' => $report_id
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Error: ' . mysqli_error($conn)
        ]);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>