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
        p.NISN,
        s.USERNAME_SISWA,
        s.NAMA_LENGKAP_SISWA, 
        p.JENIS_KELAMIN,
        p.STATUS,
        p.ID_PENDAFTARAN
    FROM siswa s
    LEFT JOIN pendaftaran p ON s.USERNAME_SISWA = p.USERNAME_SISWA
    ORDER BY s.NAMA_LENGKAP_SISWA ASC
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
                <th>Nama Lengkap</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($siswas as $siswa): ?>
                <tr>
                    <td><?= $siswa['NAMA_LENGKAP_SISWA'] ?></td>
                    <!-- Tombol Detail -->
                    <td>
                        <a href="Bread_calon_siswa.php?username=<?= $siswa['USERNAME_SISWA'] ?>" class="btn-detail">
                            Show Detail
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php require_once "../components/footer.php" ?>
</body>

</html>