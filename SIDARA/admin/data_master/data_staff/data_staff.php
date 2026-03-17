<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') { header("Location: ../../../index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Staff</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .btn-sm { padding: 5px 10px; font-size: 12px; border-radius: 4px; text-decoration: none; color: white; display: inline-block; }
        .btn-edit { background-color: #ffc107; color: #333; }
        .btn-delete { background-color: #dc3545; }
        td { vertical-align: middle; }
    </style>
</head>
<body>
    <?php include '../../layout/navbar.php'; ?>
    
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Data Master Staff</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Daftar Akun Staff (Peminjam)</h3>
                    <a href="tambah_staff.php" class="btn-add"><i class='bx bx-plus'></i> Tambah Staff</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIP / NIDN</th>
                                <th>Divisi</th>
                                <th>Username</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = mysqli_query($conn, "SELECT * FROM pengguna WHERE peran='staff' ORDER BY id_pengguna DESC");
                            while ($d = mysqli_fetch_assoc($sql)) {
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $d['nama_lengkap']; ?></td>
                                <td><?= $d['nip']; ?></td>
                                <td><?= $d['divisi']; ?></td>
                                <td><?= $d['nama_pengguna']; ?></td>
                                <td>
                                    <a href="edit_staff.php?id=<?= $d['id_pengguna']; ?>" class="btn-sm btn-edit" title="Edit">
                                        <i class='bx bx-pencil'></i>
                                    </a>
                                    <a href="hapus_staff.php?id=<?= $d['id_pengguna']; ?>" class="btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus akun staff ini?')" title="Hapus">
                                        <i class='bx bx-trash'></i>
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
</body>
</html>