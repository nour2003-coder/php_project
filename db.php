<?php
$servername = "localhost";
$username = "nour";
$password = "21644162nour"; // Replace with your MySQL password
$dbname = "Bibliotheque";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
