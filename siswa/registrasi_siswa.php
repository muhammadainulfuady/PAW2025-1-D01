<?php
require_once(__DIR__ . "/../config/function.php");
function getStickyValue($fieldName)
{
    return isset($_POST[$fieldName]) ? htmlspecialchars(trim($_POST[$fieldName])) : '';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    addSiswa($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Siswa</title>
    <link rel="stylesheet" href="../source/css/style.css">
</head>

<body>
    <section class="registrasi-siswa">
        <div class="login-container">
            <form action="" method="POST" enctype="multipart/form-data">
                <h2>Registrasi Siswa</h2>

                <div class="login-input">
                    <label for="username_siswa">Username</label>
                    <input type="text" name="username_siswa" id="username_siswa" placeholder="Masukkan username"
                        value="<?= getStickyValue('username_siswa') ?>">
                </div>

                <div class="login-input">
                    <label for="nama_lengkap_siswa">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap_siswa" id="nama_lengkap_siswa"
                        value="<?= getStickyValue('nama_lengkap_siswa') ?>" placeholder="Masukkan nama">
                </div>

                <div class="login-input">
                    <label for="password_siswa">Password</label>
                    <input type="password" name="password_siswa" id="password_siswa"
                        value="<?= getStickyValue('password_siswa') ?>" placeholder="Masukkan password">
                </div>
                <p>Sudah punya akun? <a href="../index.php" class="btn-regis-login">Login</a></p>
                <button type="submit" name="submit_siswa_register" class="btn-submit">Daftar Sekarang</button>
            </form>
        </div>
    </section>
    <?php require_once "../components/footer.php" ?>
</body>

</html>