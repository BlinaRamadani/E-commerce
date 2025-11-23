<?php
include 'connection.php';

// Get all reports with user information
$query = "SELECT cr.*, u.name as reporter_name, u.email as reporter_email 
          FROM city_reports cr 
          LEFT JOIN users u ON cr.user_id = u.id 
          ORDER BY cr.created_at DESC";

$result = mysqli_query($conn, $query);

$reports = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reports[] = $row;
}

// Get statistics
$stats = [
    'total' => mysqli_num_rows(mysqli_query($conn, "SELECT * FROM city_reports")),
    'resolved' => mysqli_num_rows(mysqli_query($conn, "SELECT * FROM city_reports WHERE status='resolved'")),
    'in_progress' => mysqli_num_rows(mysqli_query($conn, "SELECT * FROM city_reports WHERE status='in_progress'")),
    'pending' => mysqli_num_rows(mysqli_query($conn, "SELECT * FROM city_reports WHERE status='pending'"))
];

// Calculate average resolution time
$avg_query = "SELECT AVG(TIMESTAMPDIFF(DAY, created_at, resolved_at)) as avg_days 
              FROM city_reports 
              WHERE status='resolved' AND resolved_at IS NOT NULL";
$avg_result = mysqli_query($conn, $avg_query);
$avg_row = mysqli_fetch_assoc($avg_result);
$stats['avg_resolution_days'] = $avg_row['avg_days'] ? round($avg_row['avg_days'], 1) : 0;

// Get reports by category
$category_query = "SELECT category, COUNT(*) as count FROM city_reports GROUP BY category";
$category_result = mysqli_query($conn, $category_query);
$categories = [];
while ($row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $row;
}

// Get top reporters
$reporters_query = "SELECT u.name, COUNT(cr.id) as report_count 
                    FROM city_reports cr 
                    JOIN users u ON cr.user_id = u.id 
                    GROUP BY u.id 
                    ORDER BY report_count DESC 
                    LIMIT 5";
$reporters_result = mysqli_query($conn, $reporters_query);
$top_reporters = [];
while ($row = mysqli_fetch_assoc($reporters_result)) {
    $top_reporters[] = $row;
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'reports' => $reports,
    'stats' => $stats,
    'categories' => $categories,
    'top_reporters' => $top_reporters
]);

mysqli_close($conn);
?>