<?php

require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-akuntansi.php';


_delete('delete from saldo');

set_time_zone();

$strAwal = strtotime($_POST['tanggal']);
$strAkhir = strtotime(date('Y-m')."-01");

$tanggal_lanjut = array();
$tanggal_lanjut[] = date('Y-m')."-01";
while($strAkhir > $strAwal) {
	$date = date("Y-m-d",strtotime("-1month",$strAkhir));
	$tanggal_lanjut[] = date("Y-m-d",strtotime($date));
	$strAkhir = strtotime($date);	
}
$jml_rekening=count($_POST['id_rek']);

for ($i=0; $i < $jml_rekening; $i++) {
	$jumlah=currencyToNumber($_POST['jumlah'][$i]);
	for ($j=0;$j < count($tanggal_lanjut);$j++) {
		_insert("insert into saldo (jumlah,jumlah_akhir,tanggal,id_rekening) values ('".$jumlah."','".$jumlah."','".$tanggal_lanjut[$j]."','".$_POST['id_rek'][$i]."')");
	}
}

if ($_POST['opsi'] == "finish") {
	_update("update setting set saldo_awal='1'");
	$_SESSION['setting_saldo_awal'] = 1;
}

echo 1;

exit();

?>

