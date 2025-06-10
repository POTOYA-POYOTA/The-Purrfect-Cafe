<?php

session_start();
require_once('../connection.php');

if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'superadmin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $admin_id = intval($_GET['id']);
    $query = "SELECT * FROM admins WHERE id = $admin_id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
    } else {
        echo "Admin not found.";
        exit();
    }
} else {
    echo "No admin ID provided.";
    exit();
}

$error_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	{
        $error_message = "Invalid email format. Please enter a valid email address.";
    } 
	else 
	{
        $check_query = "SELECT * FROM admins WHERE (name = '$name' OR email = '$email') AND id != $admin_id";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) 
		{
            $error_message = "An admin with this name or email already exists.";
        } 
		else 
		{
            // Update admin details
            $update_query = "UPDATE admins SET name = '$name', email = '$email', role = '$role' WHERE id = $admin_id";
            if (mysqli_query($conn, $update_query)) 
			{
                header('Location: manage_admins.php?message=Admin updated successfully.');
                exit();
            } 
			else 
			{
                $error_message = "Error updating admin: " . mysqli_error($conn);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_cafe.png">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .container 
		{
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .container input, .container select 
		{
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .container button 
		{
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .container button:hover 
		{
            background-color: #0056b3;
        }
        .error 
		{
            color: red;
        }
    </style>
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            var errorMsg = document.getElementById("email-error");

            if (!emailPattern.test(email)) {
                errorMsg.innerText = "Please enter a valid email address.";
                return false;
            } else {
                errorMsg.innerText = "";
                return true;
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Edit Admin</h1>
    <?php if (!empty($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST" action="" onsubmit="return validateForm()">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
        <p id="email-error" class="error"></p>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="admin" <?php echo ($admin['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="superadmin" <?php echo ($admin['role'] === 'superadmin') ? 'selected' : ''; ?>>Superadmin</option>
        </select>

        <button type="submit">Update Admin</button>
    </form>
    <a href="manage_admins.php" style="text-decoration: none; display: block; margin-top: 20px; text-align: center;">Back to Manage Admins</a>
</div>
</body>
</html>
