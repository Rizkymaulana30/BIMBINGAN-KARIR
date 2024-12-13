<?php 
$databaseHost = 'localhost';
$databaseUsername = 'root';
$databasePassword = '';
$databaseName = 'poliklinik-new';

$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

function registrasi($data){
    global $mysqli;
    // fungsi strtolower adalah megubah menjadi huruf kecil semua
    //  fungsi striplashes menghilankan tanda gari miirng
    $username = strtolower(stripslashes($data['username']));
    // supaya juga user memasukan tanda petik dapat dengan aman dimasukan database
    $password = mysqli_real_escape_string($mysqli,$data["password"]);
    $password2 = mysqli_real_escape_string($mysqli,$data["password2"]);
    // cek ketersediaan username
    // cek sudah ada atau belum
    $result = mysqli_query($mysqli, "SELECT username FROM user WHERE username = '$username'");

    if(mysqli_fetch_assoc($result)){
        echo 
        "<script>
            alert('username sudah terdaftar');
        </script>";
        return false;
    }
    
    // cek kesamaan pssword 
    // cek konfirmasi password
    if($password !== $password2){
        echo 
        "<script>
            alert('konfirmasi password tidak sesuai');
        </script>";
        return false;
    }
    // yang terahkir enkripsi password
    // sebel8um menambahkan pasword harus dienkripsi
    // md5 = hanya mengacak pswword jangan pernah gunakan itu
    // hash = yang lebih aman mengacaknya
    $password = password_hash($password, PASSWORD_DEFAULT);
    // var_dump($password);die;

    // tambahkan user baru ke database
    mysqli_query($mysqli, "INSERT INTO user VALUES('','$username','$password')");

    // untuk menamnahkan affected row jika berhasil 1 jika gagal -1
    return mysqli_affected_rows($mysqli);
}