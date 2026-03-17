<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pengembalian Arsip</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include '../../layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Transaksi Pengembalian</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Verifikasi Pengembalian Arsip</h3>
                </div>
                <div class="table-responsive">
                    <table style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Perkara</th>
                                <th>Peminjam (Identitas)</th>
                                <th>Status Kembali</th>
                                <th>Status Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT *, transaksi_peminjaman.status AS status_pinjam 
                                      FROM transaksi_peminjaman 
                                      JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip
                                      WHERE transaksi_peminjaman.status IN ('Dipinjam', 'Menunggu Kembali')
                                      ORDER BY FIELD(transaksi_peminjaman.status, 'Menunggu Kembali', 'Dipinjam'), batas_kembali ASC";
                            $sql = mysqli_query($conn, $query);
                            while ($d = mysqli_fetch_assoc($sql)) {
                                if(!empty($d['batas_kembali'])){
                                    $tgl_batas = $d['batas_kembali'];
                                } else {
                                    $tgl_batas = date('Y-m-d', strtotime('+3 months', strtotime($d['tanggal_pinjam'])));
                                }

                                $today = new DateTime();
                                $batas = new DateTime($tgl_batas);
                                $is_late = ($today > $batas); 
                            ?>
                            <tr style="<?= ($d['status_pinjam'] == 'Menunggu Kembali') ? 'background-color: #f0f8ff;' : ''; ?>">
                                <td><?= $no++; ?></td>
                                <td><?= $d['no_perkara']; ?></td>
                                <td>
                                    <b><?= $d['nama_peminjam']; ?></b><br>
                                    <small>NIP: <?= !empty($d['nip_peminjam']) ? $d['nip_peminjam'] : '-'; ?></small><br>
                                    <small>Divisi: <?= !empty($d['divisi']) ? $d['divisi'] : '-'; ?></small>
                                </td>
                                <td>
                                    <?php if($d['status_pinjam'] == 'Menunggu Kembali') { ?>
                                        <span class="badge" style="background:#6f42c1; animation: blinker 1.5s linear infinite;">Mengajukan Kembali</span>
                                        <br><small style="color:#666;">Tgl: <?= date('d-m-Y', strtotime($d['tanggal_kembali'])); ?></small>
                                    <?php } else { ?>
                                        <span class="badge badge-warning">Sedang Dipinjam</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($is_late) { ?>
                                        <span class="badge" style="background:red;">Terlambat</span>
                                    <?php } else { ?>
                                        <span class="badge badge-success">Aman</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="form_pengembalian.php?id=<?= $d['id_transaksi']; ?>" 
                                       class="btn-add" 
                                       style="background: <?= ($d['status_pinjam']=='Menunggu Kembali') ? '#28a745' : '#0d6efd'; ?>;">
                                       <i class='bx bx-check-square'></i> <?= ($d['status_pinjam']=='Menunggu Kembali') ? 'Verifikasi' : 'Proses'; ?>
                                    </a>
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
    <style>
        @keyframes blinker { 50% { opacity: 0.5; } }
    </style>
</body>
</html>