<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../connection.php';

// FIXED: Show ALL reports, not just where issue_type = 'maintenance'
$issues = mysqli_query($conn, "SELECT * FROM maintenance ORDER BY created_at DESC")
    or die("Query failed: " . mysqli_error($conn));
?>
<h3 class="mb-4">Maintenance Issues</h3>

<!-- Table of issues -->
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
            <?php if ($issues && mysqli_num_rows($issues) > 0): ?>
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
            <?php else: ?>
                <tr><td colspan="6" class="text-center">No issues reported yet</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Map container -->
<div id="map" style="height: 500px; border-radius: 12px;"></div>

<!-- Leaflet CSS and JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Initialize map
const map = L.map('map').setView([42.6629, 21.1655], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Define colored icons
const redIcon = new L.Icon({
    iconUrl: 'https://maps.gstatic.com/mapfiles/ms2/micons/red-dot.png',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32]
});
const blueIcon = new L.Icon({
    iconUrl: 'https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32]
});
const greenIcon = new L.Icon({
    iconUrl: 'https://maps.gstatic.com/mapfiles/ms2/micons/green-dot.png',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
    popupAnchor: [0, -32]
});

// Add legend
const legend = L.control({position: 'bottomright'});
legend.onAdd = function (map) {
    const div = L.DomUtil.create('div', 'info legend');
    div.innerHTML = `
        <h6>Status Legend</h6>
        <p><img src="https://maps.gstatic.com/mapfiles/ms2/micons/red-dot.png" style="height:16px;"> Pending</p>
        <p><img src="https://maps.gstatic.com/mapfiles/ms2/micons/blue-dot.png" style="height:16px;"> In Progress</p>
        <p><img src="https://maps.gstatic.com/mapfiles/ms2/micons/green-dot.png" style="height:16px;"> Finished</p>
    `;
    div.style.background = 'white';
    div.style.padding = '8px';
    div.style.borderRadius = '6px';
    div.style.boxShadow = '0 0 6px rgba(0,0,0,0.3)';
    return div;
};
legend.addTo(map);

// Add markers from PHP
<?php
if ($issues && mysqli_num_rows($issues) > 0) {
    mysqli_data_seek($issues, 0);
    while ($row = mysqli_fetch_assoc($issues)):
        $coords = explode(',', $row['location']);
        if (count($coords) == 2):
            $lat = floatval($coords[0]);
            $lng = floatval($coords[1]);
            $status = strtolower($row['status']);
            $popup = "<strong>" . htmlspecialchars($row['issue_type']) . "</strong><br>" .
                     htmlspecialchars($row['description']) . "<br>Status: " .
                     htmlspecialchars($row['status']);
            $iconVar = 'redIcon';
            if ($status === 'in progress') $iconVar = 'blueIcon';
            if ($status === 'finished') $iconVar = 'greenIcon';
?>
L.marker([<?= $lat ?>, <?= $lng ?>], {icon: <?= $iconVar ?>}).addTo(map)
    .bindPopup(`<?= $popup ?>`);
<?php
        endif;
    endwhile;
}
?>
</script>