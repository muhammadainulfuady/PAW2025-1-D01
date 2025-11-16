<?php
require_once(__DIR__ . "/../config/function.php");

if (session_status() === PHP_SESSION_NONE)
    session_start();

// Pastikan ADMIN sudah login
if (!isset($_SESSION['ADMIN_ID'])) {
    header("Location: ../index.php");
    exit;
}

// Ambil semua siswa dari database
global $connect;
$nisn = $_GET['nisn'];
$stmnt = $connect->prepare("
    SELECT 
        NISN_SISWA,
        NAMA_LENGKAP_SISWA,
        TANGGAL_LAHIR_SISWA,
        NO_TELPON_SISWA,
        ALAMAT_SISWA,
        JENIS_KELAMIN_SISWA
    FROM siswa WHERE NISN_SISWA = '$nisn'
");
$stmnt->execute();
$siswas = $stmnt->fetchAll();

// Gunakan header admin
require_once "../components/header_admin.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>

<body>
    <div class="admin-container">
        <h2 class="judul-riwayat">Daftar Calon Siswa</h2>

        <table class="tabel-siswa">
            <tr>
                <th>NISN</th>
                <th>Nama Lengkap</th>
                <th>Asal</th>
                <th>Tanggal Lahir</th>
                <th>No Telepon</th>
                <th>Jenis Kelamin</th>
            </tr>

            <?php foreach ($siswas as $siswa): ?>
                <tr>
                    <td><?= $siswa['NISN_SISWA'] ?></td>
                    <td><?= $siswa['NAMA_LENGKAP_SISWA'] ?></td>
                    <td><?= $siswa['ALAMAT_SISWA'] ?></td>
                    <td><?= $siswa['TANGGAL_LAHIR_SISWA'] ?></td>
                    <td><?= $siswa['NO_TELPON_SISWA'] ?></td>
                    <td><?= $siswa['JENIS_KELAMIN_SISWA'] ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
        <div class="btn-kembali">
            <a href="browse_calon.php">Kembali</a>
        </div>

</body>

</html>