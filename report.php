<?php
session_start();
include 'connection.php';

// Handle form submission
$submitted = false;
$referenceNumber = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (!empty($_POST['category']) && !empty($_POST['title']) && 
        !empty($_POST['description']) && !empty($_POST['location']) && 
        !empty($_POST['name']) && !empty($_POST['email'])) {
        
       include 'connection.php'; // ADD THIS AT TOP if not already there

        // Generate unique reference number
        $referenceNumber = '#' . rand(10000, 99999);

        // Clean and escape inputs
        $category     = mysqli_real_escape_string($conn, $_POST['category']);
        $title        = mysqli_real_escape_string($conn, $_POST['title']);
        $description  = mysqli_real_escape_string($conn, $_POST['description']);
        $location     = mysqli_real_escape_string($conn, $_POST['location']); // This will be "lat, lng" from map
        $urgency      = $_POST['urgency'] ?? 'low';
        $name         = mysqli_real_escape_string($conn, $_POST['name']);
        $email        = mysqli_real_escape_string($conn, $_POST['email']);
        $phone        = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');

        // Set issue_type based on category (or keep category name)
        $issue_type = $category; // or map to friendly name if you want

        // Handle photo
        $photo_path = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $photo_path = $uploadDir . time() . '_' . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
        }

        // Insert into maintenance table
        $query = "INSERT INTO maintenance 
            (issue_type, description, status, location, photo, reporter_name, reporter_email, reporter_phone, reference_number) 
            VALUES (?, ?, 'Pending', ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssss", $issue_type, $description, $location, $photo_path, $name, $email, $phone, $referenceNumber);

        if (mysqli_stmt_execute($stmt)) {
            $submitted = true;
        } else {
            echo "Database error: " . mysqli_error($conn);
            $submitted = false;
        }
        mysqli_stmt_close($stmt);
        
        // Handle file upload if provided
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . basename($_FILES['photo']['name']);
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $fileName);
        }
    }
}

$categories = [
    ['id' => 'pothole', 'label' => 'Potholes & Road Damage', 'icon' => '🚧', 'color' => 'bg-orange-500'],
    ['id' => 'streetlight', 'label' => 'Broken Streetlight', 'icon' => '💡', 'color' => 'bg-yellow-500'],
    ['id' => 'trash', 'label' => 'Illegal Dumping/Trash', 'icon' => '🗑️', 'color' => 'bg-green-500'],
    ['id' => 'graffiti', 'label' => 'Graffiti/Vandalism', 'icon' => '⚠️', 'color' => 'bg-red-500'],
    ['id' => 'tree', 'label' => 'Tree/Vegetation Issue', 'icon' => '🌲', 'color' => 'bg-emerald-500'],
    ['id' => 'other', 'label' => 'Other Issue', 'icon' => '❗', 'color' => 'bg-gray-500']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a City Issue</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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

#hero-jewellery {
  position: relative;
  background-image: url('img/index.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  color: #ffffff;
  padding: 190px 0;
  text-align: center;
  overflow: hidden;
}

#hero-jewellery::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7); 
  z-index: 0;
}

#hero-jewellery * {
  position: relative;
  z-index: 1;
}

#hero-jewellery h2 {
  font-size: 32px;
  margin-bottom: 16px;
}

#hero-jewellery p {
  font-size: 18px;
  margin-bottom: 24px;
}


.btn {
  background-color: #19183B;
  color: #ffffff;
  padding: 13px 32px;
  text-decoration: none;
  border-radius: 4px;
  font-weight: bold;
  transition: background 0.3s;
}

