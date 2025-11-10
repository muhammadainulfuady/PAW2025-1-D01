<!-- semua function CRUD
upload file
login
register
update status
get jurusan
get siswa
get dokumen
dll -->

<?php
require_once "database.php";
function addSiswa(array $data)
{
    // mengambil data yang ada di dalam koneksi
    global $connect;
    if (
        empty($data['nama_lengkap_siswa']) ||
        empty($data['nisn_siswa']) ||
        empty($data['alamat_siswa']) ||
        empty($data['tanggal_lahir_siswa']) ||
        empty($data['jenis_kelamin_siswa']) ||
        empty($data['no_telp_siswa']) ||
        empty($data['password_siswa']) ||
        empty($_FILES['foto_siswa']['name'])
    ) {
        echo "Semua field wajib diisi!";
        return;
    }

    // proses memasukan data ke database
    $stmnt = $connect->prepare("
        INSERT INTO siswa (NISN_SISWA, NAMA_LENGKAP_SISWA, ALAMAT_SISWA, TANGGAL_LAHIR_SISWA, JENIS_KELAMIN_SISWA, NO_TELPON_SISWA, FOTO_SISWA_SISWA, PASSWORD_SISWA)
        VALUES (:nisn_siswa, :nama_lengkap_siswa, :alamat_siswa, :tanggal_lahir_siswa, :jenis_kelamin_siswa, :no_telpon_siswa, :foto_siswa_siswa, :password_siswa)
        ");
    $stmnt->execute([
        ":nisn_siswa" => htmlspecialchars($data['nisn_siswa']),
        ":nama_lengkap_siswa" => htmlspecialchars($data['nama_lengkap_siswa']),
        ":alamat_siswa" => htmlspecialchars($data['alamat_siswa']),
        ":tanggal_lahir_siswa" => htmlspecialchars($data['tanggal_lahir_siswa']),
        ":jenis_kelamin_siswa" => htmlspecialchars($data['jenis_kelamin_siswa']),
        ":no_telpon_siswa" => htmlspecialchars($data['no_telp_siswa']),
        ":foto_siswa_siswa" => uploadFileGambarSiswa(),
        ":password_siswa" => md5($data['password_siswa']),
    ]);
    if ($stmnt->rowCount() > 0) {
        header("Location: berhasil.php");
    } else {
        echo "Gagal insert data.";
    }
}

function uploadFileGambarSiswa()
{
    $namaFile = $_FILES['foto_siswa']['name'];
    $ukuranFile = $_FILES['foto_siswa']['size'];
    $eror = $_FILES['foto_siswa']['error'];
    $tmpName = $_FILES['foto_siswa']['tmp_name'];

    // cek apakah tidak ada gambar yang di upload
    if ($eror === 4) {
        echo "'Pilih gambar terlebih dahulu'";
        return false;
    }

    // cek apakah yang di upload sama user itu adalah gambar atau bukan
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode(".", $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "Yang anda upload bukan gambar";
        return false;
    }

    // cek jika ukuranya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "Ukuran gambar terlalu besar";
        return false;
    }

    // lolos pengecekan gambar siap di upload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= ".";
    $namaFileBaru .= $ekstensiGambar;
    $fileBaru = $namaFileBaru;
    move_uploaded_file($tmpName, "../source/upload/images/" . $fileBaru);
    return $fileBaru;
}
?>