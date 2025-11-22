<?php
require_once "database.php";
if (session_status() === PHP_SESSION_NONE)
    session_start();

// ====================
// eror validasi
// =====================

function requiredCheck($field)
{
    $field = trim($field);
    return empty($field);
}

function valUsername($field, &$eror)
{
    $ptUsername = "/^[a-zA-Z0-9._]{5,}$/";

    if (requiredCheck($field)) {
        $eror['username_siswa'] = "Kolom username wajib di isi.";
    } elseif (!preg_match($ptUsername, $field)) {
        $eror['username_siswa'] = "Username harus alphanumeric dan minimal 5 karakter tidak boleh spasi.";
    }
}

function valName($field, &$eror)
{
    $ptNamaLengkap = "/^[a-zA-Z\s]{5,}$/";
    if (requiredCheck($field)) {
        $eror['nama_lengkap_siswa'] = "Kolom nama lengkap wajib di isi.";
    } elseif (!preg_match($ptNamaLengkap, $field)) {
        $eror['nama_lengkap_siswa'] = "Nama lengkap harus berisi alfabet, minimal 3 karakter.";
    }
}

function valPassword($field, &$eror)
{   // Pola: Minimum 8 karakter, harus mengandung (setidaknya satu lowercase, satu uppercase, dan satu digit).
    $ptPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
    if (requiredCheck($field)) {
        $eror['password_siswa'] = "Kolom password wajib di isi.";
    } elseif (!preg_match($ptPassword, $field)) {
        $eror['password_siswa'] = "Password harus alphanumeric huruf besar kecil dan minimal 8 karakter.";
    }
}

function valNisn($field, &$eror)
{
    $ptNisn = "/^[0-9]{10}$/";
    if (requiredCheck($field)) {
        $eror['nisn_siswa'] = "Kolom NISN wajib di isi.";
    } elseif (!preg_match($ptNisn, $field)) {
        $eror['nisn_siswa'] = "NISN wajib numeric 10 angka.";
    }
}

function valJenisKelamin($field, &$eror)
{
    $ptJenisKelamin = "/^[LP]$/";
    if (requiredCheck($field)) {
        $eror['jenis_kelamin'] = "Kolom jenis kelamin wajib di isi.";
    } elseif (!preg_match($ptJenisKelamin, $field)) {
        $eror['jenis_kelamin'] = "Jenis kelamin tidak valid.";
    }
}


function valTempatLahir($field, &$eror)
{
    $ptTempatLahir = "/^[a-zA-Z\s]+$/";
    if (requiredCheck($field)) {
        $eror['tempat_lahir'] = "Tempat lahir wajib di isi.";
    } elseif (!preg_match($ptTempatLahir, $field)) {
        $eror['tempat_lahir'] = "Tempat lahir hanya boleh huruf dan spasi.";
    } elseif (strlen($field) > 20) {
        $eror['tempat_lahir'] = "Tempat lahir tidak boleh lebih dari 20 huruf.";
    }
}


function valNoHpSiswa($field, &$eror)
{
    $ptNoHpSiswa = "/^\+?[0-9]{10,15}$/";
    if (requiredCheck($field)) {
        $eror['no_hp_siswa'] = "Nomor HP siswa wajib di isi.";
    } elseif (!preg_match($ptNoHpSiswa, $field)) {
        $eror['no_hp_siswa'] = "Nomor HP harus angka 10-15 digit.";
    }
}

function valAsalSekolah($field, &$eror)
{
    $ptAsalSekolah = "/^[a-zA-Z0-9\s]+$/";
    if (requiredCheck($field)) {
        $eror['asal_sekolah'] = "Asal sekolah wajib di isi.";
    } elseif (!preg_match($ptAsalSekolah, $field)) {
        $eror['asal_sekolah'] = "Asal sekolah hanya boleh huruf, angka, dan spasi.";
    } elseif (strlen($field) > 30) {
        $eror['asal_sekolah'] = "Asal sekolah tidak boleh lebih dari 30 huruf.";
    }
}


