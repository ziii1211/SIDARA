<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM data_lokasi WHERE id_lokasi='$id'");
$d = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama_lokasi = $_POST['nama_lokasi'];
    $rak = $_POST['rak'];
    $baris = $_POST['baris'];

    $query = "UPDATE data_lokasi SET 
              nama_lokasi='$nama_lokasi', 
              rak='$rak', 
              baris='$baris' 
              WHERE id_lokasi='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Diupdate'); window.location='data_lokasi.php';</script>";
    } else {
        echo "<script>alert('Gagal Update');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Lokasi</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Edit Data Lokasi</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Edit Lokasi</h3>
                    <a href="data_lokasi.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">Nama Ruangan / Lokasi</label>
                    <input type="text" name="nama_lokasi" class="form-input" value="<?= $d['nama_lokasi']; ?>" required>

                    <label class="form-label">Nomor Rak</label>
                    <input type="text" name="rak" class="form-input" value="<?= $d['rak']; ?>" required>

                    <label class="form-label">Nomor Baris</label>
                    <input type="text" name="baris" class="form-input" value="<?= $d['baris']; ?>" required>

                    <button type="submit" name="update" class="btn-add">Update Data</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>

</html>