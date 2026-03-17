<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Transaksi</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include '../../layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Riwayat Sirkulasi</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Log Riwayat Peminjaman</h3>
                </div>
                <div class="table-responsive">
                    <table style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Perkara</th>
                                <th>Peminjam (Identitas)</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Sanksi / Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Tambahkan alias
                            $query = "SELECT *, transaksi_peminjaman.status AS status_pinjam 
                                      FROM transaksi_peminjaman 
                                      JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip
                                      WHERE transaksi_peminjaman.status = 'Kembali'
                                      ORDER BY tanggal_kembali DESC";
                            $sql = mysqli_query($conn, $query);
                            while ($d = mysqli_fetch_assoc($sql)) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $d['no_perkara']; ?></td>
                                <td>
                                    <b><?= $d['nama_peminjam']; ?></b><br>
                                    <small>NIP: <?= !empty($d['nip_peminjam']) ? $d['nip_peminjam'] : '-'; ?></small><br>
                                    <small>Divisi: <?= !empty($d['divisi']) ? $d['divisi'] : '-'; ?></small>
                                </td>
                                <td><?= date('d-m-Y', strtotime($d['tanggal_pinjam'])); ?></td>
                                <td><?= date('d-m-Y', strtotime($d['tanggal_kembali'])); ?></td>
                                <td>
                                    <?php if(!empty($d['sanksi'])) { ?>
                                        <span class="badge" style="background:red; white-space:normal; text-align:left; display:block; padding: 5px;">
                                            <?= $d['sanksi']; ?>
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge badge-success">-</span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>
</html>