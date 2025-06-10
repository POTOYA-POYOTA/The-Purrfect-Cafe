<?php

require_once('connection.php');

$result = $conn->query("SELECT image_path FROM banner WHERE id = 1");

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $banner_image = isset($row['image_path']) ? $row['image_path'] : "images/banner-1.png"; 
} else {
    $banner_image = "images/banner-1.png";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="images/logo_cafe.png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    .banner-container 
	{
      position: relative;
	  width: 100%;
      height: auto;
      background: url('images/banner-1.png') no-repeat center center/cover;
      animation: fadeIn 2s ease-in-out;
      margin-bottom: 0;
      padding-bottom: 0;
	  display: block;
    }
	/* Content Animation */
	.content 
	{
	  text-align: center;
	  margin-top: 0;
	  opacity: 0;
	  transform: translateY(20px);
	  animation: fadeIn 1.5s ease-out forwards;
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
	.button-container 
	{
		margin-top: 20px;
		text-align: center;
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 15px;
	}

	.btn 
	{
		display: block;
		width: 400px;
		padding: 12px 0;
		font-size: 16px;
		font-weight: bold;
		color: black;
		background-color: #EFDC75;
		text-align: center;
		text-decoration: none;
		border-radius: 5px;
		transition: all 0.3s ease-in-out;
		box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
		opacity: 0;
		transform: translateX(-100%);
		animation: slideIn 0.8s ease-out forwards;
	}

	.btn:nth-child(1) 
	{
		animation-delay: 0.2s;
	}

	.btn:nth-child(2) 
	{
		animation-delay: 0.4s;
	}

	.btn:nth-child(3) 
	{
		animation-delay: 0.6s;
	}

	.btn:hover 
	{
		background-color: #808080;
		transform: scale(1.1);
		box-shadow: 0 8px 10px rgba(0, 0, 0, 0.2);
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

	/* Keyframes for slide-in animation */
	@keyframes slideIn 
	{
		from {
			opacity: 0;
			transform: translateX(-100%);
		}
		to {
			opacity: 1;
			transform: translateX(0);
		}
	}
  </style>
  <title>The Purrfect Cafe</title>
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

  <!-- Content Section -->
  <div class="content">
    <h1>Welcome to The Purrfect Cafe</h1>
    <p>Your cozy getaway with delightful treats and feline companions.</p>
	<div class="button-container">
    	<a href="menu.php" class="btn">Check our menu here.</a>
   		<a href="about.php" class="btn">Find more about us.</a>
		<a href="contact.php" class="btn">Book your reservation here.</a>
  	</div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2025 The Purrfect Cafe. All rights reserved.</p>
  </footer>
</body>
</html>