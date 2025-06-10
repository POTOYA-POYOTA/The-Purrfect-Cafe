<?php

require_once '../connection.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql_delete = "DELETE FROM reservations WHERE id = $id";
    $query_delete = mysqli_query($conn, $sql_delete);

    if ($query_delete) {
        echo "<script>alert('Booking deleted successfully!'); window.location.href='manage_booking.php';</script>";
    } else {
        echo "<script>alert('Failed to delete booking: " . mysqli_error($conn) . "');</script>";
    }
}

$query = "SELECT id, name, phone, people, date, time, message FROM reservations ORDER BY date, time";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" type="image/png" href="images/logo_cafe.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - The Purrfect Cafe</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body 
		{
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 
		{
            text-align: center;
        }
        .back-button 
		{
            display: block;
            width: 200px;
            margin: 10px auto;
            padding: 10px;
            background-color: #333;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover 
		{
            background-color: #555;
        }
        table 
		{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td 
		{
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th 
		{
            background-color: #333;
            color: white;
        }
        .action-buttons 
		{
            display: flex;
            gap: 10px;
        }
        .btn 
		{
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
            text-align: center;
        }
        .btn-edit 
		{
            background-color: #007bff;
        }
        .btn-delete 
		{
            background-color: #dc3545;
        }
        .btn:hover 
		{
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <a href="../dashboard.php" class="back-button">⬅ Back to Dashboard</a>

    <h2>Manage Bookings</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>People</th>
            <th>Date</th>
            <th>Time</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['people']); ?></td>
            <td><?php echo htmlspecialchars($row['date']); ?></td>
            <td><?php echo htmlspecialchars($row['time']); ?></td>
            <td><?php echo htmlspecialchars($row['message']); ?></td>
            <td class="action-buttons">
                <a href="edit_booking.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
