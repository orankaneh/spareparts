<?php
require_once 'app/lib/common/functions.php';
 
 $idPendidikan = isset($_POST['idPendidikan'])?$_POST['idPendidikan']:NULL;
 $nmPendidikan = isset($_POST['pendidikan'])?$_POST['pendidikan']:NULL;
 $idDelete = isset($_GET['id'])?$_GET['id']:NULL;
 
 if(isset($_POST['add'])){
  $sql = "insert into pendidikan values ('','$nmPendidikan')";
  $exe = _insert($sql);  
  $idPendidikan = _last_id();
  if ($exe) {
    header("location: ".app_base_url('admisi/data-pendidikan')."?msg=1&code=".$idPendidikan);
  }
 }
 else if(isset($_POST['edit'])){
  $sql = "update pendidikan set nama = '$nmPendidikan' where id = '$idPendidikan'";  
  $exe = _update($sql);  
  if ($exe) {
    header("location: ".app_base_url('admisi/data-pendidikan')."?msg=1&code=".$idPendidikan);
  }   
 }
 else if($idDelete != NULL){
?>
    <h1 class="judul">Master Data Tingkat Pendidikan</h1>
<?
$sql = "select count(*) as jumlah from dinamis_penduduk where id_pendidikan_terakhir = '$idDelete'";
	$jml = _select_unique_result($sql);
	if ($jml['jumlah'] > 0) {
		header('location:'.  app_base_url('admisi/data-pendidikan').'?msr=14');
	} else {
    delete_list_data($idDelete, 'pendidikan', 'admisi/data-pendidikan?msg=2','admisi/data-pendidikan?msr=7',null,null,null,generate_get_parameter($_GET, null, array('msr','msg','do','id')));
	}
 }
?>
