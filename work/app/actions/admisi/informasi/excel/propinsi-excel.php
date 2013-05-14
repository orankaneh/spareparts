<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
include_css_excel_report();
header_excel("pprovinsi.xls");

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

  $code     = null;
    $order    = null;
    $key      = null;
    $batas    = 33;
    $provinsi = propinsi_muat_data($code,$order,$key,null,$batas);
	  $no_prov  = 1;
?>
  
  <?require_once './app/actions/admisi/lembar-header-excel.php';?> 
  <center>DATA PROVINSI</center>
<div class="data-list">
  <table cellpadding="0" cellspacing="0" class="tabel full">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Kode</th>
         
        </tr>
    <?php   foreach ($provinsi['list'] as $prov){
	?>
       <tr class="<?= ($no_prov%2)?"even":"odd"?>">
            <td align="center" style="width: 5%"><?= $no_prov++?></td>
              <td><?= $prov['nama']?></td>
            <td align="center" style="width: 10%"><?= $prov['kode']?></td>
           
          </tr>
    <?php  } ?>
            
</table>

</div>
<?exit;?>
