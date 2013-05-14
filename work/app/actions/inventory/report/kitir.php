<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$penjualan=  penjualan_report_muat_data($_GET['id']);
$master=$penjualan['master'];
$detail=$penjualan['detail'];
?>
<html>
    <head>
        <title>Kitir</title>
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>">
        <script type="text/javascript">
            function cetak() {
                SCETAK.innerHTML = '';
                window.print();
                if (confirm('Apakah menu print ini akan ditutup?')) {
                    window.close();
                }
                SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
            }

        </script>
        <style type="text/css">
            body{
                font-family: arial;
                font-size: 11px;
                color: #000000;
            }
        </style>
    </head>
    <body>
<? require_once 'app/actions/admisi/lembar-header.php'; ?>
        <center>KITIR</center>
        <div>
            <table width="500">
                <tr>
                    <td width="200">Nomor Penjualan</td>
                    <td><?=$master['no_penjualan']?></td>
                </tr>
                <tr>
                    <td>Nama Pembeli</td>
                    <td><?=$master['pembeli']?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td><?=  datefmysql($master['tanggal'])?></td>
                </tr>
            </table>
        </div>

        <div class="data-list">
            <table class="table-cetak">
                <tr>
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Diskon (%)</th>
                    <th>SubTotal</th>
                </tr>
<?
    $jumlah=0;
    foreach ($detail as $key => $rows): ?>
                <tr>
                    <td align="center"><?= ++$key ?></td>
                    <td><?= $rows['barang'] ?></td>
                    <td><?= $rows['jumlah_penjualan'] ?></td>
                    <td><?= $rows['harga'] ?></td>
                    <td><?= $rows['diskon'] ?></td>
                    <td><?= ($rows['jumlah_penjualan']*$rows['harga'])-(($rows['jumlah_penjualan']*$rows['harga'])*$rows['diskon']/100) ?></td>
                </tr>
                <?$jumlah+=($rows['jumlah_penjualan']*$rows['harga'])-(($rows['jumlah_penjualan']*$rows['harga'])*$rows['diskon']/100);?>
<?php endforeach; ?>
            </table>
        </div>
        <div class="display-blok">
            <table width="500" align="right">
                <tr>
                    <td width="200">Total</td>
                    <td><?=$jumlah?></td>
                </tr>
                <tr>
                    <td>Diskon</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>
                    <td>Bayar</td>
                    <td></td>
                </tr>
            </table>
        </div>
        <div  class="display-blok">
            <table width="500" align="right">
                <tr>
                    <td align="right">Petugas</td>
                </tr>
                <tr>
                    <td height="30">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right"><b><?=$master['petugas']?></b></td>
                </tr>
            </table>
        </div>
        <div class="data-input">
            <center>
                <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
            </center>
        </div>
    </body>
</html>
<?php
                exit();
?>
