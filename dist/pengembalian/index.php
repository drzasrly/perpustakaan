<script>
    $('title').text('Detail Pengembalian');
</script>

<main>
    <div class="container-fluid">
        <h2 class="mt-4">Detail Pengembalian</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Detail Pengembalian</li>
        </ol>
        <?php
            if (isset($_GET['aksi'])) {
                if ($_GET['aksi']=='berhasil'){
                    echo"<div class='alert alert-success'><strong>Berhasil!</strong> Aksi berhasil dilakukan.</div>";
                } else if ($_GET['aksi']=='gagal'){
                    echo"<div class='alert alert-danger'><strong>Gagal!</strong> Aksi gagal dilakukan.</div>";
                }
            }
        ?>
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Pustaka</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include '../config/database.php';
                            $kode_anggota = $_GET['kode_anggota'];
                            // Menampilkan detail pengembalian
                            $sql = "SELECT * FROM pengembalian 
                                    INNER JOIN detail_pengembalian 
                                    ON pengembalian.kode_pengembalian = detail_pengembalian.kode_pengembalian
                                    INNER JOIN pustaka 
                                    ON pustaka.kode_pustaka = detail_pengembalian.kode_pustaka
                                    WHERE pengembalian.kode_anggota = '$kode_anggota'";
                            $result = mysqli_query($kon, $sql);
                            $no = 0;
                            while ($ambil = mysqli_fetch_array($result)):
                                $no++;
                                $status = ($ambil['status'] == 0) ? "<span class='badge badge-warning'>Menunggu Verifikasi</span>" : "<span class='badge badge-success'>Diverifikasi</span>";
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $ambil['judul_pustaka']; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($ambil['tanggal_pinjam'])); ?></td>
                            <td><?php echo date('d-m-Y', strtotime($ambil['tanggal_kembali'])); ?></td>
                            <td><?php echo $status; ?></td>
                            <td>
                                <?php if ($ambil['status'] == 0): ?>
                                    <button class="btn btn-primary btn-circle tombol_ajukan_pengembalian" 
                                        data-id-detail="<?php echo $ambil['id_detail_pengembalian']; ?>">
                                        <i class="fas fa-paper-plane"></i> Ajukan Pengembalian
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-success btn-circle" disabled>
                                        <i class="fas fa-check"></i> Sudah Diverifikasi
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    // Ajukan pengembalian oleh anggota
    $('.tombol_ajukan_pengembalian').on('click', function() {
        var idDetail = $(this).data('id-detail');
        $.ajax({
            url: 'pengembalian/ajukan-pengembalian.php',
            method: 'post',
            data: { id_detail: idDetail },
            success: function(data) {
                alert('Pengembalian berhasil diajukan!');
                location.reload();
            },
            error: function() {
                alert('Gagal mengajukan pengembalian!');
            }
        });
    });

    // Verifikasi pengembalian oleh karyawan (contoh integrasi lebih lanjut)
    $('.tombol_verifikasi_pengembalian').on('click', function() {
        var idDetail = $(this).data('id-detail');
        $.ajax({
            url: 'pengembalian/verifikasi-pengembalian.php',
            method: 'post',
            data: { id_detail: idDetail },
            success: function(data) {
                alert('Pengembalian berhasil diverifikasi!');
                location.reload();
            },
            error: function() {
                alert('Gagal memverifikasi pengembalian!');
            }
        });
    });
</script>
