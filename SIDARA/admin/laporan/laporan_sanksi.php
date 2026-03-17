<?php
include '../../config/koneksi.php';
include 'header_laporan.php';
?>

<div class="judul-laporan">Laporan Daftar Sanksi & Denda Kearsipan</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Nama Pegawai</th>
            <th>NIP / Divisi</th>
            <th>No Perkara Arsip</th>
            <th>Tanggal Kembali</th>
            <th>Jenis Sanksi / Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Hanya ambil data yang kolom sanksinya TIDAK KOSONG
        $sql = mysqli_query($conn, "SELECT * FROM transaksi_peminjaman 
                                    JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip
                                    WHERE sanksi IS NOT NULL AND sanksi != ''
                                    ORDER BY tanggal_kembali DESC");
        
        if(mysqli_num_rows($sql) > 0) {
            while ($d = mysqli_fetch_assoc($sql)) {
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $d['nama_peminjam']; ?></td>
            <td><?= $d['nip_peminjam']; ?><br>(<?= $d['divisi']; ?>)</td>
            <td><?= $d['no_perkara']; ?></td>
            <td align="center"><?= date('d/m/Y', strtotime($d['tanggal_kembali'])); ?></td>
            <td style="color:red; font-weight:bold;"><?= $d['sanksi']; ?></td>
        </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='6' align='center'>Tidak ada data sanksi.</td></tr>";
        }
        ?>
    </tbody>
</table>

<div class="ttd-box">
    <p>Banjarmasin, <?= date('d F Y'); ?><br>Kepala Sub Bagian Pembinaan</p>
    <b>__________________________</b>
</div>

</body>
</html>