<!-- Form login siswa/admin
Proses cek username & password
Session set -->
<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
require_once(__DIR__ . "/../config/function.php");
function getStickyValue($fieldName)
{
    return isset($_POST[$fieldName]) ? htmlspecialchars(trim($_POST[$fieldName])) : '';
}

$eror = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dan bersihkan dari karakter berbahaya
    $username = $_POST['username_siswa'] ?? '';
    $password = $_POST['password_siswa'] ?? '';
    valUsername($username, $eror);
    valPassword($password, $eror);
    if (empty($eror)) {
        // Enkripsi password (pastikan di database juga tersimpan dalam md5)
        $password = md5($password);
        // Panggil fungsi login gabungan (admin + siswa)
        loginUser($username, $password);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa / Admin</title>
    <link rel="stylesheet" href="./source/css/style.css">
</head>

<body>
    <section class="login-admin-siswa">
        <?php if (isset($_SESSION['BERHASIL_REGISTER'])): ?>
            <div class='popup-succes'>
                <?= $_SESSION['BERHASIL_REGISTER'] ?>
            </div>
            <?php unset($_SESSION['BERHASIL_REGISTER']); endif ?>
        <div class="login">
            <form action="" method="POST">
                <div class="login-admin-siswa-input">
                    <label for="username_siswa">Masukkan Username</label>
                    <input type="text" name="username_siswa" id="username_siswa" placeholder="Masukkan username" value="<?php
                    if (!isset($eror['username_siswa'])) {
                        echo getStickyValue('username_siswa');
                    } ?>">
                    <span class=" eror-validasi">
                        <p><?= $eror["username_siswa"] ?? "" ?></p>
                    </span>
                </div>

                <div class="login-admin-siswa-input">
                    <label for="password_siswa">Masukkan Password</label>
                    <input type="password" name="password_siswa" id="password_siswa" placeholder="Masukkan password"
                        value="">
                    <span class="eror-validasi">
                        <p><?= $eror["password_siswa"] ?? "" ?></p>
                    </span>
                </div>
                <p>Belum punya akun? <a href="./siswa/registrasi_siswa.php" class="btn-regis-login">Register</a></p>
                <button type="submit" name="submit_login_siswa" class="btn-submit">Login</button>
            </form>
        </div>
    </section>
    <?php require_once "./components/footer.php" ?>

</body>

</html>