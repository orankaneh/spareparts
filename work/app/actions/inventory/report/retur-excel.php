<?php
include_once "app/lib/common/functions.php";
include 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/pf/obat.php';
set_time_zone();
$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$idSuplier = isset($_GET['idSuplier']) ? $_GET['idSuplier'] : NULL;
$supplier = isset($_GET['suplier']) ? $_GET['suplier'] : NULL;
$nofaktur = isset($_GET['nofaktur']) ? $_GET['nofaktur'] : NULL;
$pegawai = isset($_GET['pegawai']) ? $_GET['pegawai'] : NULL;
$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$retur = retur_muat_data($id = null, $startDate, $endDate, $idSuplier, $idPegawai);
$cp=profile_rumah_sakit_muat_data();
 

$namaFile = "retur_Pembelian.xls";

header_excel($namaFile);
?>
<table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="4" align="center"><strong><font size="+1"><?=$cp['nama']?></font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="4" align="center"><strong><font size="+1">Retur Pembelian</font></strong></td>
      </tr>
     
<tr>
          <td colspan="4">&nbsp;</td>
      </tr>    
</table>
     <table class="tabel">
            <th style="width: 10%">No. Surat</th>
            <th>Tanggal</th>
            <th>Suplier</th>
            <th>Pegawai</th>

            <?$i=1;
            foreach ($retur as $row) {
                ?>
                <tr class="<?= ($i++ % 2) ? 'odd' : 'even' ?>">
                    <td><?= $row['nosurat'] ?></td>
                    <td><?= showWaktuFromMysql($row['waktu']) ?></td>
                    <td><?= $row['suplier'] ?></td>
                    <td><?= $row['pegawai'] ?></td>
               
                <?
            }
            ?>
        </table>
<?
exit();
?>