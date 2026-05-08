<?php
session_start();
include "config/koneksi.php";
if(!isset($_SESSION['id'])) header("Location:index.php");

$id = $_SESSION['id'];
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - SIPUKM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <h2>SIPUKM</h2>
        <nav>
            <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
            <?php if($_SESSION['status']=='user'): ?>
            <a href="pengajuan.php"><i class="fa fa-plus"></i> Ajukan Surat</a>
            <?php endif; ?>
            <a href="riwayat.php"><i class="fa fa-history"></i> Riwayat</a>
            <a href="profil.php" class="active"><i class="fa fa-user"></i> Profil</a>
            <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="content">
        <h1>Profil Pengguna</h1>
        
        <div class="profile-card">
            <div class="profile-header">
                <i class="fa fa-user-circle fa-5x"></i>
                <h3><?= $user['nama'] ?></h3>
                <span class="badge status-<?= $user['status'] ?>"><?= ucfirst($user['status']) ?></span>
            </div>

            <hr>

            <div class="profile-details">
                <div class="detail-group">
                    <label><i class="fa fa-id-badge"></i> ID Pengguna</label>
                    <p><?= $user['id'] ?></p>
                </div>
                <div class="detail-group">
                    <label><i class="fa fa-at"></i> Username</label>
                    <p><?= $user['username'] ?></p>
                </div>
                <div class="detail-group">
                    <label><i class="fa fa-info-circle"></i> Hak Akses</label>
                    <p><?= ucfirst($user['status']) ?></p>
                </div>
            </div>

            <div class="profile-actions">
                <a href="dashboard.php" class="button"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
        </div>
    </main>
</div>

</body>
</html>