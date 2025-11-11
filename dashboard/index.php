<?php
require_once(__DIR__ . "/../config/function.php");
if (!isset($_SESSION['NISN_SISWA'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    selamat datang di web kami
    <a href="../siswa/edit_siswa.php">
        <?php
        if ($_SESSION['NISN_SISWA']) {
            echo showName($_SESSION['NISN_SISWA']);
        } else {
            echo "";
        }
        ; ?>
    </a>

    <a href="../auth/logout.php">Logout</a>

</body>

</html>