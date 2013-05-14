<?php
require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-data.php';

if(isset ($_POST['add']) || isset ($_POST['edit'])){
$idPenduduk = isset ($_POST['id_penduduk'])?$_POST['id_penduduk']:NULL;
$alamat = isset ($_POST['alamat'])?$_POST['alamat']:NULL;
$telpon = isset ($_POST['telp'])?$_POST['telp']:NULL;
$idKelurahan = isset ($_POST['idKel'])?$_POST['idKel']:NULL;
$idPerkawinan = isset ($_POST['idPkw'])?$_POST['idPkw']:NULL;
$pendidikan = isset ($_POST['pendidikan'])?$_POST['pendidikan']:NULL;
$pekerjaan = isset ($_POST['pekerjaan'])?$_POST['pekerjaan']:NULL;
$profesi = isset ($_POST['idProfesi'])?$_POST['idProfesi']:NULL;
$agama = isset ($_POST['agama'])?$_POST['agama']:NULL;

$arr = array('index_',$idKelurahan,$idPerkawinan,$pendidikan,$pekerjaan,$profesi,$agama);
$i=1;
$arr_length = count($arr);
while ($i < ($arr_length+1)) {
        $arr[$i]=trim($arr[$i]);
        if ($arr[$i] == ''){
                $arr[$i] = "NULL";
        }
++$i;
}
}
if (isset($_POST['add'])) {
	_update("update dinamis_penduduk set akhir = 0 where id_penduduk = '$_POST[id_penduduk]'");
	$sql = _insert("insert into dinamis_penduduk values 
	('',now(),'$idPenduduk','$alamat','$telpon',{$arr[1]},{$arr[2]},{$arr[3]},{$arr[5]},{$arr[6]},1,{$arr[4]})");
	
	if ($sql) {
		header("location: ".app_base_url('admisi/detail-pas?pid='.$_GET['pid'].'')."&msg=1");
	}
}

if (isset($_POST['edit'])) {
	$sql = _update("update dinamis_penduduk set tanggal = now(), alamat_jalan = '$alamat', no_telp = '$telpon', id_kelurahan = {$arr[1]}, status_pernikahan = {$arr[2]}, id_pendidikan_terakhir = {$arr[3]}, id_profesi = {$arr[5]}, id_agama = {$arr[6]}, id_pekerjaan={$arr[4]} where id = '$_GET[id]'");
	
	if ($sql) {
		header("location: ".app_base_url('admisi/detail-pas?pid='.$_GET['pid'].'')."&msg=1");
	}
}

if (isset ($_GET['do']) && $_GET['do'] == 'delete') { ?>

<h1 class="judul">Detail Pasien</h1>
<?php
    $penduduk = penduduk_muat_data($_GET['id']);
    $data = $penduduk;
    delete_list_data($_GET['id'], 'dinamis_penduduk', 'admisi/detail-pas?pid='.$_GET['pid'].'&msg=2','admisi/detail-pas?pid='.$_GET['pid'].'&msr=8'," dinamis penduduk ".$data['nama']);
}
?>
