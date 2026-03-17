<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

$id = $_GET['id'];

try {
    $query = "DELETE FROM kategori_perkara WHERE id_kategori='$id'";
    $result = mysqli_query($conn, $query);

    if($result){
        echo "<script>alert('Kategori Berhasil Dihapus'); window.location='kategori_perkara.php';</script>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<script>alert('Gagal Menghapus! Kategori ini sedang digunakan oleh beberapa Arsip. Hapus atau pindahkan arsip dari kategori ini terlebih dahulu.'); window.location='kategori_perkara.php';</script>";
}
?>