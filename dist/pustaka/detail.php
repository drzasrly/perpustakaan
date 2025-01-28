<?php
session_start();

class PustakaBase {
    protected $kon; 

    public function __construct($kon) {
        $this->kon = $kon;
    }

    protected function getPustakaById($id_pustaka) {
        $sql = "SELECT * FROM pustaka p 
                INNER JOIN kategori_pustaka k ON k.id_kategori_pustaka = p.kategori_pustaka
                INNER JOIN penulis s ON s.id_penulis = p.penulis
                INNER JOIN penerbit t ON t.id_penerbit = p.penerbit
                WHERE p.id_pustaka = $id_pustaka LIMIT 1";
        $hasil = mysqli_query($this->kon, $sql);
        return mysqli_fetch_array($hasil);
    }
}

class PustakaDetails extends PustakaBase {

    public function displayDetails($id_pustaka) {
        $data = $this->getPustakaById($id_pustaka);

        if (!$data) {
            echo "<div class='alert alert-danger'>Data pustaka tidak ditemukan.</div>";
            return;
        }

        // Menampilkan informasi pustaka
        echo '<div class="card-body">';
        if ($data['stok'] <= 0) {
            echo '<div class="alert alert-warning">Mohon maaf stok pustaka sedang kosong</div>';
        }

        echo '<div class="row">';
        echo '<div class="col-sm-6">';
        echo '<img class="card-img-top" src="pustaka/gambar/' . $data['gambar_pustaka'] . '" alt="Card image">';
        echo '</div>';
        echo '<div class="col-sm-6">';
        echo '<table class="table">';
        echo '<tbody>';
        echo '<tr><td>Judul</td><td>: ' . $data['judul_pustaka'] . '</td></tr>';
        echo '<tr><td>Kategori</td><td>: ' . $data['nama_kategori_pustaka'] . '</td></tr>';
        echo '<tr><td>Penulis</td><td>: ' . $data['nama_penulis'] . '</td></tr>';
        echo '<tr><td>Penerbit</td><td>: ' . $data['nama_penerbit'] . '</td></tr>';
        echo '<tr><td>Tahun</td><td>: ' . $data['tahun'] . '</td></tr>';
        echo '<tr><td>Halaman</td><td>: ' . $data['halaman'] . '</td></tr>';
        echo '<tr><td>Jumlah Stok</td><td>: ' . $data['stok'] . '</td></tr>';
        echo '<tr><td>Posisi Rak</td><td>: ' . $data['rak'] . '</td></tr>';

        if ($data['stok'] >= 1 && ($_SESSION['level'] == 'Anggota' || $_SESSION['level'] == 'anggota')) {
            echo '<tr><td colspan="2"><a href="index.php?page=keranjang&kode_pustaka=' . $data['kode_pustaka'] . '&aksi=pilih_pustaka" class="btn btn-dark btn-block">Masukan Keranjang</a></td></tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

// Koneksi database
include '../../config/database.php';

// Mengambil ID pustaka dari POST
$id_pustaka = $_POST["id_pustaka"];

// Membuat objek PustakaDetails
$pustaka = new PustakaDetails($kon);
?>

<div class="card">
    <?php $pustaka->displayDetails($id_pustaka); ?>
</div>
