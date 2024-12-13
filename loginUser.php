<?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION["login"]))
        {
            header("location: index.php");
            exit;
        }
        if(isset($_POST["login"]))
        {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $result = mysqli_query($mysqli, "SELECT * FROM user WHERE username = '$username'");
            // cek username
            if(mysqli_num_rows($result) === 1){
                // cek password
                $row = mysqli_fetch_assoc($result);
                if(password_verify($password, $row["password"])){
                    // set session
                    $_SESSION["login"]=true;
                    header("location: index.php");
                    exit;
                }
            }
            echo 
            "<script>
                alert('Username dan Password tidak cocok');
            </script>";
        }
?>
<body>
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
            <form class="border shadow p-3 border" style="width: 450px;"
            method="POST">
                <div class="mb-3">
                    <h1 class="text-center p3">Login</h1>
                    <label for="username" class="form-label">Username</label>
                    <input type="username" class="form-control" id="username" name="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary mb-3" name="login">Login</button>
                <p>Belum punya akun, <a href="index.php?page=registrasiUser">Daftar</a></p>
            </form>
        </div>
</body>