function valAlamat($field, &$eror)
{
    $ptAlamat = "/^[a-zA-Z0-9\s.,-]+$/";
    if (requiredCheck($field)) {
        $eror['alamat'] = "Alamat wajib di isi.";
    } elseif (!preg_match($ptAlamat, $field)) {
        $eror['alamat'] = "Alamat hanya boleh huruf, angka, spasi, koma, titik, dan strip.";
    }
}


function valNamaWali($field, &$eror)
{
    $ptNamaWali = "/^[a-zA-Z\s]{3,}$/";
    if (requiredCheck($field)) {
        $eror['nama_wali'] = "Nama wali wajib di isi.";
    } elseif (!preg_match($ptNamaWali, $field)) {
        $eror['nama_wali'] = "Nama wali hanya boleh huruf, spasi dan minimal 3 huruf.";
    }
}

function valNoHpWali($field, &$eror)
{
    $ptNoHpWali = "/^\+?[0-9]{10,15}$/";
    if (requiredCheck($field)) {
        $eror['no_hp_wali'] = "Nomor HP wali wajib di isi.";
    } elseif (!preg_match($ptNoHpWali, $field)) {
        $eror['no_hp_wali'] = "Nomor HP wali harus angka 10-15 digit.";
    }
}


function valProgramPondok($field, &$eror)
{
    if (requiredCheck($field)) {
        $eror['program_pondok'] = "Program pondok wajib dipilih.";
    }
}

function valJurusan($field, &$eror)
{
    if (requiredCheck($field)) {
        $eror['id_jurusan'] = "Jurusan wajib dipilih.";
    }
}

function valFileAkte($field, &$eror)
{
    if (requiredCheck($field)) {
        $eror['file_akte'] = "File akte wajib diisi.";
    }
}

function valFileKK($field, &$eror)
{
    if (requiredCheck($field)) {
        $eror['file_kk'] = "File KK wajib diisi.";
    }
}

function valTanggalLahir($field, &$eror)
{
    if (requiredCheck($field)) {
        $eror['tanggal_lahir'] = "Tanggal lahir wajib diisi.";
        return;
    }
    $pecah = explode("-", $field);
    if (count($pecah) !== 3) {
        $eror['tanggal_lahir'] = "Format tanggal tidak valid.";
        return;
    }

    list($tahun, $bulan, $hari) = $pecah;
    if (!checkdate((int) $bulan, (int) $hari, (int) $tahun)) {
        $eror['tanggal_lahir'] = "Tanggal lahir tidak valid.";
        return;
    }
    $tanggal_lahir = new DateTime($field);
    $tanggal_patokan = new DateTime("2025-07-01");
    $umur = $tanggal_patokan->diff($tanggal_lahir)->y;
    if ($umur > 21) {
        $eror['tanggal_lahir'] = "Umur maksimal 21 tahun untuk tahun ajaran.";
    } elseif ($umur < 15) {
        $eror['tanggal_lahir'] = "Umur minimal 15 tahun.";
    }
}

function valUpdateJurusan($field, &$eror)
{
    if (requiredCheck($field)) {
        $eror['nama_jurusan'] = "Nama jurusan tidak boleh kosong";
    }
}
function valCreateJurusan($field, &$eror)
{
    if (requiredCheck($field)) {
        $eror['nama_jurusan'] = "Nama jurusan tidak boleh kosong";
    }
}

function valEditNamaSiswa($field, &$eror)
{
    if (requiredCheck($field)) {
        $eror['nama_lengkap_siswa'] = "Nama lengkap tidak boleh kosong";
    }
}


function displayErrorPopup($message)
{
    echo "
        <div class='error-popup-container'>
            <p class='eror-akun'>⚠️⚠️ {$message}</p>
        </div>";
    return false;
}

// ================
// siswa registrasi
// ================

