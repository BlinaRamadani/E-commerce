<?php
include '../connection.php';

// Fetch all maintenance issues
$issues = mysqli_query($conn, "SELECT * FROM maintenance");
?>

<h3 class="mb-4">Maintenance Issues</h3>

<!-- Table of reported issues -->
<div class="table-responsive mb-5">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Description</th>
                <th>Status</th>
                <th>Location</th>
                <th>Reported At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($issues)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['issue_type']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['location']) ?></td>
                <td><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Map showing issue locations -->
<div id="map" style="height: 500px; border-radius: 12px;"></div>

<!-- Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Initialize map
const map = L.map('map').setView([42.6629, 21.1655], 13); // Centered on Pristina

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Add markers from PHP
<?php
mysqli_data_seek($issues, 0); // Reset pointer
while ($row = mysqli_fetch_assoc($issues)):
    // Extract lat/lng from location string (e.g., "42.6621,21.1600")
    $coords = explode(',', $row['location']);
    if (count($coords) == 2):
        $lat = floatval($coords[0]);
        $lng = floatval($coords[1]);
        $popup = "<strong>" . htmlspecialchars($row['issue_type']) . "</strong><br>" .
                 htmlspecialchars($row['description']) . "<br>Status: " .
                 htmlspecialchars($row['status']);
?>
L.marker([<?= $lat ?>, <?= $lng ?>]).addTo(map)
    .bindPopup(`<?= $popup ?>`);
<?php
    endif;
endwhile;
?>
</script>