// Demo data (replace with backend fetch)
const reports = [
  { title: "Network outage", category: "Network", status: "Open", date: "2025-11-18", lat: 42.6629, lng: 21.1655, location: "City Center" },
  { title: "Printer failure", category: "Hardware", status: "In Progress", date: "2025-11-19", lat: 42.6600, lng: 21.1600, location: "Office A" },
  { title: "Login bug", category: "Software", status: "Resolved", date: "2025-11-20", lat: 42.6640, lng: 21.1580, location: "Campus East" },
  { title: "WiFi instability", category: "Network", status: "Resolved", date: "2025-11-21", lat: 42.6662, lng: 21.1701, location: "Tech Park" },
  { title: "Server CPU alert", category: "Hardware", status: "Open", date: "2025-11-22", lat: 42.6612, lng: 21.1715, location: "Data Center" },
];

// Leaderboard demo
const reporters = [
  { name: "Ardit", count: 12 },
  { name: "Bora", count: 9 },
  { name: "Edi", count: 7 },
  { name: "Mira", count: 5 },
];

// Initialize stats
function updateStats() {
  const total = reports.length;
  const resolved = reports.filter(r => r.status === "Resolved").length;
  const progress = reports.filter(r => r.status === "In Progress").length;

  // Simple demo average time (days)
  const avgDays = 2; // Replace with real calculation

  document.getElementById("statTotal").textContent = total;
  document.getElementById("statResolved").textContent = resolved;
  document.getElementById("statProgress").textContent = progress;
  document.getElementById("statAvgTime").textContent = `${avgDays} days`;

  // Progress bar
  const percent = total ? Math.round((resolved / total) * 100) : 0;
  const bar = document.getElementById("progressResolved");
  bar.style.width = `${percent}%`;
  bar.textContent = `${percent}% resolved`;
}

// Notifications
function renderNotifications() {
  const container = document.getElementById("notifications");
  container.innerHTML = "";
  if (reports.length === 0) {
    document.getElementById("emptyState").classList.remove("d-none");
    return;
  }
  document.getElementById("emptyState").classList.add("d-none");

  const latest = [...reports].sort((a,b) => new Date(b.date) - new Date(a.date)).slice(0, 4);
  latest.forEach(r => {
    const icon = r.status === "Resolved" ? "bi-check-circle" :
                 r.status === "In Progress" ? "bi-hourglass-split" : "bi-exclamation-circle";
    const item = document.createElement("div");
    item.className = "list-group-item d-flex align-items-center justify-content-between";
    item.innerHTML = `
      <div class="d-flex align-items-center">
        <i class="bi ${icon} me-2"></i>
        <div>
          <div class="fw-semibold">${r.title}</div>
          <div class="small text-muted">${r.category} • ${r.location}</div>
        </div>
      </div>
      <span class="badge bg-highlight">${r.status}</span>
    `;
    container.appendChild(item);
  });
}

// Leaflet map
let map, markersLayer;
function initMap() {
  map = L.map('map').setView([42.6629, 21.1655], 13);

  // Dark-themed tiles
  L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
    subdomains: 'abcd',
    maxZoom: 19
  }).addTo(map);

  markersLayer = L.layerGroup().addTo(map);
  drawMarkers(reports);
}

function markerColor(status) {
  return status === "Resolved" ? "#6E8CFB" :
         status === "In Progress" ? "#636CCB" : "#ff5f5f";
}

function drawMarkers(data) {
  markersLayer.clearLayers();
  const bounds = [];
  data.forEach(r => {
    const m = L.circleMarker([r.lat, r.lng], {
      radius: 10,
      fillColor: markerColor(r.status),
      color: "#fff",
      weight: 2,
      opacity: 1,
      fillOpacity: 0.9
    }).bindPopup(`
      <strong>${r.title}</strong><br/>
      <span>${r.category} • ${r.status}</span><br/>
      <span class="text-muted">${r.location}</span><br/>
      <small>${r.date}</small>
    `);
    m.addTo(markersLayer);
    bounds.push([r.lat, r.lng]);
  });
  if (bounds.length) map.fitBounds(bounds, { padding: [20, 20] });
}

