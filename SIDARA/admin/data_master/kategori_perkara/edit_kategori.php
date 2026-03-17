<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM kategori_perkara WHERE id_kategori='$id'");
$d = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama_kategori = $_POST['nama_kategori'];

    $query = "UPDATE kategori_perkara SET nama_kategori='$nama_kategori' WHERE id_kategori='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Diupdate'); window.location='kategori_perkara.php';</script>";
    } else {
        echo "<script>alert('Gagal Update');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Edit Data Kategori</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Edit Kategori</h3>
                    <a href="kategori_perkara.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">Nama Kategori Perkara</label>
                    <input type="text" name="nama_kategori" class="form-input" value="<?= $d['nama_kategori']; ?>" required>

                    <button type="submit" name="update" class="btn-add">Update Data</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>

</html>