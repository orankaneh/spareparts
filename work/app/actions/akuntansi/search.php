<?php
require_once 'app/lib/common/functions.php';

switch($_GET['opsi']) {
	
case "rekening": 
    $q=strtolower($_GET['q']);
	$result = _select_arr("select * from rekening where nama like ('%$q%') order by locate ('$q',nama)");
    die(json_encode($result));
break;

case "kategoriRekening": 
    $q=strtolower($_GET['q']);
	$result = _select_arr("select * from kategori_rekening where nama like ('%$q%') order by locate ('$q',nama)");
    die(json_encode($result));
break;

case "pasien":
	$q=strtolower($_GET['q']);
	$result = _select_arr("select pa.nama,pa.id from pasien pe join penduduk pa on(pe.id=pa.id) and pa.nama like ('%$q%') order by locate ('$q',pa.nama)");
    die(json_encode($result));
break;

case "pegawai":
	$q=strtolower($_GET['q']);
	$result = _select_arr("select pa.nama,pa.id from pegawai pe join penduduk pa on(pe.id=pa.id) and pa.nama like ('%$q%') order by locate ('$q',pa.nama)");
    die(json_encode($result));
break;

case "instansi":
	$q=strtolower($_GET['q']);
	$result = _select_arr("select id,nama from instansi_relasi relasi where nama like ('%$q%') order by locate ('$q',nama)");
    die(json_encode($result));
break;

case "cek_saldo_bulan_terpilih":
	$return =array();
	$bulan = $_GET["bulan"];
	$tahun = $_GET["tahun"];
	$sql_cek = countrow("select * from saldo where MONTH(tanggal)='".$bulan."' and YEAR(tanggal)='".$tahun."' ");
	if($sql_cek==0){
		die(json_encode(array('status'=>"1")));
	}
	$sql_cek = countrow("select * from hasil_laporan_akuntansi where id_laporan = '1' and MONTH(tanggal)='".$bulan."' and YEAR(tanggal)='".$tahun."' ");
	if($sql_cek==0 || $sql_cek==""){ 
		die(json_encode(array('status'=>'status','lr'=>'false','bulan'=>$bulan,'tahun'=>$tahun))) ;
	}
	die(json_encode($return));
break;

case "bulan_belum_tergenerate":
	$array_bulan = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'Augustus','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
	$result = "";
	$sql_cek = _select_arr("
		select concat(substr(tanggal,1,4),substr(tanggal,5,3)) as periode from saldo where concat(substr(tanggal,1,4),substr(tanggal,5,3)) not in(select concat(substr(tanggal,1,4),substr(tanggal,5,3)) from hasil_laporan_akuntansi where id_laporan='1') group by concat(substr(tanggal,1,4),substr(tanggal,5,3))
	");
	$i=1;
	foreach($sql_cek as $record){
			$explode = explode("-",$record["periode"]);
			$result .="
				<div class='button' onClick=\"goDisplayLR('#tahunLR".$i."','#bulanLR".$i."') \" >Generate Laporan Laba Rugi Bulan ".$array_bulan[$explode[1]]." Tahun ".$explode[0]."</div>
				<input type='hidden' id='bulanLR".$i."' value='".$explode[1]."'>
				<input type='hidden' id='tahunLR".$i."' value='".$explode[0]."'><br>
			";
	$i++;
	}
	die($result);
break;

case "bulan_belum_tergeneratePM":
	$array_bulan = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'Augustus','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
	$result = "";
	$sql_cek = _select_arr("
		select concat(substr(tanggal,1,4),substr(tanggal,5,3)) as periode from saldo where concat(substr(tanggal,1,4),substr(tanggal,5,3)) not in(select concat(substr(tanggal,1,4),substr(tanggal,5,3)) from hasil_laporan_akuntansi where id_laporan='1') group by concat(substr(tanggal,1,4),substr(tanggal,5,3))
	");
	$i=1;
	foreach($sql_cek as $record){
			$explode = explode("-",$record["periode"]);
			$result .="
				<div class='button' onClick=\"goDisplayPM('#tahunPM".$i."','#bulanPM".$i."') \" >Generate Laporan Perubahan Modal Bulan ".$array_bulan[$explode[1]]." Tahun ".$explode[0]."</div>
				<input type='hidden' id='bulanPM".$i."' value='".$explode[1]."'>
				<input type='hidden' id='tahunPM".$i."' value='".$explode[0]."'><br>
			";
	$i++;
	}
	die($result);
break;

case "bulan_belum_tergenerateN":
	$array_bulan = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'Augustus','09'=>'September','10'=>'October','11'=>'November','12'=>'December');
	$result = "";
	$sql_cek = _select_arr("
		select concat(substr(tanggal,1,4),substr(tanggal,5,3)) as periode from saldo where concat(substr(tanggal,1,4),substr(tanggal,5,3)) not in(select concat(substr(tanggal,1,4),substr(tanggal,5,3)) from hasil_laporan_akuntansi where id_laporan='1') group by concat(substr(tanggal,1,4),substr(tanggal,5,3))
	");
	$i=1;
	foreach($sql_cek as $record){
			$explode = explode("-",$record["periode"]);
			$result .="
				<div class='button' onClick=\"goDisplayN('#tahunN".$i."','#bulanN".$i."') \" >Generate Laporan Neraca Bulan ".$array_bulan[$explode[1]]." Tahun ".$explode[0]."</div>
				<input type='hidden' id='bulanN".$i."' value='".$explode[1]."'>
				<input type='hidden' id='tahunN".$i."' value='".$explode[0]."'><br>
			";
	$i++;
	}
	die($result);
break;
}
?>
