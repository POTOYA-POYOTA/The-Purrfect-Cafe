<?php

include("connection.php");

date_default_timezone_set("Asia/Singapore");

$message = "";

if (isset($_POST['submit'])) {
    $name = $_POST['Name'];
    $phone = $_POST['Phone'];
    $pax = $_POST['Pax'];
    $date = $_POST['Date'];
    $time = $_POST['Time'];
    $message = $_POST['Message'];
    
    $status = "Booked";
    
    $booking_datetime = strtotime("$date $time");
    $current_datetime = time();

    if ($booking_datetime < $current_datetime) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                title: 'Invalid Booking!',
                text: 'You must select a future date and time.',
                icon: 'error',
                confirmButtonText: 'OK'
              }).then(() => {
                  window.location.href = 'contact.php';
              });
            });
            </script>";
        exit;
    }

    $sql_check = "SELECT * FROM booking WHERE date_book='$date' AND time_book='$time' AND status='Booked'";
    $query_check = mysqli_query($conn, $sql_check);
    $row = mysqli_num_rows($query_check);

    if ($row >= 10) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Time Slot Fully Booked!',
                text: 'Sorry, the selected date and time is fully booked. Please choose another slot.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'contact.php';
            });
        });
        </script>";
        exit;
    }

    $sql_insert = "INSERT INTO booking (name, phone, pax, date_book, time_book, message, status) 
                   VALUES ('$name', '$phone', '$pax', '$date', '$time', '$message', '$status')";
    $query_insert = mysqli_query($conn, $sql_insert);

    if ($query_insert) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Booking Successful!',
                text: 'Thank you for your booking. Please check your details and arrive on time.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'contact.php';
            });
        });
        </script>";
        exit;
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              title: 'Booking Failed!',
              text: '" . mysqli_error($conn) . "',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then(() => {
                  window.history.back();
              });
        });
        </script>";
    }

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="images/logo_cafe.png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book a Reservation - The Purrfect Cafe</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function validateDateTime() {
      let dateInput = document.getElementById("date").value;
      let timeInput = document.getElementById("time").value;
      let selectedDateTime = new Date(dateInput + " " + timeInput);
      let currentDateTime = new Date();

      if (selectedDateTime < currentDateTime) {
        alert("You cannot book a past date or time. Please select a future slot.");
        return false;
      }
      return true;
    }
  </script>
  <style>
    body 
	{
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #f4f4f4;
    }

    .content 
	{
      background: white;
      padding: 20px;
      width: 50%;
      margin: 50px auto;
      border-radius: 8px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    input, textarea, button 
	{
      display: block;
      width: 80%;
      margin: 10px auto;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button 
	{
      background-color: #333;
      color: white;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover 
	{
      background-color: #555;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <a href="index.php" class="nav-logo">The Purrfect Cafe</a>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="menu.php">Menu</a>
      <a href="contact.php">Booking</a>
      <a href="login.php" class="admin-login">
        <img src="images/admin-icon.png" alt="Admin Login" title="Admin Login">
      </a>
    </div>
  </div>

  <div class="content">
    <h1>Book a Reservation</h1>
    <form action="contact.php" method="post" onsubmit="return validateDateTime();">
      <label for="name">Your Name:</label>
      <input type="text" id="name" name="Name" placeholder="Your Name" required>

      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="Phone" placeholder="Your Phone Number" required>

      <label for="pax">Number of People:</label>
      <input type="number" id="pax" name="Pax" placeholder="Number of People" min="1" required>

      <label for="date">Date:</label>
      <input type="date" id="date" name="Date" required>

      <label for="time">Time:</label>
      <input type="time" id="time" name="Time" required>

      <label for="message">Special Request / Message:</label>
      <textarea id="message" name="Message" placeholder="Any special request (optional)"></textarea>

      <button type="submit" name="submit">Book Now</button>
    </form>
  </div>

  <footer class="footer">
    <p>&copy; 2025 The Purrfect Cafe. All rights reserved.</p>
  </footer>

</body>
</html>
