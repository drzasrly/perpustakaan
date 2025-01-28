<?php
session_start();

// Abstract class untuk mendefinisikan proses penyimpanan
abstract class DataHandler {
    protected $kon; // Koneksi database

    public function __construct($kon) {
        $this->kon = $kon;
    }

    // Method abstract untuk menyimpan data
    abstract public function save($data);
}

// Kelas untuk menyimpan data anggota
class AnggotaHandler extends DataHandler {
    public function save($data) {
        $kode_anggota = $data['kode_anggota'];
        $nama_anggota = $data['nama_anggota'];
        $nomor_telp = $data['nomor_telp'];
        $email = $data['email'];
        $alamat = $data['alamat'];

        // Query untuk menyimpan data anggota
        return mysqli_query($this->kon, "INSERT INTO anggota (kode_anggota, nama_anggota, no_telp, email, alamat) 
                                         VALUES ('$kode_anggota', '$nama_anggota', '$nomor_telp', '$email', '$alamat')");
    }
}

// Kelas untuk menyimpan data pengguna
class PenggunaHandler extends DataHandler {
    public function save($data) {
        $kode_pengguna = $data['kode_pengguna'];
        $username = $data['username'];
        $password = $data['password'];
        $status = $data['status'];
        $level = $data['level'];

        // Query untuk menyimpan data pengguna
        return mysqli_query($this->kon, "INSERT INTO pengguna (kode_pengguna, username, password, status, level) 
                                         VALUES ('$kode_pengguna', '$username', '$password', '$status', '$level')");
    }
}

// Fungsi untuk mencegah input karakter yang tidak sesuai
function input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Proses penyimpanan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../config/database.php";

    mysqli_query($kon, "START TRANSACTION");

    // Membuat kode anggota baru
    $query = mysqli_query($kon, "SELECT max(id_anggota) as kodeTerbesar FROM anggota");
    $data = mysqli_fetch_array($query);
    $id_anggota = $data['kodeTerbesar'];
    $id_anggota++;
    $kode_anggota = "A" . sprintf("%03s", $id_anggota);

    // Data dari form
    $nama_anggota = input($_POST["nama"]);
    $nomor_telp = input($_POST["nomor_telp"]);
    $email = input($_POST["email"]);
    $alamat = input($_POST["alamat"]);
    $username = input($_POST["username"]);
    $password = input($_POST["password"]);

    // Data untuk disimpan
    $anggotaData = [
        'kode_anggota' => $kode_anggota,
        'nama_anggota' => $nama_anggota,
        'nomor_telp' => $nomor_telp,
        'email' => $email,
        'alamat' => $alamat
    ];

    $penggunaData = [
        'kode_pengguna' => $kode_anggota,
        'username' => $username,
        'password' => $password,
        'status' => 1,
        'level' => "Anggota"
    ];

    $anggotaHandler = new AnggotaHandler($kon);
    $penggunaHandler = new PenggunaHandler($kon);

    $simpan_anggota = $anggotaHandler->save($anggotaData);
    $simpan_pengguna = $penggunaHandler->save($penggunaData);

    if ($simpan_anggota && $simpan_pengguna) {
        mysqli_query($kon, "COMMIT");
        header("Location:login.php?daftar=berhasil");
    } else {
        mysqli_query($kon, "ROLLBACK");
        header("Location:daftar.php?daftar=gagal");
    }
}
?>