function addSiswa(array $data)
{
    global $connect;
    if (checkUsernameDuplication($data['username_siswa'])) {
        return displayErrorPopup('Username sudah terdaftar! Silahkan pilih username lain');
    }

    $stmnt = $connect->prepare("
        INSERT INTO siswa (USERNAME_SISWA, NAMA_LENGKAP_SISWA, FOTO_SISWA, PASSWORD_SISWA)
        VALUES (:username_siswa, :nama_lengkap_siswa, :foto_siswa, :password_siswa)
    ");

    $result = $stmnt->execute([
        ":username_siswa" => htmlspecialchars($data['username_siswa']),
        ":nama_lengkap_siswa" => htmlspecialchars($data['nama_lengkap_siswa']),
        ":foto_siswa" => htmlspecialchars('default.jpg'),
        ":password_siswa" => htmlspecialchars(md5($data['password_siswa'])),
    ]);

    if ($result && $stmnt->rowCount() > 0) {
        $_SESSION['BERHASIL_REGISTER'] = "Anda berhasil register";
        header("Location: ../index.php");
        exit;
    } else {
        return displayErrorPopup("Gagal insert data. Harap coba lagi.");
    }
}

// ===================
// cek duplikasi nisn
// ===================

function checkUsernameDuplication(string $username_input)
{
    global $connect;

    $stmntDbl = $connect->prepare("SELECT COUNT(*) FROM siswa WHERE USERNAME_SISWA = :username_siswa");
    $stmntDbl->execute([
        ":username_siswa" => $username_input,
    ]);
    return $stmntDbl->fetchColumn() > 0;
}

// ===================
// upload gambar siswa
// ===================

function uploadFileGambarSiswa()
{
    $file = $_FILES['foto_siswa'];
    $ekstensiValid = ['jpg', 'jpeg', 'png'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return displayErrorPopup('Pilih gambar terlebih dahulu!');
        }
        return displayErrorPopup('Terjadi kesalahan saat mengunggah file.');
    }

    $ekstensiFile = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ekstensiFile, $ekstensiValid)) {
        return displayErrorPopup('Yang anda upload bukan file gambar (hanya JPG, JPEG, PNG)!');
    }

    if ($file['size'] > 1000000) {
        return displayErrorPopup('Ukuran gambar terlalu besar! Maksimal 1 MB');
    }

    $namaBaru = uniqid() . '.' . $ekstensiFile;
    $targetDir = "../source/upload/images/";

    if (move_uploaded_file($file['tmp_name'], $targetDir . $namaBaru)) {
        return $namaBaru;
    }

    return displayErrorPopup('Gagal memindahkan file ke server.');
}

// ===================
// fungsi login admin
// ===================

function handleAdminLogin($username_admin, $password_admin)
{
    global $connect;
    $stmntAdmin = $connect->prepare("SELECT * FROM admin WHERE USERNAME_ADMIN = :username");
    $stmntAdmin->execute([':username' => $username_admin]);
    $admin = $stmntAdmin->fetch();

    if ($admin) {
        if ($admin['PASSWORD_ADMIN'] === $password_admin) {
            $_SESSION['LOGIN_ROLE'] = 'admin';
            $_SESSION['ADMIN_ID'] = $admin['ID_ADMIN'];
            $_SESSION['NAMA_ADMIN'] = $admin['NAMA_ADMIN'];
            $_SESSION['USERNAME_ADMIN'] = $admin['USERNAME_ADMIN'];
            header("Location: ./admin/index.php");
            exit;
        }
        return displayErrorPopup('Password admin salah');
    }
    return false;
}

// ===================
// fungsi login siswa
// ===================

function handleSiswaLogin($username_siswa, $password_siswa)
{
    global $connect;
    $stmntSiswa = $connect->prepare("SELECT * FROM siswa WHERE USERNAME_SISWA = :username_siswa");
    $stmntSiswa->execute([':username_siswa' => $username_siswa]);
    $siswa = $stmntSiswa->fetch();

    if ($siswa) {
        if ($siswa['PASSWORD_SISWA'] === $password_siswa) {
            $_SESSION['LOGIN_ROLE'] = 'siswa';
            $_SESSION['USERNAME_SISWA'] = $siswa['USERNAME_SISWA'];
            $_SESSION['NAMA_SISWA'] = $siswa['NAMA_LENGKAP_SISWA'];
            $_SESSION['BERHASIL_LOGIN'] = "Anda Berhasil Login";
            header("Location:./dashboard/index.php");
            exit;
        }
        return displayErrorPopup('Password siswa salah');
    }
    return false;
}

// ===================
// login admin / siswa
// ===================

