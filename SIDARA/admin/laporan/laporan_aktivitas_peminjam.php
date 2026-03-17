<?php
include '../../config/koneksi.php';
include 'header_laporan.php';
?>

<div class="judul-laporan">Laporan Aktivitas Peminjaman (Berdasarkan Staff)</div>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Nama Peminjam (Staff)</th>
            <th>NIP</th>
            <th>Divisi</th>
            <th>Total Frekuensi Pinjam</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Menghitung frekuensi peminjaman berdasarkan id_pengguna yang role-nya staff
        $sql = mysqli_query($conn, "SELECT p.nama_lengkap, p.nip, p.divisi, COUNT(tp.id_transaksi) as total_pinjam 
                                    FROM pengguna p 
                                    JOIN transaksi_peminjaman tp ON p.id_pengguna = tp.id_pengguna 
                                    WHERE p.peran = 'staff' 
                                    GROUP BY p.id_pengguna 
                                    ORDER BY total_pinjam DESC");
        
        if(mysqli_num_rows($sql) > 0) {
            while ($d = mysqli_fetch_assoc($sql)) {
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $d['nama_lengkap']; ?></td>
            <td><?= $d['nip'] ?? '-'; ?></td>
            <td><?= $d['divisi'] ?? '-'; ?></td>
            <td align="center"><b><?= $d['total_pinjam']; ?> Kali</b></td>
        </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='5' align='center'>Belum ada data aktivitas peminjaman staff.</td></tr>";
        }
        ?>
    </tbody>
</table>

<div class="ttd-box">
    <p>Banjarmasin, <?= date('d F Y'); ?><br>Kepala Sub Bagian Pembinaan</p>
    <b>__________________________</b><br>
    NIP. .....................................
</div>

</body>
</html>