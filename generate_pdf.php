<?php
require('fpdf/fpdf.php');
include 'config/koneksi.php';

if(!isset($_GET['id'])) {
    echo "ID surat tidak diberikan!";
    exit;
}

$id_surat = intval($_GET['id']);

// Ambil data surat
$result = $conn->query("SELECT s.id, u.nama, j.nama_surat, s.keterangan, s.tgl_pengajuan, s.status, s.keterangan_admin
                        FROM surat s 
                        JOIN users u ON s.id_user = u.id 
                        JOIN jenis_surat j ON s.id_jenis_surat = j.id
                        WHERE s.id = $id_surat");

if($result->num_rows == 0){
    echo "Surat tidak ditemukan!";
    exit;
}

$row = $result->fetch_assoc();

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

// Judul
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Surat SIPUKM',0,1,'C');
$pdf->Ln(5);

// Data Surat
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,10,'ID Surat',0,0);
$pdf->Cell(0,10,$row['id'],0,1);
$pdf->Cell(50,10,'Nama Pengaju',0,0);
$pdf->Cell(0,10,$row['nama'],0,1);
$pdf->Cell(50,10,'Jenis Surat',0,0);
$pdf->Cell(0,10,$row['nama_surat'],0,1);
$pdf->Cell(50,10,'Tanggal Pengajuan',0,0);
$pdf->Cell(0,10,$row['tgl_pengajuan'],0,1);
$pdf->Cell(50,10,'Status',0,0);
$pdf->Cell(0,10,$row['status'],0,1);
$pdf->Cell(50,10,'Keterangan User',0,0);
$pdf->MultiCell(0,10,$row['keterangan']);
$pdf->Cell(50,10,'Keterangan Admin',0,0);
$pdf->MultiCell(0,10,$row['keterangan_admin']);

// Output
$pdf->Output('I', 'Surat_'.$row['id'].'.pdf');
?>
