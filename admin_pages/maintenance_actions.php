<?php
// Connect to database
include '../connection.php';

// Only run if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data safely
    $type     = isset($_POST['issue_type']) ? trim($_POST['issue_type']) : '';
    $desc     = isset($_POST['description']) ? trim($_POST['description']) : '';
    $status   = 'Pending'; // default status
    $location = isset($_POST['location']) ? trim($_POST['location']) : '';

    // Validate required fields
    if ($type === '' || $desc === '' || $location === '') {
        die("Error: All fields are required.");
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO maintenance (issue_type, description, status, location) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters (all strings)
    $stmt->bind_param("ssss", $type, $desc, $status, $location);

    // Execute query
    if ($stmt->execute()) {
        // Success → redirect back to maintenance page
        header("Location: maintenance.php");
        exit();
    } else {
        // Error inserting
        die("Error inserting issue: " . $stmt->error);
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>