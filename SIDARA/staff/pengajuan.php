<?php
session_start();
include '../config/koneksi.php';
if ($_SESSION['peran'] != 'staff') { header("Location: ../index.php"); exit; }

if (isset($_POST['ajukan'])) {
    $id_arsip = $_POST['id_arsip'];
    
    // Ambil data diri dari Session Login Staff
    $id_pengguna = $_SESSION['id_pengguna'];
    $nama_peminjam = $_SESSION['nama_lengkap'];
    $nip = $_SESSION['nip'];
    $divisi = $_SESSION['divisi'];
    
    $tanggal_pinjam = date('Y-m-d');
    $keterangan = $_POST['keterangan'];
    
    // Insert dengan status 'Menunggu'
    $insert = mysqli_query($conn, "INSERT INTO transaksi_peminjaman 
        (id_arsip, id_pengguna, nip_peminjam, nama_peminjam, divisi, tanggal_pinjam, keterangan, status)
        VALUES ('$id_arsip', '$id_pengguna', '$nip', '$nama_peminjam', '$divisi', '$tanggal_pinjam', '$keterangan', 'Menunggu')");
    
    if($insert){
        echo "<script>alert('Pengajuan Berhasil! Status: Menunggu Konfirmasi Admin.'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal Mengajukan');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Ajukan Peminjaman</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include 'layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Ajukan Peminjaman</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Pengajuan Arsip</h3>
                    <a href="dashboard.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">Pilih Arsip yang Tersedia</label>
                    <select name="id_arsip" class="form-input" required>
                        <option value="">-- Pilih No Perkara --</option>
                        <?php
                        $arsip = mysqli_query($conn, "SELECT * FROM data_arsip WHERE status='Ada'");
                        while($a = mysqli_fetch_array($arsip)){
                            echo "<option value='$a[id_arsip]'>$a[no_perkara] - Terdakwa: $a[nama_terdakwa]</option>";
                        }
                        ?>
                    </select>

                    <label class="form-label">Peminjam</label>
                    <input type="text" class="form-input" value="<?= $_SESSION['nama_lengkap']; ?> (<?= $_SESSION['divisi']; ?>)" readonly style="background-color: #e9ecef;">

                    <label class="form-label">Keterangan / Keperluan</label>
                    <textarea name="keterangan" class="form-input" rows="3" required placeholder="Contoh: Untuk menyusun memori banding"></textarea>

                    <button type="submit" name="ajukan" class="btn-add">Ajukan Sekarang</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>
</html>