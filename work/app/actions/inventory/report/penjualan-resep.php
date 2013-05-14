<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$startDate = (isset($_GET['startDate'])) ? $_GET['startDate'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['endDate'])) ? $_GET['endDate'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$idPasien = isset($_GET['idPasien']) ? $_GET['idPasien'] : NULL;
$idDokter = isset($_GET['idDokter']) ? $_GET['idDokter'] : NULL;

$resep = resep_muat_data($startDate, $endDate, $idDokter, $idPasien);
?>
<html>
    <head>
        <title>Laporan Transaksi Penjualan Resep</title>
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css') ?>">
        <script language='JavaScript'>
            function cetak() {
                SCETAK.innerHTML = '';
                window.print();
                if (confirm('Apakah menu print ini akan ditutup?')) {
                    window.close();
                }
                SCETAK.innerHTML = '<br /><input onClick=\'cetak()\' type=\'submit\' name=\'Submit\' value=\'Cetak\' class=\'tombol\'>';
            }
  
        </script>
    </head>
    <body>
        <? require_once 'app/actions/admisi/lembar-header.php'; ?>
        <center>INFORMASI TRANSAKSI PENJUALAN RESEP <BR /> PERIODE: <?= indo_tgl($startDate) ?> s . d <?= indo_tgl($endDate) ?></center>
        <div class="data-list">
            <table class="tabel">
                <tr>
                    <th>No</th>
                    <th>No. resep</th>
                    <th>Tanggal</th>
                    <th>Dokter</th>
                    <th>Pasien</th>
                </tr>
                <tr>
                    <?php
                    $jumlahResep = 0;
                    $jumlahR = 0;
                    foreach ($resep as $key => $row) {
                    ?>
                    <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                        <td align="center"><?= ++$key ?></td>
                        <td><?= $row['no_resep'] ?></td>
                        <td><?= datefmysql($row['tanggal']) ?></td>
                        <td class="no-wrap"><?= $row['nama_dokter'] ?></td>
                        <td class="no-wrap"><?= $row['nama_pasien'] ?></td>
                    </tr>
                <?php
                        $jumlahResep += count($row['no_resep']);
                        $detail = detail_resep_muat_data($row['no_resep']);
                        foreach ($detail as $rows) {
                            $jumlahR += count($rows['no_resep']);
                        }
                    } ?>
                    <tr class="even">
                        <td colspan="4">Jumlah Resep</td>
                        <td><?= $jumlahResep ?></td>
                    </tr>
                    <tr class="odd">
                        <td colspan="4">Jumlah /R</td>
                        <td><?= $jumlahR ?></td>
                    </tr>
                </table>
            </div>
            <center>
                <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
            </center>
        </body>
    </html>
<?
                    exit();
?>