<?php
require_once(__DIR__ . "/../config/function.php");

if (session_status() === PHP_SESSION_NONE)
    session_start();

if (!isset($_SESSION['ADMIN_ID'])) {
    header("Location: ../index.php");
    exit;
}

global $connect;
$eror = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama_jurusan = htmlspecialchars($_POST['nama_jurusan']);
    valCreateJurusan($nama_jurusan, $eror);

    if (empty($eror)) {
        $stmnt = $connect->prepare("INSERT INTO jurusan (nama_jurusan) VALUES (:nama)");
        $stmnt->bindParam(":nama", $nama_jurusan);
        $stmnt->execute();
        $_SESSION['BERHASIL_TAMBAH_JURUSAN'] = "Jurusan $nama_jurusan berhasil di tambah.";
        // Redirect setelah berhasil tambah
        header("Location: Ddelete_jurusan.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creare | Jurusan</title>
    <link rel="stylesheet" href="../source/css/style.css">
</head>

<body>
    <?php require_once "../components/header_admin.php";
    ?>
    <div class="admin-container">
        <h2 class="judul-riwayat">Tambah Jurusan</h2>

        <form method="POST">
            <label>Nama Jurusan</label>
            <p class="eror-validasi"><?= $eror["nama_jurusan"] ?? "" ?></p>
            <input type="text" name="nama_jurusan">
            <button type="submit" name="submit" class="btn-simpan">Simpan</button>
            <a href="Ddelete_jurusan.php">Batal</a>
        </form>
    </div>

</body>

</html>