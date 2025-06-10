<?php

session_start();
require_once('../connection.php');

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['banner_image'])) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES['banner_image']['name']);
    
    // Move the uploaded file
    if (move_uploaded_file($_FILES['banner_image']['tmp_name'], "../" . $target_file)) {
        // Update the database with new image path
        $stmt = $conn->prepare("UPDATE banner SET image_path = ? WHERE id = 1");
        $stmt->bind_param("s", $target_file);
        
        if ($stmt->execute()) {
            $message = "Banner image updated successfully.";
        } else {
            $message = "Error updating banner: " . $conn->error;
        }
    } else {
        $message = "Error uploading file.";
    }
}

// Fetch the current banner image
$result = $conn->query("SELECT image_path FROM banner WHERE id = 1");
$row = $result->fetch_assoc();
$current_banner = $row ? $row['image_path'] : "banner-1.png";

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/png" href="images/logo_cafe.png">
  <title>Change Banner - The Purrfect Cafe</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../style.css">
  <style>
    .back-button {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 15px;
        background-color: #555;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
    }
    .back-button:hover {
        background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="content">
  <a href="../dashboard.php" class="back-button">&larr; Back to Dashboard</a>
  <h1>Change Banner Image</h1>

  <?php if (!empty($message)) : ?>
      <div class="success-message"><?php echo $message; ?></div>
  <?php endif; ?>

  <p>Current Banner:</p>
  <img src="../<?php echo $current_banner; ?>" alt="Current Banner" width="300">

  <form action="edit_banner.php" method="post" enctype="multipart/form-data">
    <input type="file" name="banner_image" required>
    <button type="submit">Upload</button>
  </form>
</div>

<footer class="footer">
  <p>&copy; 2025 The Purrfect Cafe. All rights reserved.</p>
</footer>

</body>
</html>
