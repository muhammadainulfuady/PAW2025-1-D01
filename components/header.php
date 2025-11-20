<section class="header-admin-siswa">
    <h2 class="logo">PPDB Pesantern AL - AMIN</h2>
    <nav>
        <ul>
            <li><a href="../dashboard/index.php">Beranda</a></li>
            <li><a href="../siswa/browse_calon.php">Riwayat</a></li>
            <li><a href="../siswa/pendaftaran.php">Pendaftaran</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>
            <li><a href="../siswa/edit_siswa.php"><?= $siswa['NAMA_LENGKAP_SISWA']; ?></a></li>

            <!-- FOTO + NAMA -->
            <li class="user-info">
                <a href="../siswa/edit_siswa.php" class="user-link">
                    <?php if ($siswa['FOTO_SISWA'] === 'default.jpg'): ?>
                        <img src="../siswa/default.jpg" alt="Foto Siswa"><br>
                    <?php else: ?>
                        <img src="../source/upload/images/<?= $siswa['FOTO_SISWA'] ?>" alt="Foto Siswa"><br>
                    <?php endif ?>
                </a>
            </li>
        </ul>
    </nav>
</section>