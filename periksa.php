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

    if (isset($_POST['simpan'])) {
        $id_dokter = $_POST['id_dokter'];
        $hari = $_POST['hari'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];
        $sudah_diperiksa = isset($_POST['sudah_diperiksa']) ? 1 : 0;

        if (isset($_POST['id'])) {
            // Edit data
            $ubah = mysqli_query($mysqli, "UPDATE periksa SET 
                                            id_dokter = '$id_dokter',
                                            hari = '$hari',
                                            jam_mulai = '$jam_mulai',
                                            jam_selesai = '$jam_selesai',
                                            sudah_diperiksa = '$sudah_diperiksa'
                                            WHERE id = '" . $_POST['id'] . "'");
        } else {
            // Tambah data baru
            $tambah = mysqli_query($mysqli, "INSERT INTO periksa (id_dokter, hari, jam_mulai, jam_selesai, sudah_diperiksa) 
                                            VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai', '$sudah_diperiksa')");
        }

        echo "<script>
                document.location='index.php?page=periksa';
              </script>";
    }
?>
<div class="container">
    <form class="form col" method="POST" action="">
        <!-- Kode PHP untuk mengisi data ke dalam form -->
        <?php
        $id_dokter = '';
        $tanggal = '';
        $jam_mulai = '';
        $jam_selesai = '';
        $sudah_diperiksa = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $id_dokter = $row['id_dokter'];
                $tanggal = $row['hari']; // 'hari' akan diubah menjadi tanggal
                $jam_mulai = $row['jam_mulai'];
                $jam_selesai = $row['jam_selesai'];
                $sudah_diperiksa = $row['sudah_diperiksa'];
            }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>

        <!-- Pilihan Dokter -->
        <div class="row mt-3">
            <label for="id_dokter" class="form-label fw-bold">Dokter</label>
            <select class="form-control" name="id_dokter" id="id_dokter" required>
                <option value="">-- Pilih Dokter --</option>
                <?php
                $dokter_query = mysqli_query($mysqli, "SELECT * FROM dokter");
                while ($dokter = mysqli_fetch_array($dokter_query)) {
                    $selected = ($dokter['id'] == $id_dokter) ? 'selected' : '';
                    echo "<option value='" . $dokter['id'] . "' $selected>" . $dokter['nama'] . "</option>";
                }
                ?>
            </select>
        </div>

        <!-- Tanggal (Kalender) -->
        <div class="row mt-3">
            <label for="hari" class="form-label fw-bold">Tanggal</label>
            <input type="date" class="form-control" name="hari" id="hari" value="<?php echo $tanggal ?>" required>
        </div>

        <!-- Jam Mulai -->
        <div class="row mt-3">
            <label for="jam_mulai" class="form-label fw-bold">Jam Mulai</label>
            <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" value="<?php echo $jam_mulai ?>" required>
        </div>

        <!-- Jam Selesai -->
        <div class="row mt-3">
            <label for="jam_selesai" class="form-label fw-bold">Jam Selesai</label>
            <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" value="<?php echo $jam_selesai ?>" required>
        </div>

        <!-- Sudah Diperiksa (Checkbox) -->
        <div class="row mt-3">
            <label for="sudah_diperiksa" class="form-label fw-bold">Sudah Diperiksa</label>
            <input type="checkbox" name="sudah_diperiksa" id="sudah_diperiksa" <?php echo $sudah_diperiksa ? 'checked' : '' ?>>
        </div>

        <!-- Tombol Simpan -->
        <div class="row d-flex mt-3">
            <button type="submit" class="btn btn-primary rounded-pill" style="width: 3cm;" name="simpan">Simpan</button>
        </div>
    </form>

    <table class="table table-hover my-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Dokter</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th>Sudah Diperiksa</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($mysqli, "SELECT periksa.*, dokter.nama AS nama_dokter 
                                             FROM periksa
                                             JOIN dokter ON periksa.id_dokter = dokter.id");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_dokter'] ?></td>
                    <td><?php echo $data['hari'] ?></td>
                    <td><?php echo $data['jam_mulai'] ?></td>
                    <td><?php echo $data['jam_selesai'] ?></td>
                    <td><?php echo $data['sudah_diperiksa'] ? 'Ya' : 'Tidak' ?></td>
                    <td>
                        <a href="index.php?page=periksa&id=<?php echo $data['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus.php?id=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
