<?php
include 'connection.php';
session_start();

// Fetch statistics
$total_reports       = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM maintenance"))['c'];
$resolved_reports    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM maintenance WHERE status IN ('Resolved','Finished')"))['c'];
$in_progress_reports = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM maintenance WHERE status = 'In Progress'"))['c'];
$pending_reports     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM maintenance WHERE status = 'Pending'"))['c'];

// Calculate average resolution time
$avg_query = "SELECT AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours 
              FROM maintenance 
              WHERE status IN ('Resolved','Finished') AND updated_at IS NOT NULL";
$avg_result = mysqli_query($conn, $avg_query);
$avg_row = mysqli_fetch_assoc($avg_result);
$avg_resolution_time = $avg_row && $avg_row['avg_hours'] ? round($avg_row['avg_hours'], 1) . 'h' : '—';

// Fetch all reports
$reports_query = "SELECT m.*, m.reporter_name 
                  FROM maintenance m 
                  ORDER BY m.created_at DESC";
$reports_result = mysqli_query($conn, $reports_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard - Recent Activity</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  

  <style>
    /* Color palette */
:root {
  --primary-bg: #3C467B;   /* deep indigo */
  --secondary-bg: #50589C; /* card background */
  --accent: #636CCB;       /* borders/accents */
  --highlight: #6E8CFB;    /* CTA/highlight */
  --text: #F5F7FF;         /* main text */
  --muted: #CBD2FF;        /* muted text */
}

        * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #E7F2EF;
  color: #19183B;
}

header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #19183B;
  padding: 16px 32px;
  color: #ffffff;
}

.logo h1 {
  font-size: 24px;
  margin: 0;
  color: #ffffff;
}


nav {
  display: flex;
  align-items: center;
  gap: 32px;
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 24px;
  margin: 0;
}

.nav-links a {
  color: #ffffff;
  text-decoration: none;
  padding: 8px 0;
  transition: color 0.3s;
}

.nav-links a:hover {
  color: #A1C2BD;
}

 :root {
    --primary-bg: #3C467B;   /* deep indigo */
    --secondary-bg: #50589C; /* card background */
    --accent: #636CCB;       /* borders/accents */
    --highlight: #6E8CFB;    /* CTA/highlight */
    --text: #F5F7FF;         /* main text */
    --muted: #CBD2FF;        /* muted text */
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  /* City skyline icon using CSS shapes */
  .city {
    display: flex;
    align-items: flex-end;
    gap: 3px;
  }

  .building {
    width: 10px;
    height: 30px;
    background-color: var(--highlight);
    border-radius: 2px 2px 0 0;
    position: relative;
  }

  .building:nth-child(2) {
    height: 45px;
  }

  .building:nth-child(3) {
    height: 35px;
  }

  .building::after {
    content: '';
    position: absolute;
    top: 4px;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 2px;
    background-color: var(--text);
    border-radius: 50%;
  }

  /* Text */
  .logo-text {
    font-size: 2rem;
    font-weight: bold;
    color: var(--text);
  }

  .logo-text span {
    color: var(--highlight);
  }

/* Base */
html, body {
  height: 100%;
}
body {
  font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
  background: linear-gradient(135deg, #333b73 0%, var(--primary-bg) 100%);
  color: var(--text);
}

/* Cards */
.custom-card, .stat-card {
  background-color: var(--secondary-bg);
  border: 1px solid rgba(255,255,255,0.08);
  border-radius: 14px;
  box-shadow: 0 10px 20px rgba(0,0,0,0.25);
}
.card-title {
  color: var(--highlight);
  font-weight: 600;
}

/* Stats cards */
.stat-label {
  color: var(--muted);
  font-size: 0.9rem;
  letter-spacing: 0.3px;
}
.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: var(--text);
}

/* Form + buttons */
.custom-select {
  background-color: #31396f;
  color: var(--text);
  border: 1px solid var(--accent);
  border-radius: 10px;
  transition: 0.25s ease;
}
.custom-select:focus {
  outline: none;
  border-color: var(--highlight);
  box-shadow: 0 0 0 0.2rem rgba(110,140,251,0.25);
}
.btn-outline-accent {
  border-color: var(--accent);
  color: var(--text);
}
.btn-outline-accent:hover {
  background-color: var(--accent);
  color: #0d1030;
}

/* Map */
.map-container {
  height: 320px;
  border-radius: 12px;
  overflow: hidden;
  border: 2px solid var(--accent);
}

/* Progress bar */
.progress {
  background-color: rgba(255,255,255,0.12);
  border-radius: 12px;
}
.progress-bar.bg-highlight {
  background: linear-gradient(90deg, var(--accent), var(--highlight));
  font-weight: 600;
}

/* Empty state */
.empty-state .pulse {
  animation: pulse 2s infinite;
  color: var(--accent);
}
@keyframes pulse {
  0% { transform: scale(1); opacity: 0.6; }
  50% { transform: scale(1.06); opacity: 1; }
  100% { transform: scale(1); opacity: 0.6; }
}

/* Leaderboard */
.leaderboard .list-group-item {
  background: transparent;
  color: var(--text);
  border-color: rgba(255,255,255,0.08);
}
.leaderboard .badge {
  background-color: var(--highlight);
  color: #0d1030;
}

/* Table */
.table thead th {
  color: var(--primary-bg);
  border-bottom-color: rgba(255,255,255,0.08);
}
.table tbody td {
  color: var(--highlight);
  border-top-color: rgba(255,255,255,0.08);
}
.table-hover tbody tr:hover {
  background-color: rgba(255,255,255,0.06);
}

/* Utilities */
.bg-highlight {
  background-color: var(--highlight) !important;
  color: #0d1030 !important;
}
.text-success {
  color: #86f29b !important;
}

footer {
  background-color: #070F2B;
  padding: 20px;
  color: #A1C2BD;
  text-align: center;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  padding: 20px 0;
}

.footer-section {
  width: 30%;
  min-width: 200px;
  margin: 10px 0;
}

.footer-section h3 {
  color: #ffffff;
  margin-bottom: 10px;
}

.footer-section p,
.footer-section ul {
  color: #A1C2BD;
}

.footer-section ul {
  list-style-type: none;
  padding: 0;
}

.footer-section ul li {
  margin: 5px 0;
}

.footer-section ul li a {
  color: #A1C2BD;
  text-decoration: none;
}

.footer-section a img {
  margin: 0 5px;
}

.footer-bottom {
  border-top: 1px solid #A1C2BD;
  padding-top: 10px;
  font-size: 14px;
}

.icon-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #708993;
  color: #ffffff;
  padding: 8px 12px;
  border-radius: 6px;
  text-decoration: none;
  transition: background 0.3s;
}

