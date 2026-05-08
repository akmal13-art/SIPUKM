<?php
session_start();
include "config/koneksi.php";

if(isset($_POST['register'])){
    $nama = $conn->real_escape_string($_POST['nama']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $status = 'user';

    // Cek apakah username sudah ada
    $checkUser = $conn->query("SELECT username FROM users WHERE username='$username'");
    if($checkUser->num_rows > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        $sql = "INSERT INTO users (nama, username, password, status) VALUES ('$nama','$username','$password','$status')";
        if($conn->query($sql)) {
            header("Location: index.php?pesan=registrasi_berhasil"); 
            exit;
        } else {
            $error = "Terjadi kesalahan saat mendaftar.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - SIPUKM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page"> <div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <i class="fa fa-user-plus fa-3x"></i>
            <h2>Daftar Akun</h2>
            <p>Bergabung dengan SIPUKM sekarang</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateRegisterForm()">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <div class="input-group">
                    <i class="fa fa-id-card"></i>
                    <input type="text" name="nama" id="nama" placeholder="Masukkan nama lengkap" required>
                </div>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="Buat username" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Buat password" required>
                </div>
            </div>

            <button type="submit" name="register" class="btn-login">
                Daftar Sekarang <i class="fa fa-arrow-right"></i>
            </button>
        </form>

        <div class="login-footer">
            <p>Sudah punya akun? <a href="index.php">Masuk di sini</a></p>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
