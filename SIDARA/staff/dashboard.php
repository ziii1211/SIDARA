<?php
session_start();
include '../config/koneksi.php';
if ($_SESSION['peran'] != 'staff') { header("Location: ../index.php"); exit; }

$id_saya = $_SESSION['id_pengguna'];
$nama_saya = $_SESSION['nama_lengkap'];

// Statistik Dashboard
// Gunakan alias 'tp' untuk transaksi_peminjaman agar lebih aman
$pinjam_aktif = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi_peminjaman WHERE id_pengguna='$id_saya' AND status IN ('Dipinjam','Menunggu Kembali')"));
$menunggu = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi_peminjaman WHERE id_pengguna='$id_saya' AND status='Menunggu'"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Staff</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include 'layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Dashboard Staff</span>
            </div>
            <div class="profile-details">
                <i class='bx bxs-user-circle' style="font-size: 30px; margin-right: 10px;"></i>
                <span class="admin_name"><?= $nama_saya; ?></span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card" style="margin-bottom: 20px; border-left: 5px solid #198754;">
                <div class="card-header">
                    <h3>Identitas Pegawai</h3>
                </div>
                <div style="padding: 20px; display: flex; gap: 50px; flex-wrap: wrap;">
                    <div>
                        <small style="color: #666;">Nama Lengkap</small>
                        <h4 style="margin-top: 5px;"><?= $nama_saya; ?></h4>
                    </div>
                    <div>
                        <small style="color: #666;">NIP</small>
                        <h4 style="margin-top: 5px;"><?= $_SESSION['nip']; ?></h4>
                    </div>
                    <div>
                        <small style="color: #666;">Divisi</small>
                        <h4 style="margin-top: 5px;"><?= $_SESSION['divisi']; ?></h4>
                    </div>
                    <div>
                        <small style="color: #666;">Status Arsip</small>
                        <h4 style="margin-top: 5px;">
                            <span style="color: #ffc107;"><?= $pinjam_aktif; ?> Aktif</span> | 
                            <span style="color: #17a2b8;"><?= $menunggu; ?> Menunggu</span>
                        </h4>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Riwayat & Status Peminjaman Saya</h3>
                    <a href="pengajuan.php" class="btn-add"><i class='bx bx-plus'></i> Ajukan Baru</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Perkara</th>
                                <th>Tgl Pinjam/Ajuan</th>
                                <th>Batas Kembali</th>
                                <th>Status / Aksi</th>
                                <th>Sanksi / Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // PERBAIKAN PENTING:
                            // Kita ambil 'transaksi_peminjaman.status' dan kita namakan ulang jadi 'status_pinjam'
                            // Supaya tidak tertukar dengan status milik arsip (Ada/Dipinjam)
                            $query = "SELECT *, transaksi_peminjaman.status AS status_pinjam 
                                      FROM transaksi_peminjaman 
                                      JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip
                                      WHERE id_pengguna='$id_saya'
                                      ORDER BY id_transaksi DESC";
                            $sql = mysqli_query($conn, $query);
                            
                            if(mysqli_num_rows($sql) > 0) {
                                while ($d = mysqli_fetch_assoc($sql)) {
                                    $tgl = date('d-m-Y', strtotime($d['tanggal_pinjam']));
                                    
                                    // Cek Batas Waktu
                                    if(!empty($d['batas_kembali'])) {
                                        $tgl_batas = date('d-m-Y', strtotime($d['batas_kembali']));
                                        $today = new DateTime();
                                        $batas = new DateTime($d['batas_kembali']);
                                        $interval = $today->diff($batas);
                                        $selisih = $interval->format('%r%a'); 
                                    } else {
                                        // Jawaban Pertanyaanmu:
                                        // Ya, "Menunggu ACC" artinya menunggu Admin klik tombol "Setujui" di dashboard admin.
                                        $tgl_batas = "<i style='color:#17a2b8;'>Menunggu ACC Admin</i>";
                                        $selisih = 100; 
                                    }
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <b><?= $d['no_perkara']; ?></b><br>
                                    <small><?= $d['nama_terdakwa']; ?></small>
                                </td>
                                <td><?= $tgl; ?></td>
                                <td><?= $tgl_batas; ?></td>
                                <td>
                                    <?php 
                                    // Gunakan variabel baru 'status_pinjam'
                                    if($d['status_pinjam'] == 'Dipinjam') {
                                        echo "<a href='aksi_kembali.php?id=$d[id_transaksi]' 
                                              onclick=\"return confirm('Kembalikan berkas? Status akan menjadi Menunggu Verifikasi Admin.')\"
                                              class='badge' style='background:#0d6efd; color:white; text-decoration:none; cursor:pointer;'>
                                              <i class='bx bx-undo'></i> Kembalikan
                                              </a><br>";

                                        if($selisih < 0) {
                                            $hari_telat = abs($selisih);
                                            echo "<small style='color:red; font-weight:bold;'>Terlambat $hari_telat Hari</small>";
                                        } elseif($selisih <= 3) {
                                            echo "<small style='color:#e67e22; font-weight:bold;'>Hampir Habis ($selisih Hari)</small>";
                                        }
                                    } elseif($d['status_pinjam'] == 'Menunggu Kembali') {
                                        echo "<span class='badge' style='background:#6f42c1;'>Verifikasi Pengembalian</span>";
                                    } elseif($d['status_pinjam'] == 'Menunggu') { 
                                        echo "<span class='badge' style='background:#17a2b8;'>Menunggu Persetujuan</span>";
                                    } else { 
                                        echo "<span class='badge badge-success'>Sudah Dikembalikan</span>";
                                    } 
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if(!empty($d['sanksi'])) { 
                                        echo "<span style='color:red; font-weight:bold; font-size:12px;'><i class='bx bx-error'></i> $d[sanksi]</span>";
                                    } elseif($d['status_pinjam'] == 'Kembali') {
                                        echo "<span style='color:green; font-size:12px;'><i class='bx bx-check'></i> Aman</span>";
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='6' align='center'>Belum ada data riwayat.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="/sidara/assets/script.js"></script>
</body>
</html>