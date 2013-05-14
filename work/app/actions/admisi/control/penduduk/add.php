<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'app/lib/common/functions.php';

$no_id  = $_POST['no_identitas'];
$nama   = $_POST['nama'];
$alamat = $_POST['almt'];
$kelurahan = $_POST['idKelurahan'];
$kelamin= $_POST['jeKel'];
$tglLahir=date2mysql($_POST['tglLahir']);
$noKartuKeluarga = $_POST['no_kk'];
$posisi = $_POST['posisi'];
$sip    = $_POST['sip'];
$no_telp= $_POST['no_telp'];
$pendidikan = $_POST['idPendidikan'];
$profesi= $_POST['idProfesi'];
$pekerjaan= $_POST['idPekerjaan'];
$agama  = $_POST['idAgama'];
$perkawinan = $_POST['idPerkawinan'];
$umur        = isset($_POST['umur'])?$_POST['umur']:null;
//echo $perkawinan;
//exit;

// penanggulangi gagal update jika reference kolom induk tidak diisi atau NULL value
$arr = array('index_',$no_id,$alamat,$kelurahan,$posisi,$pendidikan,$profesi,$pekerjaan,$agama,$perkawinan);
$i=1;
$arr_length = count($arr);
while ($i < ($arr_length+1)) {
        $arr[$i]=trim($arr[$i]);
        if ($arr[$i] == ''){
                $arr[$i] = "NULL";
        }
++$i;
}
if($umur != "" && $tglLahir != ""){
    $date = $tglLahir;
}
if ($umur != '' && $tglLahir == "") {
    $date = tglLahir($umur);
} else {
    $date = $tglLahir;
}

$sql = "INSERT INTO penduduk VALUES ('','$no_id','$nama','$kelamin','','$date','$noKartuKeluarga','$arr[4]','$sip')";
$exe = mysql_query($sql);
$id = mysql_insert_id();
//echo $sql; die;

$sql2 = mysql_query("INSERT INTO dinamis_penduduk (id,tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan) 
                     VALUES ('',now(),'$id','$alamat','$no_telp',{$arr[3]},'$perkawinan',{$arr[5]},{$arr[6]},{$arr[8]},1,{$arr[7]})");
if ($sql2) {
        header("location:".app_base_url('/admisi/penduduk')."?idPenduduk=$id&msg=1");
}