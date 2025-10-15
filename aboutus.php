<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seraphina - About Us</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

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

#hero-jewellery {
  position: relative;
  background-image: url('img/aw.jpg');
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
  background-color: #708993;
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
      margin: 0;
      font-family: "Poppins", sans-serif;
      background-color: var(--white);
      color: var(--text-color);
    }

    .services-section {
      background-color: var(--light-bg);
      padding: 90px 40px;
      text-align: center;
    }

    .services-title {
      font-size: 38px;
      font-weight: 700;
      color: var(--dark-blue);
      margin-bottom: 60px;
      letter-spacing: 1px;
    }

    .services-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 60px;
      max-width: 1100px;
      margin: 0 auto;
      align-items: start;
    }

    .service-item {
      background: none;
      padding: 20px;
      transition: transform 0.3s ease, color 0.3s ease;
    }

    .service-item:hover {
      transform: translateY(-6px);
    }

    .service-item i {
      font-size: 48px;
      color: var(--soft-green);
      margin-bottom: 20px;
      transition: color 0.3s ease;
    }

    .service-item:hover i {
      color: var(--muted-teal);
    }

    .service-item h3 {
      font-size: 20px;
      font-weight: 600;
      color: var(--dark-blue);
      margin-bottom: 12px;
    }

    .service-item p {
      font-size: 16px;
      color: var(--muted-teal);
      line-height: 1.6;
      max-width: 280px;
      margin: 0 auto;
    }

    @keyframes fadeUp {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .service-item {
      animation: fadeUp 1s ease both;
    }

    .service-item:nth-child(1) { animation-delay: 0.1s; }
    .service-item:nth-child(2) { animation-delay: 0.2s; }
    .service-item:nth-child(3) { animation-delay: 0.3s; }
    .service-item:nth-child(4) { animation-delay: 0.4s; }
    .service-item:nth-child(5) { animation-delay: 0.5s; }
    .service-item:nth-child(6) { animation-delay: 0.6s; }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .services-title {
        font-size: 32px;
      }
      .service-item p {
        font-size: 15px;
      }
    }

.card-container {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 20px;
  background-image: url('img/2.avif');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  padding: 60px 0;
  z-index: 0;
}

.card-container::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  z-index: -3;
}

.centered-text  {
  font-size: 36px;
  font-weight: bold;
  margin-bottom: 30px;
  color: #708993;
}

.card-wrapper {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 70px;
  flex-wrap: wrap;
}

.card {
  width: 300px;
  background-color: #708993;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 12px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

.card-image {
  width: 250px;
  height: 150px;
  object-fit: cover;
  border-radius: 10px;
  margin: 20px auto;
  display: block;
}

.card .title {
  font-size: 19.2px;
  font-weight: bold;
  color: #19183B;
  margin: 15px 0;
  text-align: center;
}

.card .card-content {
  padding: 15px;
  text-align: center;
  font-size: 16px;
  color: #19183B;
  line-height: 1.6;
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
      <h2>Embrace Timeless Elegance</h2>
      <p>At Seraphina, we believe jewellery is more than an accessory — it’s a reflection of grace, passion, and individuality.</p><br>
      <a href="contantus.php" class="btn">Contact Us</a>
    </div>
  </section>

 <section class="services-section">
    <h2 class="services-title">Our Services</h2>

    <div class="services-container">
      <div class="service-item">
        <i class="fas fa-star"></i>
        <h3>Quality Products</h3>
        <p>Every piece is crafted with precision and care, ensuring top-tier quality and elegance.</p>
      </div>

      <div class="service-item">
        <i class="fas fa-shopping-cart"></i>
        <h3>Online Sales</h3>
        <p>Shop easily and securely through our online platform, available 24/7 for your convenience.</p>
      </div>

      <div class="service-item">
        <i class="fas fa-truck"></i>
        <h3>Fast Delivery</h3>
        <p>Enjoy quick and reliable delivery, right to your doorstep — wherever you are.</p>
      </div>

      <div class="service-item">
        <i class="fas fa-percent"></i>
        <h3>Discounts & Offers</h3>
        <p>Benefit from our seasonal sales, loyalty rewards, and exclusive member discounts.</p>
      </div>

      <div class="service-item">
        <i class="fas fa-retweet"></i>
        <h3>Easy Returns</h3>
        <p>Changed your mind? Our return process is simple, transparent, and stress-free.</p>
      </div>

      <div class="service-item">
        <i class="fas fa-headset"></i>
        <h3>Customer Support</h3>
        <p>We’re always here to help — our support team is ready to assist you with care and attention.</p>
      </div>
    </div>
  </section>

  <div class="card-container">
    <div class="centered-text">Welcome to Our Team</div> 
    <div class="card-wrapper">
      <div class="card">
        <img src="img/emma.jpg" alt="Emma's Image" class="card-image">
        <div class="title">Emma Doe <br><br> CIO</div>
        <div class="card-content">
          <p>Email: emma.doe@gmail.com</p>
          <p>Emma, as CIO of our jewellery website, leads tech development, ensuring a fast, secure, and user-friendly platform for an excellent reader experience.</p>
        </div>
      </div>

      <div class="card">
        <img src="img/nora.jpg" alt="Nora's Image" class="card-image">
        <div class="title">Nora Baffyn<br><br> Content Manager</div>
        <div class="card-content">
          <p>Email: nora.baffyn@gmail.com</p>
          <p>Nora is responsible for updating and maintaining the website's content, such as adding new jewellery, writing jewellery descriptions, and managing the blog.</p>
        </div>
      </div>

      <div class="card">
        <img src="img/henry.jpg" alt="Henry's Image" class="card-image">
        <div class="title">Henry Larlee<br><br>Marketing Specialist</div>
        <div class="card-content">
          <p>Email: henry.larlee@gmail.com</p>
          <p>Henry develops strategies for promoting the website, such as social media ads, email campaigns, and collaborations with authors or publishers.</p>
        </div>
      </div>
    </div>
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
          <i class="fa-brands fa-facebook" style="color:#ffffff;"></i>
        </a>
        <a href="https://twitter.com/" target="_blank">
          <i class="fa-brands fa-twitter" style="color:#ffffff;"></i>
        </a>
        <a href="https://www.instagram.com/" target="_blank">
          <i class="fa-brands fa-instagram" style="color:#ffffff;"></i>
        </a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2025 Seraphina Jewellery | All rights reserved</p>
    </div>
  </footer>
</body>
</html>