.btn:hover {
  background-color:   #708993;
  color: #ffffff;
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

        <section id="hero-jewellery">
        <div class="content">
            <h2>See. Report. Improve.</h2>
            <p>Helping your city thrive,one issue at a time.</p><br>
            <a href="contantus.php" class="btn">Contact Us</a>
        </div>
    </section>

<br><br>
<class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Success Message -->
        <?php if ($submitted): ?>
        <div class="mb-6 bg-green-50 border-2 border-green-500 rounded-xl p-6 text-center">
            <div class="text-6xl mb-4">✅</div>
            <h2 class="text-2xl font-bold text-green-800 mb-2">Report Submitted Successfully!</h2>
            <p class="text-green-700 mb-3">Reference Number: <span class="font-mono font-bold"><?php echo $referenceNumber; ?></span></p>
            <p class="text-green-600">You'll receive updates via email about the status of your report.</p>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Submit Another Report
            </a>
        </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="flex items-center justify-center mb-4">
                <div class="text-6xl">📍</div>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Report a City Issue</h1>
            <p class="text-lg text-gray-600">Help us keep our community safe and clean by reporting issues in your neighborhood</p>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" enctype="multipart/form-data" id="reportForm">
                <!-- Category Selection -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">What would you like to report?</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($categories as $cat): ?>
                        <label class="category-btn cursor-pointer p-4 rounded-xl border-2 border-gray-200 block">
                            <input type="radio" name="category" value="<?php echo $cat['id']; ?>" class="hidden category-input" required>
                            <div class="<?php echo $cat['color']; ?> w-12 h-12 rounded-lg flex items-center justify-center mx-auto mb-2 text-2xl">
                                <?php echo $cat['icon']; ?>
                            </div>
                            <span class="text-sm font-medium text-gray-700 block text-center"><?php echo $cat['label']; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Issue Details -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Issue Title *
                    </label>
                    <input
                        type="text"
                        name="title"
                        placeholder="e.g., Large pothole on Main Street"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        required
                    />
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Description *
                    </label>
                    <textarea
                        name="description"
                        placeholder="Please describe the issue in detail..."
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                        required
                    ></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Location *
                    </label>
                    <div class="relative mb-2">
                        <span class="absolute left-3 top-3.5 text-gray-400">📍</span>
                        <input
                            type="text"
                            name="location"
                            id="locationInput"
                            placeholder="Street address or nearest intersection"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                            required
                        />
                    </div>
                    
                    <button
                        type="button"
                        onclick="toggleMap()"
                        class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1"
                    >
                        📍 <span id="mapToggleText">Select location on map</span>
                    </button>

                    <div id="mapContainer" class="hidden mt-3 border-2 border-gray-300 rounded-lg overflow-hidden shadow-2xl">
                        <div class="relative h-96">
                            <iframe
                                id="mapFrame"
                                width="100%"
                                height="100%"
                                style="border:0"
                                loading="lazy"
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps/embed/v1/view?key=YOUR_API_KEY&center=42.6629,21.1655&zoom=15&maptype=satellite">
                            </iframe>
                            
                            <!-- Fallback: OpenStreetMap -->
                            <div id="osmMap" style="width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
                                <!-- OSM will be rendered here via JavaScript -->
                            </div>

                            <!-- Location Marker overlay -->
                            <div id="marker" class="absolute hidden transform -translate-x-1/2 -translate-y-full transition-all duration-300 pointer-events-none shadow-3d float-animation" style="z-index: 1000;">
                                <div class="relative">
                                    <div class="text-5xl filter drop-shadow-2xl">📍</div>
                                    <div class="absolute -bottom-2 left-1/2 w-8 h-8 bg-red-500 rounded-full opacity-20 marker-ping"></div>
                                    <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-3 h-3 bg-red-600 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Coordinates Display -->
                            <div id="coordinates" class="absolute top-3 left-3 bg-white bg-opacity-95 backdrop-blur-sm px-4 py-2 rounded-xl shadow-lg text-xs font-mono border border-gray-200 hidden" style="z-index: 1001;">
                                📍 <span id="coordText">42.662900, 21.165500</span>
                            </div>

                            <!-- Map Controls -->
                            <div class="absolute top-3 right-3 flex flex-col gap-2" style="z-index: 1001;">
                                <button type="button" onclick="changeMapType('roadmap')" class="bg-white hover:bg-gray-100 p-2 rounded-lg shadow-lg text-sm font-medium border border-gray-200">
                                    🗺️ Map
                                </button>
                                <button type="button" onclick="getCurrentLocation()" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg shadow-lg text-sm font-medium">
                                    📍 My Location
                                </button>
                            </div>

                            <!-- Instructions -->
                            <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-full text-sm pointer-events-none shadow-xl font-medium" style="z-index: 1001;">
                                🖱️ Click anywhere on the map to set location
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Urgency Level -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Urgency Level
                    </label>
                    <div class="flex gap-3">
                        <label class="flex-1">
                            <input type="radio" name="urgency" value="low" class="hidden urgency-input" checked>
                            <div class="urgency-btn py-2 px-4 rounded-lg font-medium text-center cursor-pointer bg-gray-100 text-gray-700">
                                Low
                            </div>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="urgency" value="medium" class="hidden urgency-input">
                            <div class="urgency-btn py-2 px-4 rounded-lg font-medium text-center cursor-pointer bg-gray-100 text-gray-700">
                                Medium
                            </div>
                        </label>
                        <label class="flex-1">
                            <input type="radio" name="urgency" value="high" class="hidden urgency-input">
                            <div class="urgency-btn py-2 px-4 rounded-lg font-medium text-center cursor-pointer bg-gray-100 text-gray-700">
                                High
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload Photo (Optional)
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition">
                        <div class="text-4xl mb-2">📷</div>
                        <div id="photoPreview"></div>
                        <p class="text-sm text-gray-600 mb-2">Click to upload or drag and drop</p>
                        <input
                            type="file"
                            name="photo"
                            accept="image/*"
                            class="hidden"
                            id="photo-upload"
                            onchange="previewImage(event)"
                        />
                        <label
                            for="photo-upload"
                            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg cursor-pointer hover:bg-blue-700 transition"
                        >
                            Choose File
                        </label>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="border-t pt-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Contact Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Name *
                            </label>
                            <input
                                type="text"
                                name="name"
                                placeholder="Your name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                required
                            />
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Phone
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3.5 text-gray-400">📞</span>
                                <input
                                    type="tel"
                                    name="phone"
                                    placeholder="(555) 123-4567"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3.5 text-gray-400">✉️</span>
                            <input
                                type="email"
                                name="email"
                                placeholder="your.email@example.com"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                                required
                            />
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-4 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2 shadow-lg hover:shadow-xl"
                >
                    <span>📤</span>
                    Submit Report
                </button>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
            <p class="font-medium mb-1">📋 What happens next?</p>
            <p>Your report will be reviewed by our city services team within 24-48 hours. You'll receive updates via email about the status of your report.</p>
        </div>
    </div>
<br><br>
    <footer>
        <div class="footer-content">
            <div class="footer-section about">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="report.php">Report</a></li>
                    <li><a href="contantus.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section links">
                <h3>About Urban Service</h3>
                <p>Urban Service,embodies innovation, connection, and vibrant community energy.</p>
            </div>
            <div class="footer-section social">
                <h3>Follow Us</h3>
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

    <script>
        // Category selection
        document.querySelectorAll('.category-input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.category-btn').forEach(btn => {
                    btn.classList.remove('selected');
                });
                if (this.checked) {
                    this.closest('.category-btn').classList.add('selected');
                }
            });
        });

        // Urgency selection
        document.querySelectorAll('.urgency-input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.urgency-btn').forEach(btn => {
                    btn.classList.remove('bg-green-500', 'bg-yellow-500', 'bg-red-500', 'text-white');
                    btn.classList.add('bg-gray-100', 'text-gray-700');
                });
                
                if (this.checked) {
                    const btn = this.nextElementSibling;
                    btn.classList.remove('bg-gray-100', 'text-gray-700');
                    btn.classList.add('text-white');
                    
                    if (this.value === 'low') {
                        btn.classList.add('bg-green-500');
                    } else if (this.value === 'medium') {
                        btn.classList.add('bg-yellow-500');
                    } else {
                        btn.classList.add('bg-red-500');
                    }
                }
            });
        });

        // Map functionality with OpenStreetMap
        let mapVisible = false;
        let map = null;
        let marker = null;
        let currentLat = 42.6629;
        let currentLng = 21.1655;

        function toggleMap() {
            mapVisible = !mapVisible;
            const container = document.getElementById('mapContainer');
            const toggleText = document.getElementById('mapToggleText');
            
            if (mapVisible) {
                container.classList.remove('hidden');
                toggleText.textContent = 'Hide Map';
                
                // Initialize map if not already done
                if (!map) {
                    initializeMap();
                }
            } else {
                container.classList.add('hidden');
                toggleText.textContent = 'Select location on map';
            }
        }

        function initializeMap() {
            // Load Leaflet CSS
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
            document.head.appendChild(link);

            // Load Leaflet JS
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
            script.onload = function() {
                // Hide iframe, show OSM
                document.getElementById('mapFrame').style.display = 'none';
                
                // Create map
                map = L.map('osmMap').setView([currentLat, currentLng], 15);
                
                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);

                // Add marker
                marker = L.marker([currentLat, currentLng], {
                    draggable: true
                }).addTo(map);

                // Update location on marker drag
                marker.on('dragend', function(e) {
                    const pos = marker.getLatLng();
                    updateLocation(pos.lat, pos.lng);
                });

                // Update location on map click
                map.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lng = e.latlng.lng;
                    marker.setLatLng([lat, lng]);
                    updateLocation(lat, lng);
                });
            };
            document.head.appendChild(script);
        }

        function updateLocation(lat, lng) {
            currentLat = lat;
            currentLng = lng;
            
            const coordString = lat.toFixed(6) + ', ' + lng.toFixed(6);
            document.getElementById('coordText').textContent = coordString;
            document.getElementById('locationInput').value = coordString;
            document.getElementById('coordinates').classList.remove('hidden');
        }

        function changeMapType(type) {
            if (!map) return;
            
            // Remove existing layers
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    map.removeLayer(layer);
                }
            });

            // Add new layer based on type
            if (type === 'satellite') {
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles &copy; Esri',
                    maxZoom: 19
                }).addTo(map);
            } else {
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);
            }
        }

        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    if (map && marker) {
                        map.setView([lat, lng], 17);
                        marker.setLatLng([lat, lng]);
                        updateLocation(lat, lng);
                    } else {
                        currentLat = lat;
                        currentLng = lng;
                        updateLocation(lat, lng);
                    }
                }, function(error) {
                    alert('Unable to get your location. Please select it manually on the map.');
                });
            } else {
                alert('Geolocation is not supported by your browser.');
            }
        }

        // Legacy function for compatibility
        function setLocation(event) {
            // This is now handled by Leaflet map clicks
        }

        // Image preview
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('photoPreview');
                    preview.innerHTML = `
                        <div class="mt-4">
                            <img src="${e.target.result}" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                            <button type="button" onclick="removePhoto()" class="mt-2 text-sm text-red-600 hover:text-red-700">
                                Remove photo
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        }

        function removePhoto() {
            document.getElementById('photo-upload').value = '';
            document.getElementById('photoPreview').innerHTML = '';
        }
    </script>
</body>
</html>