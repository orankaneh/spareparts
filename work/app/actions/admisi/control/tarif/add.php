<?php
require_once 'app/lib/common/master-data.php';
/*$sql = "insert  into tarif (tanggal,id_layanan,id_kelas,harga_umum,bia_bhp,profit,harga,bagian_nakes,bagian_rs)
VALUES
('".date2mysql($_POST['tanggal'])."','$_POST[idLayanan]',$_POST[kelas],$_POST[harga_umum],$_POST[biaya_bhp],
$_POST[profit],$_POST[harga],$_POST[bagian_nakes],$_POST[bagian_rs])";*/
if(isset ($_POST['add'])){
//show_array($_POST);
if($_POST['kelas']=='10'){
	$kelas = kelas_instalasi_muat_data();
	  foreach ($kelas as $row) {
		if ($row['id']!='10'){
	  $sql = "insert  into tarif (id_layanan,id_kelas)
VALUES
($_POST[idLayanan],$row[id])";
$exe = _insert($sql);
		}
	  }
	
}
else{
$sql = "insert  into tarif (id_layanan,id_kelas)
VALUES
($_POST[idLayanan],$_POST[kelas])";
$exe = _insert($sql);
}
$id = _last_id();
if ($exe) {
    header("location: ".app_base_url('admisi/data-tarif')."?msg=1&id=$id");
	
}
}