// Initialize map
let map = L.map('map').setView([42.6629, 21.1655], 8); // Kosovo coordinates
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap contributors'
}).addTo(map);

let markers = [];
let allReports = [];
let reportsChart;

// Fetch and display reports
async function loadReports() {
  try {
    const response = await fetch('get_reports_data.php');
    const data = await response.json();
    
    allReports = data.reports;
    
    // Update statistics
    updateStats(data.stats);
    
    // Update map
    updateMap(data.reports);
    
    // Update table
    updateTable(data.reports);
    
    // Update chart
    updateChart(data.reports);
    
    // Update leaderboard
    updateLeaderboard(data.top_reporters);
    
    // Update notifications
    updateNotifications(data.reports);
    
  } catch (error) {
    console.error('Error loading reports:', error);
    document.getElementById('emptyState').classList.remove('d-none');
  }
}

// Update statistics cards
function updateStats(stats) {
  document.getElementById('statTotal').textContent = stats.total;
  document.getElementById('statResolved').textContent = stats.resolved;
  document.getElementById('statProgress').textContent = stats.in_progress;
  
  const avgTime = stats.avg_resolution_days > 0 
    ? `${stats.avg_resolution_days}d` 
    : '—';
  document.getElementById('statAvgTime').textContent = avgTime;
  
  // Update progress bar
  const resolvedPercent = stats.total > 0 
    ? Math.round((stats.resolved / stats.total) * 100) 
    : 0;
  const progressBar = document.getElementById('progressResolved');
  progressBar.style.width = resolvedPercent + '%';
  progressBar.textContent = resolvedPercent + '% resolved';
}

// Update map with markers
function updateMap(reports) {
  // Clear existing markers
  markers.forEach(marker => map.removeLayer(marker));
  markers = [];
  
  reports.forEach(report => {
    if (report.latitude && report.longitude) {
      const marker = L.marker([report.latitude, report.longitude])
        .bindPopup(`
          <strong>${report.title}</strong><br>
          <em>${report.category}</em><br>
          Status: ${report.status}<br>
          ${report.created_at}
        `)
        .addTo(map);
      markers.push(marker);
    }
  });
  
  // Fit map to markers
  if (markers.length > 0) {
    const group = L.featureGroup(markers);
    map.fitBounds(group.getBounds().pad(0.1));
  }
}

// Update reports table
function updateTable(reports) {
  const tbody = document.querySelector('#reportsTable tbody');
  tbody.innerHTML = '';
  
  reports.forEach(report => {
    const row = document.createElement('tr');
    
    const statusBadge = getStatusBadge(report.status);
    const urgencyColor = getUrgencyColor(report.urgency);
    
    row.innerHTML = `
      <td>${report.title}</td>
      <td><span class="badge" style="background:${urgencyColor}">${report.category}</span></td>
      <td>${statusBadge}</td>
      <td>${new Date(report.created_at).toLocaleDateString()}</td>
      <td>${report.location}</td>
    `;
    
    tbody.appendChild(row);
  });
}

// Update chart
function updateChart(reports) {
  // Group reports by date
  const dateGroups = {};
  reports.forEach(report => {
    const date = new Date(report.created_at).toLocaleDateString();
    dateGroups[date] = (dateGroups[date] || 0) + 1;
  });
  
  const dates = Object.keys(dateGroups).slice(0, 7).reverse();
  const counts = dates.map(date => dateGroups[date]);
  
  const ctx = document.getElementById('reportsChart').getContext('2d');
  
  if (reportsChart) {
    reportsChart.destroy();
  }
  
  reportsChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: dates,
      datasets: [{
        label: 'Reports',
        data: counts,
        borderColor: '#6E8CFB',
        backgroundColor: 'rgba(110, 140, 251, 0.1)',
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
}

// Update leaderboard
function updateLeaderboard(reporters) {
  const leaderboard = document.getElementById('leaderboard');
  leaderboard.innerHTML = '';
  
  reporters.forEach((reporter, index) => {
    const li = document.createElement('li');
    li.className = 'list-group-item d-flex justify-content-between align-items-center';
    li.innerHTML = `
      <span>${index + 1}. ${reporter.name}</span>
      <span class="badge">${reporter.report_count} reports</span>
    `;
    leaderboard.appendChild(li);
  });
}

// Update notifications
function updateNotifications(reports) {
  const notifications = document.getElementById('notifications');
  const recentReports = reports.slice(0, 5);
  
  notifications.innerHTML = '';
  
  recentReports.forEach(report => {
    const div = document.createElement('div');
    div.className = 'list-group-item';
    div.innerHTML = `
      <div class="d-flex justify-content-between">
        <strong>${report.title}</strong>
        <small class="text-muted">${getTimeAgo(report.created_at)}</small>
      </div>
      <small class="text-muted">${report.category} - ${report.location}</small>
    `;
    notifications.appendChild(div);
  });
}

// Helper functions
function getStatusBadge(status) {
  const badges = {
    'pending': '<span class="badge bg-warning text-dark">Pending</span>',
    'in_progress': '<span class="badge bg-info">In Progress</span>',
    'resolved': '<span class="badge bg-success">Resolved</span>'
  };
  return badges[status] || status;
}

function getUrgencyColor(urgency) {
  const colors = {
    'low': '#10b981',
    'medium': '#f59e0b',
    'high': '#ef4444'
  };
  return colors[urgency] || '#6b7280';
}

function getTimeAgo(dateString) {
  const date = new Date(dateString);
  const now = new Date();
  const seconds = Math.floor((now - date) / 1000);
  
  if (seconds < 60) return 'Just now';
  if (seconds < 3600) return Math.floor(seconds / 60) + 'm ago';
  if (seconds < 86400) return Math.floor(seconds / 3600) + 'h ago';
  return Math.floor(seconds / 86400) + 'd ago';
}

// Filters
document.getElementById('filterCategory').addEventListener('change', applyFilters);
document.getElementById('filterStatus').addEventListener('change', applyFilters);

function applyFilters() {
  const categoryFilter = document.getElementById('filterCategory').value;
  const statusFilter = document.getElementById('filterStatus').value;
  
  let filtered = allReports;
  
  if (categoryFilter !== 'All') {
    filtered = filtered.filter(r => r.category === categoryFilter);
  }
  
  if (statusFilter !== 'All') {
    filtered = filtered.filter(r => r.status === statusFilter.toLowerCase().replace(' ', '_'));
  }
  
  updateTable(filtered);
  updateMap(filtered);
}

// Table search
document.getElementById('tableSearch').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  const filtered = allReports.filter(report => 
    report.title.toLowerCase().includes(searchTerm) ||
    report.category.toLowerCase().includes(searchTerm) ||
    report.location.toLowerCase().includes(searchTerm)
  );
  updateTable(filtered);
});

// Fit map button
document.getElementById('btnFitMap').addEventListener('click', function() {
  if (markers.length > 0) {
    const group = L.featureGroup(markers);
    map.fitBounds(group.getBounds().pad(0.1));
  }
});

// Export CSV
document.getElementById('btnExport').addEventListener('click', function() {
  let csv = 'Title,Category,Status,Date,Location\n';
  allReports.forEach(report => {
    csv += `"${report.title}","${report.category}","${report.status}","${report.created_at}","${report.location}"\n`;
  });
  
  const blob = new Blob([csv], { type: 'text/csv' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'reports.csv';
  a.click();
});

// Load reports on page load
loadReports();

// Auto-refresh every 30 seconds
setInterval(loadReports, 30000);