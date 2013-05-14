<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
include_css_excel_report();
header_excel("kabupaten.xls");

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

     $code      = null;
    $order     = null;
    $key       = null;
    $batas     = 1000;
    $kabupaten = kabupaten_muat_data($code,$order,$key,null,$batas);
    $no_kab    = 1;
?>
  
  <?require_once './app/actions/admisi/lembar-header-excel.php';?> 
  <center>DATA PROVINSI</center>
<div class="data-list">
  <table cellpadding="0" cellspacing="0" class="tabel full">
        <tr>
            <th>NO</th>
            <th>Nama Kabupaten</th>
            <th>Nama Provinsi</th>
         
        </tr>
    <?php      foreach ($kabupaten['list'] as $kab){
	?>
    <tr class="<?php echo ($no_kab%2) ? "even" : "odd" ?>">
            <td width="10" align="center"><?php echo $no_kab++;?></td>
            <td width="350"><?php echo $kab['namaKabupaten']?></td>
            <td width="350"><?php echo $kab['namaProvinsi'] ?></td>
           
          </tr>
    <?php  } ?>
            
</table>

</div>
<?exit;?>
