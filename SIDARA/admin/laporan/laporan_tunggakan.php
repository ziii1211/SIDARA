<?php
include '../../config/koneksi.php';
include 'header_laporan.php';

$tgl_sekarang = date('Y-m-d');
?>

<div class="judul-laporan">LAPORAN TUNGGAKAN DAN SANKSI KEARSIPAN</div>

<div style="text-align:center; margin-bottom: 20px; font-size: 14px;">
    Daftar Arsip Terlambat Dikembalikan & Riwayat Sanksi
</div>

<table class="table-laporan">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>No Perkara</th>
            <th>Peminjam (Divisi)</th>
            <th>Tgl Pinjam</th>
            <th>Batas Kembali</th>
            <th>Status Waktu</th>
            <th width="20%">Sanksi / Denda</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        // LOGIKA QUERY:
        // 1. Ambil yang Statusnya 'Dipinjam' TAPI sudah lewat batas waktu (Tunggakan Aktif)
        // 2. ATAU Ambil yang punya data Sanksi (Riwayat Pelanggaran)
        $query = "SELECT *, transaksi_peminjaman.status AS status_pinjam 
                  FROM transaksi_peminjaman 
                  JOIN data_arsip ON transaksi_peminjaman.id_arsip = data_arsip.id_arsip 
                  WHERE (transaksi_peminjaman.status = 'Dipinjam' AND transaksi_peminjaman.batas_kembali < '$tgl_sekarang')
                  OR (transaksi_peminjaman.sanksi IS NOT NULL AND transaksi_peminjaman.sanksi != '-')
                  ORDER BY transaksi_peminjaman.batas_kembali ASC";
        
        $sql = mysqli_query($conn, $query);
        $cek = mysqli_num_rows($sql);

        if ($cek > 0) {
            while ($d = mysqli_fetch_assoc($sql)) {
                $tgl_pinjam = date('d/m/Y', strtotime($d['tanggal_pinjam']));
                $tgl_batas = date('d/m/Y', strtotime($d['batas_kembali']));
                
                // Hitung Keterlambatan
                if($d['status_pinjam'] == 'Dipinjam') {
                    // Jika masih dipinjam, hitung selisih dari hari ini
                    $start = new DateTime($d['batas_kembali']);
                    $end = new DateTime($tgl_sekarang);
                    $diff = $start->diff($end);
                    $telat = $diff->days;
                    
                    $status_waktu = "<span style='color:red; font-weight:bold;'>SEDANG MENUNGGAK ($telat Hari)</span>";
                    $sanksi_text = "<i>(Menunggu Pengembalian)</i>";
                } else {
                    // Jika sudah kembali (History Sanksi)
                    $status_waktu = "<span style='color:black;'>Sudah Dikembalikan</span>";
                    $sanksi_text = "<span style='color:red; font-weight:bold;'>". $d['sanksi'] ."</span>";
                }
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td>
                <?= $d['no_perkara']; ?><br>
                <small>(<?= $d['nama_terdakwa']; ?>)</small>
            </td>
            <td>
                <b><?= $d['nama_peminjam']; ?></b><br>
                <span style="font-size:10px;"><?= $d['divisi']; ?></span>
            </td>
            <td align="center"><?= $tgl_pinjam; ?></td>
            <td align="center"><?= $tgl_batas; ?></td>
            <td align="center"><?= $status_waktu; ?></td>
            <td align="center"><?= $sanksi_text; ?></td>
        </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='7' align='center'>Tidak ada data tunggakan atau sanksi saat ini.</td></tr>";
        }
        ?>
    </tbody>
</table>

<div style="margin-top: 20px; font-size: 12px;">
    <b>Catatan:</b> Laporan ini memuat daftar pegawai yang sedang terlambat mengembalikan arsip (Menunggak) dan pegawai yang telah dikenakan sanksi disiplin kearsipan.
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