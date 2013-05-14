<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$startDate = (isset($_GET['startDate'])) ? $_GET['startDate'] : NULL;
$endDate = (isset($_GET['endDate'])) ? $_GET['endDate'] : NULL;
$awal = Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$akhir = Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$idBarang = isset($_GET['idBarang']) ? $_GET['idBarang'] : NULL;
$generik = isset($_GET['generik']) ? $_GET['generik'] : NULL;
$idPembeli = isset($_GET['idPembeli']) ? $_GET['idPembeli'] : NULL;
$penjualanResep = penjualan_resep_muat_data($startDate, $endDate, $idBarang, $generik, $idPembeli);
$namaFile = "penjualan-resep-excel.xls";

// header file excel

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,
        pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

// header untuk nama file
header("Content-Disposition: attachment;
        filename=" . $namaFile . "");

header("Content-Transfer-Encoding: binary ");
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="9" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="9" align="center"><strong><font size="+1">INFORMASI TRANSAKSI PENJUALAN RESEP</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="9" align="center"><strong><font size="+1">PERIODE: <?= indo_tgl(isset($startDate) ? $startDate : $awal) ?> s . d <?= indo_tgl(isset($endDate) ? $endDate : $akhir) ?></font></strong></td>
    </tr>
    <tr>
        <td colspan="9">&nbsp;</td>
    </tr>
</table>
<table border="1">
    <tr>
        <td>No</td>
        <td>Tanggal</td>
        <td>Nama Barang</td>
        <td>Nama Pasien/Pembeli</td>
        <td>No. Resep</td>
        <td>Aturan Pakai</td>
        <td>Jumlah</td>
        <td>Harga Total</td>
        <td>Pegawai</td>
    </tr>
    <?
    $jumlahResep = 0;
    $jumlahR = 0;
    foreach ($penjualanResep as $key => $row) {
        $jumlahTotal = (($row['hna'] * $row['margin']) + $row['hna']) * $row['jumlah_penjualan'];
    ?>
        <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
            <td align="center"><?= ++$key ?></td>
            <td><?= datefmysql($row['tanggal']) ?></td>
            <td class="no-wrap"><?= $row['barang'] ?></td>
            <td class="no-wrap"><?= $row['pembeli'] ?></td>
            <td class="no-wrap"><?= $row['id_resep'] ?></td>
            <td class="no-wrap"><?= $row['aturan_pakai'] ?></td>
            <td class="no-wrap"><?= $row['jumlah_penjualan'] ?></td>
            <td><?= rupiah($jumlahTotal) ?></td>
            <td class="no-wrap"><?= $row['pegawai'] ?></td>
        </tr>
    <?
        $jumlahResep += count($row['no_resep']);
        $detail = detail_resep_muat_data($row['no_resep']);
        foreach ($detail as $rows) {
            $jumlahR += count($rows['no_resep']);
        }
    }
    ?>
    <tr class="even">
        <td colspan="4">Jumlah Resep</td>
        <td><?= $jumlahResep ?></td>
    </tr>
    <tr class="odd">
        <td colspan="4">Jumlah /R</td>
        <td><?= $jumlahR ?></td>
    </tr>
</table>    
<?
    exit();
?>
