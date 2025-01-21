<script>
    $('title').text('Peminjaman Saya');
</script>
<main>
    <div class="container-fluid">
        <h2 class="mt-4">Peminjaman Saya</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Peminjaman</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                <div class="collapse show">
                    <!-- form -->
                    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="get">
                        <input type="hidden" name="page" value="peminjaman-saya"/>
                        <div class="form-row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select class="form-control" name="kode_peminjaman" id="kode_peminjaman">
                                        <option value="">Pilih Kode</option>
                                        <?php
                                            include '../config/database.php';
                                            $kode_anggota = $_SESSION['kode_pengguna'];
                                            $sql = "SELECT kode_peminjaman FROM peminjaman WHERE kode_anggota='$kode_anggota'";
                                            $ket = "";
                                            $hasil = mysqli_query($kon, $sql);
                                            $no = 0;
                                            while ($data = mysqli_fetch_array($hasil)):
                                                $no++;
                                                if (isset($_GET['kode_peminjaman'])) {
                                                    $kode_peminjaman = trim($_GET['kode_peminjaman']);
                                                    $ket = ($kode_peminjaman == $data['kode_peminjaman']) ? "selected" : "";
                                                }
                                        ?>
                                            <option <?php echo $ket; ?> value="<?php echo $data['kode_peminjaman'];?>"><?php echo $data['kode_peminjaman'];?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-dark">
                                    <span class="text"><i class="fas fa-search fa-sm"></i> Pilih</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Kode</th>
                                <th rowspan="2">Pustaka</th>
                                <th colspan="2">Waktu Peminjaman</th>
                                <th rowspan="2">Status</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Mulai</th>
                                <th>Selesai</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                include '../config/database.php';
                                $kode_anggota = $_SESSION["kode_pengguna"];
                                
                                if (isset($_GET['kode_peminjaman']) && $_GET['kode_peminjaman'] != '') {
                                    $kode_peminjaman = $_GET['kode_peminjaman'];
                                    $sql = "SELECT *
                                            FROM peminjaman p
                                            INNER JOIN detail_peminjaman d ON d.kode_peminjaman = p.kode_peminjaman
                                            INNER JOIN pustaka k ON k.kode_pustaka = d.kode_pustaka
                                            WHERE p.kode_anggota = '$kode_anggota' AND p.kode_peminjaman = '$kode_peminjaman'
                                            ORDER BY p.kode_peminjaman DESC";
                                } else {
                                    $sql = "SELECT *
                                            FROM peminjaman p
                                            INNER JOIN detail_peminjaman d ON d.kode_peminjaman = p.kode_peminjaman
                                            INNER JOIN pustaka k ON k.kode_pustaka = d.kode_pustaka
                                            WHERE p.kode_anggota = '$kode_anggota'
                                            ORDER BY p.kode_peminjaman DESC";
                                }

                                $hasil = mysqli_query($kon, $sql);
                                $no = 0;
                                $jum = 0;
                                while ($data = mysqli_fetch_array($hasil)):
                                    $no++;
                                    $jum += 1;

                                    if ($data['status'] == 0) {
                                        $status = "<span class='badge badge-dark'>Belum diambil</span>";
                                    } elseif ($data['status'] == 1) {
                                        $status = "<span class='badge badge-primary'>Sedang Dipinjam</span>";
                                    } elseif ($data['status'] == 2) {
                                        $status = "<span class='badge badge-success'>Telah Selesai</span>";
                                    } elseif ($data['status'] == 3) {
                                        $status = "<span class='badge badge-danger'>Batal</span>";
                                    }

                                    if ($data['tanggal_pinjam'] == '0000-00-00') {
                                        $tanggal_pinjam = "";
                                    } else {
                                        $tanggal_pinjam = tanggal(date("Y-m-d", strtotime($data['tanggal_pinjam'])));
                                    }
                                    if ($data['tanggal_kembali'] == '0000-00-00') {
                                        $tanggal_kembali = "";
                                    } else {
                                        $tanggal_kembali = tanggal(date("Y-m-d", strtotime($data['tanggal_kembali'])));
                                    }
                            ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $data['kode_peminjaman']; ?></td>
                                    <td><?php echo $data['judul_pustaka']; ?></td>
                                    <td><?php echo $tanggal_pinjam; ?></td>
                                    <td><?php echo $tanggal_kembali; ?></td>
                                    <td><?php echo $status; ?></td>

                                    <td>
                                        <?php if ($data['status'] == 1): ?>
                                            <form action="peminjaman/detail-peminjaman/konfirmasi.php" method="post">
                                                <input type="hidden" name="kode_peminjaman" value="<?php echo $data['kode_peminjaman']; ?>"/>
                                                <input type="hidden" name="kode_anggota" value="<?php echo $kode_anggota; ?>"/>
                                                <input type="submit" class="btn btn-warning" name="ajukan_pengembalian" value="Ajukan Pengembalian">
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($jum != 0): ?>
                    <a href="peminjaman/detail-peminjaman/invoice.php?kode_peminjaman=<?php if (isset($_GET['kode_peminjaman']) && $_GET['kode_peminjaman'] != '') echo $_GET['kode_peminjaman']; ?>&kode_anggota=<?php echo $kode_anggota; ?>" target="_blank" class="btn btn-dark btn-icon-pdf">
                        <span class="text"><i class="fas fa-print fa-sm"></i> Cetak</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php 
    // Membuat format tanggal
    function tanggal($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }
?>
