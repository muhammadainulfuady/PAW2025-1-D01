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
    $username = htmlspecialchars($_POST['username_siswa'] ?? '');
    $password = htmlspecialchars($_POST['password_siswa'] ?? '');
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
<form action="#" method="POST">
    <section class="login-admin-siswa">
        <h2>Login Calon Siswa</h2>
        <?php if (isset($_SESSION['BERHASIL_REGISTER'])): ?>
            <div class='popup-success'>
                <?= $_SESSION['BERHASIL_REGISTER'] ?>
            </div>
            <?php unset($_SESSION['BERHASIL_REGISTER']) ?>
        <?php endif ?>
        <div class="login">
            <div class="login-admin-siswa-input">
                <label for="username_siswa">Masukkan Username</label>
                <input type="text" name="username_siswa" id="username_siswa" placeholder="Masukkan username" value="<?php
                if (!isset($eror['username_siswa'])) {
                    echo getStickyValue('username_siswa');
                } ?>">
                <p class="eror-validasi"><?= $eror["username_siswa"] ?? "" ?></p>
            </div>

            <div class="login-admin-siswa-input">
                <label for="password_siswa">Masukkan Password</label>
                <input type="password" name="password_siswa" id="password_siswa" placeholder="Masukkan password"
                    value="">
                <p class="eror-validasi"><?= $eror["password_siswa"] ?? "" ?></p>
            </div>
            <p>Belum punya akun? <a href="./siswa/registrasi_siswa.php" class="btn-regis-login">Register</a></p>
            <button type="submit" name="submit_login_siswa" class="btn-submit">Login</button>
        </div>
    </section>
</form>