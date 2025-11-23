<?php
include 'connection.php'; // This line must be at the top!
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">

</head>
<style>
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

.search-bar {
  display: flex;
  align-items: center;
  background: #ffffff;
  padding: 4px 8px;
  border-radius: 25px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  gap: 6px;
}

.search-bar input {
  border: none;
  outline: none;
  padding: 8px 12px;
  border-radius: 20px;
  font-size: 14px;
  flex: 1;
  min-width: 160px;
}

.search-bar button {
  background-color: #708993;
  color: #ffffff;
  border: none;
  border-radius: 20px;
  padding: 8px 16px;
  cursor: pointer;
  transition: 0.3s ease;
  font-size: 14px;
}

.search-bar button:hover {
  background-color: #A1C2BD;
}

.search-bar .icon-btn {
  background: #708993;
  border-radius: 50%;
  width: 35px;
  height: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  transition: 0.3s;
}

.search-bar .icon-btn:hover {
  background: #A1C2BD;
}


#hero-jewellery {
  position: relative;
  background-image: url('img/kk.jpg');
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
  background: rgba(0, 0, 0, 0.6); 
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


.stats-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin: 20px 0;
}

.stat-card {
  background: #15182b;
  padding: 30px;
  border-radius: 16px;
  text-align: center;
  color: white;
  border: 1px solid rgba(255,255,255,0.1);
}

.stat-card h1 {
  margin: 0;
  font-size: 50px;
  color: #7c6cf2;
}

.stat-card p {
  margin-top: 10px;
  font-size: 16px;
  opacity: 0.8;
}

input, textarea, button {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: none;
    margin-top: 8px;
}

button {
    background: #4CAF50;
    color: white;
    font-size: 16px;
    cursor: pointer;
}


#categories {
  text-align: center;
  padding: 40px 20px;
  background-color: #708993;
}

#categories h2 {
  font-size: 24px;
  margin-bottom: 20px;
  color: #ffffff;
}

.category-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 15px;
}

.category-card {
  background-color: #A1C2BD;
  border: 1px solid #708993;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 15px;
  width: 200px;
  text-align: center;
  transition: transform 0.3s;
}

.category-card:hover {
  transform: scale(1.05);
}

.category-card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 6px;
}

.category-card h3 {
  font-size: 18px;
  margin-top: 10px;
  color: #19183B;
}


#testimonials {
  padding: 40px 20px;
  background-color: #19183B;
  color: #ffffff;
  text-align: center;
}

.testimonials-container {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.testimonial {
  background-color: #E7F2EF;
  padding: 20px;
  border-radius: 10px;
  max-width: 290px;
  font-style: italic;
  color: #19183B;
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

.review-text {
    font-family: italic;
    font-size: 25px; 
    color: #19183B;     
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
  margin: 20px 0;
}

.stat-card {
  background: #15182b;
  padding: 30px;
  border-radius: 16px;
  text-align: center;
  color: white;
  border: 1px solid rgba(255,255,255,0.1);
}

.stat-card h1 {
  margin: 0;
  font-size: 50px;
  color: #7c6cf2;
}

.stat-card p {
  margin-top: 10px;
  font-size: 16px;
  opacity: 0.8;
}

h1.title {
  text-align: center;
  margin-top: 40px;
  font-size: 34px;
  font-weight: bold;
  color: #7c6cf2;
  text-shadow: 0 0 10px rgba(109, 98, 196, 0.5);
}

input, textarea, button {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: none;
    margin-top: 8px;
}

button {
    background: #4CAF50;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

    body {
        margin: 0;
        background: #3C467B;
        font-family:'Lato', sans-serif;
        color: white;
    }

    .stats-grid {
        max-width: 900px;
        margin: 40px auto;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    .stat-card {
        background: #15182b;
        padding: 40px 20px;
        border-radius: 16px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.08);
    }

    .stat-card h1 {
        margin: 0;
        font-size: 54px;
        font-weight: bold;
        color: #7c6cf2; /* purple like your photo */
    }

    .stat-card p {
        margin-top: 10px;
        font-size: 18px;
        opacity: 0.8;
    }

.stat-card {
    background: #15182b;
    padding: 40px 20px;
    border-radius: 16px;
    text-align: center;
    color: #fff; /* Teksti i bardhë */
    text-decoration: none; /* heq vijat nën link */
    border: none; /* heq border të dukshëm */
    transition: transform 0.2s, background 0.3s;
}

.stat-card h1 {
    margin: 0;
    font-size: 54px;
    font-weight: bold;
    color: #7c6cf2; /* purple */
}

.stat-card p {
    margin-top: 10px;
    font-size: 18px;
    opacity: 0.9;
    color: #ffffff; /* Teksti i bardhë */
}

.stat-card:hover {
    transform: scale(1.05);
    background: #1f1f3a; /* pak ndryshim ngjyre kur hover */
}


html {
  scroll-behavior: smooth;
}
</style>
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
            <h2>Your City, Our Care</h2>
            <p>Making every street cleaner, safer, and brighter.</p><br>
            <a href="report.php" class="btn">Report Now</a>
        </div>
    </section>
<br><br>

<div class="tab <?php echo $tab === 'home' ? 'active' : ''; ?>">
<h1 class="title">CityCare Report Overview</h1>

<?php
// Include database connection
include 'connection.php';

// Fetch real statistics
$total_reports     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM maintenance"))['count'];
$pending_reports   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM maintenance WHERE status = 'Pending'"))['count'];
$resolved_reports  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM maintenance WHERE status = 'Resolved' OR status = 'Finished'"))['count'];

// Calculate average response time (in hours) for resolved reports
$avg_query = mysqli_query($conn, "
    SELECT AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_hours 
    FROM maintenance 
    WHERE (status = 'Resolved' OR status = 'Finished') 
      AND updated_at IS NOT NULL
");
$avg_result = mysqli_fetch_assoc($avg_query);
$avg_response = $avg_result['avg_hours'] !== null ? round($avg_result['avg_hours'], 1) . ' hrs' : '-';
?>

<div class="stats-grid">
    <a href="reports.php?type=all" class="stat-card">
        <h1><?= number_format($total_reports) ?></h1>
        <p>Total Reports</p>
    </a>
    <a href="reports.php?type=pending" class="stat-card">
        <h1><?= number_format($pending_reports) ?></h1>
        <p>Pending</p>
    </a>
    <a href="reports.php?type=resolved" class="stat-card">
        <h1><?= number_format($resolved_reports) ?></h1>
        <p>Resolved</p>
    </a>
    <a href="reports.php?type=avg" class="stat-card">
        <h1><?= $avg_response ?></h1>
        <p>Avg Response Time</p>
    </a>
</div>





    <section id="testimonials">
        <h2>Voices from Our City:</h2><br><br>
        <div class="testimonials-container"><br><br>
            <div class="testimonial"><br>
                <p class="review-text">“Urban Servis keeps our streets clean and safe. It really makes a difference in our daily life!”</p><br><br>
                <h4>- Elena R.</h4>
            </div>
            <div class="testimonial"><br>
                <p class="review-text">“I love how City Care listens to residents’ feedback and improves our neighborhoods every day.”</p><br><br>
                <h4>– Daniel M.</h4>
            </div>
            <div class="testimonial"><br>
                <p class="review-text">“Thanks to Urban Servis, our parks and public spaces are well-maintained and welcoming.”</p><br><br>
                <h4>– Sofia R.</h4>
            </div>
        </div>
    </section>

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

</body>
</html>