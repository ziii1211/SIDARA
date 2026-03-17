<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Transaksi Peminjaman</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include '../../layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Transaksi Peminjaman</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Data Peminjaman & Pengajuan</h3>
                    <a href="tambah_peminjaman.php" class="btn-add"><i class='bx bx-plus'></i> Input Manual</a>
                </div>
                <div class="table-responsive">
                    <table style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Perkara</th>
                                <th>Peminjam (Divisi)</th>
                                <th>Tgl Ajuan/Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Status/Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT *, transaksi_peminjaman.status AS status_pinjam 
                                      FROM transaksi_peminjaman 
                                      JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip
                                      WHERE transaksi_peminjaman.status IN ('Dipinjam', 'Menunggu')
                                      ORDER BY FIELD(transaksi_peminjaman.status, 'Menunggu', 'Dipinjam'), id_transaksi DESC";
                            $sql = mysqli_query($conn, $query);
                            while ($d = mysqli_fetch_assoc($sql)) {
                                
                                if(!empty($d['batas_kembali'])){
                                    $tgl_batas = date('d-m-Y', strtotime($d['batas_kembali']));
                                    
                                    $today = new DateTime();
                                    $batas = new DateTime($d['batas_kembali']);
                                    $interval = $today->diff($batas);
                                    $days = $interval->format('%r%a');
                                } else {
                                    $tgl_batas = "-";
                                    $days = 100;
                                }
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <b><?= $d['no_perkara']; ?></b><br>
                                    NIP: <?= !empty($d['nip_peminjam']) ? $d['nip_peminjam'] : '-'; ?>
                                </td>
                                <td>
                                    <?= $d['nama_peminjam']; ?><br>
                                    <small>(<?= !empty($d['divisi']) ? $d['divisi'] : '-'; ?>)</small>
                                </td>
                                <td><?= date('d-m-Y', strtotime($d['tanggal_pinjam'])); ?></td>
                                <td>
                                    <?= $tgl_batas; ?>
                                </td>
                                <td>
                                    <?php 
                                    if($d['status_pinjam'] == 'Menunggu') {
                                        echo "<a href='approve_peminjaman.php?id=$d[id_transaksi]&id_arsip=$d[id_arsip]' 
                                              onclick=\"return confirm('Setujui peminjaman ini? Pastikan arsip fisik sudah disiapkan.')\"
                                              class='btn-add' style='background:#17a2b8; font-size:12px;'>
                                              <i class='bx bx-check-circle'></i> Setujui / Serahkan Arsip
                                              </a>";
                                    } else {
                                        if($days < 0) {
                                            echo "<span class='badge badge-warning' style='background:red;'>Terlambat " . abs($days) . " Hari</span>";
                                        } elseif($days <= 27) { 
                                            if($days <= 3) {
                                                 echo "<button onclick=\"alert('Peringatan dikirim ke " . $d['nama_peminjam'] . "')\" class='badge' style='background:#ffca2c; color:black; border:none; cursor:pointer;'> <i class='bx bx-bell'></i> Ingatkan (H-$days)</button>";
                                            } else {
                                                echo "<span class='badge badge-success'>Dipinjam</span>";
                                            }
                                        } else {
                                            echo "<span class='badge badge-success'>Dipinjam</span>";
                                        }
                                    }
                                    ?>
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