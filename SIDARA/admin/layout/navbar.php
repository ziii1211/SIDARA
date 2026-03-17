<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$page = end($components);

$data_master_pages = [
    'data_arsip.php', 'tambah_arsip.php', 'edit_arsip.php',
    'data_lokasi.php', 'tambah_lokasi.php', 'edit_lokasi.php',
    'data_jaksa.php', 'tambah_jaksa.php', 'edit_jaksa.php',
    'kategori_perkara.php', 'tambah_kategori.php', 'edit_kategori.php',
    'data_staff.php', 'tambah_staff.php', 'edit_staff.php'
];

$transaksi_pages = [
    'peminjaman.php', 'tambah_peminjaman.php',
    'pengembalian.php', 'form_pengembalian.php', 'proses_pengembalian.php',
    'riwayat.php', 'approve_peminjaman.php'
];

$is_master_active = in_array($page, $data_master_pages) ? 'showMenu' : '';
$is_master_class = in_array($page, $data_master_pages) ? 'active' : '';

$is_transaksi_active = in_array($page, $transaksi_pages) ? 'showMenu' : '';
$is_transaksi_class = in_array($page, $transaksi_pages) ? 'active' : '';
?>

<div class="sidebar">
    <div class="logo-details">
        <img src="/sidara/img/kjn.webp" alt="Logo">
        <span class="logo_name">SIDARA</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/sidara/admin/dashboard.php" class="<?= ($page == 'dashboard.php') ? 'active' : ''; ?>">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard</span>
            </a>
        </li>
        
        <li class="<?= $is_master_active; ?> <?= $is_master_class; ?>">
            <div class="icon-link">
                <a href="#">
                    <i class='bx bx-data'></i>
                    <span class="link_name">Data Master</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a href="/sidara/admin/data_master/data_arsip/data_arsip.php" style="<?= (strpos($page, 'arsip') !== false) ? 'color: #ffd700;' : ''; ?>">Data Arsip</a></li>
                <li><a href="/sidara/admin/data_master/data_lokasi/data_lokasi.php" style="<?= (strpos($page, 'lokasi') !== false) ? 'color: #ffd700;' : ''; ?>">Data Lokasi</a></li>
                <li><a href="/sidara/admin/data_master/data_jaksa/data_jaksa.php" style="<?= (strpos($page, 'jaksa') !== false) ? 'color: #ffd700;' : ''; ?>">Data Jaksa</a></li>
                <li><a href="/sidara/admin/data_master/kategori_perkara/kategori_perkara.php" style="<?= (strpos($page, 'kategori') !== false) ? 'color: #ffd700;' : ''; ?>">Divisi</a></li>
                       <li><a href="/sidara/admin/data_master/data_staff/data_staff.php" style="<?= (strpos($page, 'staff') !== false) ? 'color: #ffd700;' : ''; ?>">Data Staff (Peminjam)</a></li>
            </ul>
        </li>

        <li class="<?= $is_transaksi_active; ?> <?= $is_transaksi_class; ?>">
            <div class="icon-link">
                <a href="#">
                    <i class='bx bx-transfer'></i>
                    <span class="link_name">Transaksi</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a href="/sidara/admin/transaksi/peminjaman/peminjaman.php" style="<?= (strpos($page, 'peminjaman') !== false) ? 'color: #ffd700;' : ''; ?>">Peminjaman Baru</a></li>
                <li><a href="/sidara/admin/transaksi/pengembalian/pengembalian.php" style="<?= (strpos($page, 'pengembalian') !== false) ? 'color: #ffd700;' : ''; ?>">Pengembalian</a></li>
                <li><a href="/sidara/admin/transaksi/riwayat/riwayat.php" style="<?= (strpos($page, 'riwayat') !== false) ? 'color: #ffd700;' : ''; ?>">Riwayat</a></li>
            </ul>
        </li>

        <li>
            <div class="icon-link">
                <a href="#">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Laporan</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a href="/sidara/admin/laporan/laporan_inventaris.php" target="_blank">Inventaris Arsip</a></li>
                <li><a href="/sidara/admin/laporan/laporan_status.php" target="_blank">Status Dipinjam</a></li>
                <li><a href="/sidara/admin/laporan/laporan_sirkulasi.php" target="_blank">Sirkulasi</a></li>
                <li><a href="/sidara/admin/laporan/laporan_tunggakan.php" target="_blank">Tunggakan</a></li>
                <li><a href="/sidara/admin/laporan/laporan_statistik.php" target="_blank">Statistik</a></li>
                <li><a href="/sidara/admin/laporan/laporan_sanksi.php" target="_blank" style="color: #ff6b6b;">Laporan Sanksi</a></li>
            </ul>
        </li>

        <li>
            <a href="/sidara/logout.php" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem?');">
                <i class='bx bx-log-out'></i>
                <span class="link_name">Keluar</span>
            </a>
        </li>
    </ul>
</div>