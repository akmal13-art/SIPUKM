<?php
session_start();
if(!isset($_SESSION['id'])) header("Location: index.php");
include "config/koneksi.php";

// Query sesuai role
if($_SESSION['status']=='admin'){
    $query = "SELECT s.id, u.nama, j.nama_surat, s.keterangan, s.tgl_pengajuan, s.status 
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
<title>Dashboard SIPUKM</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>SIPUKM</h2>
        <nav>
            <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
            <?php if($_SESSION['status']=='user'): ?>
            <a href="pengajuan.php"><i class="fa fa-plus"></i> Ajukan Surat</a>
            <?php endif; ?>
            <a href="riwayat.php"><i class="fa fa-history"></i> Riwayat</a>
            <a href="profil.php"><i class="fa fa-user"></i> Profil</a>
            <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="content">
        <h1>Dashboard - <?= ucfirst($_SESSION['status']) ?></h1>
        <table class="modern-table">
            <thead>
                <tr>
                    <?php if($_SESSION['status']=='admin') echo "<th>Nama Pengaju</th>"; ?>
                    <th>Jenis Surat</th>
                    <th>Keterangan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <?php if($_SESSION['status']=='admin') echo "<th>Aksi</th>"; ?>
                    <?php if($_SESSION['status']=='user') echo "<th>Cetak PDF</th>"; ?>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <?php if($_SESSION['status']=='admin') echo "<td>".$row['nama']."</td>"; ?>
                    <td><?= $row['nama_surat'] ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td><?= $row['tgl_pengajuan'] ?></td>
                    <td class="<?= 'status-'.$row['status'] ?>"><?= ucfirst($row['status']) ?></td>
                    
                    <?php if($_SESSION['status']=='admin'): ?>
                    <td><a href="perizinan.php?id=<?= $row['id'] ?>" class="button approve"><i class="fa fa-check"></i> Proses</a></td>
                    <?php endif; ?>
                    
                    <?php if($_SESSION['status']=='user'): ?>
                    <td>
                        <?php if($row['status'] == 'approved'): ?>
                            <a href="generate_pdf.php?id=<?= $row['id'] ?>" target="_blank" class="button pdf"><i class="fa fa-print"></i> Cetak PDF</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</div>

</body>
</html>
