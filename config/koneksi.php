<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "SIPUKM";  // Nama database diganti SIPUKM

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);
?>
