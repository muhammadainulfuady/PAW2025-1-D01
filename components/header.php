<?php
// header.php
?>
<link rel="stylesheet" href="../source/css/header.css">
 <header>
    <div class="container">
        <h1 class="logo">NAMA PESANTREEEEEN</h1>
        <nav>
            <ul>
                <li><a href="../dashboard/index.php">beranda</a></li>
                <li><a href="../dashboard/daftar_siswa.php">Informasi</a></li>
                <li><a href="../siswa/registrasi.php">Registrasi</a></li>
                <li><a href="../auth/login_siswa.php">Login Siswa</a></li>
                <li><a href="../siswa/edit_siswa.php"><img src="../upload/<?= $siswa['FOTO_SISWA_SISWA']; ?>" 
                    alt="Foto Siswa" class="foto-profil">
                    </a>
                    <!-- <a href="../auth/logout.php">Logout</a></li> -->
            </ul>
        </nav>
    </div>
</header>