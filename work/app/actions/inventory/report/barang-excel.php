<?
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';
require_once 'app/config/db.php';
set_time_zone();
include_css_excel_report();
header_excel("barang.xls");

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

    require_once 'app/lib/pf/satuan.php';

$category = isset($_GET['category']) ? $_GET['category'] : NULL;
$key = isset($_GET['key']) ? $_GET['key'] : NULL;
$code = isset($_GET['code']) ? $_GET['code'] : NULL;
$page = isset($_GET['page']) ? $_GET['page'] : NULL;
$sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : NULL;
$barangs = barang_muat_data($code, $sort, $sortBy, $page, $dataPerPage = 10000, $key, $category);
$no=nomer_paging($page,$dataPerPage);
$barangTotal = barang_muat_data(NULL, NULL, NULL, NULL, NULL, $key, $category);
$kategori = sub_kategori_barang_muat_data();
 $barang=array();
    $idBarang = array_value($barang, "id");
    $namaBarang = array_value($barang, "nama");
    $idKategori = array_value($barang, "id_sub_kategori_barang");
    $pabrik = array_value($barang, "pabrik");
    $idPabrik = array_value($barang, "idPabrik");
?>
  
  <?require_once 'app/actions/admisi/lembar-header-excel.php';?> 
  <center>DATA BARANG</center>
<div class="data-list">
  <table cellpadding="0" cellspacing="0" class="tabel full">
        <tr>
            <th><!--<a href="<?//= app_base_url('inventory/barang?') . generate_sort_parameter(0, $sortBy) ?>" class='sorting'></a>-->NO</th>
            <th style="width: 35%;">Nama</th>
            <th style="width: 35%;">Pabrik</th>
            <th style="width: 25%;">Sub Kategori</th>
         
        </tr>
     <?php
                        foreach ($barangs['list'] as $key => $row):

                            if (($row['generik'] == 'Generik') || ($row['generik'] == 'Non Generik')) {
                                $nama = ($row['kekuatan']!=0)?"$row[nama] $row[kekuatan], $row[sediaan]":"$row[nama] $row[sediaan]";
                                $nama.=($row['generik'] == 'Generik')?' '. $row['pabrik']:'';
                            } else {
                                $nama = "$row[nama]";
                            }
        ?>
         <tr class="<?= ($key % 2) ? 'even' : 'odd' ?>">
                                <td align="center"><?= ($no++) ?></td>
                                <td class="no-wrap"><?= $nama ?></td>
                                <td class="no-wrap"><?= $row['pabrik'] ?></td>
                                <td><?= $row['kategori'] ?></td>
                                 </tr>
             <?php endforeach; ?>
</table>

</div>
<?exit;?>
