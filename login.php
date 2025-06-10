<?php

session_start();
require_once 'connection.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) 
	{
        $admin = mysqli_fetch_assoc($result);
        
        if ($password === $admin['password']) 
		{
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['role'] = $admin['role'];
            header('Location: dashboard.php');
            exit();
        } 
		else 
		{
            $error_message = "Password is incorrect."; //Incorrect password pop-up message
        }
    } 
	else 
	{
        $error_message = "Login unsuccessful. <br>Account does not exist.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/png" href="images/logo_cafe.png">
  <title>Login - The Purrfect Cafe</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <style>
    .login-container 
	{
      width: 300px;
      margin: 100px auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }
    .login-container h1 
	{
      text-align: center;
      margin-bottom: 20px;
    }
    label 
	{
      display: block;
      margin-bottom: 5px;
    }
    input 
	{
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .button 
	{
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .button:hover 
	{
      background-color: #218838;
    }
    .back-button 
	{
      display: block;
      margin: 10px auto;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      text-align: center;
      text-decoration: none;
      border-radius: 4px;
    }
    .back-button:hover 
	{
      background-color: #0056b3;
    }
    .error 
	{
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }
    .footer 
	{
      text-align: center;
      margin-top: 50px;
      padding: 10px;
      background-color: #333;
      color: #fff;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
  <script>
    function validateForm() {
        var email = document.getElementById("email").value;
        var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        var errorMsg = document.getElementById("email-error");

        if (!emailPattern.test(email)) 
		{
            errorMsg.innerText = "Please enter a valid email address.";
            return false;
        } 
		else 
		{
            errorMsg.innerText = "";
            return true;
        }
    }
  </script>
</head>
<body>

<div class="login-container">
  <h1>Admin Login</h1>
  <?php if (!empty($error_message)): ?>
      <p class="error"> <?php echo $error_message; ?> </p>
  <?php endif; ?>
  
  <form method="POST" action="" onsubmit="return validateForm()">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <p id="email-error" class="error"></p>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="button">Login</button>
	<a href="index.php" class="back-button">Back</a>
  </form>
</div>

<!-- Footer -->
<footer class="footer">
  <p>&copy; 2025 The Purrfect Cafe. All rights reserved.</p>
</footer>

</body>
</html>
