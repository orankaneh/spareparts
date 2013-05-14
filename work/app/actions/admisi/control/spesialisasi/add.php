<?php
if(isset($_POST['save'])){
$id_penduduk = isset($_POST["id_penduduk"])?$_POST["id_penduduk"]:null;
$nama = isset($_POST["nama_dokter"])?$_POST["nama_dokter"]:null;
$no_identitas = isset($_POST["no_identitas"])?$_POST["no_identitas"]:null;
$address = isset($_POST["alamatJln"])?$_POST["alamatJln"]:null;
$idKel  = isset($_POST["idKel"])?$_POST["idKel"]:null;
$jKelamin = isset($_POST["kelamin"])?$_POST["kelamin"]:null;
$agama = isset($_POST["agama"])?$_POST["agama"]:null;
$noSIP = isset($_POST["no_sip"])?$_POST["no_sip"]:null;
$spesialisasi = isset($_POST["id_spesialisasi"])?$_POST["id_spesialisasi"]:null;
	$countz = countrow("select * from penduduk where id= '$id_penduduk'");
	$array = array('', $idKel, null, null, '2', $agama, null);
		for ($i = 0; $i < count($array); $i++) {
            if (empty($array[$i]) || $array[$i]=='' || $array[$i]==null || empty($array[$i])) {
                $array[$i] = 'NULL';
            }
        } 
	if($countz==0){
		
		_insert("insert into penduduk values ('','$no_identitas','$nama','$jKelamin','','0000-00-00','','NULL','$noSIP')");
            $id_penduduk = mysql_insert_id();
		_insert("insert into dinamis_penduduk
            (id,tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan)
            values
            ('',now(),'$id_penduduk','$address','',{$array[1]},{$array[2]},{$array[3]},{$array[4]},{$array[5]},'1',{$array[6]})");
	}
	_update("update penduduk set no_identitas='$no_identitas', jenis_kelamin='$jKelamin',sip='$noSIP' where id='$id_penduduk'");
	_update("update dinamis_penduduk set alamat_jalan = '$address', id_kelurahan = $idKel, id_profesi = '2', id_agama ={$array[5]} where id_penduduk = '$id_penduduk' and akhir = '1'");
	$countd = countrow("select * from dokter where id= '$id_penduduk'");
	
	$succes = ($countd==0)? _insert("insert into dokter(id,id_spesialisasi) values('".$id_penduduk."','".$spesialisasi."') ") :  _update("update dokter set id_spesialisasi='".$spesialisasi."' where id='".$id_penduduk."'");
	if($succes){
		header('location:' . app_base_url('admisi/spesialisasi_dokter?msg=1'));
	}
}
?>