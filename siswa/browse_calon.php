<?php
require_once(__DIR__ . "/../config/function.php");
if (session_status() === PHP_SESSION_NONE)
    session_start();

if (!isset($_SESSION['NISN_SISWA'])) {
    header("Location: ../index.php");
    exit;
}

$nisn = $_SESSION['NISN_SISWA'];

global $connect;
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE NISN_SISWA = :nisn");
$stmnt->execute([':nisn' => $nisn]);
$siswa = $stmnt->fetch();

global $connect;
$siswas = $connect->prepare("SELECT * FROM pendaftaran WHERE NISN_SISWA = :nisn");
$siswas->execute([':nisn' => $nisn]);
$siswas = $siswas->fetchAll();

global $connect;
$id_pendaftaran = $connect->prepare("SELECT ID_PENDAFTARAN FROM pendaftaran WHERE NISN_SISWA = :nisn");
$id_pendaftaran->execute([':nisn' => $nisn]);
$id_pendaftarans = $id_pendaftaran->fetch();

if (isset($id_pendaftarans['ID_PENDAFTARAN'])) {
    global $connect;
    $showdoc = $connect->prepare("SELECT * FROM dokumen WHERE ID_PENDAFTARAN = :id_pendaftaran");
    $showdoc->execute([':id_pendaftaran' => $id_pendaftarans['ID_PENDAFTARAN']]);
    $showdocs = $showdoc->fetchAll();
} else {
    displayErrorPopup("Tolong daftar terlebih dahulu");
}
require_once "../components/header.php"
    ?>
<div class="form-container">
    <h2 class="judul-riwayat">Riwayat Pendaftaran dan Status</h2>
    <?php foreach ($siswas as $sis): ?>
        <img src="../source/upload/images/<?= $siswa['FOTO_SISWA_SISWA'] ?>" class="img-daftar" alt="">
        <p><?= $sis['TANGGAL_PENDAFTARAN'] ?></p>
        <p><?= $sis['NAMA_WALI'] ?></p>
        <p><?= $sis['NO_HP_WALI'] ?></p>
        <p>
            <?php if ($sis['STATUS'] === "0"): ?>
                Masih proses verifikasi
            <?php endif ?>
        </p>
        <p><?= $sis['JURUSAN'] ?></p>
        <p><?= $sis['JENJANG'] ?></p>
    <?php endforeach ?>
    <?php if (isset($showdocs)): ?>
        <?php foreach ($showdocs as $showdocument): ?>
            <?php if ($showdocument['JENIS_DOKUMEM'] === "Akte Kelahiran"): ?>
                <a href="../source/upload/documents/<?= $showdocument['PATH_FILE'] ?>" target="_blank">Lihat Akte</a>
            <?php elseif ($showdocument['JENIS_DOKUMEM'] === "Kartu Keluarga"): ?>
                <a href="../source/upload/documents/<?= $showdocument['PATH_FILE'] ?>" target="_blank">Lihat KK</a>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
</div>