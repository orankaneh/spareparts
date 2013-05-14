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

?>
<html>
  <head>
     <title>Stok Barang</title> 
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css')?>">
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
  </head>  
  <body>
    <?require_once 'app/actions/admisi/lembar-header.php';?> 
  <center>INFORMASI STOK BARANG <BR /> PERIODE: <?= indo_tgl($startDate)?> s . d <?= indo_tgl($endDate)?></center>
  <div class="data-list">
      <table class="table-cetak">
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
            <td><?= hitung_rop($rows['id_packing_barang'])?></td>
        </tr>
       <?php endforeach; ?>
    </table>
    </div>
    <center>
      <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
    </center>
  </body>
</html>  
<?php
exit();
?>
