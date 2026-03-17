<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM data_jaksa WHERE id_jaksa='$id'");
$d = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nip = $_POST['nip'];
    $nama_jaksa = $_POST['nama_jaksa'];
    $jabatan = $_POST['jabatan'];

    $query = "UPDATE data_jaksa SET 
              nip='$nip', 
              nama_jaksa='$nama_jaksa', 
              jabatan='$jabatan' 
              WHERE id_jaksa='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Diupdate'); window.location='data_jaksa.php';</script>";
    } else {
        echo "<script>alert('Gagal Update');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Jaksa</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Edit Data Jaksa</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Edit Jaksa</h3>
                    <a href="data_jaksa.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-input" value="<?= $d['nip']; ?>" required>

                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_jaksa" class="form-input" value="<?= $d['nama_jaksa']; ?>" required>

                    <label class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-input" value="<?= $d['jabatan']; ?>" required>

                    <button type="submit" name="update" class="btn-add">Update Data</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>

</html>