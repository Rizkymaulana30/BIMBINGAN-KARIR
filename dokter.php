<?php
    // session_start();
    if(!isset($_SESSION["login"]))
    {
        header("location: index.php?page=loginUser");
        exit;
    }
?>
<form class="form col" method="POST" action="" name="myForm" onsubmit="return(validate());">
            <!-- Kode php untuk menghubungkan form dengan database -->
            <?php
            $nama = '';
            $alamat = '';
            $no_hp = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, 
                "SELECT * FROM dokter 
                WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $nama = $row['nama'];
                    $alamat = $row['alamat'];
                    $no_hp = $row['no_hp'];
                }
            ?>
                <input type="hidden" name="id" value="<?php echo
                $_GET['id'] ?>">
            <?php
            }
            ?>
            <div class="row mt-3">
                <label for="nama" class="form-label fw-bold">
                    Nama
                </label>
                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama ?>">
            </div>
            <div class="row mt-3">
                <label for="alamat" class="form-label fw-bold">
                    Alamat
                </label>
                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat ?>">
            </div>
            <div class="row mt-3">
                <label for="no_hp" class="form-label fw-bold">
                    No HP
                </label>
                <input type="number" class="form-control" name="no_hp" id="no_hp" placeholder="No HP" value="<?php echo $no_hp ?>">
            </div>
            <div class="row d-flex mt-3">
                <button type="submit" class="btn btn-primary rounded-pill" style="width: 3cm;" name="simpan">Simpan</button>
            </div>
        </form>
        <!-- tabel -->
        <!-- Table-->
        <table class="table table-hover my-3">
            <!--thead atau baris judul-->
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No HP</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <!--tbody berisi isi tabel sesuai dengan judul atau head-->
            <tbody>
                <!-- Kode PHP untuk menampilkan semua isi dari tabel urut
                berdasarkan status dan tanggal awal-->
                <?php
                    $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $data['nama'] ?></td>
                            <td><?php echo $data['alamat'] ?></td>
                            <td><?php echo $data['no_hp'] ?></td>
                            <td>
                                <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                                <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                ?>
            </tbody>
        </table>
        <!-- logi simpan ubah deleted -->
        <?php
                if (isset($_POST['simpan'])) {
                    if (isset($_POST['id'])) {
                        $ubah = mysqli_query($mysqli, "UPDATE dokter SET 
                                                        nama = '" . $_POST['nama'] . "',
                                                        alamat = '" . $_POST['alamat'] . "',
                                                        no_hp = '" . $_POST['no_hp'] . "'
                                                        WHERE
                                                        id = '" . $_POST['id'] . "'");
                    } else {
                        $tambah = mysqli_query($mysqli, "INSERT INTO dokter(nama,alamat,no_hp) 
                                                        VALUES ( 
                                                            '" . $_POST['nama'] . "',
                                                            '" . $_POST['alamat'] . "',
                                                            '" . $_POST['no_hp'] . "'
                                                            )");
                    }

                    echo "<script> 
                            document.location='index.php?page=dokter';
                            </script>";
                }

                if (isset($_GET['aksi'])) {
                    if ($_GET['aksi'] == 'hapus') {
                        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
                    } 
                    echo "<script> 
                            document.location='index.php?page=dokter';
                            </script>";
                }
        ?>