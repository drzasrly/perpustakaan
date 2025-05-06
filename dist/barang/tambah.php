<?php
session_start();
    if (isset($_POST['tambah_pelanggan'])) {
        include '../../config/database.php';
        
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            mysqli_query($kon,"START TRANSACTION");

            $kodeBarang=input($_POST["kodeBarang"]);
            $namaBarang=$_POST["namaBarang"];
            $kategoriBarang=input($_POST["kategoriBarang"]);
            $stok=input($_POST["stok"]);

            $ekstensi_diperbolehkan	= array('png','jpg');
            $gambarBarang = $_FILES['gambarBarang']['name'];
            $x = explode('.', $gambarBarang);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['gambarBarang']['size'];
            $file_tmp = $_FILES['gambarBarang']['tmp_name'];	

            if (!empty($gambarBarang)){
                if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                    if($ukuran < 1044070){	
                        move_uploaded_file($file_tmp, 'gambar/'.$gambarBarang);
                        $sql="insert into barang (kodeBarang,namaBarang,kategoriBarang,gambarBarang,rak) values
                        ('$kodeBarang','$namaBarang','$kategoriBarang0','$gambarBarang','$stok')";
                    }
                }
            }else {
                $gambarBarang="gambar_default.png";
                $sql="insert into barang (kodeBarang,namaBarang,kategoriBarang,gambarBarang,rak) values
                ('$kodeBarang','$namaBarang','$kategoriBarang0','$gambarBarang','$stok')";
            }

            $simpan_barang=mysqli_query($kon,$sql);

            if ($simpan_barang) {
                mysqli_query($kon,"COMMIT");
                header("Location:../../dist/index.php?page=barang&add=berhasil");
            }
            else {
                mysqli_query($kon,"ROLLBACK");
                header("Location:../../dist/index.php?page=barang&add=gagal");
            }
        }
    }
      include '../../config/database.php';
      $query = mysqli_query($kon, "SELECT max(idBarang) as kodeTerbesar FROM barang");
      $data = mysqli_fetch_array($query);
      $idBarang = $data['kodeTerbesar'];
      $idBarang++;
      $huruf = "br";
      $kodeBarang = $huruf . sprintf("%02s", $idBarang);

?>
<form action="barang/tambah.php" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
                <label>Nama Barang:</label>
                <input name="namaBarang" type="text" class="form-control" placeholder="Masukan Nama Barang" required>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label>Kode:</label>
                <h3><?php echo $kodeBarang; ?></h3>
                <input name="kode" value="<?php echo $kodeBarang; ?>" type="hidden" class="form-control">
            </div>
        </div>
    </div>              
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>Kategori:</label>
                <select name="kategoriBarang" class="form-control">
                <?php
                    $sql="select * from kategoriBarang order by idKategori asc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($data = mysqli_fetch_array($hasil)):
                ?>
                    <option value="<?php echo $data['idKategori']; ?>"><?php echo $data['namaKategori']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Jumlah Stok:</label>
                        <input name="stok" type="number" class="form-control" placeholder="Masukan stok" required>
                    </div>
                </div>
        </div>
    </div>
    <!-- rows -->   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div id="msg"></div>
                <label>Gambar Barang:</label>
                <input type="file" name="gambarBarang" class="file" >
                    <div class="input-group my-3">
                        <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                        <div class="input-group-append">
                            <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                        </div>
                    </div>
                <img src="../src/img/img80.png" id="preview" class="img-thumbnail">
            </div>
        </div>
    </div>

    <!-- rows -->   
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
             <button type="submit" name="tambah_anggota" class="btn btn-success">Tambah</button>
            </div>
        </div>
    </div>

</form>

<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>
<script>
    $(document).on("click", "#pilih_gambar", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    });
</script>
