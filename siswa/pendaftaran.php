<?php
require_once(__DIR__ . "/../config/function.php");
if (session_status() === PHP_SESSION_NONE)
    session_start();

// pastikan sudah login
if (!isset($_SESSION['NISN_SISWA'])) {
    header("Location: ../index.php");
    exit;
}
function getStickyValue($fieldName)
{
    return isset($_POST[$fieldName]) ? htmlspecialchars(trim($_POST[$fieldName])) : '';
}

$nisn = $_SESSION['NISN_SISWA'];
global $connect;

$stmnt_check_enroll = $connect->prepare("SELECT COUNT(*) FROM pendaftaran WHERE NISN_SISWA = :nisn AND STATUS = '0' OR '1' OR '2'");
$stmnt_check_enroll->execute([':nisn' => $nisn]);

if ($stmnt_check_enroll->fetchColumn() > 0) {
    $ini = $_SESSION['pendaftaran_info'] = "Maaf, kamu sudah memiliki pendaftaran yang masih diproses. Silakan cek status pendaftaran Anda.";
    echo $ini;
    header("Location: browse_calon.php");
    exit;
}



// Ambil data siswa
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE NISN_SISWA = :nisn");
$stmnt->execute([':nisn' => $nisn]);
$siswa = $stmnt->fetch();

// Ambil data jurusan dari database
$jurusan_stmnt = $connect->prepare("SELECT * FROM jurusan");
$jurusan_stmnt->execute();
$jurusans = $jurusan_stmnt->fetchAll();

if (isset($_POST['submit_pendaftaran'])) {
    addPendaftaran($_POST, $nisn);
}
require_once '../components/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa</title>
    <link rel="stylesheet" href="../source/css/style.css">
</head>

<body>
    <div class="form-container">
        <h2>Formulir Pendaftaran Siswa</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nama_wali">Nama Wali</label>
            <input type="text" name="nama_wali" id="nama_wali" placeholder="Masukkan nama wali"
                value="<?= getStickyValue('nama_wali') ?>">

            <label for="no_hp">No HP Wali</label>
            <input type="text" name="no_hp" id="no_hp" placeholder="Masukkan nomor HP wali"
                value="<?= getStickyValue('no_hp') ?>">

            <label for=" program_pondok">Pilih Program Pondok</label>
            <select name="program_pondok" id="program_pondok">
                <option value="">-- Program Pondok --</option>
                <option value="Tahfidz Alquran" <?= getStickyValue('program_pondok') == 'Tahfidz Alquran' ? 'selected' : '' ?>>Tahfidz
                    Alquran</option>
                <option value="Diniyah" <?= getStickyValue('program_pondok') == 'Diniyah' ? 'selected' : '' ?>>Diniyah
                </option>
                <option value="Qiroati" <?= getStickyValue('program_pondok') == 'Qiroati' ? 'selected' : '' ?>>Qiroati
                </option>
            </select>

            <label for="jurusan">Jurusan</label>
            <select name="jurusan" id="jurusan">
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($jurusans as $jurusan): ?>
                    <?= getStickyValue('jurusan') == trim($jurusan['NAMA_JURUSAN']) ? 'selected' : '' ?>>
                    <?= $jurusan['NAMA_JURUSAN'] ?> </option>
                <?php endforeach; ?>
            </select>

            <div class="document-upload">
                <label for="file_akte">Upload Akte Kelahiran *</label>
                <input type="file" name="file_akte" id="file_akte" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <div class="document-upload">
                <label for="file_kk">Upload Kartu Keluarga (KK) *</label>
                <input type="file" name="file_kk" id="file_kk" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <button type="submit" name="submit_pendaftaran">Daftar</button>
        </form>
    </div>
</body>

</html>