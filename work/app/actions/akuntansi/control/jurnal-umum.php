<?php

require_once 'app/lib/common/functions.php';
require_once 'app/lib/common/master-akuntansi.php';

switch($_GET['opsi']) {

 // ------------------- Add Jurnal Umum ---------------------- //
 

 case "tambah":
 
 $bulan_simpan=strlen($_POST['bulan_jurnal']==1)?"0".$_POST['bulan_jurnal']:$_POST['bulan_jurnal'];
 
 $tgl = strlen($_POST['tanggal_jurnal']==1)?"0".$_POST['tanggal_jurnal']:$_POST['tanggal_jurnal'];
 
 $tanggal = $_POST['tahun_jurnal']."-".$bulan_simpan."-".$tgl;

 $bulan = $bulan_simpan;
 $tahun = $_POST['tahun_jurnal'];
 $bukti=$_POST['kode'].$_POST['nomor'];
 $jumlah=currencyToNumber($_POST['jumlah']);
 

 $sql=_insert("insert into jurnal VALUES (null,'".$tanggal."','".$_POST['transaksi']."','".$bukti."','".$jumlah."','".$_POST['tipejurnal']."')");
 if ($sql) {
	$idjurnal=_last_id();
	
	// simpan jurnal umum - saldo rekening debet
	
	$jumlahrek_debet=count($_POST['id_rekDebet']);
	
	$tipe_rekening="";

	for ($i=0; $i < $jumlahrek_debet; $i++) {
		$idparse = explode("-",$_POST['id_rekDebet'][$i]);
		
		switch($idparse[1]) {
			case "2": $tipe_rekening ="h"; break;
			case "4": $tipe_rekening ="p"; break;
		}
		
		_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$idparse[0]."','".currencyToNumber($_POST['jumlah_rekdebet'][$i])."','d')");
		if ($_POST['tipejurnal'] == 1) transaksi_jurnalumum($bulan,$tahun,$idparse[0]);
		else transaksi_jurnalpenyesuaian($bulan,$tahun,$idparse[0]);
	}
	
	// simpan jurnal umum - saldo rekening kredit
	
	$jumlahrek_kredit=count($_POST['id_rekKredit']);

	for ($j=0; $j < $jumlahrek_kredit; $j++) {
		$idparse = explode("-",$_POST['id_rekKredit'][$j]);
		switch($idparse[1]) {
			case "2": $tipe_rekening ="h"; break;
			case "4": $tipe_rekening ="p"; break;
		}
		_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$idparse[0]."','".currencyToNumber($_POST['jumlah_rekkredit'][$j])."','k')");
		if ($_POST['tipejurnal'] == 1) transaksi_jurnalumum($bulan,$tahun,$idparse[0]);
		else transaksi_jurnalpenyesuaian($bulan,$tahun,$idparse[0]);
	}

	if (!empty($_POST['status_terkait'])) {
		$exe=_insert("insert into hutang_piutang values ('','".$_POST['status_terkait']."','".$_POST['id_terkait']."','".$idjurnal."','".$tipe_rekening."')");
		if ($exe) echo 1;
		else 404;
	} else {
		echo 1;
	}
 } else {
	echo 404;
 }
 
 
 break;
 
 // ------------------- Edit Jurnal Umum ---------------------- //
 
 case "edit":
 
 $bukti=$_POST['kode'].$_POST['nomor'];
 $jumlah=currencyToNumber($_POST['jumlah']);
 
 //Format Tanggal
 $bulan_simpan=strlen($_POST['bulan_jurnal'])==1?"0".$_POST['bulan_jurnal']:$_POST['bulan_jurnal'];
 $tgl = strlen($_POST['tanggal_jurnal']==1)?"0".$_POST['tanggal_jurnal']:$_POST['tanggal_jurnal'];
 $tanggal = $_POST['tahun_jurnal']."-".$bulan_simpan."-".$tgl;
 
 //update Tabel Jurnal
 
 $sql = _update("update jurnal set nama = '".$_POST['transaksi']."', nomor_bukti = '".$bukti."', jumlah = '".$jumlah."', tanggal = '".$tanggal."' where id = '".$_POST['id']."'");

 //update Rekening

 $bulan = strlen($_POST['bulan_jurnal'])==1?"0".$_POST['bulan_jurnal']:$_POST['bulan_jurnal'];
 $tahun = $_POST['tahun_jurnal'];
 
 $idjurnal=$_POST['id'];
	
	$deleteRekening = _delete("delete from detail_jurnal where id_jurnal = '".$idjurnal."'"); 
	// simpan jurnal umum - saldo rekening debet

	$tipe_rekening="";
	
	$jumlahrek_debet=count($_POST['id_rekDebet']);

	for ($i=0; $i < $jumlahrek_debet; $i++) {
		$idparse_debet = explode("-",$_POST['id_rekDebet'][$i]);
		switch($idparse_debet[1]) {
			case "2": $tipe_rekening ="h"; break;
			case "4": $tipe_rekening ="p"; break;
		}

		_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$idparse_debet[0]."','".currencyToNumber($_POST['jumlah_rekdebet'][$i])."','d')");
		
		if ($_POST['tipejurnal'] == 1) transaksi_jurnalumum($bulan,$tahun,$idparse_debet[0]);
		else transaksi_jurnalpenyesuaian($bulan,$tahun,$idparse_debet[0]);
	}
	
	// simpan jurnal umum - saldo rekening kredit
	
	$jumlahrek_kredit=count($_POST['id_rekKredit']);

	for ($j=0; $j < $jumlahrek_kredit; $j++) {
		$idparse_kredit = explode("-",$_POST['id_rekKredit'][$j]);
		switch($idparse_kredit[1]) {
			case "2": $tipe_rekening ="h"; break;
			case "4": $tipe_rekening ="p"; break;
		}

		_insert("insert into detail_jurnal values (null,'".$idjurnal."','".$idparse_kredit[0]."','".currencyToNumber($_POST['jumlah_rekkredit'][$j])."','k')");
		
		if ($_POST['tipejurnal'] == 1) transaksi_jurnalumum($bulan,$tahun,$idparse_kredit[0]);
		else transaksi_jurnalpenyesuaian($bulan,$tahun,$idparse_kredit[0]);
	}
	
	
	// ----------------- Update Sebelum Edit ------------------ //
	
	// Simpan jurnal sebelum edit - Saldo Rekening Debet
	
	$jumlahsebelum_rek_debet=count($_POST['id_sebelum_rekDebet']);
	
	for ($i=0; $i < $jumlahsebelum_rek_debet; $i++) {
		if ($_POST['id_rekDebet'][$i] != $_POST['id_sebelum_rekDebet'][$i]) {
			$idparse_debet_past = explode("-",$_POST['id_sebelum_rekDebet'][$i]);
			if ($_POST['tipejurnal'] == 1) transaksi_jurnalumum($bulan,$tahun,$idparse_debet_past[0]);
			else transaksi_jurnalpenyesuaian($bulan,$tahun,$idparse_debet_past[0]);
		}
	}
	
	// simpan jurnal sebelum edit - Saldo Rekening Kredit
	
	$jumlahsebelum_rek_kredit=count($_POST['id_sebelum_rekKredit']);

	for ($j=0; $j < $jumlahsebelum_rek_kredit; $j++) {
		if ($_POST['id_sebelum_rekKredit'][$j] !=$_POST['id_rekKredit'][$j]) {
			$idparse_kredit_past = explode("-",$_POST['id_sebelum_rekKredit'][$j]);
			if ($_POST['tipejurnal'] == 1) transaksi_jurnalumum($bulan,$tahun,$idparse_kredit_past[0]);
			else transaksi_jurnalpenyesuaian($bulan,$tahun,$idparse_kredit_past[0]);
		}
	}


 //Update Hutang Piutang
			
 if (empty($_POST['status_sebelum']) and !empty($_POST['status_terkait'])) {
	$updatepiutang=_insert("insert into hutang_piutang values ('','".$_POST['status_terkait']."','".$_POST['id_terkait']."','".$_POST['id']."','".$tipe_rekening."')");
 } else if (!empty($_POST['status_sebelum']) and empty($_POST['status_terkait'])) {
	$updatepiutang=_delete("delete from hutang_piutang where id_jurnal = '".$_POST['id']."'");
 } else if (!empty($_POST['status_sebelum']) and !empty($_POST['status_terkait']) and ($_POST['status_sebelum']!=$_POST['status_terkait'] or $_POST['id_terkait_sebelum']!=$_POST['id_terkait'])) {
	$updatepiutang=_update("update hutang_piutang set status='".$_POST['status_terkait']."', id_terkait = '".$_POST['id_terkait']."', tipe='".$tipe_rekening."' where id_jurnal = '".$_POST['id']."'");
 } else {
	$updatepiutang=_update("update hutang_piutang set tipe='".$tipe_rekening."' where id_jurnal = '".$_POST['id']."'");
 }
 if ($sql) echo 3;
 else echo 404;

 break;

 // ------------------- Delete Jurnal ---------------------- //
 
 case "hapus":
 
 $data = array();
 
 $sql = mysql_query("select * from detail_jurnal where id_jurnal = '".$_POST['id']."'");
 while ($d = mysql_fetch_array($sql)) {
	$data[] = $d['id_rekening'];
 }
 
 $sqljurnal = mysql_query("select * from jurnal where id = '".$_POST['id']."'");
 $d_jurnal = mysql_fetch_array($sqljurnal);
 
 $tanggal = explode("-",$d_jurnal['tanggal']);
 
 $cascade= _delete("delete from hutang_piutang where id_jurnal ='".$_POST['id']."'"); 
 $deleteRekening = _delete("delete from detail_jurnal where id_jurnal = '".$_POST['id']."'"); 
 $exe=_delete("delete from jurnal where id = '".$_POST['id']."'");
 
 // delete saldo saat semua jurnal habis 
 
 for ($i=0; $i < count($data); $i++) {
	//hapus_full_saldo($tanggal[1],$tanggal[0],$data[$i]);
	if ($d_jurnal['status'] == 1 ) transaksi_jurnalumum($tanggal[1],$tanggal[0],$data[$i]);
	else transaksi_jurnalpenyesuaian($tanggal[1],$tanggal[0],$data[$i]);
 }
 
 if ($exe) echo 3;
 else echo 404;
 	
 break;
	
}

exit();

?>

