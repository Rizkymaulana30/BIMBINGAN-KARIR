<?php
    // session_start();
    if(!isset($_SESSION["login"]))
    {
        header("location: index.php?page=loginUser");
        exit;
    }

    // Koneksi ke database
    $mysqli = new mysqli('localhost', 'root', '', 'poliklinik-new');
    if ($mysqli->connect_error) {
        die("Koneksi gagal: " . $mysqli->connect_error);
    }
?>
<form class="form col" method="POST" action="" name="myForm">
    <!-- Kode PHP untuk menghubungkan form dengan database -->
    <?php
    $nama_poli = '';
    $keterangan = '';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($mysqli, "SELECT * FROM poli WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $nama_poli = $row['nama_poli'];
            $keterangan = $row['keterangan'];
        }
    ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
    }
    ?>
    <div class="row mt-3">
        <label for="nama_poli" class="form-label fw-bold">Nama Poli</label>
        <input type="text" class="form-control" name="nama_poli" id="nama_poli" placeholder="Nama Poli" value="<?php echo $nama_poli ?>" required>
    </div>
    <div class="row mt-3">
        <label for="keterangan" class="form-label fw-bold">Keterangan</label>
        <textarea class="form-control" name="keterangan" id="keterangan" placeholder="keterangan Poli" required><?php echo $keterangan ?></textarea>
    </div>
    <div class="row d-flex mt-3">
        <button type="submit" class="btn btn-primary rounded-pill" style="width: 3cm;" name="simpan">Simpan</button>
    </div>
</form>

<!-- Tabel -->
<h2 class="mt-5">Daftar Poli</h2>
<table class="table table-hover my-3">
    <!-- Tabel Head -->
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Poli</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <!-- Tabel Body -->
    <tbody>
        <?php
        $result = mysqli_query($mysqli, "SELECT * FROM poli");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $data['nama_poli'] ?></td>
                <td><?php echo $data['keterangan'] ?></td>
                <td>
                    <a class="btn btn-success rounded-pill px-3" href="index.php?page=poli&id=<?php echo $data['id'] ?>">Ubah</a>
                </td>
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
        // Proses Edit Data
        $ubah = mysqli_query($mysqli, "UPDATE poli SET 
                                        nama_poli = '" . $_POST['nama_poli'] . "',
                                        keterangan = '" . $_POST['keterangan'] . "' 
                                        WHERE id = '" . $_POST['id'] . "'");
    } else {
        // Proses Tambah Data
        $tambah = mysqli_query($mysqli, "INSERT INTO poli (nama_poli, keterangan) 
                                        VALUES (
                                            '" . $_POST['nama_poli'] . "',
                                            '" . $_POST['keterangan'] . "'
                                        )");
    }

    // Redirect ke halaman poli
    echo "<script>
            document.location='index.php?page=poli';
          </script>";
}
?>
