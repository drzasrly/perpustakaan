<?php
session_start();
$kategori="";

if (isset($_POST['kategoriBarang'])) {
	foreach ($_POST['kategoriBarang'] as $value)
	{
		$kategori .= "'$value'". ",";
	}
	$kategori = substr($kategori,0,-1);
}else {
    $kategori = "0"; 
}
?>

<div class="row">
    <div class="col-sm-2">
        <div class="form-group">
        <?php 
            if ($_SESSION['level']=='Penjual' or $_SESSION['level']=='penjual'):
        ?>
            <button type="button" id="btn-tambah-barang" class="btn btn-warning"><span class="text"><i class="fas fa-book fa-sm"></i> Tambah barang</span></button>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">

<?php         
    include '../../config/database.php';

    if (isset($_POST['kodeKategori'])) {
        $sql = "SELECT * FROM barang WHERE kodeKategori IN ($kategori)";
    } else {
        $sql = "SELECT * FROM barang";
    }

    $hasil = mysqli_query($kon, $sql);
    $cek = mysqli_num_rows($hasil);

    if ($cek<=0){
        echo"<div class='col-sm-12'><div class='alert alert-warning'>Data tidak ditemukan!</div></div>";
        exit;
    }
    $no=0;
    while ($data = mysqli_fetch_array($hasil)):
    $no++;
?>
<div class="col-sm-2">
    <div class="card">

        <div class="card bg-basic">
            <img class="card-img-top" src="../dist/barang/gambar/<?php echo $data['gambarBarang'];?>"  alt="Card image cap">
            <div class="card-body text-center">
            <?php 
                if ($_SESSION['level']=='Penjual' or $_SESSION['level']=='penjual'):
            ?>
                <button  type="button" class="btn-detail-barang btn btn-light" idBarang="<?php echo $data['idBarang'];?>"  kodeBarang="<?php echo $data['kodeBarang'];?>" ><span class="text"><i class="fas fa-mouse-pointer"></i></span></button>
				<button  type="button" class="btn-edit-barang btn btn-light" idBarang="<?php echo $data['idBarang'];?>" kodeBarang="<?php echo $data['kodeBarang'];?>" ><span class="text"><i class="fas fa-edit"></i></span></button>
				<a href="barang/hapus.php?idBarang=<?php echo $data['idBarang']; ?>&gambarBarang=<?php echo $data['gambarBarang']; ?>" class="btn-hapus btn btn-light" ><i class="fa fa-trash"></i></a>
            <?php endif; ?>
            <?php 
                if ($_SESSION['level']=='Pelanggan' or $_SESSION['level']=='pelanggan'):
            ?>
             <button  type="button" class="btn-detail-barang btn btn-warning btn-block" id_pustaka="<?php echo $data['idBarang'];?>"  kodeBarang="<?php echo $data['kodeBarang'];?>" ><span class="text">Lihat</span></button>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
</div>


<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
            <h4 class="modal-title" id="namaBarang"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Bagian body -->
        <div class="modal-body">
            <div id="tampil_data">

            </div>  
        </div>
        <!-- Bagian footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>


<script>
    $('#btn-tambah-barang').on('click',function(){
        $.ajax({
            url: 'barang/tambah.php',
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("namaBarang").innerHTML='Tambah Barang Baru';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

    $('.btn-detail-barang').on('click',function(){
		var idBarang = $(this).attr("idBarang");
        var kodeBarang = $(this).attr("kodeBarang");
        $.ajax({
            url: 'barang/detail.php',
            method: 'post',
			data: {idBarang:idBarang},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("namaBarang").innerHTML='Detail Barang #'+kodeBarang;
            }
        });
        $('#modal').modal('show');
    });

    $('.btn-edit-barang').on('click',function(){
		var idBarang = $(this).attr("idBarang");
        var kodeBarang = $(this).attr("kodeBarang");
        $.ajax({
            url: 'barang/edit.php',
            method: 'post',
			data: {idBarang:idBarang},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("namaBarang").innerHTML='Edit barang #'+kodeBarang;
            }
        });
        $('#modal').modal('show');
    });

    $('.btn-hapus').on('click',function(){
        konfirmasi=confirm("Yakin ingin menghapus barang ini?")
        if (konfirmasi){
            return true;
        }else {
            return false;
        }
    });
</script>
