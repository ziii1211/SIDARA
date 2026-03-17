<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

if(isset($_POST['proses'])){
    $id_transaksi = $_POST['id_transaksi'];
    $id_arsip = $_POST['id_arsip'];
    $sanksi = $_POST['sanksi'];
    
    // Gunakan tanggal yang sudah divalidasi di form sebelumnya (Tanggal Staff klik atau Hari ini)
    $tanggal_kembali = $_POST['tanggal_kembali_fix'];

    if($sanksi == "-") {
        $sanksi_sql = "NULL";
    } else {
        $sanksi_sql = "'$sanksi'";
    }

    $query = "UPDATE transaksi_peminjaman SET 
              tanggal_kembali='$tanggal_kembali', 
              status='Kembali',
              sanksi=$sanksi_sql
              WHERE id_transaksi='$id_transaksi'";

    $update_transaksi = mysqli_query($conn, $query);

    if($update_transaksi){
        mysqli_query($conn, "UPDATE data_arsip SET status='Ada' WHERE id_arsip='$id_arsip'");
        echo "<script>alert('Pengembalian Dikonfirmasi & Sanksi Disimpan'); window.location='pengembalian.php';</script>";
    } else {
        echo "<script>alert('Gagal Memproses'); window.location='pengembalian.php';</script>";
    }
}
?>