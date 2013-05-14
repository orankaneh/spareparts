<?php
require_once 'app/lib/common/functions.php';

$idAgama = isset($_POST['idagama']) ? $_POST['idagama'] : NULL;
$nmAgama = isset($_POST['namaagama']) ? ucwords($_POST['namaagama']) : NULL;
$idDelete = isset($_POST['id']) ? $_POST['id'] : NULL;

switch($_GET['sub']) {

	case "simpanagama":
	
	if (!empty($idAgama)) {
		$sql = "select * from agama where nama='".$nmAgama."' and id <> '".$idAgama."'";
		if (_num_rows($sql) > 0) {
			echo 2;
		} else {
			$exe = _update("update agama set nama = '$nmAgama' where id = '$idAgama'");
			if ($exe) echo 3;
			else echo 404;
		}
	} else {
		$sql = "select * from agama where nama='".$nmAgama."'";
		if (_num_rows($sql) > 0) {
			echo 2;
		} else {
			$exe = _insert("insert into agama values ('','$nmAgama')");
			if ($exe) echo 1;
			else echo 404;
		}
	
	}
	
	break;
	
	case "hapusagama":
	
	$sqlhapus = "select * from dinamis_penduduk where id_agama = '$idDelete'";
	if (_num_rows($sqlhapus) == 0) {
		$exe=_delete("delete from agama where id = '".$idDelete."'");
		if ($exe) echo 1;
		else echo 404;
	} else {
		echo 2;
	}
	
	break;

}

exit();