function loginUser($username, $password)
{
    if (handleAdminLogin($username, $password)) {
        return true;
    }
    if (handleSiswaLogin($username, $password)) {
        return true;
    }
}

// ====================
// siswa update profile
// ====================

function updateSiswa($username, $data)
{
    global $connect;
    $stmnt = $connect->prepare("SELECT * FROM siswa WHERE USERNAME_SISWA = :username_siswa");
    $stmnt->execute([':username_siswa' => $username]);
    $siswaLama = $stmnt->fetch();

    if (!$siswaLama) {
        return displayErrorPopup("Data siswa tidak ditemukan untuk USERNAME ini!");
    }

    $fotoBaru = $siswaLama['FOTO_SISWA'];

    if (isset($_FILES['foto_siswa']) && $_FILES['foto_siswa']['error'] === 0) {

        $uploadedFileName = uploadFileGambarSiswa();

        if ($uploadedFileName === false) {
            return;
        }

        if (!empty($siswaLama['FOTO_SISWA'])) {
            $oldPath = "../source/upload/images/" . $siswaLama['FOTO_SISWA'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        $fotoBaru = $uploadedFileName;
    }

    $stmnt = $connect->prepare("
        UPDATE siswa SET
            NAMA_LENGKAP_SISWA = :nama,
            FOTO_SISWA = :foto
        WHERE USERNAME_SISWA = :username
    ");

    $update = $stmnt->execute([
        ':nama' => htmlspecialchars($data['nama_lengkap_siswa']),
        ':foto' => htmlspecialchars($fotoBaru),
        ':username' => htmlspecialchars($username)
    ]);

    if ($update) {
        header("Location: ../dashboard/index.php");
        $_SESSION['BERHASIL_EDIT'] = "Siswa berhasil di edit";
        exit;
    } else {
        return displayErrorPopup("Gagal memperbarui data siswa Silakan coba lagi.");
    }
}

// =====================
// Siswa upload document
// =====================

function uploadDocumentFile($fileKey, $keterangan)
{
    $namaFile = $_FILES[$fileKey]['name'];
    $ukuranFile = $_FILES[$fileKey]['size'];
    $error = $_FILES[$fileKey]['error'];
    $tmpName = $_FILES[$fileKey]['tmp_name'];

    if ($error === 4) {
        return false;
    }

    // Ekstensi yang diperbolehkan (pdf, jpg, jpeg, png)
    $ekstensiValid = ['pdf', 'jpg', 'jpeg', 'png'];
    $ekstensiFile = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (!in_array($ekstensiFile, $ekstensiValid)) {
        displayErrorPopup("File tidak valid (hanya PDF, JPG, JPEG, PNG");
        return false;
    }

    if ($ukuranFile > 2000000) {
        echo displayErrorPopup("Ukuran file terlalu besar! Maksimal 2 MB");
        return false;
    }

    $namaBaru = 'doc_' . uniqid() . '.' . $ekstensiFile;
    move_uploaded_file($tmpName, "../source/upload/documents/" . $namaBaru);
    return $namaBaru;
}

// ===========================
// siswa melakukan pendaftaran
// ===========================

function insertDocument($id_pendaftaran, $keterangan, $jenis, $path)
{
    global $connect;
    $stmnt = $connect->prepare("
        INSERT INTO dokumen (ID_PENDAFTARAN, KETERANGAN, JENIS_DOKUMEN, PATH_FILE)
        VALUES (:id_pendaftaran, :keterangan, :jenis, :path_file)
    ");
    return $stmnt->execute([
        ":id_pendaftaran" => $id_pendaftaran,
        ":keterangan" => $keterangan,
        ":jenis" => $jenis,
        ":path_file" => $path
    ]);
}

function getJurusanIdByName(string $nama_jurusan_input)
{
    global $connect;
    $stmnt = $connect->prepare("SELECT ID_JURUSAN FROM jurusan WHERE NAMA_JURUSAN = :nama");
    $stmnt->execute([':nama' => trim($nama_jurusan_input)]);
    $jurusan_data = $stmnt->fetch();
    return $jurusan_data ? $jurusan_data['ID_JURUSAN'] : NULL;
}

function processDocumentUploads($id_pendaftaran, $fileKey, $keterangan, $jenis)
{
    $path = uploadDocumentFile($fileKey, $keterangan);
    if ($path === false) {
        return false;
    }

    $success = insertDocument($id_pendaftaran, $keterangan, $jenis, $path);

    if (!$success) {
        unlink("../source/upload/documents/" . $path);
        return false;
    }
    return true;
}

function addPendaftaran(array $data, $username_siswa)
{
    global $connect;

    $id_jurusan = $data['id_jurusan'];

    $status_penerimaan = "0";
    $stmnt_pendaftaran = $connect->prepare("
        INSERT INTO pendaftaran (ID_JURUSAN, USERNAME_SISWA, NISN, JENIS_KELAMIN, TANGGAL_LAHIR, TEMPAT_LAHIR, NO_HP_SISWA, ASAL_SEKOLAH, ALAMAT, NAMA_WALI, NO_HP_WALI, STATUS, PROGRAM_PONDOK)
        VALUES (:id_jurusan, :username_siswa, :nisn_siswa, :jenis_kelamin, :tanggal_lahir, :tempat_lahir, :no_hp_siswa, :asal_sekolah, :alamat, :nama_wali, :no_hp_wali, :status, :program_pondok)
    ");

    $result_pendaftaran = $stmnt_pendaftaran->execute([
        ":id_jurusan" => htmlspecialchars($id_jurusan),
        ":username_siswa" => htmlspecialchars($username_siswa),
        ":nisn_siswa" => htmlspecialchars($data['nisn_siswa']),
        ":jenis_kelamin" => htmlspecialchars($data['jenis_kelamin']),
        ":tanggal_lahir" => htmlspecialchars($data['tanggal_lahir']),
        ":tempat_lahir" => htmlspecialchars($data['tempat_lahir']),
        ":no_hp_siswa" => htmlspecialchars($data['no_hp_siswa']),
        ":asal_sekolah" => htmlspecialchars($data['asal_sekolah']),
        ":alamat" => htmlspecialchars($data['alamat']),
        ":nama_wali" => htmlspecialchars($data['nama_wali']),
        ":no_hp_wali" => htmlspecialchars($data['no_hp_wali']),
        ":status" => htmlspecialchars($status_penerimaan),
        ":program_pondok" => htmlspecialchars($data['program_pondok']),
    ]);

    $id_pendaftaran = $connect->lastInsertId();

    if ($result_pendaftaran) {
        $akte_success = processDocumentUploads($id_pendaftaran, 'file_akte', 'Akte Kelahiran Siswa', 'Akte Kelahiran');
        $kk_success = processDocumentUploads($id_pendaftaran, 'file_kk', 'Kartu Keluarga Siswa', 'Kartu Keluarga');

        if ($akte_success && $kk_success) {
            header("Location: browse_calon.php");
            $_SESSION['BERHASIL_DAFTAR'] = "Selamat anda berhasil daftar";
            exit;
        } else {
            return displayErrorPopup("Pendaftaran gagal di tingkat dokumen.");
        }
    } else {
        return displayErrorPopup("Gagal menyimpan data pendaftaran utama.");
    }
}

// ===============================
// Admin Update Status Pendaftaran
// ===============================

function updatePendaftaranStatus($username_siswa, $new_status)
{
    global $connect;

    $valid_statuses = ['0', '1', '2'];
    if (!in_array($new_status, $valid_statuses)) {
        // Asumsi displayErrorPopup ada di file ini
        return displayErrorPopup("Status yang dimasukkan tidak valid (hanya 0, 1, atau 2).");
    }

    $stmnt = $connect->prepare("
        UPDATE pendaftaran
        SET STATUS = :status
        WHERE USERNAME_SISWA = :username
        ORDER BY ID_PENDAFTARAN DESC
        LIMIT 1
    ");

    $result = $stmnt->execute([
        ':status' => $new_status,
        ':username' => $username_siswa
    ]);

    if ($result) {
        $_SESSION['success_message'] = "Status pendaftaran berhasil diperbarui.";
        header("Location: Bread_calon_siswa.php?username=" . urlencode($username_siswa));
        exit;
    } else {
        return displayErrorPopup("Gagal memperbarui status pendaftaran.");
    }
}