<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
include_css_excel_report();
header_excel("kelurahan.xls");

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
    $kelurahan = kelurahan_muat_data($code,$order,$key,null,$batas);
    $no_kel    = 1;
?>
  
  <?require_once './app/actions/admisi/lembar-header-excel.php';?> 
  <center>DATA PROVINSI</center>
<div class="data-list">
  <table cellpadding="0" cellspacing="0" class="tabel full">
        <tr>
           <th>NO</th>
            <th>Nama Kelurahan</th>
			<th>Nama Kecamatan</th>
            <th>Kode Wilayah</th>
         
        </tr>
    <?php            foreach ($kelurahan['list'] as $kel)
{
	$kode_wilayah = kode_wilayah($kel['kodeKelurahan'], $kel['id_kecamatan']);
	?>
    <tr class="<?php echo ($no_kel%2) ? "even" : "odd" ?>">
            <td width=15 align="center"><?php echo $no_kel++;?></td>
            <td width=350><?php echo $kel['namaKelurahan']?></td>
            <td width=350><?php echo $kel['namaKecamatan'] ?></td>
            <td><?php echo $kode_wilayah; ?></td>
           
          </tr>
    <?php  } ?>
            
</table>

</div>
<?exit;?>
