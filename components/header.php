<?php
// header.php
$nisn = $_SESSION['NISN_SISWA'];
require_once("../config/function.php");

// Ambil data siswa
global $connect;
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE NISN_SISWA = :nisn");
$stmnt->execute([':nisn' => $nisn]);
$siswa = $stmnt->fetch();
?>
<link rel="stylesheet" href="../source/css/header.css">
 <header>
    <div class="container">
        <h1 class="logo">NAMA PESANTREEEEEN</h1>
<nav>
    <ul>
        <li><a href="../dashboard/index.php">Beranda</a></li>
        <li><a href="../dashboard/daftar_siswa.php">Informasi</a></li>
        <li><a href="../auth/logout.php">Logout</a></li>
        <li>
            <a href="../siswa/edit_siswa.php">
                <img src="../source/upload/images/<?= $siswa['FOTO_SISWA_SISWA']; ?>" alt="Foto Siswa" style="width:40px; height:40px; border-radius:50%;">
            </a>
        </li>
    </ul>
</nav>
</div>
</header>