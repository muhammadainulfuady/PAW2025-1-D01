<!-- Koneksi PDO ke MySQL -->
<?php

// koneksi ke database
$host = "localhost";
$dbname = "paw2025-1-d01_dump";
$username = "root";
$password = "";
try {
    $connect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $err) {
    echo "Koneksi Gagal: " . $err->getMessage();
    die();
}