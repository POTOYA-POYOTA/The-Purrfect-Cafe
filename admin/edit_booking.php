<?php

require_once '../connection.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

$query = "SELECT name, phone, people, date, time, message FROM reservations WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    die("Booking not found");
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $people = $_POST['people'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];

    $current_datetime = new DateTime();
    $selected_datetime = new DateTime("$date $time");

    if ($selected_datetime < $current_datetime) {
        $error_message = "You cannot set a booking to a past date and time.";
    } else {
        $updateQuery = "UPDATE reservations SET name=?, phone=?, people=?, date=?, time=?, message=? WHERE id=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssisssi", $name, $phone, $people, $date, $time, $message, $id);
        $stmt->execute();

        header("Location: manage_booking.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" type="image/png" href="images/logo_cafe.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking - The Purrfect Cafe</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body 
		{
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container 
		{
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }
        h2 
		{
            text-align: center;
        }
        .form-group 
		{
            margin-bottom: 15px;
        }
        label 
		{
            font-weight: bold;
        }
        input, textarea 
		{
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn 
		{
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
            text-align: center;
            cursor: pointer;
        }
        .btn-save 
		{
            background-color: #28a745;
        }
        .btn-save:hover 
		{
            background-color: #218838;
        }
        .btn-back 
		{
            background-color: #333;
        }
        .btn-back:hover 
		{
            background-color: #555;
        }
        .error 
		{
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
    <script>
        function validateDateTime() {
            var date = document.getElementById("date").value;
            var time = document.getElementById("time").value;
            var errorMsg = document.getElementById("date-error");

            var selectedDateTime = new Date(date + " " + time);
            var currentDateTime = new Date();

            if (selectedDateTime < currentDateTime) {
                errorMsg.innerText = "You cannot select a past date and time.";
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
        <h2>Edit Booking</h2>
        <?php if (!empty($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" onsubmit="return validateDateTime()">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($booking['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($booking['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="people">People:</label>
                <input type="number" id="people" name="people" value="<?php echo htmlspecialchars($booking['people']); ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($booking['date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($booking['time']); ?>" required>
                <p id="date-error" class="error"></p>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message"><?php echo htmlspecialchars($booking['message']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-save">Save Changes</button>
            <a href="manage_booking.php" class="btn btn-back">⬅ Back to Manage Bookings</a>
        </form>
    </div>
</body>
</html>
