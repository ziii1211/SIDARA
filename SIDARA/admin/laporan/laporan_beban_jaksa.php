<?php
include '../../config/koneksi.php';
include 'header_laporan.php';
?>

<div class="judul-laporan">Laporan Rekapitulasi Beban Perkara Jaksa</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>NIP</th>
            <th>Nama Jaksa</th>
            <th>Jabatan</th>
            <th>Jumlah Perkara (Arsip) Ditangani</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Query menggunakan LEFT JOIN dan COUNT untuk menghitung total arsip per jaksa
        $sql = mysqli_query($conn, "SELECT dj.nip, dj.nama_jaksa, dj.jabatan, COUNT(da.id_arsip) as total_perkara 
                                    FROM data_jaksa dj 
                                    LEFT JOIN data_arsip da ON dj.id_jaksa = da.id_jaksa 
                                    GROUP BY dj.id_jaksa 
                                    ORDER BY total_perkara DESC");
        while ($d = mysqli_fetch_assoc($sql)) {
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $d['nip'] ?? '-'; ?></td>
            <td><?= $d['nama_jaksa']; ?></td>
            <td><?= $d['jabatan']; ?></td>
            <td align="center"><b><?= $d['total_perkara']; ?> Berkas</b></td>
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