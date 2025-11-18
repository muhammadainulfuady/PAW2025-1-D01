<!-- Form login siswa/admin
Proses cek username & password
Session set -->
<?php
require_once(__DIR__ . "/../config/function.php");
function getStickyValue($fieldName)
{
    return isset($_POST[$fieldName]) ? htmlspecialchars(trim($_POST[$fieldName])) : '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dan bersihkan dari karakter berbahaya
    $username = htmlspecialchars(trim($_POST['username_login_siswa']));
    $password = htmlspecialchars(trim($_POST['password_login_siswa']));

    // Enkripsi password (pastikan di database juga tersimpan dalam md5)
    $password = md5($password);

    // Panggil fungsi login gabungan (admin + siswa)
    loginUser($username, $password);
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
        <div class="login">
            <form action="" method="POST">
                <div class="login-admin-siswa-input">
                    <label for="username_login_siswa">Masukkan Username</label>
                    <input type="text" name="username_login_siswa" id="username_login_siswa"
                        placeholder="Masukkan username" value="<?= getStickyValue('username_login_siswa') ?>">
                </div>

                <div class="login-admin-siswa-input">
                    <label for="password_login_siswa">Masukkan Password</label>
                    <input type="password" name="password_login_siswa" id="password_login_siswa"
                        placeholder="Masukkan password" value="<?= getStickyValue('password_login_siswa') ?>">
                </div>
                <p>Belum punya akun? <a href="./siswa/registrasi_siswa.php" class="btn-regis-login">Register</a></p>
                <button type="submit" name="submit_login_siswa" class="btn-submit">login</button>
            </form>
        </div>
    </section>
    <?php require_once "./components/footer.php" ?>

</body>

</html>