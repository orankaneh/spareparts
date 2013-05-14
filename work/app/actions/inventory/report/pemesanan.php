<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
require_once 'app/config/db.php';
set_time_zone();

$startDate=(isset($_GET['startDate']))? $_GET['startDate']:NULL;
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:NULL;
$awal = Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$akhir = Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$idSuplier = isset ($_GET['idsuplier'])?$_GET['idsuplier']:NULL;
$idBarang = isset ($_GET['idbarang'])?$_GET['idbarang']:NULL;
$sp = sp_muat_data($startDate,$endDate,$idBarang,$idSuplier);
?>
<html>
  <head>
     <title>Laporan Pemesanan</title> 
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/tabel.css')?>">
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
    <?require_once 'app/actions/admisi/lembar-header.php';?> 
  <center>INFORMASI PEMESANAN <BR /> PERIODE: <?= indo_tgl(isset ($startDate)?$startDate:$awal)?> s . d <?= indo_tgl(isset ($endDate)?$endDate:$akhir)?></center>
  <div class="data-list">
      <table class="tabel">
        <tr>
            <th>No</th>
            <th>No. SP</th>
            <th>Tanggal</th>
            <th>Nama Suplier</th>
            <th>No. Faktur</th>
        </tr>
        <?php foreach ($sp as $key => $row) {
           ?>
        <tr class="<?= ($key%2) ? 'odd':'even' ?>">
            <td align="center"><?= ++$key ?></td>
            <td><?= $row['id']?></td>
            <td><?= $row['waktu']?></td>
            <td><?= $row['suplier']?></td>
            <td><?= $row['no_faktur']?></td>
            </tr>
        <?php } ?>
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