<?php
    if(isset($_POST["register"])){
        if(registrasi($_POST) > 0){
            echo 
            "<script>
                alert('user berhasil ditambahkan');
                document.location='index.php?page=loginUser';
            </script>";
        }else{
            echo mysqli_error($mysqli);
        }
    }
?>

<body>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
            <form class="border shadow p-3 border" style="width: 450px;"
            action="" method="POST">
                <div class="mb-3">
                    <h1 class="text-center p3">Register</h1>
                    <label for="username" class="form-label">Username</label>
                    <input type="username" class="form-control" id="username" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="password2" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password2" name="password2">
                </div>
                
                <button type="submit" class="btn btn-primary mb-3" name="register">Register</button>
                <p>Sudah punya akun, <a href="index.php?page=loginUser">Login</a></p>
            </form>
        </div>
</body>