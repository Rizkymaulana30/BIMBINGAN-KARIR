<?php
    // session_start();
    if(!isset($_SESSION["login"]))
    {
        header("location: index.php?page=loginUser");
        exit;
    }
?>
<form class="form col" method="POST" action="" name="myForm" onsubmit="return(validate());">
    <!-- Kode PHP untuk menghubungkan form dengan database -->
    <?php
    $nama_obat = '';
    $jenis_obat = '';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($mysqli, 
        "SELECT * FROM obat 
        WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $nama_obat = $row['nama_obat'];
            $jenis_obat = $row['jenis_obat'];
        }
    ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
    }
    ?>
    <div class="row mt-3">
        <label for="nama_obat" class="form-label fw-bold">
            Nama Obat
        </label>
        <input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" value="<?php echo $nama_obat ?>">
    </div>
    <div class="row mt-3">
        <label for="jenis_obat" class="form-label fw-bold">
            Jenis Obat
        </label>
        <input type="text" class="form-control" name="jenis_obat" id="jenis_obat" placeholder="Jenis Obat" value="<?php echo $jenis_obat ?>">
    </div>
    <div class="row d-flex mt-3">
        <button type="submit" class="btn btn-primary rounded-pill" style="width: 3cm;" name="simpan">Simpan</button>
    </div>
</form>

<!-- Tabel Obat -->
<table class="table table-hover my-3">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Obat</th>
            <th scope="col">Jenis Obat</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($mysqli, "SELECT * FROM obat");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $data['nama_obat'] ?></td>
                <td><?php echo $data['jenis_obat'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<!-- Logika Simpan dan Ubah -->
<?php
if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE obat SET 
                                    nama_obat = '" . $_POST['nama_obat'] . "',
                                    jenis_obat = '" . $_POST['jenis_obat'] . "'
                                    WHERE
                                    id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO obat(nama_obat, jenis_obat) 
                                    VALUES ( 
                                        '" . $_POST['nama_obat'] . "',
                                        '" . $_POST['jenis_obat'] . "'
                                        )");
    }

    echo "<script> 
            document.location='index.php?page=obat';
          </script>";
}
