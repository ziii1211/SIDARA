<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

$id = $_GET['id'];

try {
    $query = "DELETE FROM data_jaksa WHERE id_jaksa='$id'";
    $result = mysqli_query($conn, $query);

    if($result){
        echo "<script>alert('Data Jaksa Berhasil Dihapus'); window.location='data_jaksa.php';</script>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<script>alert('Gagal Menghapus! Data Jaksa ini masih tercantum dalam Arsip Perkara. Hapus atau edit arsip yang terkait terlebih dahulu.'); window.location='data_jaksa.php';</script>";
}
?>