<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

$id_transaksi = $_GET['id'];
$id_arsip = $_GET['id_arsip'];

$tgl_pinjam_resmi = date('Y-m-d');
$batas_kembali = date('Y-m-d', strtotime('+3 months', strtotime($tgl_pinjam_resmi)));

$update_transaksi = mysqli_query($conn, "UPDATE transaksi_peminjaman SET 
    status='Dipinjam', 
    tanggal_pinjam='$tgl_pinjam_resmi',
    batas_kembali='$batas_kembali' 
    WHERE id_transaksi='$id_transaksi'");

$update_arsip = mysqli_query($conn, "UPDATE data_arsip SET status='Dipinjam' WHERE id_arsip='$id_arsip'");

if($update_transaksi && $update_arsip){
    echo "<script>alert('Peminjaman Disetujui! Arsip statusnya sekarang Dipinjam.'); window.location='peminjaman.php';</script>";
} else {
    echo "<script>alert('Gagal memproses persetujuan.'); window.location='peminjaman.php';</script>";
}
?>