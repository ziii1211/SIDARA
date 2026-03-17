<!DOCTYPE html>
<html>

<head>
    <title>Cetak Laporan</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            padding: 20px;
        }

        .kop-surat {
            border-bottom: 4px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .kop-logo {
            width: 90px;
            height: auto;
            position: absolute;
            left: 20px;
        }

        .kop-text {
            text-align: center;
            width: 100%;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .kop-text h2 {
            margin: 5px 0;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 13px;
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
            text-align: left;
        }

        th {
            background-color: #e0e0e0;
            text-align: center;
        }

        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: bold;
        }

        .ttd-box {
            float: right;
            margin-top: 50px;
            text-align: center;
            width: 250px;
        }

        .ttd-box p {
            margin-bottom: 70px;
        }

        @media print {
            @page {
                margin: 2cm;
                size: auto;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="kop-surat">
        <img src="/sidara/img/kjn.webp" class="kop-logo" alt="Logo">
        <div class="kop-text">
            <h3>KEJAKSAAN REPUBLIK INDONESIA</h3>
            <h2>KEJAKSAAN NEGERI BANJARMASIN</h2>
            <p>Jl. Brig Jend. Hasan Basri No. 6, Pangeran, Kec. Banjarmasin Utara</p>
            <p>Kota Banjarmasin, Kalimantan Selatan 70124</p>
            <p>Telp: (0511) 3300000 | Email: kn.banjarmasin@kejaksaan.go.id</p>
        </div>
    </div>