<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

$id = $_GET['id'];

try {
    $query = "DELETE FROM data_lokasi WHERE id_lokasi='$id'";
    $result = mysqli_query($conn, $query);

    if($result){
        echo "<script>alert('Data Lokasi Berhasil Dihapus'); window.location='data_lokasi.php';</script>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<script>alert('Gagal Menghapus! Lokasi ini sedang digunakan oleh Arsip. Pastikan Rak/Lemari kosong dari arsip sebelum dihapus.'); window.location='data_lokasi.php';</script>";
}
?>