.icon-btn:hover {
  background: #A1C2BD;
  color: #ffffff;
}

.icon-btn i {
  font-size: 18px;
}
</style>
</head>
<body>
<header>
<div class="logo">
  <div class="city">
    <div class="building"></div>
    <div class="building"></div>
    <div class="building"></div>
  </div>
  <div class="logo-text">Urban <span>Service</span></div>
</div>

        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="report.php">Report</a></li>
                <li><a href="contantus.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>


<div class="container py-4">
  <!-- Stats cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="card stat-card shadow-sm">
        <div class="card-body text-center">
          <div class="stat-label">Total reports</div>
          <div class="stat-value"><?= $total_reports ?></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card stat-card shadow-sm">
        <div class="card-body text-center">
          <div class="stat-label">Resolved</div>
          <div class="stat-value text-success"><?= $resolved_reports ?></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card stat-card shadow-sm">
        <div class="card-body text-center">
          <div class="stat-label">In progress</div>
          <div class="stat-value"><?= $in_progress_reports ?></div>
        </div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="card stat-card shadow-sm">
        <div class="card-body text-center">
          <div class="stat-label">Avg resolution time</div>
          <div class="stat-value"><?= $avg_resolution_time ?></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters + notifications -->
  <div class="row g-3 mb-4">
    <div class="col-md-6">
      <div class="card custom-card h-100">
        <div class="card-body">
          <h4 class="card-title mb-3">Recent activity</h4>
          
          <div class="mt-4">
            <div class="d-flex align-items-center mb-2">
              <span class="badge bg-highlight me-2">Live</span>
              <span class="text-muted small">Latest reports</span>
            </div>
            <div class="list-group list-group-flush">
              <?php 
              $recent_query = "SELECT * FROM maintenance ORDER BY created_at DESC LIMIT 5";
              $recent_result = mysqli_query($conn, $recent_query);
              while($report = mysqli_fetch_assoc($recent_result)): 
              ?>
              <div class="list-group-item" style="background: transparent; color: var(--text); border-color: rgba(255,255,255,0.08);">
                <div class="d-flex justify-content-between">
                  <strong><?= htmlspecialchars($report['description'] ?? 'No title') ?></strong>
                  <small class="text-muted"><?= htmlspecialchars($report['issue_type'] ?? 'Unknown') ?> - <?= htmlspecialchars($report['location']) ?></small>
                </div>
