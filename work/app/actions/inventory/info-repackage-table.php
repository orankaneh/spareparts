<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/actions/admisi/pesan.php';
set_time_zone();

$startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
$endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
$idBarang = isset ($_GET['idBarang'])?$_GET['idBarang']:NULL;
?>
<table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width: 80%">
    <tr>
        <th style="width:5%">No</th>
        <th style="width:20%">Waktu</th>
        <th>Nama Barang</th>
        <th>No. Batch</th>
        <th>E.D</th>
        <th>HPP(RP.)</th>
        <th>HNA(RP.)</th>
        <th style="width:10%">Stok Akhir</th>
    </tr>
    <?php
      $stok = info_repackage_muat_data($idBarang,$startDate,$endDate);
      foreach ($stok as $key => $row){
    ?>
      <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
         <td align="center"><?= ++$key?></td>
         <td align="center" class="no-wrap"><?= $row['waktu']?></td>
         <td class="no-wrap"><?= $row['barang']." ".$row['nilai_konversi']." ".$row['satuan']?></td>
         <td align="center"><?= $row['batch']?></td>
         <td align="center"><?= datefmysql($row['ed'])?></td>
         <td align="right"><?= rupiah($row['hpp'])?></td>
         <td align="right"><?= rupiah($row['hna'])?></td>
         <td align="right"><?= rupiah($row['sisa'])?></td>
      </tr>   
    <?
      }
    ?>
</table>
<?php
exit();
?>