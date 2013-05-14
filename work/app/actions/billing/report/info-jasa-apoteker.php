<?php
require_once 'app/lib/common/master-data.php';
$startDate  = $_GET['startDate'];
$endDate    = $_GET['endDate'];
$startDateMysql = date2mysql($startDate);
$endDateMysql = date2mysql($endDate);
header_excel("info-keuangan-apoteker.xls");
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="6" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="6" align="center"><strong><font size="+1">PENERIMAAN JASA APOTEKER <?= strtoupper($_GET['nakes']) ?> TERHITUNG SEJAK TANGGAL <?= $startDate ?> HINGGA <?= $endDate ?></font></strong></td>
    </tr>
    <tr>
        <td colspan="6">&nbsp;</td>
    </tr>
</table>
<table style="width: 60%" cellspacing=0 border="1">
    <tr>
        <th style="width: 5%">No</th>
        <th style="width: 25%">NORM</th>
        <th style="width: 25%">Pasien</th>
        <th style="width: 15%">Konsultasi (Rp)</th>
        <th style="width: 15%">Pelayanan Resep (Rp)</th>
        <th style="width: 15%">Nilai Total (Rp)</th>
    </tr>
    <?php
    $jasa = jasa_apoteker_muat_data($_GET['idnakes'], $startDateMysql, $endDateMysql);
    $i = 1;
    $totalKonsultasi = 0;
    $totalLayananResep = 0;
    foreach ($jasa as $row) {
        ?>
        <tr>
            <td style="width: 5%"><?= $i++ ?></td>
            <td style="width: 25%"><?= $row['norm'] ?></td>
            <td style="width: 25%"><?= $row['nama'] ?></td>
            <td style="width: 15%" align="right"><?= rupiah($row['konsultasi']) ?></td>
            <td style="width: 15%" align="right"><?= rupiah($row['layanan_resep']) ?></td>
            <td style="width: 15%" align="right"><?= rupiah($row['layanan_resep'] + $row['konsultasi']) ?></td>
        </tr>
        <?
        $totalKonsultasi+=$row['konsultasi'];
        $totalLayananResep+=$row['layanan_resep'];
    }
    ?>
    <tr>
        <td colspan="3" align="center">TOTAL</td>
        <td style="width: 15%" align="right"><?= rupiah($totalKonsultasi) ?></td>
        <td style="width: 15%" align="right"><?= rupiah($totalLayananResep) ?></td>
        <td style="width: 15%" align="right"><?= rupiah($totalKonsultasi + $totalLayananResep) ?></td>
    </tr>
</table>
<?php
exit;
?>