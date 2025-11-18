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
$stmnt = $connect->prepare("
    SELECT 
        NAMA_LENGKAP_SISWA
        FROM siswa
");
$stmnt->execute();
$siswas = $stmnt->fetchAll();

global $connect;
$pendaftaran = $connect->prepare("
    SELECT 
        STATUS
    FROM pendaftaran
");
$pendaftaran->execute();
$pendaftars = $pendaftaran->fetchAll();

// Gunakan header admin
require_once "../components/header_admin.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../source/css/style.css">

    <title></title>
</head>

<body>
    <div class="admin-container">
        <h2 class="judul-riwayat">Daftar Calon Siswa</h2>

        <table class="tabel-siswa">
            <tr>
                <th>NISN</th>
                <th>Nama Lengkap</th>
                <th>Kelamin</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($siswas as $siswa): ?>
                <tr>
                    <td class="nisn_td"><?= $siswa['NISN_SISWA'] ?></td>
                    <td><?= $siswa['NAMA_LENGKAP_SISWA'] ?></td>
                    <td><?= $siswa['JENIS_KELAMIN_SISWA'] ?></td>
                    <!-- Tombol Detail -->
                    <td>
                        <a href="Bread_calon_siswa.php?nisn=<?= $siswa['NISN_SISWA'] ?>" class="btn-detail">
                            Show Detail
                        </a>
                        <a href="">Tolak</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php require_once "../components/footer.php" ?>
</body>

</html>