<small class="text-muted"><?= htmlspecialchars($report['issue_type'] ?? 'Other') ?> - <?= htmlspecialchars($report['location']) ?></small>             
             
              </div>
              <?php endwhile; ?>
            </div>
          </div>

          <?php if($total_reports == 0): ?>
          <div class="empty-state text-center mt-5">
            <i class="bi bi-clipboard display-1 pulse"></i>
            <p class="mt-3 fs-6">No reports yet. Be the first to report an issue!</p>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Map -->
    <div class="col-md-6">
      <div class="card custom-card h-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="card-title mb-0">Reported locations</h4>
            <button id="btnFitMap" class="btn btn-sm btn-outline-accent">Fit to markers</button>
          </div>
          <div id="map" class="map-container"></div>
          <div class="mt-3">
            <div class="progress">
              <?php 
              $resolved_percent = $total_reports > 0 ? round(($resolved_reports / $total_reports) * 100) : 0;
              ?>
              <div class="progress-bar bg-highlight" role="progressbar" style="width: <?= $resolved_percent ?>%;">
                <?= $resolved_percent ?>% resolved
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Table -->
  <div class="row g-3">
    <div class="col-12">
      <div class="card custom-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">All reports</h4>
            <input id="tableSearch" type="text" class="form-control custom-select w-auto" placeholder="Search..." />
          </div>
          <div class="table-responsive">
            <table class="table table-hover align-middle" id="reportsTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Location</th>
                  <th>Reporter</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                mysqli_data_seek($reports_result, 0); // Reset pointer
                while($report = mysqli_fetch_assoc($reports_result)): 
                  $status_class = $report['status'] == 'resolved' ? 'success' : ($report['status'] == 'in_progress' ? 'info' : 'warning');
?>
                <tr>
                  <td>#<?= $report['id'] ?></td>
                 <td><?= htmlspecialchars($report['description'] ?? 'No description') ?></td>
                  <td><span class="badge bg-primary"><?= htmlspecialchars($report['issue_type'] ?? 'Other') ?></span></td>  
                  
                  <td><span class="badge bg-<?= $status_class ?>"><?= ucfirst(str_replace('_', ' ', $report['status'])) ?></span></td>
                  <td><?= date('M d, Y', strtotime($report['created_at'])) ?></td>
                  <td><?= htmlspecialchars(substr($report['location'], 0, 30)) ?></td>
                  <td><?= htmlspecialchars($report['reporter_name'] ?? 'Unknown') ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

    <footer>
        <div class="footer-content">
            <div class="footer-section about">
                <h4 style="color: #ffffff;">Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="report.php">Report</a></li>
                    <li><a href="contantus.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section links">
                <h4 style="color: #ffffff;">About Urban Service</h4>
                <p>Urban Service,embodies innovation, connection, and vibrant community energy.</p>
            </div>
            <div class="footer-section social">
                <h4 style="color: #ffffff;">Follow Us</h4>
                <a href="https://facebook.com" target="_blank">
                    <i class="fa-brands fa-facebook"aria-hidden="true" style="color:#ffffff;" ></i>
                </a>
                <a href="https://twitter.com/" target="_blank">
                    <i class="fa-brands fa-twitter" aria-hidden="true" style="color:#ffffff;"></i>
                </a>
                <a href="https://www.instagram.com/" target="_blank">
                    <i class="fa-brands fa-instagram"  aria-hidden="true" style="color:#ffffff;"></i>
                </a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Urban Serve | All rights reserved</p>
        </div>
    </footer>

<!-- Scripts -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
// Initialize map
let map = L.map('map').setView([42.6629, 21.1655], 8);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);

let markers = [];

// Add markers from PHP data
<?php
mysqli_data_seek($reports_result, 0);
while($report = mysqli_fetch_assoc($reports_result)):
    if(!empty($report['location'])):
        $coords = explode(',', $report['location']);
        if(count($coords) == 2):
            $lat = trim($coords[0]);
            $lng = trim($coords[1]);
?>
let marker<?= $report['id'] ?> = L.marker([<?= $lat ?>, <?= $lng ?>])
    .bindPopup(`<strong><?= htmlspecialchars($report['description'] ?? 'Issue Reported') ?></strong><br>
                <em><?= htmlspecialchars($report['issue_type']) ?></em><br>
                Status: <?= ucfirst(str_replace('_', ' ', $report['status'])) ?><br>
                <?= date('M d, Y', strtotime($report['created_at'])) ?>`)
    .addTo(map);
markers.push(marker<?= $report['id'] ?>);
<?php
        endif;
    endif;
endwhile;
?>

// Fit map to markers
if (markers.length > 0) {
  let group = L.featureGroup(markers);
  map.fitBounds(group.getBounds().pad(0.1));
}

document.getElementById('btnFitMap').addEventListener('click', function() {
  if (markers.length > 0) {
    let group = L.featureGroup(markers);
    map.fitBounds(group.getBounds().pad(0.1));
  }
});

// Table search
document.getElementById('tableSearch').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  const rows = document.querySelectorAll('#reportsTable tbody tr');
  
  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(searchTerm) ? '' : 'none';
  });
});

// Export CSV
document.getElementById('btnExport').addEventListener('click', function() {
  let csv = 'ID,Title,Category,Status,Date,Location,Reporter\n';
  const rows = document.querySelectorAll('#reportsTable tbody tr');
  
  rows.forEach(row => {
    const cols = row.querySelectorAll('td');
    const rowData = Array.from(cols).map(col => `"${col.textContent.trim()}"`).join(',');
    csv += rowData + '\n';
  });
  
  const blob = new Blob([csv], { type: 'text/csv' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'city_reports.csv';
  a.click();
});
</script>

</body>
</html>