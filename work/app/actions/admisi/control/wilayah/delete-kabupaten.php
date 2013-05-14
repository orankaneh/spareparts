<?php
require_once 'app/lib/common/master-data.php';
$idDelete = isset($_GET['id']) ? $_GET['id'] : NULL;
$kabupaten = kabupaten_muat_data($idDelete);
if(isset ($_GET['id'])){
?>
  <h1 class="judul">Master Data Wilayah</h1>
<?php
  delete_list_data($idDelete, 'kabupaten', 'admisi/data-wilayah2?msg=2&tab=kab','admisi/data-wilayah2?msr=7&tab=kab' ,"Kabupaten ".$kabupaten['namaKabupaten']);
}
?>
