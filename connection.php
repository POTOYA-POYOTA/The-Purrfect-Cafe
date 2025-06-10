<?php

$host = 'localhost'; // Database host
$username = 'root'; // Database username
$password = ''; // Database password
$database = 'the_purrfect_cafe'; // Database name

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
