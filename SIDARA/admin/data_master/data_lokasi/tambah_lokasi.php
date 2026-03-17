<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama_lokasi = $_POST['nama_lokasi'];
    $rak = $_POST['rak'];
    $baris = $_POST['baris'];

    $query = "INSERT INTO data_lokasi VALUES (NULL, '$nama_lokasi', '$rak', '$baris')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='data_lokasi.php';</script>";
    } else {
        echo "<script>alert('Gagal Menyimpan');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Lokasi</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Tambah Lokasi Baru</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Input Lokasi</h3>
                    <a href="data_lokasi.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">Nama Ruangan / Lokasi</label>
                    <input type="text" name="nama_lokasi" class="form-input" required placeholder="Contoh: Ruang Arsip Pidum">

                    <label class="form-label">Nomor Rak</label>
                    <input type="text" name="rak" class="form-input" required placeholder="Contoh: A-01">

                    <label class="form-label">Nomor Baris</label>
                    <input type="text" name="baris" class="form-input" required placeholder="Contoh: 2">

                    <button type="submit" name="simpan" class="btn-add">Simpan Data</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>

</html>