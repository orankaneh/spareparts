<?php
require_once 'app/lib/common/master-data.php';
require_once 'app/lib/common/functions.php';

$act=$_GET['act'];
switch($act) {

case "simpan":
	$kode = $_POST['kode'];
    $nama = $_POST['nama'];
	$id = $_POST['id'];
	
	if (!empty($id)) {
		$check="select * from icd_9 where (nama='".$nama."' or kode='".$kode."') and id <> '".$id."'";
		if (_num_rows($check) !=0) echo 2;
		else {
			$exe = _update("update icd_9 set kode = '".$kode."', nama = '".$nama."' where id = '".$id."'");
			if ($exe) echo 3;
			else echo 404;
		}
	} else {
		$check="select * from icd_9 where nama='".$nama."' or kode='".$kode."'";
		if (_num_rows($check) !=0) echo 2;
		else {
			$exe = _insert("insert INTO icd_9 VALUES ('','$kode','$nama')");
			if ($exe) echo 1;
			else echo 404;
		}
			
	}
break;

case "hapus":
	
    $exe = _delete("delete from icd_9 where id = '".$_POST['id']."'");
    if ($exe) echo 1;
	else echo 404;

break;
}
exit();
?>
