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
$foto_siswa = $connect->prepare("SELECT FOTO_SISWA FROM siswa WHERE USERNAME_SISWA = :username_siswa");
$foto_siswa->execute([
        ':username_siswa' => $username_siswa,
]);
$foto_siswas = $foto_siswa->fetch();

if (isset($_POST['update_status']) && isset($_POST['new_status'])) {
        $new_status = $_POST['new_status'];
        updatePendaftaranStatus($username_siswa, $new_status);
}
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
?>

<!DOCTYPE html>
<html lang="id">

<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Detail | siswa</title>
</head>

<body>
        <?php require_once "../components/header_admin.php";
        ?>
        <div class="admin-container">
                <h2 class="judul-riwayat">Detail Calon Siswa</h2>

                <div class="riwayat-item">
                        <div class="riwayat-header">
                                <?php if ($foto_siswas['FOTO_SISWA'] === 'default.jpg'): ?>
                                        <img src="../siswa/default.jpg" alt="Foto Siswa"><br>
                                <?php else: ?>
                                        <img src="../source/upload/images/<?= $foto_siswas['FOTO_SISWA'] ?>"
                                                alt="Foto Siswa"><br>
                                <?php endif ?>
                                <?php foreach ($siswas as $siswa): ?>
                                        <span
                                                class="status-badge status-<?= ($siswa['STATUS'] === "0" ? 'proses' : ($siswa['STATUS'] === "1" ? 'diterima' : ($siswa['STATUS'] === "2" ? 'tolak' : 'none'))) ?>">
                                                <?= ($siswa['STATUS'] === "0" ? 'Proses Verifikasi' : ($siswa['STATUS'] === "1" ? 'Diterima' : ($siswa['STATUS'] === "2" ? 'Ditolak' : 'Belum Daftar'))) ?>
                                        </span>
                                </div>

                                <div class="riwayat-detail">
                                        <div class="detail-row"><span class="detail-label">NISN:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['NISN'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">Nama Lengkap:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['NAMA_LENGKAP_SISWA'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">Jenis Kelamin:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['JENIS_KELAMIN'] ?? '-')?></span></div>
                                        <div class="detail-row"><span class="detail-label">Tanggal Lahir:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['TANGGAL_LAHIR'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">Tempat Lahir:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['TEMPAT_LAHIR'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">No Hp Siswa:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['NO_HP_SISWA'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">Asal Sekolah:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['ASAL_SEKOLAH'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">Alamat:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['ALAMAT'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">Nama Wali:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['NAMA_WALI'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">No HP Wali:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['NO_HP_WALI'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">Jurusan:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['NAMA_JURUSAN'] ?? '-' )?></span></div>
                                        <div class="detail-row"><span class="detail-label">Program Pondok:</span> <span
                                                        class="detail-value"><?= htmlspecialchars($siswa['PROGRAM_PONDOK'] ?? '-' )?></span></div>
                                </div>
                        <?php endforeach ?>
                </div>
                <?php
                $has_pendaftaran = !empty($siswas) && !empty($siswas[0]['NISN']);
                if ($has_pendaftaran):
                        ?>
                        <h3 class="judul-riwayat">Ubah Status Pendaftaran</h3>
                        <div class="verif-siswa">

                                <form method="POST">
                                        <input type="hidden" name="new_status" value="1">
                                        <button type="submit" name="update_status" class="btn-detail btn-terima">
                                                ✅ Terima (Status 1)
                                        </button>
                                </form>

                                <form method="POST">
                                        <input type="hidden" name="new_status" value="2">
                                        <button type="submit" name="update_status" class="btn-detail btn-tolak">
                                                ❌ Tolak (Status 2)
                                        </button>
                                </form>

                                <form method="POST">
                                        <input type="hidden" name="new_status" value="0">
                                        <button type="submit" name="update_status" class="btn-detail btn-proses">
                                                ⚠️ Proses (Status 0)
                                        </button>
                                </form>

                        </div>
                <?php endif; ?>

                <div class="btn-kembali">
                        <a href="riwayat_calon_siswa.php">Kembali ke Daftar</a>
                </div>
        </div>
</body>

</html>