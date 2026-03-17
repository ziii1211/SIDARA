<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

$id = $_GET['id'];

try {
    $query = "DELETE FROM pengguna WHERE id_pengguna='$id'";
    $result = mysqli_query($conn, $query);

    if($result){
        echo "<script>alert('Akun Staff Berhasil Dihapus'); window.location='data_staff.php';</script>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<script>alert('Gagal Menghapus! Akun Staff ini memiliki riwayat transaksi arsip. Data transaksi harus dihapus terlebih dahulu.'); window.location='data_staff.php';</script>";
}
?>