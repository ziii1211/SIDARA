<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

$id = $_GET['id'];
$d = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengguna WHERE id_pengguna='$id'"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama_lengkap'];
    $nip = $_POST['nip'];
    $divisi = $_POST['divisi'];
    $username = $_POST['nama_pengguna'];
    $password_baru = $_POST['kata_sandi'];
    
    if($password_baru != ""){
        $pass_md5 = md5($password_baru);
        $query = "UPDATE pengguna SET 
                  nama_lengkap='$nama', 
                  nip='$nip', 
                  divisi='$divisi',
                  nama_pengguna='$username',
                  kata_sandi='$pass_md5'
                  WHERE id_pengguna='$id'";
    } else {
        $query = "UPDATE pengguna SET 
                  nama_lengkap='$nama', 
                  nip='$nip', 
                  divisi='$divisi',
                  nama_pengguna='$username'
                  WHERE id_pengguna='$id'";
    }
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Data Staff Berhasil Diupdate'); window.location='data_staff.php';</script>";
    } else {
        echo "<script>alert('Gagal Update');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Staff</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include '../../layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Edit Data Staff</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Edit Staff</h3>
                    <a href="data_staff.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-input" value="<?= $d['nama_lengkap']; ?>" required>
                    
                    <label class="form-label">NIP / NRP</label>
                    <input type="text" name="nip" class="form-input" value="<?= $d['nip']; ?>" required>
                    
                    <label class="form-label">Bidang / Divisi</label>
                    <select name="divisi" class="form-input" required>
                        <option value="">-- Pilih Bidang --</option>
                        <option value="Bidang Tindak Pidana Umum" <?= ($d['divisi'] == 'Bidang Tindak Pidana Umum') ? 'selected' : ''; ?>>Bidang Tindak Pidana Umum</option>
                        <option value="Bidang Tindak Pidana Khusus" <?= ($d['divisi'] == 'Bidang Tindak Pidana Khusus') ? 'selected' : ''; ?>>Bidang Tindak Pidana Khusus</option>
                        <option value="Bidang Perdata dan Tata Usaha Negara" <?= ($d['divisi'] == 'Bidang Perdata dan Tata Usaha Negara') ? 'selected' : ''; ?>>Bidang Perdata dan Tata Usaha Negara</option>
                    </select>

                    <label class="form-label">Username</label>
                    <input type="text" name="nama_pengguna" class="form-input" value="<?= $d['nama_pengguna']; ?>" required>

                    <label class="form-label">Password Baru (Biarkan kosong jika tidak ingin mengganti)</label>
                    <input type="password" name="kata_sandi" class="form-input" placeholder="Isi jika ingin reset password">

                    <button type="submit" name="update" class="btn-add">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>
</html>