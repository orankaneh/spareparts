<?php
require_once 'app/lib/common/functions.php';
 $idPekerjaan = isset($_POST['idPekerjaan'])?$_POST['idPekerjaan']:NULL;
 $nmPekerjaan = isset($_POST['pekerjaan'])?$_POST['pekerjaan']:NULL;
 $idDelete = isset($_GET['id'])?$_GET['id']:NULL;
 if(isset($_POST['add'])){
  $sql = "insert into pekerjaan values ('','$nmPekerjaan')";
  $exe = _insert($sql);
  	$id = _last_id();
  if ($exe) {
    header("location: ".app_base_url('admisi/data-pekerjaan')."?msg=1&code=".$id);
  }
 } else if(isset($_POST['edit'])){
  $sql = "update pekerjaan set nama = '$nmPekerjaan' where id = '$idPekerjaan'";  
  $exe = _update($sql);  
  if ($exe) {
    header("location: ".app_base_url('admisi/data-pekerjaan')."?msg=1&code=".$idPekerjaan);
  }   
 }else if($idDelete != NULL){
?>
    <h1 class="judul">Master Data Pekerjaan</h1>
<?
$sql = "select count(*) as jumlah from dinamis_penduduk where id_pekerjaan = '$idDelete'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('admisi/data-pekerjaan').'?msr=14'."&".  generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	} 
    delete_list_data($idDelete, 'pekerjaan', 'admisi/data-pekerjaan?msg=2','admisi/data-pekerjaan?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
 }
?>