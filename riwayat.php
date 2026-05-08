<?php
session_start();
include "config/koneksi.php";
if(!isset($_SESSION['id'])) header("Location:index.php");

if($_SESSION['status'] == 'admin'){
    $query = "SELECT s.id, u.nama, j.nama_surat, s.keterangan, s.tgl_pengajuan, s.status, s.keterangan_admin 
              FROM surat s 
              JOIN users u ON s.id_user = u.id 
              JOIN jenis_surat j ON s.id_jenis_surat = j.id
              ORDER BY s.tgl_pengajuan DESC";
} else {
    $id_user = $_SESSION['id'];
    $query = "SELECT s.id, j.nama_surat, s.keterangan, s.tgl_pengajuan, s.status, s.keterangan_admin 
              FROM surat s 
              JOIN jenis_surat j ON s.id_jenis_surat = j.id
              WHERE s.id_user = $id_user
              ORDER BY s.tgl_pengajuan DESC";
}
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Surat - SIPUKM</title>
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
            <a href="riwayat.php" class="active"><i class="fa fa-history"></i> Riwayat</a>
            <a href="profil.php"><i class="fa fa-user"></i> Profil</a>
            <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="content">
        <div class="header-action">
            <h1>Riwayat Pengajuan Surat</h1>
        </div>

        <table class="modern-table">
            <thead>
                <tr>
                    <th>No</th>
                    <?php if($_SESSION['status']=='admin') echo "<th>Nama Pengaju</th>"; ?>
                    <th>Jenis Surat</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = $result->fetch_assoc()): 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <?php if($_SESSION['status']=='admin') echo "<td><strong>".$row['nama']."</strong></td>"; ?>
                    <td><?= $row['nama_surat'] ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td><?= date('d M Y', strtotime($row['tgl_pengajuan'])) ?></td>
                    <td>
                        <span class="badge status-<?= $row['status'] ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <small><em><?= $row['keterangan_admin'] ? $row['keterangan_admin'] : '-' ?></em></small>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if($result->num_rows == 0): ?>
                <tr>
                    <td colspan="<?= ($_SESSION['status']=='admin') ? '7' : '6' ?>" style="text-align: center;">Belum ada riwayat pengajuan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>

</body>
</html>