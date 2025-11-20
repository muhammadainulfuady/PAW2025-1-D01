<?php
require_once(__DIR__ . "/../config/function.php");
if (session_status() === PHP_SESSION_NONE)
    session_start();

// untuk memastikan bahwa siswa itu sudah login atau tidak
$username_siswa = $_SESSION['USERNAME_SISWA'];
if (!isset($_SESSION['USERNAME_SISWA'])) {
    header("Location: ../index.php");
    exit;
}


// query untuk menampilkan nama yang ada di dalam header kanan atas sampingnya foto profile
global $connect;
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE USERNAME_SISWA = :username_siswa");
$stmnt->execute([':username_siswa' => $username_siswa]);
$siswa = $stmnt->fetch();

// query untuk menampilkan dari tanggal pendaftaran sampai dengan status
global $connect;
$siswa_qry = $connect->prepare("SELECT * FROM pendaftaran WHERE USERNAME_SISWA = :username_siswa");
$siswa_qry->execute([':username_siswa' => $username_siswa]);
$siswas = $siswa_qry->fetchAll();

// query untuk menampilkan jurusan
global $connect;
$jurusan_qry = $connect->prepare("
SELECT 
        p.*, 
        j.NAMA_JURUSAN
    FROM pendaftaran p
    INNER JOIN jurusan j ON p.ID_JURUSAN = j.ID_JURUSAN
    WHERE p.USERNAME_SISWA = :username_siswa
    ORDER BY p.TANGGAL_PENDAFTARAN DESC");
$jurusan_qry->execute([':username_siswa' => $username_siswa]);
$jurusans = $jurusan_qry->fetch();

// query untuk menampilkan id pendaftaran
global $connect;
$id_pendaftaran = $connect->prepare("SELECT ID_PENDAFTARAN FROM pendaftaran WHERE USERNAME_SISWA = :username_siswa");
$id_pendaftaran->execute([':username_siswa' => $username_siswa]);
$id_pendaftarans = $id_pendaftaran->fetch();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat | Siswa</title>
    <link rel="stylesheet" href="../source/css/style.css">

</head>

<body>
    <?php require_once "../components/header.php" ?>
    <?php
    if (isset($id_pendaftarans['ID_PENDAFTARAN'])) {
        global $connect;
        $showdoc = $connect->prepare("SELECT * FROM dokumen WHERE ID_PENDAFTARAN = :id_pendaftaran");
        $showdoc->execute([':id_pendaftaran' => $id_pendaftarans['ID_PENDAFTARAN']]);
        $showdocs = $showdoc->fetchAll();
    } else {
        displayErrorPopup("Kamu belum daftar");
    }
    ?>
    <div class="form-container">
        <?php if (isset($_SESSION['BERHASIL_DAFTAR'])): ?>
            <div class='popup-success'>
                <?= $_SESSION['BERHASIL_DAFTAR'] ?>
            </div>
            <?php unset($_SESSION['BERHASIL_DAFTAR']) ?>
        <?php endif ?>
        <h2 class="judul-riwayat">Riwayat Pendaftaran dan Status</h2>

        <div class="siswa-container">
            <?php foreach ($siswas as $data_pendaftaran): ?>
                <div class="riwayat-item">
                    <div class="riwayat-header">
                        <?php if ($siswa['FOTO_SISWA'] === "default.jpg"): ?>
                            <img src="default.jpg" alt="Foto Siswa">
                        <?php else: ?>
                            <img src="../source/upload/images/<?= $siswa['FOTO_SISWA'] ?>" alt="Foto Siswa" class="siswa-foto">
                        <?php endif ?>

                        <span
                            class="status-badge status-<?= ($data_pendaftaran['STATUS'] === "0" ? 'proses' : ($data_pendaftaran['STATUS'] === "1" ? 'diterima' : "tolak")) ?>">
                            <?= ($data_pendaftaran['STATUS'] === "0" ? 'Proses Verifikasi' : ($data_pendaftaran['STATUS'] === "1" ? 'Diterima' : "Ditolak")) ?>
                        </span>
                    </div>

                    <div class="riwayat-detail">
                        <div class="detail-row">
                            <span class="detail-label">NISN:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['NISN']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Jenis Kelamin:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['JENIS_KELAMIN']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal Lahir:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['TANGGAL_LAHIR']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tempat Lahir:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['TEMPAT_LAHIR']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">NO HP Siswa:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['NO_HP_SISWA']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Tanggal Pendaftaran:</span>
                            <span
                                class="detail-value"><?= htmlspecialchars($data_pendaftaran['TANGGAL_PENDAFTARAN']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Asal Sekolah:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['ASAL_SEKOLAH']) ?></span>
                        </div>
                        <div class="detail-row detail-alamat">
                            <span class="detail-label">Alamat:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['ALAMAT']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Nama Wali:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['NAMA_WALI']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">NO HP Wali:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['NO_HP_WALI']) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Jurusan:</span>
                            <span class="detail-value">
                                <?= htmlspecialchars($jurusans['NAMA_JURUSAN']) ?>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Program Pondok:</span>
                            <span class="detail-value"><?= htmlspecialchars($data_pendaftaran['PROGRAM_PONDOK']) ?></span>
                        </div>
                    </div>

                    <div class="riwayat-dokumen">
                        <span class="dokumen-label">Dokumen:</span>
                        <?php if (isset($showdocs)): ?>
                            <div class="dokumen-list">
                                <?php foreach ($showdocs as $showdocument): ?>
                                    <?php if ($showdocument['JENIS_DOKUMEN'] === "Akte Kelahiran"): ?>
                                        <a class="link-doc" href="../source/upload/documents/<?= $showdocument['PATH_FILE'] ?>"
                                            target="_blank">Lihat Akte</a>
                                    <?php elseif ($showdocument['JENIS_DOKUMEN'] === "Kartu Keluarga"): ?>
                                        <a class="link-doc" href="../source/upload/documents/<?= $showdocument['PATH_FILE'] ?>"
                                            target="_blank">Lihat KK</a>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <?php require_once "../components/footer.php" ?>
</body>

</html>