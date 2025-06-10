<?php

session_start();
require_once('../connection.php');

// Ensure user is logged in and authorized
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] !== 'superadmin') {
    header('Location: ../index.php'); // Redirect to login if unauthorized
    exit();
}

// Handle adding a new admin
$popup_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Validate email format (PHP validation)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $popup_message = "Invalid email format. Please enter a valid email address.";
    } else {
        // Check if both name and email already exist
        $check_query = "SELECT * FROM admins WHERE name = '$name' OR email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $popup_message = "An admin with this name or email already exists.";
        } else {
            // Default password
            $password = '12345';

            $query = "INSERT INTO admins (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
            if (mysqli_query($conn, $query)) {
                $popup_message = "New admin has been created successfully.";
            } else {
                $popup_message = "Error adding admin: " . mysqli_error($conn);
            }
        }
    }
}

// Handle deleting an admin
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $query = "DELETE FROM admins WHERE id = $delete_id";
    if (mysqli_query($conn, $query)) {
        $popup_message = "Admin has been deleted successfully.";
    } else {
        $popup_message = "Error deleting admin: " . mysqli_error($conn);
    }
}

// Fetch all admins
$query = "SELECT * FROM admins";
$result = mysqli_query($conn, $query);
$admins = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_cafe.png">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .form-container {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .form-container input, .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #218838;
        }
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: none;
        }
        .popup .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 18px;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
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
        .action-button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #555;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }
        .action-button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function showPopup(message) {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup-message').innerText = message;
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function validateForm() {
            var email = document.getElementById("email").value;
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            var errorMsg = document.getElementById("email-error");

            if (!emailPattern.test(email)) {
                errorMsg.innerText = "Please enter a valid email address.";
                return false; // Prevent form submission
            } else {
                errorMsg.innerText = "";
                return true; // Allow form submission
            }
        }
    </script>
</head>
<body>
<div class="container">
    <a href="../dashboard.php" class="back-button">&larr; Back to Dashboard</a>

    <h1>Manage Admins</h1>

    <?php if ($popup_message): ?>
        <div id="overlay" class="overlay" onclick="closePopup()"></div>
        <div id="popup" class="popup">
            <span class="close" onclick="closePopup()">&times;</span>
            <p id="popup-message"><?php echo $popup_message; ?></p>
        </div>
        <script>
            showPopup("<?php echo $popup_message; ?>");
        </script>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?php echo $admin['id']; ?></td>
                    <td><?php echo $admin['name']; ?></td>
                    <td><?php echo $admin['email']; ?></td>
                    <td><?php echo $admin['role']; ?></td>
                    <td>
                        <a href="edit_admin.php?id=<?php echo $admin['id']; ?>" class="action-button">Edit</a>
                        <a href="manage_admins.php?delete_id=<?php echo $admin['id']; ?>" class="action-button" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="form-container">
        <h2>Add New Admin</h2>
        <form method="POST" action="" onsubmit="return validateForm()">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <p id="email-error" style="color: red;"></p>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin">Admin</option>
                <option value="superadmin">Superadmin</option>
            </select>

            <button type="submit" name="add_admin">Add Admin</button>
        </form>
    </div>
</div>
</body>
</html>
