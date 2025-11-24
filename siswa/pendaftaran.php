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
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../source/css/style.css'>
        <title>Di proeses</title>
    </head>
    <body>
    <div class='text-proses'>
        <p class='proses-siswa proses-iscon'>⚠️⚠️ {$message}</p>
    </div>
        <a href='browse_calon.php' class='btn-kembali-pusat'>Kembali</a>
    </body>
    </html>";
    die;
} elseif ($status === "2") {
    $message = "Pendaftaran Anda Di Tolak";
    echo " 
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../source/css/style.css'>
        <title>Di tolak</title>
    </head>
    <body>
    <div class='text-tolak'>
        <p class='tolak-siswa tolak-iscon'>❌❌ {$message}</p>
    </div>
        <a href='browse_calon.php' class='btn-kembali-pusat'>Kembali</a>
    </body>
    </html>";
    die;
} elseif ($status === "1") {
    $message = "Pendaftaran Anda Diterima.";
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../source/css/style.css'>
        <title>Di terima</title>
    </head>
    <body>
    <div class='text-terima'>
        <p class='terima-siswa terima-icon'>✔️✔️ {$message}</p>
    </div>
        <a href='browse_calon.php' class='btn-kembali-pusat'>Kembali</a>
    </body>
    </html>";
    die;
}
$eror = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nisn_siswa = $_POST['nisn_siswa'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $tempat_lahir = $_POST['tempat_lahir'] ?? '';
    $no_hp_siswa = $_POST['no_hp_siswa'] ?? '';
    $asal_sekolah = $_POST['asal_sekolah'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $nama_wali = $_POST['nama_wali'] ?? '';
    $no_hp_wali = $_POST['no_hp_wali'] ?? '';
    $program_pondok = $_POST['program_pondok'] ?? '';
    $id_jurusan = $_POST['id_jurusan'] ?? '';
    $file_akte = $_FILES['file_akte'] ?? '';
    $file_kk = $_FILES['file_kk'] ?? '';
    valNisn($nisn_siswa, $eror);
    valTanggalLahir($tanggal_lahir, $eror);
    valJenisKelamin($jenis_kelamin, $eror);
    valTempatLahir($tempat_lahir, $eror);
    valNoHpSiswa($no_hp_siswa, $eror);
    valAsalSekolah($asal_sekolah, $eror);
    valAlamat($alamat, $eror);
    valNamaWali($nama_wali, $eror);
    valNoHpWali($no_hp_wali, $eror);
    valProgramPondok($program_pondok, $eror);
    valJurusan($id_jurusan, $eror);
    valFileAkte($file_akte, $eror);
    valFileKK($file_kk, $eror);

    if (empty($eror)) {
        addPendaftaran($_POST, $username_siswa);
    }
}
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
    <?php require_once '../components/header.php'; ?>
    <div class="form-container">
        <h2>Formulir Pendaftaran Calon Siswa 2025/2026</h2>
        <form action="#" method="POST" enctype="multipart/form-data">

            <label for="nisn_siswa">NISN</label>
            <input type="text" name="nisn_siswa" id="nisn_siswa" placeholder="Masukkan nisn" value="<?php if (!isset($eror['nisn_siswa'])) {
                echo getStickyValue('nisn_siswa');
            } ?>">

            <p class="eror-validasi"><?= $eror["nisn_siswa"] ?? "" ?></p>


            <label for="jenis_kelamin">Jenis kelamin siswa</label>
            <select name="jenis_kelamin" id="jenis_kelamin">
                <option value="">-- Jenis Kelamin --</option>
                <option value="L" <?= getStickyValue('jenis_kelamin') == 'L' ? 'selected' : '' ?>>
                    Laki - Laki</option>
                <option value="P" <?= getStickyValue('jenis_kelmin') == 'P' ? 'selected' : '' ?>>
                    Perempuan</option>
            </select>

            <p class="eror-validasi"><?= $eror["jenis_kelamin"] ?? "" ?></p>


            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="<?php if (!isset($eror['tanggal_lahir'])) {
                echo getStickyValue('tanggal_lahir');
            } ?>">

            <p class="eror-validasi"><?= $eror["tanggal_lahir"] ?? "" ?></p>

            <label for="tempat_lahir">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" placeholder="Contoh : Bungah Gresik" value="<?php if (!isset($eror['tempat_lahir'])) {
                echo getStickyValue('tempat_lahir');
            } ?>">

            <p class="eror-validasi"><?= $eror["tempat_lahir"] ?? "" ?></p>



            <label for="no_hp_siswa">Nomor HP Siswa</label>
            <input type="text" name="no_hp_siswa" id="no_hp_siswa" placeholder="08123456789 atau +62812..." value="<?php if (!isset($eror['no_hp_siswa'])) {
                echo getStickyValue('no_hp_siswa');
            } ?>">
            <p class="eror-validasi"><?= $eror["no_hp_siswa"] ?? "" ?></p>


            <label for="asal_sekolah">Asal Sekolah</label>
            <input type="text" name="asal_sekolah" id="asal_sekolah" placeholder="Masukkan asal sekolah" value="<?php if (!isset($eror['asal_sekolah'])) {
                echo getStickyValue('asal_sekolah');
            } ?>">

            <p class="eror-validasi"><?= $eror["asal_sekolah"] ?? "" ?></p>


            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat lengkap" value="<?php if (!isset($eror['alamat'])) {
                echo getStickyValue('alamat');
            } ?>">

            <p class="eror-validasi"><?= $eror["alamat"] ?? "" ?></p>



            <label for="nama_wali">Nama Wali</label>
            <input type="text" name="nama_wali" id="nama_wali" placeholder="Masukkan nama wali" value="<?php if (!isset($eror['nama_wali'])) {
                echo getStickyValue('nama_wali');
            } ?>">

            <p class="eror-validasi"><?= $eror["nama_wali"] ?? "" ?></p>

            <label for="no_hp_wali">Nomor HP Wali</label>
            <input type="text" name="no_hp_wali" id="no_hp_wali" placeholder="08123456789 atau +62812..." value="<?php if (!isset($eror['no_hp_wali'])) {
                echo getStickyValue('no_hp_wali');
            } ?>">

            <p class="eror-validasi"><?= $eror["no_hp_wali"] ?? "" ?></p>

            <label for="program_pondok">Program Pondok</label>
            <select name="program_pondok" id="program_pondok">
                <option value="">-- Program Pondok --</option>
                <option value="Tahfidz Alquran" <?= getStickyValue('program_pondok') == 'Tahfidz Alquran' ? 'selected' : '' ?>>Tahfidz
                    Alquran</option>
                <option value="Diniyah" <?= getStickyValue('program_pondok') == 'Diniyah' ? 'selected' : '' ?>>Diniyah
                </option>
                <option value="Qiroati" <?= getStickyValue('program_pondok') == 'Qiroati' ? 'selected' : '' ?>>Qiroati
                </option>
            </select>

            <p class="eror-validasi"><?= $eror["program_pondok"] ?? "" ?></p>

            <label for="id_jurusan">Jurusan</label>
            <select name="id_jurusan" id="id_jurusan">
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($jurusans as $jurusan): ?>
                    <option value="<?= $jurusan['ID_JURUSAN'] ?>" <?= getStickyValue('id_jurusan') == $jurusan['ID_JURUSAN'] ? 'selected' : '' ?>>
                        <?= $jurusan['NAMA_JURUSAN'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <p class="eror-validasi"><?= $eror["id_jurusan"] ?? "" ?></p>

            <div class="document-upload">
                <label for="file_akte">Upload Akte Kelahiran *</label>
                <input type="file" name="file_akte" id="file_akte">
            </div>

            <p class="eror-validasi"><?= $eror["file_akte"] ?? "" ?></p>


            <div class="document-upload">
                <label for="file_kk">Upload Kartu Keluarga (KK) *</label>
                <input type="file" name="file_kk" id="file_kk">
            </div>

            <p class="eror-validasi"><?= $eror["file_kk"] ?? "" ?></p>

            <button type="submit" name="submit_pendaftaran">Daftar</button>
        </form>
    </div>
    <?php require_once "../components/footer.php" ?>

</body>

</html>