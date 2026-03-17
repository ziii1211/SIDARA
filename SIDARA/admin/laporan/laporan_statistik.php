<?php
include '../../config/koneksi.php';
include 'header_laporan.php';

$labels = [];
$data_jumlah = [];

$query_grafik = mysqli_query($conn, "SELECT k.nama_kategori, COUNT(a.id_arsip) as jumlah 
                                     FROM kategori_perkara k 
                                     LEFT JOIN data_arsip a ON k.id_kategori = a.id_kategori 
                                     GROUP BY k.id_kategori");

while ($g = mysqli_fetch_assoc($query_grafik)) {
    $labels[] = $g['nama_kategori'];
    $data_jumlah[] = $g['jumlah'];
}

$json_labels = json_encode($labels);
$json_data = json_encode($data_jumlah);

$total_arsip = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM data_arsip"));
$arsip_ada = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM data_arsip WHERE status='Ada'"));
$arsip_pinjam = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM data_arsip WHERE status='Dipinjam'"));
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="judul-laporan">Laporan Statistik Kearsipan</div>

<div style="margin-bottom: 20px;">
    <h4 style="text-align:center; font-size:14px;">Ringkasan Data</h4>
    <table style="width: 50%; margin: 0 auto; font-size: 12px;">
        <tr>
            <td>Total Seluruh Arsip</td>
            <td align="center"><b><?= $total_arsip; ?></b> Berkas</td>
        </tr>
        <tr>
            <td>Arsip Tersedia (Di Rak)</td>
            <td align="center"><b><?= $arsip_ada; ?></b> Berkas</td>
        </tr>
        <tr>
            <td>Arsip Sedang Dipinjam</td>
            <td align="center"><b><?= $arsip_pinjam; ?></b> Berkas</td>
        </tr>
    </table>
</div>

<div style="display: flex; justify-content: center; gap: 40px; margin-bottom: 30px; page-break-inside: avoid;">
    <div style="width: 30%; text-align: center;">
        <h5 style="font-size:12px;">Persentase Bidang</h5>
        <canvas id="pieChart"></canvas>
    </div>
    <div style="width: 35%; text-align: center;">
        <h5 style="font-size:12px;">Jumlah Arsip Per Bidang</h5>
        <canvas id="barChart"></canvas>
    </div>
</div>

<h4 style="text-align:center; font-size:14px;">Rincian Data Per Bidang</h4>
<table style="font-size: 12px;">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Bidang / Kategori Perkara</th>
            <th width="20%">Jumlah Arsip</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $sql = mysqli_query($conn, "SELECT k.nama_kategori, COUNT(a.id_arsip) as jumlah 
                                    FROM kategori_perkara k 
                                    LEFT JOIN data_arsip a ON k.id_kategori = a.id_kategori 
                                    GROUP BY k.id_kategori");
        while ($d = mysqli_fetch_assoc($sql)) {
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td><?= $d['nama_kategori']; ?></td>
            <td align="center"><?= $d['jumlah']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr style="background-color: #f2f2f2; font-weight:bold;">
            <td colspan="2" align="center">Total Keseluruhan</td>
            <td align="center"><?= $total_arsip; ?></td>
        </tr>
    </tfoot>
</table>

<div class="ttd-box" style="float: right; text-align: center; width: 40%; margin-top: 50px; font-size: 12px;">
    <p>Banjarmasin, <?= date('d F Y'); ?><br>
    <b>Kepala Sub Bagian Pembinaan</b></p>
    <br><br><br><br>
    <p style="text-decoration: underline; font-weight: bold;">ANDRI NANDA HEVEA NORFIKRI, S.H., M.H.</p>
    <p>NIP. 19810725 200003 1 001</p>
</div>

<script>
    const labels = <?= $json_labels; ?>;
    const dataJumlah = <?= $json_data; ?>;
    const backgroundColors = [
        'rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)'
    ];

    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataJumlah,
                backgroundColor: backgroundColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 10 } } } },
            animation: { duration: 0 }
        }
    });

    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Arsip',
                data: dataJumlah,
                backgroundColor: 'rgba(25, 135, 84, 0.7)',
                borderColor: 'rgba(25, 135, 84, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10 } } },
                x: { ticks: { font: { size: 10 } } }
            },
            animation: { duration: 0 }
        }
    });

    window.onload = function() {
        setTimeout(function(){ window.print(); }, 1000);
    }
</script>

</body>
</html>