<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$page = end($components);
?>
<style>
    .logo-details {
        display: flex;
        align-items: center;
        padding-left: 10px;
    }
    .logo-details img {
        height: 40px;
        margin-right: 10px;
    }
    .logo_name {
        color: #fff;
        font-size: 22px;
        font-weight: 600;
        text-transform: uppercase;
    }
</style>
<div class="sidebar">
    <div class="logo-details">
        <img src="/sidara/img/kjn.webp" alt="Logo">
        <span class="logo_name">SIDARA</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="/sidara/staff/dashboard.php" class="<?= ($page == 'dashboard.php') ? 'active' : ''; ?>">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard Staff</span>
            </a>
        </li>
        <li>
            <a href="/sidara/staff/pengajuan.php" class="<?= ($page == 'pengajuan.php') ? 'active' : ''; ?>">
                <i class='bx bx-plus-circle'></i>
                <span class="link_name">Ajukan Peminjaman</span>
            </a>
        </li>
        <li>
            <a href="/sidara/logout.php" class="logout-btn" onclick="return confirm('Yakin ingin keluar?');">
                <i class='bx bx-log-out'></i>
                <span class="link_name">Keluar</span>
            </a>
        </li>
    </ul>
</div>