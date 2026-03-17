<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama_kategori = $_POST['nama_kategori'];

    $query = "INSERT INTO kategori_perkara VALUES (NULL, '$nama_kategori')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='kategori_perkara.php';</script>";
    } else {
        echo "<script>alert('Gagal Menyimpan');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Tambah Kategori Baru</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Input Kategori</h3>
                    <a href="kategori_perkara.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">Nama Kategori Perkara</label>
                    <input type="text" name="nama_kategori" class="form-input" required placeholder="Contoh: Tindak Pidana Umum">

                    <button type="submit" name="simpan" class="btn-add">Simpan Data</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>

</html>