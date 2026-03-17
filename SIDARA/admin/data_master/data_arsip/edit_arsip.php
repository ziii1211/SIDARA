<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM data_arsip WHERE id_arsip='$id'");
$d = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $no_perkara = $_POST['no_perkara'];
    $nama_terdakwa = $_POST['nama_terdakwa'];
    $id_kategori = $_POST['id_kategori'];
    $id_jaksa = $_POST['id_jaksa'];
    $id_lokasi = $_POST['id_lokasi'];

    $filename = $_FILES['file_arsip']['name'];
    $rand = rand();

    if ($filename != "") {
        $xx = $rand . '_' . $filename;
        move_uploaded_file($_FILES['file_arsip']['tmp_name'], '../../../uploads/' . $xx);

        $query = "UPDATE data_arsip SET 
                  no_perkara='$no_perkara', 
                  nama_terdakwa='$nama_terdakwa', 
                  id_kategori='$id_kategori', 
                  id_jaksa='$id_jaksa', 
                  id_lokasi='$id_lokasi',
                  file_arsip='$xx'
                  WHERE id_arsip='$id'";
    } else {
        $query = "UPDATE data_arsip SET 
                  no_perkara='$no_perkara', 
                  nama_terdakwa='$nama_terdakwa', 
                  id_kategori='$id_kategori', 
                  id_jaksa='$id_jaksa', 
                  id_lokasi='$id_lokasi' 
                  WHERE id_arsip='$id'";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Diupdate'); window.location='data_arsip.php';</script>";
    } else {
        echo "<script>alert('Gagal Update');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Edit Arsip</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Edit Data Arsip</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Edit Arsip</h3>
                    <a href="data_arsip.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <label class="form-label">No. Perkara</label>
                    <input type="text" name="no_perkara" class="form-input" value="<?= $d['no_perkara']; ?>" required>

                    <label class="form-label">Nama Terdakwa</label>
                    <input type="text" name="nama_terdakwa" class="form-input" value="<?= $d['nama_terdakwa']; ?>" required>

                    <label class="form-label">Kategori Perkara</label>
                    <select name="id_kategori" class="form-input" required>
                        <?php
                        $kat = mysqli_query($conn, "SELECT * FROM kategori_perkara");
                        while ($k = mysqli_fetch_array($kat)) {
                            $selected = ($k['id_kategori'] == $d['id_kategori']) ? "selected" : "";
                            echo "<option value='$k[id_kategori]' $selected>$k[nama_kategori]</option>";
                        }
                        ?>
                    </select>

                    <label class="form-label">Jaksa Penuntut</label>
                    <select name="id_jaksa" class="form-input" required>
                        <?php
                        $jak = mysqli_query($conn, "SELECT * FROM data_jaksa");
                        while ($j = mysqli_fetch_array($jak)) {
                            $selected = ($j['id_jaksa'] == $d['id_jaksa']) ? "selected" : "";
                            echo "<option value='$j[id_jaksa]' $selected>$j[nama_jaksa]</option>";
                        }
                        ?>
                    </select>

                    <label class="form-label">Lokasi Penyimpanan</label>
                    <select name="id_lokasi" class="form-input" required>
                        <?php
                        $lok = mysqli_query($conn, "SELECT * FROM data_lokasi");
                        while ($l = mysqli_fetch_array($lok)) {
                            $selected = ($l['id_lokasi'] == $d['id_lokasi']) ? "selected" : "";
                            echo "<option value='$l[id_lokasi]' $selected>$l[nama_lokasi] - Rak $l[rak]</option>";
                        }
                        ?>
                    </select>

                    <label class="form-label">Update File (Biarkan kosong jika tidak diubah)</label>
                    <input type="file" name="file_arsip" class="form-input">
                    <?php if ($d['file_arsip'] != "") { ?>
                        <small style="color:#666;">File saat ini: <a href="/sidara/uploads/<?= $d['file_arsip']; ?>" target="_blank"><?= $d['file_arsip']; ?></a></small>
                    <?php } ?>

                    <button type="submit" name="update" class="btn-add" style="margin-top:10px;">Update Data</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>

</html>