<?php
require_once(__DIR__ . "/../config/function.php");
if (!isset($_SESSION['USERNAME_SISWA'])) {
    header("Location: ../index.php");
    exit;
}
$username_siswa = $_SESSION['USERNAME_SISWA'];
global $connect;
// Ambil data siswa
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE USERNAME_SISWA = :username_siswa");
$stmnt->execute([':username_siswa' => $username_siswa]);
$siswa = $stmnt->fetch();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../source/css/style.css">
    <title>Dashboard Siswa</title>
</head>

<body>
    <?php include '../components/header.php'; ?>
    <section class="dashboard-siswa">
        <?php if (isset($_SESSION['BERHASIL_LOGIN'])): ?>
            <div class='popup-success'>
                <?= $_SESSION['BERHASIL_LOGIN'] ?>
            </div>
            <?php unset($_SESSION['BERHASIL_LOGIN']) ?>
        <?php endif ?>
        <?php if (isset($_SESSION['BERHASIL_EDIT'])): ?>
            <div class='popup-success'>
                <?= $_SESSION['BERHASIL_EDIT'] ?>
            </div>
            <?php unset($_SESSION['BERHASIL_EDIT']) ?>
        <?php endif ?>
        <div class="container-siswa">
            <h2>Tahun Ajaran 2025/2026</h2>
            <p>Sekolah Berbasis Pesantren Modern yang Berkomitmen Mencetak Generasi Qur'ani, Unggul dalam Prestasi
                Akademik, Mandiri, Berjiwa Pemimpin, dan Berakhlakul Karimah untuk Membangun Peradaban Islam yang
                Gemilang.</p>
        </div>
        <div class="visi-misi">
            <h3>🏫 Visi</h3>
            <p>“Menjadi lembaga pendidikan berbasis pesantren modern yang unggul dalam pembentukan generasi Qur’ani,
                berakhlak mulia, berwawasan global, dan berjiwa kepemimpinan.”</p>
            <h3>🎯 Misi</h3>
            <p>
                Menanamkan nilai-nilai keislaman melalui kegiatan keagamaan yang terintegrasi dalam seluruh aspek
                pendidikan.
            </p>
        </div>
        <div class="visi-misi">
            <h3>Cara mendaftar</h3>
            <ol type="1">
                <li>Klik pendaftaran di atas</li>
                <li>Masukkan data diri kamu</li>
                <li>Usahakan semuanya terpenuhi di pendaftaran</li>

            </ol>
            <a href="../siswa/pendaftaran.php" class="btn-dft">Ayo mendaftar</a>
        </div>
        <?php require_once "../components/footer.php" ?>
    </section>
</body>

</html>