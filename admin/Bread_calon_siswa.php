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
$username_siswa = $_GET['username'];
$stmnt = $connect->prepare("
SELECT 
        p.NISN,
        s.USERNAME_SISWA,
        s.NAMA_LENGKAP_SISWA,
        p.TANGGAL_LAHIR,
        p.NO_HP_SISWA,
        p.ALAMAT,
        p.JENIS_KELAMIN,
        p.TEMPAT_LAHIR,
        p.ASAL_SEKOLAH,
        p.NAMA_WALI,
        p.NO_HP_WALI,
        p.PROGRAM_PONDOK,
        p.STATUS,
        j.NAMA_JURUSAN
    FROM siswa s
    LEFT JOIN pendaftaran p ON s.USERNAME_SISWA = p.USERNAME_SISWA
    LEFT JOIN jurusan j ON p.ID_JURUSAN = j.ID_JURUSAN
    WHERE s.USERNAME_SISWA = '$username_siswa'
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
        <h2 class="judul-riwayat">Detail Calon Siswa</h2>

        <div class="riwayat-item">
            <div class="riwayat-header">
                <img src="../siswa/default.jpg" alt="Foto Siswa" class="siswa-foto">
                <?php foreach ($siswas as $siswa): ?>
                    <span
                        class="status-badge status-<?= ($siswa['STATUS'] === "0" ? 'proses' : ($siswa['STATUS'] === "1" ? 'diterima' : ($siswa['STATUS'] === "2" ? 'pending' : 'none'))) ?>">
                        <?= ($siswa['STATUS'] === "0" ? 'Proses Verifikasi' : ($siswa['STATUS'] === "1" ? 'Diterima' : ($siswa['STATUS'] === "2" ? 'Ditolak' : 'Belum Daftar'))) ?>
                    </span>
                </div>

                <div class="riwayat-detail">
                    <div class="detail-row"><span class="detail-label">NISN:</span> <span
                            class="detail-value"><?= $siswa['NISN'] ?></span></div>
                    <div class="detail-row"><span class="detail-label">Nama Lengkap:</span> <span
                            class="detail-value"><?= $siswa['NAMA_LENGKAP_SISWA'] ?></span></div>
                    <div class="detail-row"><span class="detail-label">Jenis Kelamin:</span> <span
                            class="detail-value"><?= $siswa['JENIS_KELAMIN'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">Tanggal Lahir:</span> <span
                            class="detail-value"><?= $siswa['TANGGAL_LAHIR'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">Tempat Lahir:</span> <span
                            class="detail-value"><?= $siswa['TEMPAT_LAHIR'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">No Telepon Siswa:</span> <span
                            class="detail-value"><?= $siswa['NO_HP_SISWA'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">Asal Sekolah:</span> <span
                            class="detail-value"><?= $siswa['ASAL_SEKOLAH'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">Alamat:</span> <span
                            class="detail-value"><?= $siswa['ALAMAT'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">Nama Wali:</span> <span
                            class="detail-value"><?= $siswa['NAMA_WALI'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">No HP Wali:</span> <span
                            class="detail-value"><?= $siswa['NO_HP_WALI'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">Jurusan:</span> <span
                            class="detail-value"><?= $siswa['NAMA_JURUSAN'] ?? '-' ?></span></div>
                    <div class="detail-row"><span class="detail-label">Program Pondok:</span> <span
                            class="detail-value"><?= $siswa['PROGRAM_PONDOK'] ?? '-' ?></span></div>
                </div>
            <?php endforeach ?>
        </div>

        <div class="btn-kembali">
            <a href="riwayat_calon_siswa.php">Kembali ke Daftar</a>
        </div>
    </div>
</body>

</html>