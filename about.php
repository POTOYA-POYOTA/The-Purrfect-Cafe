<?php

session_start();
require_once('connection.php');

$banner_query = "SELECT image_path FROM banner WHERE id = 1";
$banner_result = $conn->query($banner_query);
$banner = $banner_result->fetch_assoc();
$banner_image = $banner ? $banner['image_path'] : 'images/banner-1.png';

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" type="image/png" href="images/logo_cafe.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - The Purrfect Cafe</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body 
		{
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container 
		{
            flex: 1;
            text-align: center;
        }
        .content 
		{
            padding: 20px;
            font-size: 18px;
            line-height: 1.6;
        }
		.footer 
		{
			background: #333;
			color: white;
			text-align: center;
			padding: 10px;
			position: absolute;
			bottom: 0;
			width: 100%;
		}
        .about-container 
		{
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .about-container h1 
		{
            font-size: 28px;
            color: #333;
        }
        .about-container p 
		{
            font-size: 18px;
            line-height: 1.6;
            color: #666;
        }
		/* Banner Styling */
		.banner-container 
		{
			width: 100%;
			height: 300px;
			overflow: hidden;
			display: flex;
			justify-content: center;
			align-items: center;
		}
        .banner-container img 
		{
            width: 100%;
            height: auto;
            display: block;
            animation: fadeIn 2s ease-in-out;
        }
        @keyframes fadeIn 
		{
            from { opacity: 0; }
            to { opacity: 1; }
        }
		header 
		{
			padding: 20px;
			background: #ffcc00;
			font-size: 24px;
			font-weight: bold;
			animation: slideIn 1.5s ease-in-out;
			text-align: center;
			display: flex;
			justify-content: center;
			align-items: center;
			color: black;
	   		animation: bounceIn 1.5s ease-in-out;
		}
		@keyframes bounceIn {
			0% { transform: scale(0.8); opacity: 0; }
			50% { transform: scale(1.2); opacity: 0.5; }
			100% { transform: scale(1); opacity: 1; }
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
    <div class="container">
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
			$banner_path = 'images/banner-1.png';
		}
		?>
		<img src="<?php echo htmlspecialchars($banner_path); ?>" alt="Cafe Banner">
	</div>

    <header>
        <h1>About Us</h1>
    </header>

    <main class="content">
        <p>Welcome to Cat Cafe, a cozy and relaxing space where coffee and cats come together! <br><br>Our café is designed to be a haven for cat lovers, providing a warm atmosphere where you can enjoy delicious drinks and snacks while spending time with our friendly resident cats.<br><br>Whether you’re here to unwind, study, or simply enjoy some feline company, we strive to create a peaceful and inviting space for all.<br><br>Come sip, snuggle, and stay a while!</p>
		<br><br>
		<p>Find us at:<br>12, Persiaran Taman Meru 12, Taman Meru, 30020 Ipoh, Perak</p>
    </main>

    <footer class="footer">
        <p>&copy; 2025 The Purrfect Cafe. All rights reserved.</p>
    </footer>
  	</div>
</body>
</html>