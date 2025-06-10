<?php

require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $people = (int)$_POST['people'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($phone) && $people > 0 && !empty($date) && !empty($time)) {
        $stmt = $conn->prepare("INSERT INTO reservations (name, phone, people, date, time, message) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisss", $name, $phone, $people, $date, $time, $message);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }

        $stmt->close();
    } else {
        echo "invalid";
    }
}

$conn->close();

?>
