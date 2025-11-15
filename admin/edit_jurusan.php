<?php
require_once(__DIR__ . "/../config/function.php");

if (session_status() === PHP_SESSION_NONE)
    session_start();

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
        $update = $connect->prepare("
            UPDATE jurusan 
            SET nama_jurusan = :nama 
            WHERE id_jurusan = :id
        ");
        $update->bindParam(":nama", $nama_jurusan);
        $update->bindParam(":id", $id);
        $update->execute();

        // Redirect setelah update
        header("Location: jurusan.php");
        exit;
    }
}

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
        <h2 class="judul-riwayat">Edit Jurusan</h2>

        <form method="POST">
            <label>Nama Jurusan</label>
            <input type="text" name="nama_jurusan" placeholder="<?php echo htmlspecialchars($data['nama_jurusan']); ?>"
                required>

            <button type="submit" name="submit" class="btn-simpan">Update</button>
        </form>
    </div>

</body>

</html>