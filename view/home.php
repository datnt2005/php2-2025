<body>

    
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Discover the New iPhone</h1>
            <p>Experience innovation like never before</p>
            <a href="#products" class="btn">Shop Now</a>
        </div>
    </section>

    <section id="products" class="products">
        <h2>Our Products</h2>
        <div class="product-list">
            <div class="product">
                <img src="https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329143/iphone-16-pro-titan-tu-nhien-1-638638980481725831-750x500.jpg" alt="iPhone 14">
                <h3>iPhone 14</h3>
                <p>$799</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329135/iphone-16-xanh-luu-ly-1-638639088268837180-750x500.jpg" alt="iPhone 14 Pro">
                <h3>iPhone 14 Pro</h3>
                <p>$999</p>
                <button>Add to Cart</button>
            </div>
        </div>
    </section>
    
    <section id="features" class="features">
        <h2>Why Choose iPhone?</h2>
        <div class="feature-list">
            <div class="feature">
                <h3>Stunning Design</h3>
                <p>Crafted with premium materials for a sleek and stylish look.</p>
            </div>
            <div class="feature">
                <h3>Powerful Performance</h3>
                <p>Experience blazing fast speed with the latest A-series chip.</p>
            </div>
        </div>
    </section>
    
    <section id="reviews" class="reviews">
        <h2>Customer Reviews</h2>
        <div class="review-list">
            <div class="review">
                <p>"Best phone I’ve ever used!" - John D.</p>
            </div>
            <div class="review">
                <p>"Amazing camera quality and battery life!" - Sarah W.</p>
            </div>
        </div>
    </section>
    

</body>
<style>
    /* Google Font */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

/* Reset & Setup */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #0e0e0e;
    color: white;
}

/* Navbar */
.navbar {
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.8);
    padding: 15px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.navbar.scrolled {
    background: rgba(0, 0, 0, 0.95);
}

.navbar .logo {
    font-size: 24px;
    font-weight: 600;
    color: #fff;
}

.navbar ul {
    list-style: none;
    display: flex;
}

.navbar ul li {
    margin: 0 15px;
}

.navbar ul li a {
    text-decoration: none;
    color: #ddd;
    font-weight: 400;
    transition: 0.3s;
}

.navbar ul li a:hover {
    color: #00aaff;
}

/* Hero Section */
.hero {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: url('iphone-banner.jpg') no-repeat center center/cover;
    position: relative;
}

.hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}

.hero .content {
    position: relative;
    z-index: 2;
}

.hero h1 {
    font-size: 3rem;
    font-weight: 600;
}

.hero p {
    font-size: 1.2rem;
    margin: 15px 0;
}

.btn {
    padding: 12px 25px;
    background: #00aaff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}

.btn:hover {
    background: #0088cc;
}

/* Products */
.products {
    padding: 50px 0;
    text-align: center;
}

.products h2 {
    font-size: 2.5rem;
    margin-bottom: 30px;
}

.product-grid {
    display: flex;
    justify-content: center;
    gap: 20px;
}

.product {
    background: #1b1b1b;
    padding: 20px;
    border-radius: 10px;
    transition: 0.3s;
}

.product:hover {
    transform: scale(1.05);
}

.product img {
    width: 250px;
    border-radius: 10px;
}

/* Footer */
.footer {
    background: #0a0a0a;
    text-align: center;
    padding: 15px;
    margin-top: 30px;
}

.footer p {
    color: #888;
}
</style>    