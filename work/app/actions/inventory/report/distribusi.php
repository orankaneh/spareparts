<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';
set_time_zone();

$startDate = (isset($_GET['awal'])) ? $_GET['awal'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$endDate = (isset($_GET['akhir'])) ? $_GET['akhir'] : Date('d') . '/' . Date('m') . '/' . (2000 + Date('y'));
$idPegawai = isset($_GET['idPegawai']) ? $_GET['idPegawai'] : NULL;
$pegawai = isset($_GET['pegawai']) && ($idPegawai != null) ? $_GET['pegawai'] : NULL;
$idUnit = get_value('unit');
$distribusi = distribusi_muat_data($startDate, $endDate, $idPegawai, $idUnit);
$namaFile = "distribusi-report.xls";
 $cp=profile_rumah_sakit_muat_data();
// header file excel

//header_excel($namaFile);
?>
  <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/base.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/style.css')?>">
     <link rel="stylesheet" type="text/css" href="<?= app_base_url('/assets/css/workspace.css')?>">
    <?require_once 'app/actions/admisi/lembar-header.php';?> 
  <center>INFORMASI DISTRIBUSI <BR /> PERIODE: <?= indo_tgl(isset ($startDate)?$startDate:$awal)?> s . d <?= indo_tgl(isset ($endDate)?$endDate:$akhir)?></center>
    <div class="data-list">
<table class="tabel">
    <tr>
        <th>No</th>
        <th>No. Distribusi</th>
        <th>Tanggal</th>
        <th>Unit Tujuan</th>
        <th>Pegawai</th>
    </tr>
<?php foreach ($distribusi as $key => $row) {
?>
    <tr class="<?= ($key % 2) ? 'odd' : 'even' ?>">
        <td align="center"><?= ++$key ?></td>
        <td><?= $row['id_distribusi'] ?></td>
        <td><?= datefmysql($row['tanggal']) ?></td>
        <td class="no-wrap"><?= $row['unit_tujuan'] ?></td>
        <td><?= $row['nama_pegawai'] ?></td>
    </tr>
<?php } ?>
</table>
</div>
 <center>
      <p><span id="SCETAK"><input type="button" class="button" value="Cetak" onClick="cetak()"/></span></p>
    </center>
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
<?exit;?>