// Fit map button
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("btnFitMap").addEventListener("click", () => {
    const coords = reports.map(r => [r.lat, r.lng]);
    if (coords.length) map.fitBounds(coords, { padding: [20,20] });
  });
});

// Filters
function applyFilters() {
  const cat = document.getElementById("filterCategory").value;
  const stat = document.getElementById("filterStatus").value;
  const filtered = reports.filter(r =>
    (cat === "All" || r.category === cat) &&
    (stat === "All" || r.status === stat)
  );
  renderTable(filtered);
  drawMarkers(filtered);
  renderChart(filtered);
}
document.getElementById("filterCategory").addEventListener("change", applyFilters);
document.getElementById("filterStatus").addEventListener("change", applyFilters);

// Table
function renderTable(data) {
  const tbody = document.querySelector("#reportsTable tbody");
  tbody.innerHTML = "";
  data.forEach(r => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${r.title}</td>
      <td>${r.category}</td>
      <td><span class="badge ${r.status === "Resolved" ? "bg-highlight" : "text-bg-secondary"}">${r.status}</span></td>
      <td>${r.date}</td>
      <td>${r.location}</td>
    `;
    tbody.appendChild(tr);
  });
}

// Table search
document.getElementById("tableSearch").addEventListener("input", (e) => {
  const q = e.target.value.toLowerCase();
  const filtered = reports.filter(r =>
    r.title.toLowerCase().includes(q) ||
    r.category.toLowerCase().includes(q) ||
    r.status.toLowerCase().includes(q) ||
    r.location.toLowerCase().includes(q) ||
    r.date.toLowerCase().includes(q)
  );
  renderTable(filtered);
  drawMarkers(filtered);
  renderChart(filtered);
});

// Export CSV
document.getElementById("btnExport").addEventListener("click", () => {
  const headers = ["Title","Category","Status","Date","Location","Lat","Lng"];
  const rows = reports.map(r => [r.title, r.category, r.status, r.date, r.location, r.lat, r.lng]);
  const csv = [headers, ...rows].map(r => r.join(",")).join("\n");
  const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url; a.download = "reports.csv";
  a.click();
  URL.revokeObjectURL(url);
});

// Leaderboard
function renderLeaderboard() {
  const list = document.getElementById("leaderboard");
  list.innerHTML = "";
  reporters
    .sort((a, b) => b.count - a.count)
    .slice(0, 5)
    .forEach((u, idx) => {
      const medal = idx === 0 ? "🥇" : idx === 1 ? "🥈" : idx === 2 ? "🥉" : "🏅";
      const li = document.createElement("li");
      li.className = "list-group-item d-flex justify-content-between align-items-center";
      li.innerHTML = `
        <span>${medal} ${u.name}</span>
        <span class="badge">${u.count}</span>
      `;
      list.appendChild(li);
    });
}

// Chart
let chart;
function renderChart(data = reports) {
  const daily = {};
  data.forEach(r => {
    daily[r.date] = (daily[r.date] || 0) + 1;
  });
  const labels = Object.keys(daily).sort();
  const values = labels.map(d => daily[d]);

  const ctx = document.getElementById("reportsChart").getContext("2d");
  if (chart) chart.destroy();
  chart = new Chart(ctx, {
    type: "line",
    data: {
      labels,
      datasets: [{
        label: "Reports",
        data: values,
        tension: 0.35,
        borderColor: "#6E8CFB",
        backgroundColor: "rgba(110,140,251,0.20)",
        fill: true,
        pointBackgroundColor: "#636CCB",
        pointBorderColor: "#fff",
        pointRadius: 4
      }]
    },
    options: {
      plugins: {
        legend: { labels: { color: "#f5f7ff" } }
      },
      scales: {
        x: { ticks: { color: "#cbd2ff" }, grid: { color: "rgba(255,255,255,0.08)" } },
        y: { ticks: { color: "#cbd2ff" }, grid: { color: "rgba(255,255,255,0.08)" }, beginAtZero: true }
      }
    }
  });
}

// Init
document.addEventListener("DOMContentLoaded", () => {
  updateStats();
  renderNotifications();
  initMap();
  renderTable(reports);
  renderLeaderboard();
  renderChart(reports);
});