<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $no_perkara = $_POST['no_perkara'];
    $nama_terdakwa = $_POST['nama_terdakwa'];
    $id_kategori = $_POST['id_kategori'];
    $id_jaksa = $_POST['id_jaksa'];
    $id_lokasi = $_POST['id_lokasi'];
    $tanggal = date('Y-m-d');

    // Logika Upload File
    $filename = $_FILES['file_arsip']['name'];

    if ($filename != "") {
        $rand = rand();
        $ekstensi =  array('png', 'jpg', 'jpeg', 'pdf');
        $ukuran = $_FILES['file_arsip']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Cek ekstensi (Opsional, matikan jika tidak perlu)
        if (!in_array($ext, $ekstensi)) {
            echo "<script>alert('Gagal! Format file harus PDF atau Gambar (JPG/PNG).'); window.location='tambah_arsip.php';</script>";
            exit;
        }

        $xx = $rand . '_' . $filename;
        // PERBAIKAN: Gunakan 3 titik (../../../) untuk kembali ke folder sidara
        $target_path = '../../../uploads/' . $xx;

        if (move_uploaded_file($_FILES['file_arsip']['tmp_name'], $target_path)) {
            // Jika upload sukses, simpan ke DB
            mysqli_query($conn, "INSERT INTO data_arsip VALUES (NULL, '$no_perkara', '$nama_terdakwa', '$id_kategori', '$id_jaksa', '$id_lokasi', '$tanggal', 'Ada', '$xx')");
            echo "<script>alert('Data & File Berhasil Disimpan'); window.location='data_arsip.php';</script>";
        } else {
            echo "<script>alert('Gagal Upload File! Pastikan folder uploads ada.');</script>";
        }
    } else {
        // Jika tidak ada file
        mysqli_query($conn, "INSERT INTO data_arsip VALUES (NULL, '$no_perkara', '$nama_terdakwa', '$id_kategori', '$id_jaksa', '$id_lokasi', '$tanggal', 'Ada', NULL)");
        echo "<script>alert('Data Berhasil Disimpan Tanpa File'); window.location='data_arsip.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Arsip</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Tambah Arsip Baru</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Input Arsip</h3>
                    <a href="data_arsip.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <label class="form-label">No. Perkara</label>
                    <input type="text" name="no_perkara" class="form-input" required placeholder="Contoh: PDM-123/BJM/2025">

                    <label class="form-label">Nama Terdakwa</label>
                    <input type="text" name="nama_terdakwa" class="form-input" required>

                    <label class="form-label">Kategori Perkara</label>
                    <select name="id_kategori" class="form-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        $kat = mysqli_query($conn, "SELECT * FROM kategori_perkara");
                        while ($k = mysqli_fetch_array($kat)) {
                            echo "<option value='$k[id_kategori]'>$k[nama_kategori]</option>";
                        }
                        ?>
                    </select>

                    <label class="form-label">Jaksa Penuntut</label>
                    <select name="id_jaksa" class="form-input" required>
                        <option value="">-- Pilih Jaksa --</option>
                        <?php
                        $jak = mysqli_query($conn, "SELECT * FROM data_jaksa");
                        while ($j = mysqli_fetch_array($jak)) {
                            echo "<option value='$j[id_jaksa]'>$j[nama_jaksa]</option>";
                        }
                        ?>
                    </select>

                    <label class="form-label">Lokasi Penyimpanan</label>
                    <select name="id_lokasi" class="form-input" required>
                        <option value="">-- Pilih Lokasi --</option>
                        <?php
                        $lok = mysqli_query($conn, "SELECT * FROM data_lokasi");
                        while ($l = mysqli_fetch_array($lok)) {
                            echo "<option value='$l[id_lokasi]'>$l[nama_lokasi] - Rak $l[rak]</option>";
                        }
                        ?>
                    </select>

                    <label class="form-label">Upload File (PDF/Gambar) - <i>Opsional</i></label>
                    <input type="file" name="file_arsip" class="form-input">

                    <button type="submit" name="simpan" class="btn-add">Simpan Data</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>

</html>