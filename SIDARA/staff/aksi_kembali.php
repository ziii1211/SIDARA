<?php
session_start();
include '../config/koneksi.php';
if ($_SESSION['peran'] != 'staff') { header("Location: ../index.php"); exit; }

if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $tanggal_kembali = date('Y-m-d'); 

    $query = "UPDATE transaksi_peminjaman SET 
              status='Menunggu Kembali', 
              tanggal_kembali='$tanggal_kembali' 
              WHERE id_transaksi='$id_transaksi'";
              
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Pengembalian Berhasil Diajukan! Menunggu verifikasi Admin untuk pengecekan sanksi.'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal memproses.'); window.location='dashboard.php';</script>";
    }
}
?>