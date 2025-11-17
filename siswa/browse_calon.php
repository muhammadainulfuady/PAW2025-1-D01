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
    displayErrorPopup("Kamu belum daftar");
}
require_once "../components/header.php"
    ?>
<title>Riwayat | Siswa</title>
<div class="form-container">
    <h2 class="judul-riwayat">Riwayat Pendaftaran dan Status</h2>
    <table class="table-browse-siswa">
        <?php foreach ($siswas as $sis): ?>
            <div class="riwayat-item">
                <img src="../source/upload/images/<?= $siswa['FOTO_SISWA_SISWA'] ?>" alt="Foto">
                <tr>
                    <th>Tanggal Pendaftaran</th>
                    <th>Nama Wali</th>
                    <th>No Hp Wali</th>
                    <th>Status</th>
                    <th>Jurusan</th>
                    <th>Program</th>
                    <th>Dokumen Akte</th>
                    <th>Dokumen KK</th>
                </tr>
                <tr>
                    <td>
                        <?= $sis['TANGGAL_PENDAFTARAN'] ?>
                    </td>
                    <td>
                        <?= $sis['NAMA_WALI'] ?>
                    </td>
                    <td>
                        <?= $sis['NO_HP_WALI'] ?>
                    </td>
                    <td>
                        <?php if ($sis['STATUS'] === "0"): ?>
                            <span class="status-badge status-proses">Proses Verifikasi</span>

                        <?php elseif ($sis['STATUS'] === "1"): ?>
                            <span class="status-badge status-pending">Ditolak</span>

                        <?php else: ?>
                            <span class="status-badge status-diterima">Diterima</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $sis['JURUSAN'] ?>
                    </td>
                    <td>
                        <?= $sis['PROGRAM'] ?>
                    </td>
                    <td>
                        <?php if (isset($showdocs)): ?>
                            <div class="dokumen-list">
                                <?php foreach ($showdocs as $showdocument): ?>
                                    <?php if ($showdocument['JENIS_DOKUMEN'] === "Akte Kelahiran"): ?>
                                        <a class="link-doc" href="../source/upload/documents/<?= $showdocument['PATH_FILE'] ?>"
                                            target="_blank">
                                            Lihat Akte
                                        </a>
                                </td>
                                <td>
                                <?php elseif ($showdocument['JENIS_DOKUMEN'] === "Kartu Keluarga"): ?>
                                    <a class="link-doc" href="../source/upload/documents/<?= $showdocument['PATH_FILE'] ?>"
                                        target="_blank">
                                        Lihat KK
                                    </a>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </td>
                </tr>
            </div>
        <?php endforeach ?>
    </table>
</div>
<?php require_once "../components/footer.php" ?>