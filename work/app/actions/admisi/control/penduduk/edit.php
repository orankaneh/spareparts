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
$perkawinan = isset($_POST['idPerkawinan'])?$_POST['idPerkawinan']:null;
$umur = isset($_POST['umur'])?$_POST['umur']:null;

// penanggulangi gagal update jika reference kolom induk tidak diisi atau NULL value
$arr = array('index_',$no_id,$alamat,$kelurahan,$posisi,$pendidikan,$profesi,$pekerjaan,$agama,$perkawinan);
//$arr = array('index_',$kelurahan,$posisi,$pendidikan,$profesi,$agama,$perkawinan);
//$i=1;

$arr_length = count($arr);

for ($i = 1; $i <= $arr_length - 1; $i++) {
        $arr[$i]=trim($arr[$i]);
        if ($arr[$i] == ''){
                $arr[$i] = "NULL";
        }
        //echo $arr[$i] . "";
}
if($umur != "" && $tglLahir != ""){
    $date = $tglLahir;
}
if ($umur != '' && $tglLahir == "") {
    $date = tglLahir($umur);
} else {
    $date = $tglLahir;
}

$cek=("Select * from dinamis_penduduk where id_penduduk = '$_POST[idPenduduk]'");
$hasil= countrow($cek);
if ($hasil==0){
$sql2 = mysql_query("INSERT INTO dinamis_penduduk (id,tanggal,id_penduduk,alamat_jalan,no_telp,id_kelurahan,status_pernikahan,id_pendidikan_terakhir,id_profesi,id_agama,akhir,id_pekerjaan) 
                     VALUES ('',now(),'$_POST[idPenduduk]','$alamat','$no_telp',{$arr[3]},'$perkawinan',{$arr[5]},{$arr[6]},{$arr[8]},1,{$arr[7]})");
}

$sql = "update penduduk set no_identitas = '$no_id', nama = '$nama', jenis_kelamin = '$kelamin', tanggal_lahir = '$date', no_kartu_keluarga = '$noKartuKeluarga', posisi_di_keluarga = '$arr[4]', sip = '$sip' where id = '$_POST[idPenduduk]'";

$exe = mysql_query($sql);

$sql2 = mysql_query("update dinamis_penduduk set alamat_jalan = '$alamat', no_telp = '$no_telp', id_kelurahan = {$arr[3]}, id_pendidikan_terakhir = {$arr[5]}, id_profesi = {$arr[6]}, id_pekerjaan= {$arr[7]}, id_agama = {$arr[8]}, status_pernikahan = '$perkawinan' where id_penduduk = '$_POST[idPenduduk]' and akhir = '1'");

if ($sql2) {
        header("location: ".app_base_url('/admisi/penduduk')."?idPenduduk=$_POST[idPenduduk]&msg=1");
}