<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

$id = $_GET['id'];

// Mengambil nama file untuk dihapus dari folder uploads
$cek = mysqli_query($conn, "SELECT file_arsip FROM data_arsip WHERE id_arsip='$id'");
$data = mysqli_fetch_assoc($cek);
$file_lama = $data['file_arsip'];

try {
    $query = "DELETE FROM data_arsip WHERE id_arsip='$id'";
    $result = mysqli_query($conn, $query);

    if($result){
        // Hapus file fisik jika ada
        if($file_lama != "" && file_exists("../../../../uploads/".$file_lama)){
            unlink("../../../../uploads/".$file_lama);
        }
        echo "<script>alert('Data Berhasil Dihapus'); window.location='data_arsip.php';</script>";
    }
} catch (mysqli_sql_exception $e) {
    // Menangkap error jika data sedang digunakan di tabel transaksi
    echo "<script>alert('Gagal Menghapus! Data Arsip ini masih tercatat di Riwayat Peminjaman/Transaksi. Hapus dulu data transaksinya jika ingin menghapus arsip ini.'); window.location='data_arsip.php';</script>";
}
?>