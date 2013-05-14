<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();
$startDate = (isset($_GET['startDate'])) ? get_value('startDate') : date("d/m/Y");
$endDate = (isset($_GET['endDate'])) ? get_value('endDate') : date("d/m/Y");
$barang = isset ($_GET['barang'])?$_GET['barang']:NULL;
$gudang = isset ($_GET['gudang'])?$_GET['gudang']:NULL;
$idBarang = isset ($_GET['idBarang'])?$_GET['idBarang']:NULL;
 $cp=profile_rumah_sakit_muat_data();

$namaFile = "stok-barang-gudang.xls";

header_excel($namaFile);
?>
<table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="7" align="center"><strong><font size="+1"><?=$cp['nama']?></font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="7" align="center"><strong><font size="+1">INFORMASI STOK  OPNAME GUDANG</font></strong></td>
      </tr>
     
      <tr>
          <td colspan="9">&nbsp;</td>
      </tr>    
</table>
   <table cellpadding="0" cellspacing="0" border="0" id="table" class="tabel" style="width: 80%">
        <tr>
<!--            <th style="width:5%">No</th>-->
            <th style="width:20%">Waktu</th>
            <th>Nama Barang</th>
               <? if ($gudang == 1) {
			   ?>
                <th>No. Batch</th>
                 <th>E.D</th>
                 <?
				 }
				 ?>

            <th>Harga Beli(RP.)</th>
            <th>Harga Jual(RP.)</th>
            <th style="width:10%">Stok Akhir</th>
        </tr>
<?
  if ($gudang == 1) {
                $stok = info_stock_opname_gudang_muat_data($idBarang, $startDate, $endDate);
            }
            else{
                $stok = info_stock_opname_muat_data($idBarang, $startDate, $endDate);
            }
           foreach ($stok as $key => $row){
           
           $nama=nama_packing_barang(array($row['generik'],$row['barang'],$row['kekuatan'],$row['sediaan'],$row['nilai_konversi'],$row['satuan'],$row['pabrik']));
        ?>
          <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
<!--              <td align="center"><?= ++$key?></td>-->
              <td align="center" class="no-wrap"><?= $row['waktu']?></td>
              <td class="no-wrap"><?=$nama?></td>
               <? if ($gudang == 1) {
			  echo "<td align='center'>".$row['batch']."</td>";
              echo "<td align='center'>".datefmysql($row['ed'])."</td>";
             
              
				 }
				 ?>
              <td align="right"><?= rupiah($row['hpp'])?></td>
              <td align="right"><?= rupiah($row['hna'])?></td>
              <td align="right"><?= rupiah($row['sisa'])?></td>
          </tr>
        <?
      }
        ?>
    </table>
<?
exit();
?>