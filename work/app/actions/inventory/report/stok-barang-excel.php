<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$unit = isset ($_GET['unit'])?$_GET['unit']:NULL;
$packing = isset ($_GET['packing'])?$_GET['packing']:NULL;
$jenisTransaksi = isset ($_GET['jenisTransaksi'])?$_GET['jenisTransaksi']:NULL;
$stok = stok_barang_muat_data($startDate,$endDate,$unit,$packing,$jenisTransaksi);

$namaFile = "stok-barang.xls";

header_excel($namaFile);
?>
<table border="0">
      <tr bgcolor="#cccccc">
          <td colspan="11" align="center"><strong><font size="+1">RS. PKU MUHAMMADYAH TEMANGGUNG</font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="11" align="center"><strong><font size="+1">INFORMASI STOK BARANG</font></strong></td>
      </tr>
      <tr bgcolor="#cccccc">
          <td colspan="11" align="center"><strong><font size="+1">PERIODE: <?= indo_tgl($startDate)?> s . d <?= indo_tgl($endDate)?></font></strong></td>
      </tr>
      <tr>
          <td colspan="11">&nbsp;</td>
      </tr>    
</table>
<table border="1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Transaksi</th>
            <th>Unit</th>
            <th>Stok Awal</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Sisa</th>
            <th>Satuan</th>
            <th>ROP</th>
        </tr>
        <?foreach($stok as $key => $rows): ?>
        <tr class="<?= ($key%2) ? 'odd': 'even' ?>">
            <td align="center"><?= ++$key ?></td>
            <td><?= datefmysql($rows['tanggal']) ?></td>
            <td class="no-wrap"><?= $rows['barang'] ?></td>
            <td class="no-wrap"><?= $rows['jenis_transaksi'] ?></td>
            <td class="no-wrap"><?= $rows['unit'] ?></td>
            <td><?= $rows['awal']?></td>
            <td><?= $rows['masuk']?></td>
            <td><?= $rows['keluar']?></td>
            <td><?= $rows['sisa']?></td>
            <td><?= $rows['satuan'] ?></td>
            <td><?= $rows['rop']?></td>
        </tr>
       <?php endforeach; ?>
</table>        
<?
exit();
?>