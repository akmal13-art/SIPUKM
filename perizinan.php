<?php
session_start();
include "config/koneksi.php";

// Proteksi halaman: Khusus Admin
if(!isset($_SESSION['id']) || $_SESSION['status'] != 'admin') {
    header("Location:index.php");
    exit;
}

$id_surat = $_GET['id'];
$surat = $conn->query("SELECT s.*, u.nama, j.nama_surat FROM surat s 
                       JOIN users u ON s.id_user = u.id 
                       JOIN jenis_surat j ON s.id_jenis_surat = j.id
                       WHERE s.id=$id_surat")->fetch_assoc();

if(isset($_POST['submit'])){
    $status = $_POST['status'];
    $keterangan_admin = $conn->real_escape_string($_POST['keterangan_admin']);
    
    $conn->query("UPDATE surat SET status='$status', keterangan_admin='$keterangan_admin' WHERE id=$id_surat");
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Perizinan - SIPUKM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <h2>SIPUKM</h2>
        <nav>
            <a href="dashboard.php" class="active"><i class="fa fa-home"></i> Dashboard</a>
            <a href="riwayat.php"><i class="fa fa-history"></i> Riwayat</a>
            <a href="profil.php"><i class="fa fa-user"></i> Profil</a>
            <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="content">
        <h1>Proses Perizinan Surat</h1>
        <p>Tinjau detail pengajuan di bawah ini sebelum memberikan keputusan.</p>

        <div class="card-process">
            <div class="info-section">
                <div class="info-item">
                    <label>Nama Pengaju</label>
                    <p><strong><?= $surat['nama'] ?></strong></p>
                </div>
                <div class="info-item">
                    <label>Jenis Surat</label>
                    <p><?= $surat['nama_surat'] ?></p>
                </div>
                <div class="info-item">
                    <label>Keterangan User</label>
                    <p class="user-note">"<?= $surat['keterangan'] ?>"</p>
                </div>
            </div>

            <hr>

            <form method="POST" class="form-decision">
                <div class="form-group">
                    <label for="status"><i class="fa fa- gavel"></i> Keputusan Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="approved" class="text-success">✅ Setujui (Approve)</option>
                        <option value="rejected" class="text-danger">❌ Tolak (Reject)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="keterangan_admin"><i class="fa fa-comment-dots"></i> Catatan Admin (Opsional)</label>
                    <textarea name="keterangan_admin" id="keterangan_admin" class="form-control" rows="4" placeholder="Berikan alasan jika ditolak atau catatan tambahan jika disetujui..."></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" class="button btn-process">
                        <i class="fa fa-save"></i> Simpan Keputusan
                    </button>
                    <a href="dashboard.php" class="button btn-cancel">Kembali</a>
                </div>
            </form>
        </div>
    </main>
</div>

</body>
</html>