<?php
require_once(__DIR__ . "/../config/function.php");

if (session_status() === PHP_SESSION_NONE)
    session_start();

// pastikan admin sudah login
if (!isset($_SESSION['ADMIN_ID'])) {
    header("Location: ../index.php");
    exit;
}

global $connect;

// Pastikan parameter id ada
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: jurusan.php");
    exit;
}

$id = $_GET['id'];

// Ambil data jurusan berdasarkan ID
$stmnt = $connect->prepare("SELECT nama_jurusan FROM jurusan WHERE id_jurusan = :id");
$stmnt->bindParam(":id", $id);
$stmnt->execute();
$data = $stmnt->fetch(PDO::FETCH_ASSOC);

// Jika ID tidak ditemukan
if (!$data) {
    header("Location: jurusan.php");
    exit;
}

// Proses update data
if (isset($_POST['submit'])) {
    $nama_jurusan = trim($_POST['nama_jurusan']);
    if ($nama_jurusan != "") {
        $cek = $connect->prepare("
        SELECT COUNT(*) 
        FROM pendaftaran 
        WHERE id_jurusan = :id");
        $cek->execute([':id' => $id]);
        $dipakai = $cek->fetchColumn();

        if ($dipakai > 0) {
            $_SESSION['eror_update_jurusan'] = "Jurusan sudah ada yang punya tidak bisa di edit";
            header("Location: Ddelete_jurusan.php");
            exit;
        }

        // Lanjut update jika aman
        $update = $connect->prepare("
        UPDATE jurusan 
        SET nama_jurusan = :nama 
        WHERE id_jurusan = :id
    ");
        $update->bindParam(":nama", $nama_jurusan);
        $update->bindParam(":id", $id);
        $update->execute();
        header("Location: Ddelete_jurusan.php");
    }
}

// Header admin
?>
<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update | Jurusan</title>
<link rel="stylesheet" href="../source/css/style.css">

<body>
    <?php require_once "../components/header_admin.php";
    ?>
    <div class="admin-container">

        <h2 class="judul-riwayat">Edit Jurusan</h2>

        <form method="POST">
            <label>Nama Jurusan</label>
            <input type="text" name="nama_jurusan" value="<?php echo htmlspecialchars($data['nama_jurusan']); ?>">

            <button type="submit" name="submit" class="btn-simpan">Update</button>
            <a href="Ddelete_jurusan.php">Batal</a>
        </form>
    </div>

</body>

</html>