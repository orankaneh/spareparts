<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$namaFile = "info-keuangan-ambulance.xls";

// header file excel

header_excel($namaFile);
?>
<table border="0">
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">PENERIMAAN JASA KESELURUHAN AMBULANCE</font></strong></td>
    </tr>
    <tr bgcolor="#cccccc">
        <td colspan="10" align="center"><strong><font size="+1">PERIODE: <?= indo_tgl(isset($startDate) ? $startDate : $startDate) ?> s . d <?= indo_tgl(isset($endDate) ? $endDate : $endDate) ?></font></strong></td>
    </tr>
    <tr>
        <td colspan="10">&nbsp;</td>
    </tr>
</table>
<table border="1" class="tabel">
    <th>No</th>
    <th>Tanggal</th>
    <th>No. RM</th>
    <th>Nama Pasien</th>
    <th>Layanan</th>
    <th>Frekuensi / Km</th>
    <th>Nakes 1</th>
    <th>Nakes 2</th>
    <th>Nakes 3</th>
    <th>Nilai Total (Rp)</th>
    <?
          $ambulance = info_keuangan_ambulance($startDate, $endDate);
          $totalAll = 0;
          foreach ($ambulance as $no => $row){
       ?>
        <tr class="<?= ($no%2)?"even":"odd";?>">
            <td align="center" style="width: 5%"><?= ++$no?></td>
            <td style="width: 8%"><?= datefmysql($row['tanggal'])?></td>
            <td style="width: 8%"><?= $row['id_pasien']?></td>
            <td><?= $row['nama']?></td>
            <td><?= $row['layanan']?></td>
            <td style="width: 8%"><?= $row['frekuensi']?></td>
            <td><?= $row['nakes1']?></td>
            <td><?= $row['nakes2']?></td>
            <td><?= $row['nakes3']?></td>
            <td align="right" style="width: 10%">
              <?
                 $subtotal = $row['frekuensi']*$row['total'];
                 echo "Rp. ".rupiah($subtotal)."";
              ?>
            </td>
        </tr>
       <? 
          $totalAll = $totalAll+$subtotal;
          }
        ?>
        <tr>
            <td colspan="9" align="right">Total</td>
            <td align="right"><?= "Rp. ".rupiah($totalAll);?></td>
        </tr>
</table>
<?
exit();
?>