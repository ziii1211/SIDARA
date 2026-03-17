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
    <title>Data Arsip</title>
    <link rel="stylesheet" href="/sidara/assets/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* CSS Tambahan Khusus Halaman Ini agar lebih rapi */
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            display: inline-block;
        }

        .btn-view {
            background-color: #17a2b8;
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
                <span class="dashboard">Data Master Arsip</span>
            </div>
        </nav>

        <div class="home-content">
            <div class="card">
                <div class="card-header">
                    <h3>Daftar Arsip Perkara</h3>
                    <a href="tambah_arsip.php" class="btn-add"><i class='bx bx-plus'></i> Tambah Arsip</a>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Perkara</th>
                                <th>Terdakwa</th>
                                <th>Lokasi Simpan</th>
                                <th>Status</th>
                                <th>Dokumen</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = "SELECT * FROM data_arsip 
                                      JOIN kategori_perkara ON data_arsip.id_kategori = kategori_perkara.id_kategori
                                      JOIN data_jaksa ON data_arsip.id_jaksa = data_jaksa.id_jaksa
                                      JOIN data_lokasi ON data_arsip.id_lokasi = data_lokasi.id_lokasi
                                      ORDER BY id_arsip DESC";
                            $sql = mysqli_query($conn, $query);
                            while ($d = mysqli_fetch_assoc($sql)) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <b><?= $d['no_perkara']; ?></b><br>
                                        <small style="color:#666;"><?= $d['nama_kategori']; ?></small>
                                    </td>
                                    <td>
                                        <?= $d['nama_terdakwa']; ?><br>
                                        <small style="color:#666;">JPU: <?= $d['nama_jaksa']; ?></small>
                                    </td>
                                    <td><?= $d['nama_lokasi']; ?> <br> (Rak <?= $d['rak']; ?>)</td>
                                    <td>
                                        <?php if ($d['status'] == 'Ada') { ?>
                                            <span class="badge badge-success">Tersedia</span>
                                        <?php } else { ?>
                                            <span class="badge badge-warning">Dipinjam</span>
                                        <?php } ?>
                                    </td>
                                    <td align="center">
                                        <?php if ($d['file_arsip'] != "") { ?>
                                            <a href="/sidara/uploads/<?= $d['file_arsip']; ?>" target="_blank" class="btn-sm btn-view">
                                                <i class='bx bx-file'></i> Lihat
                                            </a>
                                        <?php } else { ?>
                                            <span style="color:#ccc; font-size:12px;">Tidak ada</span>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="edit_arsip.php?id=<?= $d['id_arsip']; ?>" class="btn-sm btn-edit" title="Edit"><i class='bx bx-pencil'></i></a>
                                        <a href="hapus_arsip.php?id=<?= $d['id_arsip']; ?>" class="btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus arsip ini?')" title="Hapus"><i class='bx bx-trash'></i></a>
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