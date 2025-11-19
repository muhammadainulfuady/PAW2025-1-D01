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
    // Pola: Hanya huruf (a-z), angka (0-9), atau underscore/dot. Minimal 5 karakter.
    $ptUsername = "/^[a-zA-Z0-9_\.]{5,}$/";

    if (requiredCheck($field)) {
        $eror['username_siswa'] = "Kolom username wajib di isi.";
    } elseif (!preg_match($ptUsername, $field)) {
        $eror['username_siswa'] = "Username harus alphanumeric (a-z, 0-9) dan minimal 5 karakter.";
    } elseif (!preg_match($ptUsername, $field)) {
        $eror['username_siswa'] = "Username tidak boleh mengandung simbol.  ";
    }
}

function valName($field, &$eror)
{
    $ptNamaLengkap = "/^[a-zA-Z\s]{5,}$/";
    if (requiredCheck($field)) {
        $eror['nama_lengkap_siswa'] = "Kolom nama lengkap wajib di isi.";
    } elseif (!preg_match($ptNamaLengkap, $field)) {
        $eror['nama_lengkap_siswa'] = "Nama lengkap harus berisi huruf dan spasi, minimal 5 karakter.";
    }
}

function valPassword($field, &$eror)
{   // Pola: Minimum 8 karakter, harus mengandung (setidaknya satu lowercase, satu uppercase, dan satu digit).
    $ptPassword = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
    if (requiredCheck($field)) {
        $eror['password_siswa'] = "Kolom password wajib di isi.";
    } elseif (!preg_match($ptPassword, $field)) {
        $eror['password_siswa'] = "Username harus alphanumeric (a-z, 0-9) dan minimal 5 karakter.";
    }
}

function displayErrorPopup($message)
{
    echo "
        <div class='error-popup-container'>
            <span class='error-icon'>⚠️⚠️<span>
            <p class='eror-akun'>{$message}</p>
        </div>";
    return false;
}

// ====================
// succes validasi
// =====================

function displaySuccesPopup($message)
{
    echo "
        <div class='succes-popup-container'>
            <span class='succes-icon'>✔️<span>
            <p class='succes-akun'>{$message}</p>
        </div>";
    return false;
}

// ================
// siswa registrasi
// ================

function addSiswa(array $data)
{
    global $connect;

    // $username_input = trim($data['username_siswa']);
    // if (checkUsernameDuplication($username_input)) {
    //     return displayErrorPopup("username ({$username_input}) sudah terdaftar. Silakan login atau gunakan username lain.");
    // }

    $stmnt = $connect->prepare("
        INSERT INTO siswa (USERNAME_SISWA, NAMA_LENGKAP_SISWA, FOTO_SISWA, PASSWORD_SISWA)
        VALUES (:username_siswa, :nama_lengkap_siswa, :foto_siswa, :password_siswa)
    ");

    $result = $stmnt->execute([
        ":username_siswa" => htmlspecialchars($data['username_siswa']),
        ":nama_lengkap_siswa" => htmlspecialchars($data['nama_lengkap_siswa']),
        ":foto_siswa" => 'default.jpg',
        ":password_siswa" => md5($data['password_siswa']),
    ]);

    if ($result && $stmnt->rowCount() > 0) {
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
    return displayErrorPopup('Akun tidak ditemukan');
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
        ':foto' => $fotoBaru,
        ':username' => $username
    ]);

    if ($update) {
        header("Location: ../dashboard/index.php");
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

function getStatusText(string $status_code)
{
    switch ($status_code) {
        case '0':
            return '<span style="color: blue; font-weight: bold;">Masih Proses Verifikasi</span>';
        case '1':
            return '<span style="color: green; font-weight: bold;">DITERIMA</span>';
        case '2':
            return '<span style="color: red; font-weight: bold;">DITOLAK</span>';
        default:
            return 'Status Tidak Diketahui';
    }
}

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

    $required_fields = ['id_jurusan', 'nisn_siswa', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir', 'no_hp_siswa', 'asal_sekolah', 'alamat', 'nama_wali', 'no_hp_wali', 'program_pondok'];
    foreach ($required_fields as $field) {
        if (empty(trim($data[$field]))) {
            return displayErrorPopup("Harap isi semua field pendaftaran!");
        }
    }

    if (empty($_FILES['file_akte']['name']) || empty($_FILES['file_kk']['name'])) {
        return displayErrorPopup("Harap upload semua dokumen wajib (Akte & Kartu Keluarga)!");
    }

    // $stmnt_check = $connect->prepare("SELECT COUNT(*) FROM pendaftaran WHERE USERNAME_SISWA = :username_siswa AND STATUS = '0'");
    // $stmnt_check->execute([':username_siswa' => $username_siswa]);
    // if ($stmnt_check->fetchColumn() > 0) {
    //     return displayErrorPopup("Anda sudah memiliki pendaftaran dengan status 'Masih Proses'.");
    // }

    $nama_jurusan_input = trim($data['id_jurusan']);
    $id_jurusan = getJurusanIdByName($nama_jurusan_input);

    $status_penerimaan = "0";
    $stmnt_pendaftaran = $connect->prepare("
        INSERT INTO pendaftaran (ID_JURUSAN, USERNAME_SISWA, NISN, JENIS_KELAMIN, TANGGAL_LAHIR, TEMPAT_LAHIR, NO_HP_SISWA, ASAL_SEKOLAH, ALAMAT, NAMA_WALI, NO_HP_WALI, STATUS, PROGRAM_PONDOK)
        VALUES (:id_jurusan, :username_siswa, :nisn_siswa, :jenis_kelamin, :tanggal_lahir, :tempat_lahir, :no_hp_siswa, :asal_sekolah, :alamat, :nama_wali, :no_hp_wali, :status, :program_pondok)
    ");

    $result_pendaftaran = $stmnt_pendaftaran->execute([
        ":id_jurusan" => $id_jurusan,
        ":username_siswa" => $username_siswa,
        ":nisn_siswa" => htmlspecialchars($data['nisn_siswa']),
        ":jenis_kelamin" => htmlspecialchars($data['jenis_kelamin']),
        ":tanggal_lahir" => htmlspecialchars($data['tanggal_lahir']),
        ":tempat_lahir" => htmlspecialchars($data['tempat_lahir']),
        ":no_hp_siswa" => htmlspecialchars($data['no_hp_siswa']),
        ":asal_sekolah" => htmlspecialchars($data['asal_sekolah']),
        ":alamat" => htmlspecialchars($data['alamat']),
        ":nama_wali" => htmlspecialchars($data['nama_wali']),
        ":no_hp_wali" => htmlspecialchars($data['no_hp_wali']),
        ":status" => $status_penerimaan,
        ":program_pondok" => htmlspecialchars($data['program_pondok']),
    ]);

    $id_pendaftaran = $connect->lastInsertId();

    if ($result_pendaftaran) {
        $akte_success = processDocumentUploads($id_pendaftaran, 'file_akte', 'Akte Kelahiran Siswa', 'Akte Kelahiran');
        $kk_success = processDocumentUploads($id_pendaftaran, 'file_kk', 'Kartu Keluarga Siswa', 'Kartu Keluarga');

        if ($akte_success && $kk_success) {
            header("Location: browse_calon.php");
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