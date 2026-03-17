<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

if (isset($_POST['simpan'])) {
    $id_arsip = $_POST['id_arsip'];
    $id_pengguna = $_POST['id_pengguna']; // ID Staff yang dipilih
    $keterangan = $_POST['keterangan'];
    $tanggal_pinjam = date('Y-m-d');
    
    // 1. Ambil Data Detail Staff dari Database berdasarkan ID yang dipilih
    $cari_staff = mysqli_query($conn, "SELECT * FROM pengguna WHERE id_pengguna='$id_pengguna'");
    $data_staff = mysqli_fetch_assoc($cari_staff);

    $nama_peminjam = $data_staff['nama_lengkap'];
    $nip = $data_staff['nip'];
    $divisi = $data_staff['divisi'];
    
    // 2. Set Batas Waktu (H+3 Bulan)
    $batas_kembali = date('Y-m-d', strtotime('+3 months', strtotime($tanggal_pinjam)));

    // 3. Simpan ke Transaksi
    // Status langsung 'Dipinjam' karena Admin yang input (dianggap sudah disetujui/diambil)
    $insert = mysqli_query($conn, "INSERT INTO transaksi_peminjaman 
        (id_arsip, id_pengguna, nip_peminjam, nama_peminjam, divisi, tanggal_pinjam, batas_kembali, keterangan, status)
        VALUES ('$id_arsip', '$id_pengguna', '$nip', '$nama_peminjam', '$divisi', '$tanggal_pinjam', '$batas_kembali', '$keterangan', 'Dipinjam')");
    
    if($insert){
        // Update Status Arsip jadi Dipinjam
        mysqli_query($conn, "UPDATE data_arsip SET status='Dipinjam' WHERE id_arsip='$id_arsip'");
        echo "<script>alert('Peminjaman Berhasil Disimpan'); window.location='peminjaman.php';</script>";
    } else {
        echo "<script>alert('Gagal Menyimpan');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Peminjaman Manual</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include '../../layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Input Peminjaman (Admin)</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Form Peminjaman Arsip</h3>
                    <a href="peminjaman.php" class="btn-add" style="background:#6c757d;">Kembali</a>
                </div>
                <form method="POST">
                    <label class="form-label">Pilih Arsip (Hanya yang Tersedia)</label>
                    <select name="id_arsip" class="form-input" required>
                        <option value="">-- Pilih No Perkara --</option>
                        <?php
                        $arsip = mysqli_query($conn, "SELECT * FROM data_arsip WHERE status='Ada'");
                        while($a = mysqli_fetch_array($arsip)){
                            echo "<option value='$a[id_arsip]'>$a[no_perkara] - $a[nama_terdakwa]</option>";
                        }
                        ?>
                    </select>

                    <label class="form-label">Pilih Staff Peminjam</label>
                    <select name="id_pengguna" class="form-input" required>
                        <option value="">-- Pilih Nama Staff --</option>
                        <?php
                        // Ambil hanya user dengan role 'staff'
                        $staff = mysqli_query($conn, "SELECT * FROM pengguna WHERE peran='staff' ORDER BY nama_lengkap ASC");
                        while($s = mysqli_fetch_array($staff)){
                            echo "<option value='$s[id_pengguna]'>$s[nama_lengkap] (Divisi: $s[divisi])</option>";
                        }
                        ?>
                    </select>
                    <small style="color: #666; margin-bottom:15px; display:block;">*NIP dan Divisi akan terisi otomatis sesuai data Staff.</small>

                    <label class="form-label">Keterangan / Keperluan</label>
                    <textarea name="keterangan" class="form-input" rows="3" placeholder="Contoh: Untuk keperluan sidang banding"></textarea>

                    <div style="background: #e9ecef; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                        <small style="color: #d63384; font-weight: bold;">*Catatan: Batas waktu otomatis diatur 3 bulan dari hari ini.</small>
                    </div>

                    <button type="submit" name="simpan" class="btn-add">Simpan Transaksi</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>
</html>