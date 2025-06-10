<?php

session_start();
require_once 'connection.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$role = $_SESSION['role'];

$sessionRole = $_SESSION['role'];

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_cafe.png">
    <title>Dashboard - The Purrfect Cafe</title>
    <link rel="stylesheet" href="style.css">
    <style>
		.brand 
		{
            font-size: 24px;
            font-weight: bold;
        }
        .dashboard-container 
		{
            width: 80%;
            margin: 50px auto;
            text-align: center;
        }
        .dashboard-container h1 
		{
            margin-bottom: 20px;
        }
        .nav-links 
		{
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .nav-links a 
		{
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .nav-links a:hover 
		{
            background-color: #218838;
        }
		.logout-container 
		{
			display: flex;
			justify-content: center;
			margin: 20px 0;
		}

		.logout-button 
		{
			padding: 10px 20px;
			background-color: #dc3545;
			color: white;
			text-decoration: none;
			border-radius: 5px;
			font-size: 16px;
			font-weight: bold;
			transition: background-color 0.3s ease, transform 0.2s ease;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.logout-button:hover 
		{
			background-color: #c82333;
			transform: scale(1.05);
		}
    </style>
</head>
<body>

<div class="dashboard-container">
	<div class="brand">The Purrfect Cafe</div>
    <h1>Welcome to the Dashboard</h1>
    <div class="nav-links">
        <?php if ($sessionRole === 'superadmin'): ?>
        	<a href="admin/manage_admins.php">Manage Admins</a>
        <?php endif; ?>
        <a href="admin/edit_banner.php">Edit Banner</a>
        <a href="admin/manage_booking.php">Manage Bookings</a>
    </div>
    <br>
	<div class="logout-container">
		<a href="logout.php" class="logout-button">Logout</a>
	</div>
</div>

</body>
</html>
