<?php
include '../../config/koneksi.php';
include 'header_laporan.php';

// Ambil Tanggal Hari Ini
$tgl_sekarang = date('d F Y');
?>

<div class="judul-laporan">LAPORAN SIRKULASI DAN STATUS PEMINJAMAN ARSIP</div>

<div style="text-align:center; margin-bottom: 20px; font-size: 14px;">
    Periode Cetak: <?= $tgl_sekarang; ?>
</div>

<table class="table-laporan">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>No Perkara</th>
            <th>Nama Terdakwa</th>
            <th>Peminjam (Staff/Jaksa)</th>
            <th width="12%">Tgl Pinjam</th>
            <th width="12%">Tgl Kembali</th>
            <th width="10%">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // Query Menggabungkan Data Transaksi Peminjaman & Arsip
        // Diurutkan dari yang terbaru (DESC)
        $query = "SELECT *, transaksi_peminjaman.status AS status_pinjam 
                  FROM transaksi_peminjaman 
                  JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip 
                  ORDER BY transaksi_peminjaman.tanggal_pinjam DESC, transaksi_peminjaman.id_transaksi DESC";
        
        $sql = mysqli_query($conn, $query);
        $jumlah_data = mysqli_num_rows($sql);

        if ($jumlah_data > 0) {
            while ($d = mysqli_fetch_assoc($sql)) {
                // Format Tanggal
                $tgl_pinjam = date('d/m/Y', strtotime($d['tanggal_pinjam']));
                
                // Cek Tanggal Kembali
                if ($d['status_pinjam'] == 'Kembali' && !empty($d['tanggal_kembali'])) {
                    $tgl_kembali = date('d/m/Y', strtotime($d['tanggal_kembali']));
                } else {
                    $tgl_kembali = "-";
                }

                // Warna Status biar enak dilihat pas diprint (Opsional, tapi rapi)
                $status_label = $d['status_pinjam'];
                $bg_color = ""; // Default putih

                // Jika sedang dipinjam, kasih highlight tipis
                if($d['status_pinjam'] == 'Dipinjam') {
                    $status_label = "SEDANG DIPINJAM";
                    $bg_color = "background-color: #fff3cd;"; // Kuning tipis
                } elseif($d['status_pinjam'] == 'Menunggu' || $d['status_pinjam'] == 'Menunggu Kembali') {
                    $status_label = "PROSES VERIFIKASI";
                    $bg_color = "background-color: #cff4fc;"; // Biru tipis
                } elseif($d['status_pinjam'] == 'Kembali') {
                    $status_label = "DIKEMBALIKAN";
                }
        ?>
        <tr style="<?= $bg_color; ?>">
            <td align="center"><?= $no++; ?></td>
            <td><?= $d['no_perkara']; ?></td>
            <td><?= $d['nama_terdakwa']; ?></td>
            <td>
                <b><?= $d['nama_peminjam']; ?></b><br>
                <span style="font-size:10px;">(<?= $d['divisi']; ?>)</span>
            </td>
            <td align="center"><?= $tgl_pinjam; ?></td>
            <td align="center"><?= $tgl_kembali; ?></td>
            <td align="center" style="font-weight:bold; font-size: 11px;">
                <?= $status_label; ?>
            </td>
        </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='7' align='center'>Belum ada data sirkulasi arsip.</td></tr>";
        }
        ?>
    </tbody>
</table>

<div style="margin-top: 20px; font-size: 12px;">
    <b>Keterangan:</b><br>
    Total Transaksi Tercatat: <?= $jumlah_data; ?> Data
</div>

<div class="ttd-box" style="float: right; text-align: center; width: 40%; margin-top: 50px; font-size: 12px;">
    <p>Banjarmasin, <?= date('d F Y'); ?><br>
    <b>Kepala Sub Bagian Pembinaan</b></p>
    <br><br><br><br>
    <p style="text-decoration: underline; font-weight: bold;">ANDRI NANDA HEVEA NORFIKRI, S.H., M.H.</p>
    <p>NIP. 19810725 200003 1 001</p>
</div>

<script>
    window.onload = function() {
        setTimeout(function(){ window.print(); }, 1000);
    }
</script>

</body>
</html>