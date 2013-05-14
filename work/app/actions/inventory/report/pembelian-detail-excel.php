<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$startDate=(isset($_GET['id']))? $_GET['id']:NULL;
 $detail = detail_pembelian_muat_data($_GET['id']);
$rs = profile_rumah_sakit_muat_data();
header_excel("info-detail-pembelian.xls");

// header file excel


?>
<table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="8" align="center"><strong><font size="+1"><?= $rs['nama'] ?></font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="8" align="center"><strong><font size="+1">INFORMASI DETAIL PEMBELIAN</font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="8" align="center"><strong><font size="+1">No. Surat: <?=$_GET['no']?></font></strong></td>
      </tr>
      <tr>
          <td colspan="8">&nbsp;</td>
      </tr>    
  </table>
     <table border="1">
                <tr>
                    <th >No</th>
                    <th style="width: 10%">Nama Packing Barang</th>
                    <th style="width: 10%">No Batch</th>
                    <th style="width: 10%">Jumlah Pembelian</th>
                    <th style="width: 10%">Harga@</th>
                    <th style="width: 10%">Sub Total</th>
                    <th style="width: 10%">Diskon (%)</th>
                    <th style="width: 10%">Nilai Diskon (Rp.)</th>
                </tr>
                <?php
                foreach ($detail as $num => $rows) {
                    $class = ($num % 2) ? 'even' : 'odd';
                    $style = "class='$class'";
                 $nama=nama_packing_barang(array($rows['generik'],$rows['nama'],$rows['kekuatan'],$rows['sediaan'],$rows['nilai_konversi'],$rows['satuan_terkecil'],$rows['pabrik']));
                    $subtotal=$rows['jumlah_pembelian']*$rows['harga_pembelian'];
                    ?>
                    <tr <?= $style ?>>
                        <td align="center"><?= ++$num ?></td>
                        <td class="no-wrap"><?= $nama ?></td>
                        <td align="center"><?= $rows['batch'] ?></td>
                        <td align="center"><?= ($rows['jumlah_pembelian']) ?></td>
                        <td class="no-wrap" align="right"><?= rupiah($rows['harga_pembelian']) ?></td>
                        <td align="right"><?= rupiah($subtotal) ?></td>
                        <td align="center"><?= $rows['diskon'] ?></td>
                        <td align="right"><?= rupiah(($subtotal*$rows['diskon'])/100) ?></td>
                    </tr>                
                    <?php
                }
                ?>
            </table>
<?
exit();
?>