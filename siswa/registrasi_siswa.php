<?php
require_once(__DIR__ . "/../config/function.php");
function getStickyValue($fieldName)
{
    return isset($_POST[$fieldName]) ? htmlspecialchars(trim($_POST[$fieldName])) : '';
}
$eror = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_siswa = $_POST['username_siswa'] ?? '';
    $nama_lengkap_siswa = $_POST['nama_lengkap_siswa'] ?? '';
    $password_siswa = $_POST['password_siswa'] ?? '';
    valUsername($username_siswa, $eror);
    valName($nama_lengkap_siswa, $eror);
    valPassword($password_siswa, $eror);

    if (empty($eror)) {
        addSiswa($_POST);
    }
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
                <h2>Registrasi Calon Siswa</h2>

                <div class="login-input">
                    <label for="username_siswa">Username</label>
                    <input type="text" name="username_siswa" id="username_siswa" placeholder="Contoh : loremIpsum09"
                        value="<?php
                        if (!isset($eror['username_siswa'])) {
                            echo getStickyValue('username_siswa');
                        }
                        ?>">
                    <span class="eror-validasi">
                        <p><?= $eror["username_siswa"] ?? "" ?></p>
                    </span>
                </div>

                <div class="login-input">
                    <label for="nama_lengkap_siswa">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap_siswa" id="nama_lengkap_siswa"
                        placeholder="Contoh : Lorem Ipsum" value="<?php
                        if (!isset($eror['nama_lengkap_siswa'])) {
                            echo getStickyValue('nama_lengkap_siswa');
                        }
                        ?>">
                    <span class="eror-validasi">
                        <p><?= $eror["nama_lengkap_siswa"] ?? "" ?></p>
                    </span>
                </div>

                <div class="login-input">
                    <label for="password_siswa">Password</label>
                    <input type="password" name="password_siswa" id="password_siswa" placeholder="Contoh Lorem234"
                        value="<?php
                        if (!isset($eror['password_siswa'])) {
                            echo getStickyValue('password_siswa');
                        }
                        ?>">
                    <span class="eror-validasi">
                        <p><?= $eror["password_siswa"] ?? "" ?></p>
                    </span>
                </div>
                <p>Sudah punya akun? <a href="../index.php" class="btn-regis-login">Login</a></p>
                <p class="nb">NB : Catat username dan pasword anda biar tidak lupa😊😊</p>
                <button type="submit" name="submit_siswa_register" class="btn-submit">Registrasi</button>
            </form>
        </div>
    </section>
    <?php require_once "../components/footer.php" ?>
</body>

</html>