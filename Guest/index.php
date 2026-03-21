<?php
include 'config.php';
include 'includes/header.php';
?>



<style>
    /* BANNER */
    .banner {
        position: relative;
        height: 500px;
        background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70') no-repeat center/cover;
        color: white;
        display: flex;
        align-items: center;
        padding-left: 60px;
    }

    .banner-content h1 {
        font-size: 50px;
        margin: 0;
    }

    .banner-content p {
        font-size: 20px;
        margin-top: 10px;
    }

    .banner-content button {
        margin-top: 20px;
        padding: 10px 20px;
        background: red;
        border: none;
        color: white;
        cursor: pointer;
    }

    /* SECTION */
    .section {
        padding: 40px 60px;
        text-align: center;
    }

    .cards {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    .card {
        width: 300px;
    }

    .card img {
        width: 100%;
        border-radius: 5px;
    }
</style>

<!-- BANNER -->
<div class="banner">
    <div class="banner-content">
        <h1>DOMINATE</h1>
        <h2>THE INTERNET</h2>
        <p>Attract, Engage & Convert more customers</p>
        <button>Explore Now</button>
    </div>
</div>

<!-- CONTENT -->
<div class="section">
    <h2>Discover Our Products</h2>

    <div class="cards">
        <div class="card">
            <img src="https://images.unsplash.com/photo-1518655048521-f130df041f66">
            <p>Mountain Bike</p>
        </div>

        <div class="card">
            <img src="https://images.unsplash.com/photo-1485965120184-e220f721d03e">
            <p>City Bike</p>
        </div>

        <div class="card">
            <img src="https://images.unsplash.com/photo-1502741338009-cac2772e18bc">
            <p>Sport Bike</p>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>