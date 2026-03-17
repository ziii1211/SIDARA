<?php
session_start();
include '../../../config/koneksi.php';
if ($_SESSION['peran'] != 'admin') {
    header("Location: ../../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kategori Perkara</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            display: inline-block;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #333;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        td {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php include '../../layout/navbar.php'; ?>

    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">Data Master Kategori</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Daftar Kategori Perkara</h3>
                    <a href="tambah_kategori.php" class="btn-add"><i class='bx bx-plus'></i> Tambah Kategori</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th>Nama Kategori</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = mysqli_query($conn, "SELECT * FROM kategori_perkara ORDER BY id_kategori DESC");
                            while ($d = mysqli_fetch_assoc($sql)) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $d['nama_kategori']; ?></td>
                                    <td>
                                        <a href="edit_kategori.php?id=<?= $d['id_kategori']; ?>" class="btn-sm btn-edit" title="Edit">
                                            <i class='bx bx-pencil'></i>
                                        </a>
                                        <a href="hapus_kategori.php?id=<?= $d['id_kategori']; ?>" class="btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus kategori ini?')" title="Hapus">
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