<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
require_once("../config/function.php");

// pastikan sudah login
if (!isset($_SESSION['USERNAME_SISWA'])) {
    header("Location: ../index.php");
    exit;
}

$username = $_SESSION['USERNAME_SISWA'];

global $connect;
$stmnt = $connect->prepare("SELECT * FROM siswa WHERE USERNAME_SISWA = :username");
$stmnt->execute([':username' => $username]);
$siswa = $stmnt->fetch();

if (!$siswa) {
    $message = "Akun tidak ditemukan";
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../source/css/style.css'>
        <title>Siswa | None</title>
    </head>
    <body>
    <div class='text-tolak'>
        <p class='tolak-siswa tolak-iscon'>⚠️⚠️ {$message}</p>
    </div>
        <a href='../dashboard/index.php' class='btn-kembali-pusat'>Kembali</a>
    </body>
    </html>
";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateSiswa($username, $_POST);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit | Siswa</title>
    <link rel="stylesheet" href="../source/css/style.css">
</head>

<body>
    <?php require_once "../components/header.php" ?>
    <section class="edit-siswa">
        <h2>Edit Profil Siswa</h2>
        <div class="edit-form-siswa">
            <form action="#" method="POST" enctype="multipart/form-data">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama_lengkap_siswa"
                    value="<?= htmlspecialchars($siswa['NAMA_LENGKAP_SISWA']) ?>">

                <label>Foto Saat Ini:</label><br>
                <?php if ($siswa['FOTO_SISWA'] === "default.jpg"): ?>
                    <img src="default.jpg" alt="Foto Siswa">
                <?php else: ?>
                    <img src="../source/upload/images/<?= $siswa['FOTO_SISWA'] ?>" alt="Foto Siswa" name="foto"><br>
                <?php endif ?>
                <br>
                <label>Ganti Foto Baru (opsional):</label>
                <input type="file" name="foto_siswa">
                <button type="submit" name="submit_edit">💾 Simpan Perubahan</button>
            </form>
        </div>
    </section>
    <?php require_once "../components/footer.php" ?>
</body>

</html>