<?php
session_start();
include "config/koneksi.php";

// Jika sudah login, langsung lempar ke dashboard
if(isset($_SESSION['id'])) {
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['login'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        // Menggunakan password_verify (pastikan saat register menggunakan password_hash)
        if(password_verify($password, $user['password'])){
            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['status'] = $user['status'];
            header("Location: dashboard.php"); 
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPUKM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">

<div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <i class="fa fa-envelope-open-text fa-3x"></i>
            <h2>SIPUKM</h2>
            <p>Sistem Informasi Persuratan UKM</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateLoginForm()">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="Masukkan username" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                </div>
            </div>

            <button type="submit" name="login" class="btn-login">
                Login <i class="fa fa-sign-in-alt"></i>
            </button>
        </form>

        <div class="login-footer">
            <p>Belum punya akun? <a href="register.php">Daftar Sekarang</a></p>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>