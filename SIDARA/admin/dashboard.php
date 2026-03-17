<?php
session_start();
include '../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$arsip = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_arsip"));
$jaksa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_jaksa"));
$lokasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_lokasi"));
$dipinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_arsip WHERE status='Dipinjam'"));

$label_kategori = [];
$data_kategori = [];
$q_kat = mysqli_query($conn, "SELECT k.nama_kategori, COUNT(a.id_arsip) as jumlah 
                              FROM data_arsip a 
                              JOIN kategori_perkara k ON a.id_kategori = k.id_kategori 
                              GROUP BY k.nama_kategori");
while ($row = mysqli_fetch_assoc($q_kat)) {
    $label_kategori[] = $row['nama_kategori'];
    $data_kategori[] = $row['jumlah'];
}

$ada = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_arsip WHERE status='Ada'"));
$pinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_arsip WHERE status='Dipinjam'"));
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include 'layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Dashboard Overview</span>
            </div>
            <div class="profile-details">
                <i class='bx bxs-user-circle' style="font-size: 30px; margin-right: 10px;"></i>
                <span class="admin_name"><?php echo $_SESSION['nama_lengkap']; ?></span>
            </div>
        </nav>

        <div class="home-content">
            <div class="overview-boxes">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Arsip</div>
                        <div class="number"><?= number_format($arsip['total']); ?></div>
                        <div class="indicator">
                            <span class="text">Dokumen Tersimpan</span>
                        </div>
                    </div>
                    <i class='bx bxs-folder cart'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Jaksa</div>
                        <div class="number"><?= number_format($jaksa['total']); ?></div>
                        <div class="indicator">
                            <span class="text">Jaksa Aktif</span>
                        </div>
                    </div>
                    <i class='bx bxs-user-detail cart two'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Lokasi</div>
                        <div class="number"><?= number_format($lokasi['total']); ?></div>
                        <div class="indicator">
                            <span class="text">Rak/Lemari</span>
                        </div>
                    </div>
                    <i class='bx bxs-map cart three'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Sedang Dipinjam</div>
                        <div class="number"><?= number_format($dipinjam['total']); ?></div>
                        <div class="indicator">
                            <span class="text">Berkas Keluar</span>
                        </div>
                    </div>
                    <i class='bx bxs-time-five cart four'></i>
                </div>
            </div>

            <div class="charts-grid">
                <div class="card chart-card">
                    <div class="card-header">
                        <h3>Statistik Arsip per Kategori</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartKategori"></canvas>
                    </div>
                </div>

                <div class="card chart-card">
                    <div class="card-header">
                        <h3>Status Ketersediaan Arsip</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartStatus"></canvas>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Arsip Terbaru Masuk</h3>
                    <a href="data_master/data_arsip/data_arsip.php" class="btn-add">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No Perkara</th>
                                <th>Terdakwa</th>
                                <th>Kategori</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent = mysqli_query($conn, "SELECT * FROM data_arsip 
                                JOIN kategori_perkara ON data_arsip.id_kategori = kategori_perkara.id_kategori
                                ORDER BY id_arsip DESC LIMIT 5");
                            while ($r = mysqli_fetch_assoc($recent)) {
                            ?>
                                <tr>
                                    <td><?= $r['no_perkara']; ?></td>
                                    <td><?= $r['nama_terdakwa']; ?></td>
                                    <td><?= $r['nama_kategori']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($r['tanggal_masuk'])); ?></td>
                                    <td>
                                        <span class="badge <?= ($r['status'] == 'Ada') ? 'badge-success' : 'badge-warning'; ?>">
                                            <?= $r['status']; ?>
                                        </span>
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
    <script>
        const ctx1 = document.getElementById('chartKategori').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?= json_encode($label_kategori); ?>,
                datasets: [{
                    label: 'Jumlah Arsip',
                    data: <?= json_encode($data_kategori); ?>,
                    backgroundColor: '#0d6efd',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('chartStatus').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Tersedia', 'Dipinjam'],
                datasets: [{
                    data: [<?= $ada['total']; ?>, <?= $pinjam['total']; ?>],
                    backgroundColor: ['#28a745', '#ffc107'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>

</html>