<?php
include '../../config/koneksi.php';
include 'header_laporan.php';
?>

<div class="judul-laporan">Laporan Kapasitas Lokasi Penyimpanan Arsip</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Nama Ruangan (Lokasi)</th>
            <th>Nomor Rak</th>
            <th>Baris</th>
            <th>Jumlah Arsip Tersimpan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Menggabungkan tabel lokasi dengan data arsip untuk melihat kepadatan rak
        $sql = mysqli_query($conn, "SELECT dl.nama_lokasi, dl.rak, dl.baris, COUNT(da.id_arsip) as total_arsip 
                                    FROM data_lokasi dl 
                                    LEFT JOIN data_arsip da ON dl.id_lokasi = da.id_lokasi 
                                    GROUP BY dl.id_lokasi 
                                    ORDER BY dl.nama_lokasi ASC, dl.rak ASC");
        while ($d = mysqli_fetch_assoc($sql)) {
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $d['nama_lokasi']; ?></td>
            <td align="center"><?= $d['rak']; ?></td>
            <td align="center"><?= $d['baris']; ?></td>
            <td align="center"><b><?= $d['total_arsip']; ?> Berkas</b></td>
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