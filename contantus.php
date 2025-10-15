<?php
include 'connection.php';
session_start();

// ✅ Require user to be logged in
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['send_message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO message (user_id, name, email, number, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $name, $email, $number, $message);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contantus.php';</script>";
    } else {
        echo "<script>alert('Error sending message. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
<title>Contact Us - Seraphina</title>
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

:root{
  --accent:#A1C2BD;
  --dark:#19183B;
  --light:#fff;
}

.logo-elegant{
  display:flex;
  align-items:center;
  gap:12px;
  user-select:none;
}

/* circular initial */
.logo-elegant .mark{
  width:58px;
  height:58px;
  display:inline-grid;
  place-items:center;
  background:linear-gradient(135deg,var(--accent),#ffffff);
  color:var(--dark);
  font-family:'Montserrat',sans-serif;
  font-weight:700;
  font-size:28px;
  border-radius:50%;
  box-shadow:0 6px 18px rgba(25,24,59,0.12);
}

/* word */
.logo-elegant .word{
  font-family:'Dancing Script',cursive;
  color:var(--dark);
  font-size:36px;
  line-height:1;
  letter-spacing:0.5px;
  text-shadow:0 1px 0 rgba(255,255,255,0.2);
}

/* responsive */
@media (max-width:480px){
  .logo-elegant .mark{ width:46px; height:46px; font-size:22px;}
  .logo-elegant .word{ font-size:26px;}
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
  background-image: url('img/ab.jpg');
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

:root {
  --dark-blue: #19183B;
  --muted-teal: #708993;
  --soft-green: #A1C2BD;
  --light-bg: #E7F2EF;
  --text-color: #19183B;
  --white: #ffffff;
}

body {
  background-color: var(--light-bg);
  font-family: 'Poppins', sans-serif;
  color: var(--text-color);
}

/* === Contact Form Container === */
.contact-container {
  max-width: 520px;
  margin: 80px auto;
  background: var(--white);
  padding: 45px 55px;
  border-radius: 25px;
  box-shadow: 0 4px 25px rgba(105, 137, 147, 0.2); /* soft teal shadow */
  text-align: center;
  transition: all 0.3s ease;
}

.contact-container:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(25, 24, 59, 0.25);
}

/* === Heading === */
.contact-container h2 {
  font-size: 2rem;
  color: var(--dark-blue);
  margin-bottom: 20px;
  font-family: 'Playfair Display', serif;
  letter-spacing: 1px;
  font-weight: 700;
}

/* === Input Fields === */
.contact-container input,
.contact-container textarea {
  width: 100%;
  padding: 13px 15px;
  margin: 10px 0;
  border: 1.5px solid var(--soft-green);
  border-radius: 12px;
  font-size: 16px;
  background-color: var(--light-bg);
  transition: all 0.3s ease;
  color: var(--text-color);
}

.contact-container input:focus,
.contact-container textarea:focus {
  outline: none;
  border-color: var(--muted-teal);
  box-shadow: 0 0 8px rgba(112, 137, 147, 0.4);
  background-color: var(--white);
}

/* === Submit Button === */
.contact-container button {
  width: 100%;
  padding: 14px 0;
  background: var(--dark-blue);
  color: var(--white);
  border: none;
  border-radius: 12px;
  font-size: 17px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 15px;
  letter-spacing: 0.5px;
}

.contact-container button:hover {
  background: var(--muted-teal);
  color: var(--white);
  box-shadow: 0 4px 15px rgba(161, 194, 189, 0.5);
  transform: translateY(-2px);
}

/* === Placeholder Text === */
::placeholder {
  color: var(--muted-teal);
  font-style: italic;
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
    font-family: 'Dancing Script', cursive;
    font-size: 25px; 
    color: #19183B;     
}

html {
  scroll-behavior: smooth;
}

  :root {
    --dark-blue: #19183B;
    --muted-teal: #708993;
    --soft-green: #A1C2BD;
    --light-bg: #E7F2EF;
    --text-color: #19183B;
    --white: #ffffff;
  }

  body {
    font-family: "Poppins", sans-serif;
    background-color: var(--light-bg);
    color: var(--text-color);
    margin: 0;
    padding: 0;
  }

  .contact-container {
    max-width: 600px;
    margin: 80px auto;
    background: var(--white);
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
    color: var(--white);
  }

  input, textarea {
    width: 100%;
    padding: 12px;
    margin-bottom: 16px;
    border: 1px solid var(--muted-teal);
    border-radius: 6px;
    outline: none;
    font-size: 15px;
  }

  textarea {
    resize: vertical;
    height: 120px;
  }

  button {
    background-color: var(--dark-blue);
    color: var(--white);
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s;
  }

  button:hover {
    background-color: var(--muted-teal);
  }

  h1{
    font-size:40px;
    text-align: center;
    margin-bottom: 5px;
    color: var(--dark-blue);
  }
</style>
</head>
<body>
 <header>

        <div class="logo-elegant" aria-label="Seraphina logo">
  <span class="mark">S</span>
  <span class="word">Seraphina</span>
</div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="index.php#jewellery">Buy</a></li>
                <li><a href="contantus.php">Contact Us</a></li>
            </ul>
            <div class="search-bar">
                <input type="text" placeholder="Search jewellery...">
                <button>Search</button><br>
                <a href="cart.php" class="icon-btn">
            <i class="fa-regular fa-heart"></i>
            </a>
            <a href="cart.php" class="icon-btn">
            <i class="fa-solid fa-cart-shopping"></i>
      </a>
            </div>
        </nav>
    </header>

    <section id="hero-jewellery">
        <div class="content">
            <h2>We’d Love to Hear From You</h2>
            <p>At Seraphina, every message shines as bright as our jewels — reach out and let us make your experience truly radiant.</p><br>
            <a href="aboutus.php" class="btn">About us</a>
        </div>
    </section>
<br><br>


<div class="contact-container">
  <h2>Send Us a Message</h2>
  <form action="" method="POST">
    <input type="text" name="name" placeholder="Your Name..." required>
    <input type="email" name="email" placeholder="Your Email..." required>
    <input type="text" name="number" placeholder="Your Phone Number..." required>
    <textarea name="message" placeholder="Type your message here..." required></textarea>
    <button type="submit" name="send_message">Send Message</button>
  </form>
</div>



<footer>
        <div class="footer-content">
            <div class="footer-section about">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="#">Books</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section links">
                <h3>About Seraphina</h3>
                <p>Seraphina, inspired by celestial seraphim, embodies purity, light, and timeless elegance.</p>
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
            <p>&copy; 2025 Seraphina Jewellery | All rights reserved</p>
        </div>
    </footer>

</body>
</html>
