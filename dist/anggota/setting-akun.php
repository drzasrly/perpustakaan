<?php
session_start();
if (isset($_POST['submit'])) {
    include '../config/config.php';

    mysqli_query($connection, "START TRANSACTION");
    
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $kodeMember = input($_POST["kodeMember"]);
    $nama = input($_POST["nama"]);
    $password = input($_POST["password"]);

    $query = mysqli_query($connection, "SELECT passwordMember FROM member WHERE kodeMember='$kodeMember' LIMIT 1");
    $data = mysqli_fetch_array($query);

    if ($data['passwordMember'] == $_POST["password"]) {
        $passwordMember = input($_POST["password"]);
    } else {
        $passwordMember = input($_POST["password"]);
    }

    $sql = "UPDATE member SET
        nama='$nama',
        passwordMember='$passwordMember'
        WHERE kodeMember='$kodeMember'";

    $update_member = mysqli_query($connection, $sql);

    if ($update_member) {
        mysqli_query($connection, "COMMIT");
        header("Location:../../dist/index.php?page=anggota&setting-akun=berhasil");
    } else {
        mysqli_query($connection, "ROLLBACK");
        header("Location:../../dist/index.php?page=anggota&setting-akun=gagal");
    }
}

//-------------------------------------------------------------------------------------------

$kodeMember = $_POST["kodeMember"];
include '../config/config.php';
$query = mysqli_query($connection, "SELECT * FROM member WHERE kodeMember='$kodeMember'");
$data = mysqli_fetch_array($query); 
$nama = $data['nama'];
$passwordMember = $data['passwordMember'];

if ($nama == null) {
    echo "<div class='alert alert-warning'>Nama dan password belum di set up.</div>";
}
?>
<form action="anggota/setting-akun.php" method="post">

<input name="kodeMember" value="<?php echo $kodeMember; ?>" type="hidden" class="form-control">
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Nama:</label>
            <input name="nama" value="<?php echo $nama; ?>" id="nama" type="text" class="form-control" placeholder="Masukan nama" required>
            <div id="info_nama"> </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Password:</label>
            <input name="password" value="<?php echo $passwordMember; ?>" type="password" class="form-control" placeholder="Masukan password" required>
        </div>
    </div>
</div>
<br>
<button type="submit" name="submit" id="submit" class="btn btn-dark">Submit</button>
</form>

<script>
$("#nama").bind('keyup', function () {
    var nama = $('#nama').val();

    $.ajax({
        url: 'anggota/cek-nama.php',
        method: 'POST',
        data: {nama: nama},
        success: function(data) {
            $('#info_nama').show();
            $('#info_nama').html(data);
        }
    }); 
});
</script>
