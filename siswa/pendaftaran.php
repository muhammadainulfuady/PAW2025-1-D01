<link rel="stylesheet" href="../source/css/style.css">
<?php
require_once(__DIR__ . "/../config/function.php");
if (session_status() === PHP_SESSION_NONE)
    session_start();

$username_siswa = $_SESSION['USERNAME_SISWA'];
// pastikan sudah login
if (!isset($_SESSION['USERNAME_SISWA'])) {
    header("Location: ../index.php");
    exit;
}
function getStickyValue($fieldName)
{
    return isset($_POST[$fieldName]) ? htmlspecialchars(trim($_POST[$fieldName])) : '';
}


global $connect;
$stmnt_check_enroll = $connect->prepare("SELECT COUNT(*) FROM pendaftaran WHERE USERNAME_SISWA = :username_siswa AND STATUS = '0'");
$stmnt_check_enroll->execute([':username_siswa' => $username_siswa]);


// Ambil data siswa
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE USERNAME_SISWA = :username_siswa");
$stmnt->execute([':username_siswa' => $username_siswa]);
$siswa = $stmnt->fetch();

// Ambil data jurusan dari database
$jurusan_stmnt = $connect->prepare("SELECT * FROM jurusan");
$jurusan_stmnt->execute();
$jurusans = $jurusan_stmnt->fetchAll();
// Ambil status pendaftaran siswa
$check = $connect->prepare("
    SELECT STATUS 
    FROM pendaftaran 
    WHERE USERNAME_SISWA = :username_siswa
    ORDER BY ID_PENDAFTARAN DESC
    LIMIT 1
");
$check->execute([':username_siswa' => $username_siswa]);
$status = $check->fetchColumn();

// verifikasi
if ($status === "0") {
    $message = "Pendaftaran Anda Di Proses";
    echo "<title>Siswaa proses</title>";
    echo "
        <div class='text-proses'>
            <span class='proses-icon'>⚠️⚠️<span>
            <p class='proses-siswa'>{$message}</p>
        </div>";
    echo "<a href='browse_calon.php' class='btn-kembali-pusat'>Kembali</a>";
    die;
} elseif ($status === "2") {
    echo "<title>Siswaa ditolak</title>";
    $message = "Pendaftaran Anda Di Tolak";
    echo "
        <div class='text-tolak'>
            <span class='tolak-icon'>❌❌<span>
            <p class='tolak-siswa'>{$message}</p>
        </div>";
    echo "<a href='browse_calon.php' class='btn-kembali-pusat'>Kembali</a>";
    die;
} elseif ($status === "1") {
    echo "<title>Siswaa diterima</title>";
    $message = "Pendaftaran Anda Diterima.";
    echo "
        <div class='text-terima'>
            <span class='terima-icon'>✔️✔️<span>
            <p class='terima-siswa'>{$message}</p>
        </div>";
    echo "<a href='browse_calon.php' class='btn-kembali-pusat'>Kembali</a>";
    die;
} else {

}
if (isset($_POST['submit_pendaftaran'])) {
    addPendaftaran($_POST, $username_siswa);
}
require_once '../components/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran | Siswa</title>
    <link rel="stylesheet" href="../source/css/style.css">
</head>

<body>
    <div class="form-container">
        <h2>Formulir Pendaftaran Siswa</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="nisn_siswa">NISN</label>
            <input type="text" name="nisn_siswa" id="nisn_siswa" placeholder="Masukkan nisn"
                value="<?= getStickyValue('nisn_siswa') ?>">

            <label for="jenis_kelamin">Jenis kelamin siswa</label>
            <select name="jenis_kelamin" id="jenis_kelamin">
                <option value="L" <?= getStickyValue('jenis_kelaim') == 'Laki - Laki' ? 'selected' : '' ?>>
                    Laki - Laki</option>
                <option value="P" <?= getStickyValue('jenis_kelaim') == 'Perempuan' ? 'selected' : '' ?>>
                    Perempuan</option>
            </select>

            <label for="tanggal_lahir">Masukkan tanggal lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" placeholder="Contoh 12-05-2021"
                value="<?= getStickyValue("tanggal_lahir") ?>">

            <label for="tempat_lahir">Masukkan tempat lahir</label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Gresik"
                value="<?= getStickyValue("tempat_lahir") ?>">

            <label for="no_hp_siswa">No hp siswa</label>
            <input type="text" name="no_hp_siswa" id="no_hp_siswa" placeholder="Masukkan no siswa"
                value="<?= getStickyValue("no_hp_siswa") ?>">

            <label for="asal_sekolah">Asal sekolah</label>
            <input type="text" name="asal_sekolah" id="asal_sekolah" placeholder="Masukkan asal sekolah"
                value="<?= getStickyValue("asal_sekolah") ?>">

            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat"
                value="<?= getStickyValue("alamat") ?>">

            <label for="nama_wali">Nama wali</label>
            <input type="text" name="nama_wali" id="nama_wali" placeholder="Masukkan nama wali"
                value="<?= getStickyValue("nama_wali") ?>">

            <label for="no_hp_wali">No hp wali</label>
            <input type="text" name="no_hp_wali" id="no_hp_wali" placeholder="Masukkan no wali"
                value="<?= getStickyValue("no_hp_wali") ?>">

            <label for="program_pondok">Pilih Program Pondok</label>
            <select name="program_pondok" id="program_pondok">
                <option value="">-- Program Pondok --</option>
                <option value="Tahfidz Alquran" <?= getStickyValue('program_pondok') == 'Tahfidz Alquran' ? 'selected' : '' ?>>Tahfidz
                    Alquran</option>
                <option value="Diniyah" <?= getStickyValue('program_pondok') == 'Diniyah' ? 'selected' : '' ?>>Diniyah
                </option>
                <option value="Qiroati" <?= getStickyValue('program_pondok') == 'Qiroati' ? 'selected' : '' ?>>Qiroati
                </option>
            </select>

            <label for="id_jurusan">Jurusan</label>
            <select name="id_jurusan" id="id_jurusan">
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($jurusans as $jurusan): ?>
                    <option>
                        <?= $jurusan['NAMA_JURUSAN'] ?>
                    </option>
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