<?php
session_start();
include '../config/koneksi.php';
if ($_SESSION['peran'] != 'pimpinan') {
    header("Location: ../index.php");
    exit;
}

$arsip = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_arsip"));
$dipinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_arsip WHERE status='Dipinjam'"));
$tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_arsip WHERE status='Ada'"));
$jaksa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM data_jaksa"));

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
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Dashboard Pimpinan</title>
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
                <span class="dashboard">Dashboard Pimpinan</span>
            </div>
            <div class="profile-details">
                <i class='bx bxs-user-badge' style="font-size: 30px; margin-right: 10px;"></i>
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
                            <span class="text">Seluruh Berkas</span>
                        </div>
                    </div>
                    <i class='bx bxs-folder-open cart'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Arsip Tersedia</div>
                        <div class="number"><?= number_format($tersedia['total']); ?></div>
                        <div class="indicator">
                            <span class="text">Di Ruang Arsip</span>
                        </div>
                    </div>
                    <i class='bx bxs-check-shield cart two'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Sedang Dipinjam</div>
                        <div class="number"><?= number_format($dipinjam['total']); ?></div>
                        <div class="indicator">
                            <span class="text">Keluar dari Rak</span>
                        </div>
                    </div>
                    <i class='bx bxs-time cart four'></i>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Total Jaksa</div>
                        <div class="number"><?= number_format($jaksa['total']); ?></div>
                        <div class="indicator">
                            <span class="text">Personil Jaksa</span>
                        </div>
                    </div>
                    <i class='bx bxs-user-detail cart three'></i>
                </div>
            </div>

            <div class="charts-grid">
                <div class="card chart-card">
                    <div class="card-header">
                        <h3>Statistik Arsip per Kategori</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartPimpinan"></canvas>
                    </div>
                </div>

                <div class="card chart-card">
                    <div class="card-header">
                        <h3>Persentase Status Arsip</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="chartPie"></canvas>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>5 Aktivitas Peminjaman Terakhir</h3>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No Perkara</th>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $log = mysqli_query($conn, "SELECT * FROM transaksi_peminjaman 
                                JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip
                                ORDER BY id_transaksi DESC LIMIT 5");
                            while ($l = mysqli_fetch_assoc($log)) {
                            ?>
                                <tr>
                                    <td><?= $l['no_perkara']; ?></td>
                                    <td><?= $l['nama_peminjam']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($l['tanggal_pinjam'])); ?></td>
                                    <td>
                                        <span class="badge <?= ($l['status'] == 'Dipinjam') ? 'badge-warning' : 'badge-success'; ?>">
                                            <?= $l['status']; ?>
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
        const ctx1 = document.getElementById('chartPimpinan').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?= json_encode($label_kategori); ?>,
                datasets: [{
                    label: 'Jumlah Berkas',
                    data: <?= json_encode($data_kategori); ?>,
                    backgroundColor: '#198754',
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

        const ctx2 = document.getElementById('chartPie').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Tersedia', 'Dipinjam'],
                datasets: [{
                    data: [<?= $tersedia['total']; ?>, <?= $dipinjam['total']; ?>],
                    backgroundColor: ['#198754', '#ffc107'],
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