<?php
include '../../config/koneksi.php';
include 'header_laporan.php';
?>

<div class="judul-laporan">Laporan Inventaris Arsip Perkara</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>No Perkara</th>
            <th>Nama Terdakwa</th>
            <th>Kategori</th>
            <th>Jaksa Penuntut</th>
            <th>Lokasi Simpan</th>
            <th>Tanggal Masuk</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $sql = mysqli_query($conn, "SELECT * FROM data_arsip 
                                    JOIN kategori_perkara ON data_arsip.id_kategori = kategori_perkara.id_kategori
                                    JOIN data_jaksa ON data_arsip.id_jaksa = data_jaksa.id_jaksa
                                    JOIN data_lokasi ON data_arsip.id_lokasi = data_lokasi.id_lokasi
                                    ORDER BY id_arsip DESC");
        while ($d = mysqli_fetch_assoc($sql)) {
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $d['no_perkara']; ?></td>
            <td><?= $d['nama_terdakwa']; ?></td>
            <td><?= $d['nama_kategori']; ?></td>
            <td><?= $d['nama_jaksa']; ?></td>
            <td><?= $d['nama_lokasi']; ?> (Rak <?= $d['rak']; ?>)</td>
            <td align="center"><?= date('d/m/Y', strtotime($d['tanggal_masuk'])); ?></td>
            <td align="center"><?= $d['status']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="ttd-box">
    <p>Banjarmasin, <?= date('d F Y'); ?><br>Kepala Sub Bagian Pembinaan</p>
    <b>__________________________</b><br>
    NIP. .....................................
</div>

</body>
</html>