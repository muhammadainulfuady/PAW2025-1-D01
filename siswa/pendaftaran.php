<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa</title>
    <link rel="stylesheet" href="../source/css/pendaftaran.css">
</head>

<body>
    <div class="form-container">
        <h2>Formulir Pendaftaran Siswa</h2>
        <form action="" method="POST">
            <label for="tanggal_pendaftaran">Tanggal Pendaftaran</label>
            <input type="text" name="tanggal_pendaftaran" id="tanggal_pendaftaran" placeholder="contoh: 13-11-2025">

            <label for="nama_wali">Nama Wali</label>
            <input type="text" name="nama_wali" id="nama_wali" placeholder="Masukkan nama wali">

            <label for="no_hp">No HP</label>
            <input type="text" name="no_hp" id="no_hp" placeholder="Masukkan nomor HP wali">

            <label for="jurusan">Jurusan</label>
            <input type="text" name="jurusan" id="jurusan" placeholder="contoh: IPA, IPS, Bahasa">

            <label for="jenjang">Jenjang</label>
            <select name="jenjang" id="jenjang">
                <option value="">-- Pilih Jenjang --</option>
                <option value="Tahfidz Qur'an">Tahfidz Qur'an</option>
                <option value="Tilawatil Qur'an">Tilawatil Qur'an</option>
                <option value="Diniyah">Diniyah</option>
            </select>

            <button type="submit" name="submit_pendaftaran">Daftar</button>
        </form>
    </div>
</body>

</html>