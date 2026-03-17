<?php
include '../../config/koneksi.php';
include 'header_laporan.php';
?>

<div class="judul-laporan">Laporan Status Arsip Dipinjam</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>No Perkara</th>
            <th>Nama Terdakwa</th>
            <th>Dipinjam Oleh</th>
            <th>Tanggal Pinjam</th>
            <th>Keperluan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $sql = mysqli_query($conn, "SELECT * FROM transaksi_peminjaman 
                                    JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip
                                    WHERE transaksi_peminjaman.status = 'Dipinjam'
                                    ORDER BY tanggal_pinjam ASC");
        while ($d = mysqli_fetch_assoc($sql)) {
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $d['no_perkara']; ?></td>
            <td><?= $d['nama_terdakwa']; ?></td>
            <td><?= $d['nama_peminjam']; ?></td>
            <td align="center"><?= date('d/m/Y', strtotime($d['tanggal_pinjam'])); ?></td>
            <td><?= $d['keterangan']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<div class="ttd-box">
    <p>Banjarmasin, <?= date('d F Y'); ?><br>Petugas Kearsipan</p>
    <b>__________________________</b>
</div>

</body>
</html>