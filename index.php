<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seraphina Jewellery</title>
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
  background-image: url('img/jhome.jpg');
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


#jewellery {
  background-color:  #E7F2EF;
  padding: 32px;
  text-align: center;
}

#jewellery h2 {
  font-size: 32px;
  margin-bottom: 24px;
}

.jewellery-container {
  display: flex;
  justify-content: center;
  gap: 32px;
}

.jewellery-box  {
  background-color:  #ffffff;
  padding: 16px;
  border-radius: 8px;
  border: 1px solid #708993;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 180px;
  transition: transform 0.3s;
}

.jewellery-box img {
  width: 100%;
  height: 250px;
  object-fit: cover;
  border-radius: 5px;
}

.jewellery-box h3 {
  font-size: 18px;
  margin-top: 16px;
}

.jewellery-box p {
  font-size: 14px;
  margin: 8px 0;
}

.jewellery-box:hover {
  transform: scale(1.05);
}


.read-more {
  background-color: #708993;
  color: #ffffff;
  padding: 8px 20px;
  border: none;
  border-radius: 4px;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.3s;
}

.read-more:hover {
  background-color: #A1C2BD;
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
  max-width: 250px;
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
    font-family: 'Dancing Script', cursive;
    font-size: 25px; 
    color: #19183B;     
}


html {
  scroll-behavior: smooth;
}
</style>
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
                <li><a href="#jewellery">Buy</a></li>
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
            <h2>Discover Your Next Treasure</h2>
            <p>Step into the world of Seraphina, where every piece of jewellery shines with elegance and heavenly beauty.</p><br>
            <a href="#jewellery" class="btn">Buy Now</a>
        </div>
    </section>
<br><br>

    <section id="jewellery">
        <h2>Jewellery to Love</h2>
        <p class="review-text">From timeless classics to modern designs, discover the pieces that celebrate your unique style.</p><br><br>
        <div class="jewellery-container">
            <div class="jewellery-box">
                <img src="img/home1.jpg" alt="Book 1">
                <h3>Earrings</h3>
                <h4>$70<br><br></h4>
                <a href="cart.php" class="icon-btn">
            <i class="fa-regular fa-heart"></i>
            </a>
                <a class="read-more" href="#">Buy</a>
            </div>
            <div class="jewellery-box">
                <img src="img/homee.jpg" alt="Book 2">
                <h3>Bracelet</h3>
                <h4>$85</h4><br>
                <a href="cart.php" class="icon-btn">
            <i class="fa-regular fa-heart"></i>
            </a>
                <a class="read-more" href="#">Buy</a>
            </div>
            <div class="jewellery-box">
                <img src="img/homeee.jpg" alt="Book 3">
                <h3>Stud Earrings</h3>
                <h4>$90<br><br></h4>
                <a href="cart.php" class="icon-btn">
            <i class="fa-regular fa-heart"></i>
            </a>
                <a class="read-more" href="#">Buy</a>
            </div>
        </div>
    </section>


    <section id="jewellery">
        <div class="jewellery-container">
            <div class="jewellery-box">
                <img src="img/image.avif" alt="Book 1">
                <h3>Diamond Ring</h3>
                <h4>$120<br><br></h4>
                <a href="cart.php" class="icon-btn">
            <i class="fa-regular fa-heart"></i>
            </a>
                <a class="read-more" href="#">Buy</a>
            </div>
            <div class="jewellery-box">
                <img src="img/home3.avif" alt="Book 2">
                <h3>Bracelet</h3>
                <h4>$95</h4><br>
                <a href="cart.php" class="icon-btn">
            <i class="fa-regular fa-heart"></i>
            </a>
                <a class="read-more" href="#">Buy</a>
            </div>
            <div class="jewellery-box">
                <img src="img/homeJ.jpg" alt="Book 3">
                <h3>Necklace</h3>
                <h4>$180<br><br></h4>
                <a href="cart.php" class="icon-btn">
            <i class="fa-regular fa-heart"></i>
            </a>
                <a class="read-more" href="#">Buy</a>
            </div>
        </div>
    </section>
<section id="categories">
        <h2>Popular Collections</h2>
        <div class="category-cards">
            <div class="category-card">
                <img src="img/rings.jpg" alt="#">
                <h3>Rings</h3>
            </div>
            <div class="category-card">
                <img src="img/nacles.jpg" alt="#">
                <h3>Necklaces</h3>
            </div>
            <div class="category-card">
                <img src="img/braslets.jpg" alt="#">
                <h3>Bracelets</h3>
            </div>
            <div class="category-card">
                <img src="img/earings.jpg" alt="#">
                <h3>Earrings</h3>
            </div>
        </div>
    </section>

    <section id="testimonials">
        <h2>What Our Customers Say</h2><br><br>
        <div class="testimonials-container"><br><br>
            <div class="testimonial">
                <p class="review-text">"Seraphina jewellery makes every moment feel special. Absolutely stunning!"</p><br>
                <h4>- Elena R.</h4>
            </div>
            <div class="testimonial">
                <p class="review-text">"Elegant, unique, and divine. I always get compliments! I love there products"</p><br>
                <h4>– Daniel M.</h4>
            </div>
            <div class="testimonial">
                <p class="review-text">"Absolutely stunning! Every piece feels like it was made just for me."</p><br><br>
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