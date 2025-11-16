<?php
require_once(__DIR__ . "/../config/function.php");

if (session_status() === PHP_SESSION_NONE)
    session_start();

// Pastikan ADMIN sudah login
if (!isset($_SESSION['ADMIN_ID'])) {
    header("Location: ../index.php");
    exit;
}

global $connect;

// -----------------------------------
// DELETE JURUSAN LANGSUNG DI HALAMAN
// -----------------------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = $connect->prepare("DELETE FROM jurusan WHERE id_jurusan = :id");
    $delete->execute([':id' => $id]);

    // Kembali ke halaman jurusan.php setelah delete
    header("Location: Ddelete_jurusan.php");
    exit;
}

// Ambil semua jurusan
$stmnt = $connect->prepare("SELECT nama_jurusan, id_jurusan FROM jurusan ORDER BY nama_jurusan ASC");
$stmnt->execute();
$jurusans = $stmnt->fetchAll();

// Header admin
require_once "../components/header_admin.php";
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../source/css/style.css">
</head>

<body>

    <div class="admin-container">
        <h2 class="judul-riwayat">Daftar Jurusan</h2>

        <table class="tabel-siswa">
            <tr>
                <th>Nama Jurusan</th>
                <th>Aksi</th>
            </tr>

            <?php foreach ($jurusans as $j): ?>
                <tr>
                    <td><?= $j['nama_jurusan'] ?></td>

                    <td>
                        <!-- Edit -->
                        <a href="Cupdate_jurusan.php?id=<?= $j['id_jurusan'] ?>" class="btn-edit">Edit</a>

                        <!-- Delete tanpa file lain -->
                        <a href="Ddelete_jurusan.php?delete=<?= $j['id_jurusan'] ?>" class="btn-delete">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <a href="Acreate_jurusan.php" class="btn-tambah">+ Tambah Jurusan</a>

    </div>

</body>

</html>