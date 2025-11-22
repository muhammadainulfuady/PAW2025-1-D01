<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

// Ambil parameter role dari link yang diklik
$role = isset($_GET['role']) ? $_GET['role'] : '';

if ($role === 'admin') {
    // Hapus Khusus Data Admin
    unset($_SESSION['ADMIN_ID']);
    unset($_SESSION['NAMA_ADMIN']);
    unset($_SESSION['USERNAME_ADMIN']);

    // Jika sedang login sebagai admin, hapus role-nya juga
    if (isset($_SESSION['LOGIN_ROLE']) && $_SESSION['LOGIN_ROLE'] == 'admin') {
        unset($_SESSION['LOGIN_ROLE']);
    }

} elseif ($role === 'siswa') {
    // Hapus Khusus Data Siswa
    unset($_SESSION['USERNAME_SISWA']);
    unset($_SESSION['NAMA_SISWA']);

    // Hapus session notifikasi siswa biar bersih
    unset($_SESSION['BERHASIL_LOGIN']);
    unset($_SESSION['BERHASIL_EDIT']);
    unset($_SESSION['BERHASIL_DAFTAR']);

    // Jika sedang login sebagai siswa, hapus role-nya juga
    if (isset($_SESSION['LOGIN_ROLE']) && $_SESSION['LOGIN_ROLE'] == 'siswa') {
        unset($_SESSION['LOGIN_ROLE']);
    }

} else {
    // Jika tidak ada role (akses langsung), hapus semua (Pembersihan Total)
    session_unset();
    session_destroy();
}

// Redirect ke halaman login utama
header("Location: ../index.php");
exit;
?>