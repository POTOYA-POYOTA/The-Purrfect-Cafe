<?php

require_once('connection.php');

$result = $conn->query("SELECT image_path FROM banner WHERE id = 1");

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $banner_image = isset($row['image_path']) ? $row['image_path'] : "default-banner.jpg"; 
} else {
    $banner_image = "default-banner.jpg";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" type="image/png" href="images/logo_cafe.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu - The Purrfect Cafe</title>
    <link rel="stylesheet" href="style.css">
	<style>
    body 
	{
        font-family: Arial, sans-serif;
        background-color: #fffaf0;
        margin: 0;
        padding: 0;
    }
	.banner-container 
	{
		width: 100%;
		max-height: 400px;
		overflow: hidden;
		display: flex;
		justify-content: center;
		align-items: center;
		background-color: black;
	}

	.banner-container img 
	{
		width: 100%;
		height: 100%;
		object-fit: contain;
	}
	/* Content Animation */
	.content 
	{
	  text-align: center;
	  margin-top: 0;
	  opacity: 0;
	  transform: translateY(20px); /* Slightly shifted downward */
	  animation: fadeIn 1.5s ease-out forwards; /* Fade-in animation */
	}

	/* Keyframes for Animations */
	@keyframes slideIn 
	{
	  from {
		top: -100px;
	  }
	  to {
		top: 0;
	  }
	}

	@keyframes fadeIn 
	{
	  from {
		opacity: 0;
		transform: translateY(20px);
	  }
	  to {
		opacity: 1;
		transform: translateY(0);
	  }
	}
    .footer 
	{
      background-color: #333;
      color: white;
      text-align: center;
      padding: 10px;
      position: relative;
    }
    @keyframes fadeIn 
	{
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }
    @keyframes slideUp 
	{
      from {
        transform: translateY(20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

	.section-title 
	{
		font-size: 32px;
		margin-bottom: 20px;
	}

    .menu-section 
	{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 40px;
        padding: 50px 20px;
	}
    .menu-content 
	{
        max-width: 500px;
        text-align: left;
    }
    .menu-content h1 
	{
        text-align: center;
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #333;
    }
    .menu-item 
	{
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
    .menu-item h4 
	{
        font-size: 1.5rem;
        color: #222;
        margin-bottom: 5px;
    }
    .menu-item p 
	{
        font-size: 1.3rem;
        color: #444;
        margin-left: 15px;
        line-height: 1.6;
    }
    .menu-image 
	{
        max-width: 500px;
        width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
	/* Responsive Design */
	@media (max-width: 768px) 
	{
		.menu-container {
			flex-direction: column;
			align-items: center;
		}
	}
	.price 
	{
		color: #777;
		font-size: 16px;
	}
	</style>
</head>
<body>
  <!-- Navbar -->
  <div class="navbar">
    <a href="index.php" class="nav-logo">The Purrfect Cafe</a>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="menu.php">Menu</a>
      <a href="contact.php">Booking</a>
      <!-- Admin Login Icon -->
      <a href="login.php" class="admin-login">
        <img src="images/admin-icon.png" alt="Admin Login" title="Admin Login">
      </a>
    </div>
  </div>

  <!-- Banner Section -->
	  <div class="banner-container">
		  <?php
		  require_once 'connection.php';

		  $query = "SELECT banner_path FROM settings LIMIT 1";
		  $result = $conn->query("SELECT image_path FROM banner WHERE id = 1");

		  if ($result && $row = $result->fetch_assoc()) 
		  {
		  	  $banner_path = $row['image_path'];
		  } 
		  else 
		  {
			  $banner_path = 'images/banner-1.png';
		  }

		  if (!file_exists($banner_path)) 
		  {
			  $banner_path = 'images/banner-1.png'; // Use default if file not found
		  }
		  ?>
		  <img src="<?php echo htmlspecialchars($banner_path); ?>" alt="Cafe Banner">
	  </div>

<!-- Menu Section -->
<div class="menu-section">
    <div class="menu-content">
        <h1>Our Food Menu</h1>
        <div class="menu-item">
            <h4>Nasi Lemak</h4>
            <p>Biasa RM3.00 <br> Telur RM4.50</p>
        </div>
        <div class="menu-item">
            <h4>Roti Bakar Telur Goyang</h4>
            <p>Biasa RM5.00 <br> Double RM6.00</p>
        </div>
        <div class="menu-item">
            <h4>Maggie Goreng</h4>
            <p>Biasa RM5.50 <br> Telur RM7.00</p>
        </div>
        <div class="menu-item">
            <h4>Kuey Teow Sup</h4>
            <p>Biasa RM6.00 <br> Special RM7.00</p>
        </div>
        <div class="menu-item">
            <h4>Spaghetti</h4>
            <p>Carbonara RM7.00  <br>Bolognese RM8.00  <br>Aglio Alio RM9.00</p>
        </div>
    </div>
    <img src="images/food_menu.jpg" alt="Food Menu" class="menu-image">
</div>

<div class="menu-section">
    <img src="images/drinks_menu.jpg" alt="Drinks Menu" class="menu-image">
    <div class="menu-content">
        <h1>Our Drinks Menu</h1>
        <div class="menu-item">
            <h4>Kopi / Kopi O</h4>
            <p>Panas RM2.00 <br> Sejuk RM2.50</p>
        </div>
        <div class="menu-item">
            <h4>Teh / Teh O</h4>
            <p>Panas RM2.00 <br> Sejuk RM2.50</p>
        </div>
        <div class="menu-item">
            <h4>Fresh Orange Juice</h4>
            <p>Panas RM3.40 <br> Sejuk RM3.80</p>
        </div>
        <div class="menu-item">
            <h4>Chocolate</h4>
            <p>Panas RM7.90 <br> Sejuk RM8.90</p>
        </div>
        <div class="menu-item">
            <h4>Green Tea</h4>
            <p>Panas RM7.90 <br> Sejuk RM8.90</p>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
  <p>&copy; 2025 The Purrfect Cafe. All rights reserved.</p>
</footer>

</body>
</html>
