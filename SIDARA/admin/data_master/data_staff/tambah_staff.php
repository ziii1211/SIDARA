<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_lengkap'];
    $nip = $_POST['nip'];
    $divisi = $_POST['divisi'];
    $username = $_POST['nama_pengguna'];
    $password = md5($_POST['kata_sandi']);
    
    $cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengguna WHERE nama_pengguna='$username'"));
    
    if($cek > 0){
        echo "<script>alert('Username sudah digunakan! Ganti yang lain.');</script>";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO pengguna 
            (nama_pengguna, kata_sandi, nama_lengkap, peran, nip, divisi)
            VALUES ('$username', '$password', '$nama', 'staff', '$nip', '$divisi')");
        
        if($insert){
            echo "<script>alert('Akun Staff Berhasil Dibuat'); window.location='data_staff.php';</script>";
        } else {
            echo "<script>alert('Gagal Menyimpan');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Staff</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include '../../layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Tambah Staff Baru</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Registrasi Staff (Peminjam)</h3>
                    <a href="data_staff.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-input" required placeholder="Nama Lengkap beserta Gelar">
                    
                    <label class="form-label">NIP / NRP</label>
                    <input type="text" name="nip" class="form-input" required placeholder="Nomor Induk Pegawai">
                    
                    <label class="form-label">Bidang / Divisi</label>
                    <select name="divisi" class="form-input" required>
                        <option value="">-- Pilih Bidang --</option>
                        <option value="Bidang Tindak Pidana Umum">Bidang Tindak Pidana Umum</option>
                        <option value="Bidang Tindak Pidana Khusus">Bidang Tindak Pidana Khusus</option>
                        <option value="Bidang Perdata dan Tata Usaha Negara">Bidang Perdata dan Tata Usaha Negara</option>
                    </select>

                    <label class="form-label">Username (Untuk Login)</label>
                    <input type="text" name="nama_pengguna" class="form-input" required placeholder="Buat username unik">

                    <label class="form-label">Password</label>
                    <input type="password" name="kata_sandi" class="form-input" required placeholder="Buat password">

                    <button type="submit" name="simpan" class="btn-add">Buat Akun Staff</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>
</html>