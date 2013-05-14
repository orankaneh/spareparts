<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
include_css_excel_report();
header_excel("kecamatan.xls");

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
    $kecamatan = kecamatan_muat_data($code,$order,$key,null,$batas);
    $no_kec    = 1;
?>
  
  <?require_once './app/actions/admisi/lembar-header-excel.php';?> 
  <center>DATA PROVINSI</center>
<div class="data-list">
  <table cellpadding="0" cellspacing="0" class="tabel full">
        <tr>
             <th>NO</th>
            <th>Nama Kecamatan</th>
			<th>Nama Kabupaten</th>
         
        </tr>
    <?php      foreach ($kecamatan['list'] as $kec){
	?>
    <tr class="<?php echo ($no_kec%2) ? "even" : "odd" ?>">
            <td width=12 align="center"><?php echo $no_kec++;?></td>
            <td width=300><?php echo $kec['namaKecamatan']?></td>
            <td width=350><?php echo $kec['namaKabupaten'] ?></td>
           
          </tr>
    <?php  } ?>
            
</table>

</div>
<?exit;?>
