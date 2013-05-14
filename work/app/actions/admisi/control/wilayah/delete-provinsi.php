<?php
require_once 'app/lib/common/master-data.php';
$idDelete = isset($_GET['id']) ? $_GET['id'] : NULL;
$provinsi = propinsi_muat_data($idDelete);
if(isset ($_GET['id'])){
?>
  <h1 class="judul">Master Data Wilayah</h1>
<?php
  delete_list_data($idDelete, 'provinsi', 'admisi/data-wilayah2?msg=2&tab=prov','admisi/data-wilayah2?msr=7&tab=prov' ,"Provinsi ".$provinsi['nama']);
}
?>
