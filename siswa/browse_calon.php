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

if (isset($id_pendaftarans['ID_PENDAFTARAN'])) {
    global $connect;
    $showdoc = $connect->prepare("SELECT * FROM dokumen WHERE ID_PENDAFTARAN = :id_pendaftaran");
    $showdoc->execute([':id_pendaftaran' => $id_pendaftarans['ID_PENDAFTARAN']]);
    $showdocs = $showdoc->fetchAll();
} else {
    displayErrorPopup("Kamu belum daftar");
}
require_once "../components/header.php"
    ?>
<title>Riwayat | Siswa</title>
<div class="form-container">
    <h2 class="judul-riwayat">Riwayat Pendaftaran dan Status</h2>
    <div class="riwayat-item">
        <div class="siswa-container">
            <div class="riwayat-header">
                <?php if ($siswa['FOTO_SISWA'] === "default.jpg"): ?>
                    <img src="default.jpg" alt="Foto Siswa">
                <?php else: ?>
                    <img src="../source/upload/images/<?= $siswa['FOTO_SISWA'] ?>" alt="Foto Siswa" name="foto"><br>
                <?php endif ?>
                <?php foreach ($siswas as $siswa): ?>
                    <span
                        class="status-badge status-<?= ($siswa['STATUS'] === "0" ? 'proses' : ($siswa['STATUS'] === "1" ? 'diterima' : "tolak")) ?>">
                        <?= ($siswa['STATUS'] === "0" ? 'Proses Verifikasi' : ($siswa['STATUS'] === "1" ? 'Diterima' : "Ditolak")) ?>
                    </span>
                </div>

                <div class="riwayat-detail">
                    <div class="detail-row">
                        <span class="detail-label">NISN:</span>
                        <span class="detail-value"><?= $siswa['NISN'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jenis Kelamin:</span>
                        <span class="detail-value"><?= $siswa['JENIS_KELAMIN'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal Lahir:</span>
                        <span class="detail-value"><?= $siswa['TANGGAL_LAHIR'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tempat Lahir:</span>
                        <span class="detail-value"><?= $siswa['TEMPAT_LAHIR'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">NO HP Siswa:</span>
                        <span class="detail-value"><?= $siswa['NO_HP_SISWA'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Tanggal Pendaftaran:</span>
                        <span class="detail-value"><?= $siswa['TANGGAL_PENDAFTARAN'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Asal Sekolah:</span>
                        <span class="detail-value"><?= $siswa['ASAL_SEKOLAH'] ?></span>
                    </div>
                    <div class="detail-row detail-alamat">
                        <span class="detail-label">Alamat:</span>
                        <span class="detail-value"><?= $siswa['ALAMAT'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Nama Wali:</span>
                        <span class="detail-value"><?= $siswa['NAMA_WALI'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">NO HP Wali:</span>
                        <span class="detail-value"><?= $siswa['NO_HP_WALI'] ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Jurusan:</span>
                        <span class="detail-value">
                            <?= $jurusans['NAMA_JURUSAN'] ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Program Pondok:</span>
                        <span class="detail-value"><?= $siswa['PROGRAM_PONDOK'] ?></span>
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