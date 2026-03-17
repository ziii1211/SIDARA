<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }

$id = $_GET['id'];
$query = "SELECT * FROM transaksi_peminjaman 
          JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip 
          WHERE id_transaksi='$id'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $query));

// Tentukan Tanggal Pengembalian (Jika staff sudah klik 'Kembalikan', pakai tanggal itu)
if($data['status'] == 'Menunggu Kembali') {
    $tanggal_kembali_aktual = $data['tanggal_kembali'];
} else {
    $tanggal_kembali_aktual = date('Y-m-d');
}

// Cek Batas
if(!empty($data['batas_kembali'])){
    $batas = new DateTime($data['batas_kembali']);
} else {
    $batas = new DateTime(date('Y-m-d', strtotime('+3 months', strtotime($data['tanggal_pinjam']))));
}

$kembali = new DateTime($tanggal_kembali_aktual);
$is_late = ($kembali > $batas);
$selisih = $kembali->diff($batas)->days;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Konfirmasi Pengembalian</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include '../../layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Verifikasi Pengembalian</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Cek Kondisi & Input Sanksi</h3>
                    <a href="pengembalian.php" class="btn-add" style="background:#6c757d;">Batal</a>
                </div>
                
                <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <table style="width: 100%;">
                        <tr><td style="width: 150px;"><b>No Perkara</b></td><td>: <?= $data['no_perkara']; ?></td></tr>
                        <tr><td><b>Peminjam</b></td><td>: <?= $data['nama_peminjam']; ?></td></tr>
                        <tr><td><b>Batas Kembali</b></td><td>: <?= date('d-m-Y', strtotime($data['batas_kembali'])); ?></td></tr>
                        <tr>
                            <td><b>Dikembalikan Tgl</b></td>
                            <td>: <?= date('d-m-Y', strtotime($tanggal_kembali_aktual)); ?> 
                                <?= ($data['status'] == 'Menunggu Kembali') ? '(Diajukan Staff)' : '(Hari Ini)'; ?>
                            </td>
                        </tr>
                    </table>
                    
                    <div style="margin-top: 15px;">
                        <?php if($is_late) { ?>
                            <p style="color:red; font-weight:bold; font-size: 16px;">STATUS: TERLAMBAT <?= $selisih; ?> HARI</p>
                            <small>Silakan input sanksi di bawah ini.</small>
                        <?php } else { ?>
                            <p style="color:green; font-weight:bold; font-size: 16px;">STATUS: TEPAT WAKTU</p>
                        <?php } ?>
                    </div>
                </div>

                <form action="proses_pengembalian.php" method="POST">
                    <input type="hidden" name="id_transaksi" value="<?= $data['id_transaksi']; ?>">
                    <input type="hidden" name="id_arsip" value="<?= $data['id_arsip']; ?>">
                    <input type="hidden" name="tanggal_kembali_fix" value="<?= $tanggal_kembali_aktual; ?>">

                    <label class="form-label">Sanksi / Denda</label>
                    <select name="sanksi" id="sanksi" class="form-input">
                        <option value="-">- Tidak Ada Sanksi -</option>
                        <option value="Teguran tertulis karena kelalaian">Teguran tertulis (Kelalaian)</option>
                        <option value="Pemotongan tunjangan kinerja">Pemotongan Tunjangan Kinerja</option>
                        <option value="Penundaan kenaikan gaji berkala (1 Thn)">Penundaan Kenaikan Gaji Berkala</option>
                        <option value="Penurunan jabatan 1 tingkat (1 Thn)">Penurunan Jabatan</option>
                        <option value="Ganti Rugi Material">Ganti Rugi Material</option>
                    </select>

                    <button type="submit" name="proses" class="btn-add" style="background:#28a745;">Konfirmasi & Simpan</button>
                </form>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>
</html>