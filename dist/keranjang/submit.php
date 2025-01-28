<?php 
    session_start();
    include '../../config/database.php';

    mysqli_query($kon,"START TRANSACTION");

    $query = mysqli_query($kon, "SELECT max(id_peminjaman) as id_peminjaman_terbesar FROM peminjaman");
    $data = mysqli_fetch_array($query);
    $id_peminjaman = $data['id_peminjaman_terbesar'];
    $id_peminjaman++;
    $kode_peminjaman = sprintf("%03s", $id_peminjaman);
    $tanggal=date('Y-m-d');
    $kode_anggota=$_SESSION['kode_pengguna'];

    $simpan_tabel_peminjaman=mysqli_query($kon,"insert into peminjaman (kode_peminjaman,kode_anggota,tanggal) values ('$kode_peminjaman','$kode_anggota','$tanggal')");

    if(!empty($_SESSION["cart_pustaka"])) {
        foreach ($_SESSION["cart_pustaka"] as $item) {
            $kode_pustaka=$item['kode_pustaka'];
            $status = 0; 
            $denda = 0;   
            $simpan_tabel_detail=mysqli_query($kon,"insert into detail_peminjaman (kode_peminjaman, kode_pustaka, tanggal_pinjam, tanggal_kembali, jenis_denda, status, denda) values ('$kode_peminjaman', '$kode_pustaka', NOW(), CURRENT_DATE + INTERVAL 7 DAY, 0, '$status', '$denda')");
        }
    }

    if ($simpan_tabel_peminjaman and $simpan_tabel_detail) {
        mysqli_query($kon,"COMMIT");

        unset($_SESSION["cart_pustaka"]);
        header("Location:../index.php?page=booking&kode_peminjaman=$kode_peminjaman");
    }
    else {
        mysqli_query($kon,"ROLLBACK");

        unset($_SESSION["cart_pustaka"]);
        header("Location:../index.php?page=booking&add=gagal");
    }
?>
