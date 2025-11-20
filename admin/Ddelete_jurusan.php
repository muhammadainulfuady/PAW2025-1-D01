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
    $check_jurusan = $connect->prepare("SELECT COUNT(*) FROM PENDAFTARAN WHERE ID_JURUSAN = :id");
    $check_jurusan->execute([
        ":id" => $id,
    ]);
    $check_dipakai_gk_jurusan = $check_jurusan->fetchColumn();
    if ($check_dipakai_gk_jurusan > 0) {
        $_SESSION['eror_delete_jurusan'] = "Jurusan sudah ada yang punya tidak bisa di hapus";
        header("Location: Ddelete_jurusan.php");
        exit;
    }
    $delete = $connect->prepare("DELETE FROM jurusan WHERE id_jurusan = :id");
    $delete->execute([':id' => $id]);
    exit;
}

// Ambil semua jurusan
$stmnt = $connect->prepare("SELECT nama_jurusan, id_jurusan FROM jurusan ORDER BY nama_jurusan ASC");
$stmnt->execute();
$jurusans = $stmnt->fetchAll();


// Header admin
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen | Siswa</title>
    <link rel="stylesheet" href="../source/css/style.css">
</head>

<body>
    <?php require_once "../components/header_admin.php";
    ?>
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
                    <?php if (isset($_SESSION['eror_update_jurusan'])): ?>
                        <div class="eror-jurusan">
                            <?= $_SESSION['eror_update_jurusan'] ?>
                        </div>
                        <?php unset($_SESSION['eror_update_jurusan']); ?>
                    <?php endif ?>
                    <?php if (isset($_SESSION['eror_delete_jurusan'])): ?>
                        <div class="eror-jurusan">
                            <?= $_SESSION['eror_delete_jurusan']; ?>
                        </div>
                        <?php unset($_SESSION['eror_delete_jurusan']); ?>
                    <?php endif ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="Acreate_jurusan.php" class="btn-tambah">+ Tambah Jurusan</a>
    </div>
    <?php require_once "../components/footer.php" ?>
</body>

</html>