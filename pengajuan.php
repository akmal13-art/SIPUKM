<?php
session_start();
include "config/koneksi.php";

// Proteksi halaman: hanya untuk user
if(!isset($_SESSION['id']) || $_SESSION['status'] != 'user') {
    header("Location:index.php");
    exit;
}

if(isset($_POST['ajukan'])){
    $id_user = $_SESSION['id'];
    $id_jenis = $_POST['id_jenis_surat'];
    $keterangan = $conn->real_escape_string($_POST['keterangan']); // Keamanan tambahan
    $tgl = date('Y-m-d');

    $sql = "INSERT INTO surat (id_user, id_jenis_surat, keterangan, tgl_pengajuan, status) 
            VALUES ($id_user, $id_jenis, '$keterangan', '$tgl', 'pending')";
            
    if($conn->query($sql)){
        header("Location: dashboard.php?pesan=berhasil");
    } else {
        $error = "Gagal mengajukan surat.";
    }
}

$jenis = $conn->query("SELECT * FROM jenis_surat");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Surat - SIPUKM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <aside class="sidebar">
        <h2>SIPUKM</h2>
        <nav>
            <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
            <a href="pengajuan.php" class="active"><i class="fa fa-plus"></i> Ajukan Surat</a>
            <a href="riwayat.php"><i class="fa fa-history"></i> Riwayat</a>
            <a href="profil.php"><i class="fa fa-user"></i> Profil</a>
            <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </nav>
    </aside>

    <main class="content">
        <h1>Form Pengajuan Surat</h1>
        <p>Silakan isi detail pengajuan surat di bawah ini.</p>

        <div class="card-form">
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" onsubmit="return validatePengajuanForm()">
                <div class="form-group">
                    <label for="id_jenis_surat"><i class="fa fa-envelope"></i> Jenis Surat</label>
                    <select name="id_jenis_surat" id="id_jenis_surat" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Jenis Surat --</option>
                        <?php while($row = $jenis->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>"><?= $row['nama_surat'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="keterangan"><i class="fa fa-pencil-alt"></i> Keterangan / Alasan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="5" placeholder="Tuliskan keterangan lebih lanjut mengenai pengajuan Anda..." required></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" name="ajukan" class="button btn-submit">
                        <i class="fa fa-paper-plane"></i> Kirim Pengajuan
                    </button>
                    <a href="dashboard.php" class="button btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </main>
</div>

<script src="js/script.js"></script>
</body>
</html>