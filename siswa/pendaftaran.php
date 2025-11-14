<?php
require_once(__DIR__ . "/../config/function.php");
if (session_status() === PHP_SESSION_NONE)
    session_start();
$nisn = $_SESSION['NISN_SISWA'];
global $connect;

// Ambil data siswa
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE NISN_SISWA = :nisn");
$stmnt->execute([':nisn' => $nisn]);
$siswa = $stmnt->fetch();
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
            <label for="tanggal_pendaftaran">Tanggal Pendaftaran</label>
            <input type="text" name="tanggal_pendaftaran" id="tanggal_pendaftaran" placeholder="contoh: 13-11-2025">

            <label for="nama_wali">Nama Wali</label>
            <input type="text" name="nama_wali" id="nama_wali" placeholder="Masukkan nama wali">

            <label for="no_hp">No HP</label>
            <input type="text" name="no_hp" id="no_hp" placeholder="Masukkan nomor HP wali">

            <label for="jurusan_pilihan">Jurusan Pilihan</label>
            <input type="text" name="jurusan_pilihan" id="jurusan_pilihan" placeholder="contoh: IPA, IPS, Bahasa">

            <label for="jenjang">Jenjang</label>
            <select name="jenjang" id="jenjang">
                <option value="">-- Pilih Jenjang --</option>
                <option value="Tahfidz Qur'an">Tahfidz Qur'an</option>
                <option value="Tilawatil Qur'an">Tilawatil Qur'an</option>
                <option value="Diniyah">Diniyah</option>
            </select>

            <div class="document-upload">
                <label for="file_ijazah">Upload Ijazah/Surat Keterangan Lulus (SKL) *</label>
                <input type="file" name="file_ijazah" id="file_ijazah" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <div class="document-upload">
                <label for="file_akte">Upload Akte Kelahiran *</label>
                <input type="file" name="file_akte" id="file_akte" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <button type="submit" name="submit_pendaftaran">Daftar</button>
        </form>
    </div>
</body>

</html>