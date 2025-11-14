<!-- daftar riwayat pendaftaran siswa
status pendaftaran
(Wajib sesuai persyaratan!) -->
<?php
require_once("../config/function.php");
if (session_status() === PHP_SESSION_NONE)
    session_start();

// pastikan sudah login
if (!isset($_SESSION['NISN_SISWA'])) {
    header("Location: ../index.php");
    exit;
}

$nisn = $_SESSION['NISN_SISWA'];

// Ambil data siswa
global $connect;
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE NISN_SISWA = :nisn");
$stmnt->execute([':nisn' => $nisn]);
$siswa = $stmnt->fetch();
require_once "../components/header.php"
    ?>
<h1>ini nanti siswa bisa tahu dia sudah ngisi apa saja</h1>