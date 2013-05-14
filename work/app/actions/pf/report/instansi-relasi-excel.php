<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
include_css_excel_report();
header_excel("instansi-relasi.xls");

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

   require_once 'app/lib/common/functions.php';
include_once 'app/actions/admisi/pesan.php';
require_once 'app/lib/common/master-inventory.php';
$code = isset($_GET['code'])?$_GET['code']:NULL;
$page = isset($_GET['page'])?$_GET['page']:NULL;
$sort = isset ($_GET['sort'])?$_GET['sort']:NULL;
$sortBy = isset ($_GET['sortBy'])?$_GET['sortBy']:NULL;
$key = isset ($_GET['key'])?$_GET['key']:NULL;
$jenis_instansi = jenis_instansi_relasi_muat_data();
$dataPerPage = 10000;
$no=nomer_paging($page,$dataPerPage);
$all=instansi_relasi_muat_data(NULL,NULL,NULL,NULL,NULL,$key);
$instansi = instansi_relasi_muat_data($code,$sort, $sortBy, $page, $dataPerPage, $key);
?>
  
  <?require_once 'app/actions/admisi/lembar-header-excel.php';?> 
  <center>DATA INSTANSI RELASI</center>
<div class="data-list">
  <table cellpadding="0" cellspacing="0" class="tabel full">
        <tr>
         <th>No</th>
          <th>Nama</th>
                <th>Alamat</th>
                <th>Kelurahan</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>No. Fax</th>
                <th>Website</th>
                <th>Jenis</th>
         
        </tr>
     <?php
                       foreach ($instansi['list']  as $num => $row): 

                        
        ?>
          <tr class="<?= ($num%2) ? 'even' : 'odd' ?>">
                <td align="center"><?= $no++ ?></td>
                <td class="no-wrap"><?= $row['nama'] ?></td>
                <td style="width:25%"><?= $row['alamat'] ?></td>
                <td class="no-wrap"><?= $row['nama_kelurahan'] ?></td>
                <td><?= $row['telp']?></td>
                <td class="no-wrap"><?= $row['email']?></td>
                <td><?= $row['fax']?></td>
                <td class="no-wrap"><?= $row['website']?></td>
                <td class="no-wrap"><?= $row['jenis_instansi'] ?></td>
             <?php endforeach; ?>
</table>

</div>
<?exit;?>
