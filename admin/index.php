<?php

include '../components/header_admin.php';
require_once(__DIR__ . "/../config/function.php");
require_once(__DIR__ . "/../config/database.php");
if (session_status() === PHP_SESSION_NONE)
    session_start();

if (!isset($_SESSION['ADMIN_ID'])) {
    header("Location: ../index.php");
    exit;
}

// mengambil banyak siswa yang sudah daftar sekolah
global $connect;
$count_siswa_ = $connect->prepare("SELECT COUNT(*) AS BANYAK_SISWA FROM siswa");
$count_siswa_->execute();
$counts_siswa = $count_siswa_->fetch();

// mengambil banyak jurusan ada berapa di dalam sekolah
global $connect;
$count_jurusan_ = $connect->prepare("SELECT COUNT(*) AS BANYAK_JURUSAN FROM jurusan");
$count_jurusan_->execute();
$counts_jurusan = $count_jurusan_->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../source/css/style.css">
</head>

<body>
    <div class="container-siswa">
        <h2>Selamat datang di beranda admin</h2>
        <p>kelola data,edit jurusan siswa baru Pesantern AL - AMIN </p>
        <div>
            <div class="dashboard-container">
                <a href="../admin/riwayat_calon_siswa.php" class="dashboard-card">
                    Siswa <?= $counts_siswa['BANYAK_SISWA'] ?>
                    <div class="img-dashboard-admin">
                        <img src="../source/images/siswa_sekolah.png" alt="">
                    </div>
                </a>
                <a href="../admin/Ddelete_jurusan.php" class="dashboard-card">
                    Jurusan <?= $counts_jurusan['BANYAK_JURUSAN'] ?>
                    <div class="img-dashboard-admin">
                        <img src="../source/images/siswa_sekolah.png" alt="">
                    </div>
                </a>
            </div>
</body>

</html>