<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();

$sort=(isset($_GET['sort']))?$_GET['sort']:null;
$by=(isset($_GET['by']))?$_GET['by']:'asc';
$category = (isset($_GET['kategori']))?$_GET['kategori']:NULL;
$key = (isset($_GET['key']))?$_GET['key']:NULL;
$id= (isset($_GET['id']))?$_GET['id']:NULL;
$startDate=(isset($_GET['startDate']))? $_GET['startDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));
$endDate=(isset($_GET['endDate']))? $_GET['endDate']:Date('d').'/'.Date('m').'/'.(2000+Date('y'));

?>
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
<?php
set_time_zone();

//membuat link sorting
if($sort=='k.waktu' && $by=='DESC')
    $waktu=app_base_url('admisi/informasi-pengirim?startDate='.$startDate.'&endDate='.$endDate.'&sort=k.waktu&by=ASC&tampil=Display');
else
    $waktu=app_base_url('admisi/informasi-pengirim?startDate='.$startDate.'&endDate='.$endDate.'&sort=k.waktu&by=DESC&tampil=Display');

if($sort=='pg.nama' && $by=='DESC')
    $nama=app_base_url('admisi/informasi-pengirim?startDate='.$startDate.'&endDate='.$endDate.'&sort=pg.nama&by=ASC&tampil=Display');
else
    $nama=app_base_url('admisi/informasi-pengirim?startDate='.$startDate.'&endDate='.$endDate.'&sort=pg.nama&by=DESC&tampil=Display');



$startDate=date2mysql($startDate);
$endDate=date2mysql($endDate);
if($sort==null){

    $kunjungan = pengirim_muat_data($startDate,$endDate,$id);
}
else{

    $kunjungan = pengirim_muat_data($startDate,$endDate,$id,$sort,$by);
	//show_array($kunjungan);
}
?>
   <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css')?>">
  <?require_once 'app/actions/admisi/lembar-header.php';?> 
  <center>INFORMASI PENGIRIM KUNJUNGAN <BR /> PERIODE: <?= datefmysql($startDate)?> s . d <?= datefmysql($endDate)?></center>
<div class="data-list">
<table width="100%" class="tabel">
		
    <tr>
       <th width="20">No</th>
        <th width="85">Nama pengirim</th>
        <th width="35">Total</th>
    </tr>
    <?php foreach($kunjungan as $num => $row):
	?>
      <tr class="<?= ($key%2) ? 'even':'odd' ?>">
         <td align="center"><?= ++$num ?></td>
	<td align="center"><?= $row['pengantar']?></td>
       <td align="center"><?= $row['total']?></td>
    </tr>
    <?php  endforeach; ?>
            
</table>
<center>
    <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
  </center>
</div>
<?exit;?>
