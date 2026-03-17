<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$page = end($components);

$laporan_pages = [
    'laporan_inventaris.php',
    'laporan_status.php',
    'laporan_sirkulasi.php',
    'laporan_tunggakan.php',
    'laporan_statistik.php'
];

$is_laporan_active = in_array($page, $laporan_pages) ? 'showMenu' : '';
$is_laporan_class = in_array($page, $laporan_pages) ? 'active' : '';
?>

<div class="sidebar">
    <div class="logo-details">
        <img src="/sidara/img/kjn.webp" alt="Logo">
        <span class="logo_name">SIDARA</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/sidara/pimpinan/dashboard.php" class="<?= ($page == 'dashboard.php') ? 'active' : ''; ?>">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard</span>
            </a>
        </li>

        <li class="<?= $is_laporan_active; ?> <?= $is_laporan_class; ?>">
            <div class="icon-link">
                <a href="#">
                    <i class='bx bx-printer'></i>
                    <span class="link_name">Pusat Laporan</span>
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