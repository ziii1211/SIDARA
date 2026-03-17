<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nip = $_POST['nip'];
    $nama_jaksa = $_POST['nama_jaksa'];
    $jabatan = $_POST['jabatan'];

    $query = "INSERT INTO data_jaksa VALUES (NULL, '$nip', '$nama_jaksa', '$jabatan')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Disimpan'); window.location='data_jaksa.php';</script>";
    } else {
        echo "<script>alert('Gagal Menyimpan');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Jaksa</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Tambah Jaksa Baru</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Input Jaksa</h3>
                    <a href="data_jaksa.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-input" required placeholder="Contoh: 19850101 201001 1 001">

                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_jaksa" class="form-input" required placeholder="Contoh: Budi Santoso, S.H., M.H.">

                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-input" required placeholder="Contoh: Jaksa Pratama">

                    <button type="submit" name="simpan" class="btn-add">Simpan Data</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>

</html>